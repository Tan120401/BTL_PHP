<?php
    // mail
    require "../PHPMailer/src/PHPMailer.php";
    require "../PHPMailer/src/Exception.php";
    require "../PHPMailer/src/OAuth.php";
    require "../PHPMailer/src/POP3.php";
    require "../PHPMailer/src/SMTP.php";

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    $mail = new PHPMailer(true);
    

    include "./database.php";

    session_start();

    $loggedIn_username_or_email = $_SESSION["check_user"];

    $loggedIn_member_sql = "SELECT MaThanhVien, TenThanhVien, Email from THANHVIEN WHERE username = '$loggedIn_username_or_email' or Email='$loggedIn_username_or_email'";
    $loggedIn_member_result = mysqli_query($conn, $loggedIn_member_sql);
    $loggedIn_member_data = mysqli_fetch_all($loggedIn_member_result, MYSQLI_ASSOC);

    $memberId = $loggedIn_member_data[0]['MaThanhVien'];
    $memberName = $loggedIn_member_data[0]['TenThanhVien'];
    $memberEmail = $loggedIn_member_data[0]['Email'];
    $tourId = $_GET["tourId"];

    if($tourId) {
        $ordered_tour_sql = "SELECT DIADIEM.DonGia, TOUR.SoNgay, TOUR.NgayKhoiHanh from TOUR, DIADIEM 
                             WHERE TOUR.MaDiaDiem = DIADIEM.MaDiaDiem and TOUR.MaTour = '$tourId'";
        $ordered_tour_result = mysqli_query($conn, $ordered_tour_sql);
        $ordered_tour_data = mysqli_fetch_all($ordered_tour_result, MYSQLI_ASSOC);

        $placePrice = $ordered_tour_data[0]['DonGia'];
        $daysNum = $ordered_tour_data[0]["SoNgay"];
        $startingDate = $ordered_tour_data[0]["NgayKhoiHanh"];

        $quantity = $_POST["quantity"];
        // $daysNum = $_POST["days"];
        // $startingDate = $_POST["starting-date"];
        
        $_SESSION["order_quantity"] = $quantity;
        // $_SESSION["order_daysNum"] = $daysNum;
        // $_SESSION["order_startingDate"] = $startingDate;

        if($daysNum <= 0) {
            $daysNum = 1;
        }
        // if($daysNum >= 10) {
        //     $daysNum = 10;
        // }
        if($quantity <= 0) {
            $quantity = 1;
        }

        if($quantity <= 1) $discount = 0;
        else if($placePrice / 20 > 0.4) $discount = 0.4;
        else $discount = $placePrice / 20;

        $total = $placePrice * $daysNum * $quantity * (1 - $discount);

        // check valid date (not in the past)
        if(time() - strtotime($startingDate) >= 0) {
            $today = date("Y/m/d");

            $_SESSION['isOrderedAlert'] = "Ng??y kh???i h??nh ph???i sau ng??y $today. Ch???n ng??y kh??c.";
            header("Location: details.php?tourId=$tourId");
            exit();
        }

        // check tour existance
        $doesTour_exists_sql = "
            SELECT COUNT(1) AS c FROM ct_tour, tour 
            WHERE ct_tour.MaTour = tour.MaTour and ct_tour.MaThanhVien = '3' 
                and (
                    tour.NgayKhoiHanh <= '$startingDate' and 
                    DATE_ADD(tour.NgayKhoiHanh, INTERVAL tour.SoNgay day) >= '$startingDate'
                )
            ";

        $doesTour_exists_result = mysqli_query($conn, $doesTour_exists_sql);
        $doesTour_exists_data = mysqli_fetch_all($doesTour_exists_result, MYSQLI_ASSOC);

        if($doesTour_exists_data[0]['c'] >= 1) {
            $_SESSION['isOrderedAlert'] = "B???n ???? c?? tour trong th???i gian n??y. Ch???n tour kh??c.";
            header("Location: details.php?tourId=$tourId");
            exit();
        }

        $add_order_sql = "INSERT INTO ct_tour(MaThanhVien, MaTour, SoNguoi, ThanhTien) values ('$memberId', '$tourId', $quantity, $total)";
        $add_order_result = mysqli_query($conn, $add_order_sql);

        if(!$add_order_result) {
            $_SESSION['isOrderedAlert'] = "Ch???n tour kh??c. B???n ???? ?????t tour n??y";
            header("Location: details.php?tourId=$tourId");
            exit();
        } else {
            $_SESSION['successOrdered'] = "?????t tour th??nh c??ng. <br> H??y ki???m tra h???p th?? c???a b???n ????? bi???t th??m chi ti???t";
        }

        // SEND MAIL
        // get tour info
        $sql_infor_tour = "SELECT TenTour, TenDiaDiem, TenKhachSan, DiaChiKhachSan, NgayKhoiHanh, SoNgay
                           FROM tour t join diadiem d on t.MaDiaDiem = d.MaDiaDiem
                           WHERE MaTour = $tourId";
        $tour_infor = mysqli_fetch_array(mysqli_query($conn, $sql_infor_tour), MYSQLI_ASSOC);

        try {
            //Server settings
            $mail->CharSet = 'UTF-8';
            $mail->SMTPDebug = 0;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'mtp.travel.company@gmail.com';     // SMTP username
            $mail->Password = 'lufvfhfwuchjykwc';                 // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to
         
            //Recipients
            $mail->setFrom('mtp.travel.company@gmail.com', 'MTP Travel');
            $mail->addAddress($memberEmail);     // Add a recipient
            
            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Th??ng b??o ?????t tour th??nh c??ng';
            $mail->Body    = '<h3 style="color: red;">MTP TRAVEL TR???N TR???NG TH??NG B??O</h3>
                                <p>K??nh ch??o Qu?? kh??ch <strong>' . $memberName . '</strong>,</p>
                                <p>Ch??c m???ng Qu?? kh??ch ???? ?????t th??nh c??ng tour du l???ch b??n ch??ng t??i. Ch??ng t??i xin g???i t???i qu?? kh??ch th??ng tin v??? chuy???n ??i:</p>
                                <p>- M?? tour: ' . $tourId . '</p>
                                <p>- T??n tour: ' . $tour_infor['TenTour'] . '</p>
                                <p>- ??i???m ?????n: ' . $tour_infor['TenDiaDiem'] . '</p>
                                <p>- T??n kh??ch s???n: ' . $tour_infor['TenKhachSan'] . '</p>
                                <p>- ?????a ch??? kh??ch s???n: ' . $tour_infor['DiaChiKhachSan'] . '</p>
                                <p>- Ng??y kh???i h??nh: ' . $tour_infor['NgayKhoiHanh'] . '</p>
                                <p>- S??? ng??y: ' . $tour_infor['SoNgay'] . '</p>
                                <p>- S??? ng?????i: ' . $quantity . '</p>
                                <p>- T???ng ti???n: ' . $total . '</p>
                                <hr>
                                <p>C???m ??n Qu?? kh??ch ???? s??? d???ng d???ch v??? c???a ch??ng t??i!
                                <br>M???i th???c m???c xin vui l??ng li??n h??? MTP Travel qua email: hotro@mtptravel.vn ho???c s??? hotline: 0368 686 868 - 0939 393 939
                                <br>Tr??n tr???ng!</p>';
         
            $mail->send();
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
            exit();
        }

        header("Location: details.php?tourId=$tourId");
        exit();
    }
?>