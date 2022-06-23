<?php 
    $conn = mysqli_connect("localhost", "root", "Tan@1204", "qlbantour");
    if (!$conn) {
      die("Connection failed");
    }

    $search_html = "";
    $search_sql;
    $search_result;
    $search_data;

    $search_province = $_GET['province'];
    $search_price = $_GET['price'];

    // SEARCH
    if($search_price == 'Dưới 2 triệu'){

        if(!$search_province || $search_province == "default") {
            $search_sql = "SELECT * FROM tour,diadiem,tinh
            where tour.MaDiaDiem = diadiem.MaDiaDiem and diadiem.matinh = tinh.matinh and DonGia < 2000000";      
        } else {
            $search_sql = "SELECT * FROM tour,diadiem,tinh
            where tour.MaDiaDiem = diadiem.MaDiaDiem and diadiem.matinh = tinh.matinh and diadiem.MaTinh = '$search_province' and DonGia < 2000000";
        }
       
    }
    else if($search_price =='2 triệu - 4 triệu'){

        if(!$search_province || $search_province == "default") {
            $search_sql = "SELECT * FROM tour,diadiem,tinh
            where tour.MaDiaDiem = diadiem.MaDiaDiem and diadiem.matinh = tinh.matinh and DonGia BETWEEN 2000000 and 4000000";
        } else {
            $search_sql = "SELECT * FROM tour,diadiem,tinh
            where tour.MaDiaDiem = diadiem.MaDiaDiem and diadiem.matinh = tinh.matinh and diadiem.MaTinh = '$search_province' and DonGia BETWEEN 2000000 and 4000000";
        }

    }
    else if($search_price =='4 triệu - 6 triệu'){

        if(!$search_province || $search_province == "default") {
            $search_sql = "SELECT * FROM tour,diadiem,tinh
            where tour.MaDiaDiem = diadiem.MaDiaDiem and diadiem.matinh = tinh.matinh and DonGia BETWEEN 4000000 and 6000000";
        } else {
            $search_sql = "SELECT * FROM tour,diadiem,tinh
            where tour.MaDiaDiem = diadiem.MaDiaDiem and diadiem.matinh = tinh.matinh and diadiem.MaTinh = '$search_province' and DonGia BETWEEN 4000000 and 6000000";
        }
        
    }
    else if($search_price =='Trên 6 triệu'){

        if(!$search_province || $search_province == "default") {
            $search_sql = "SELECT * FROM tour,diadiem,tinh
            where tour.MaDiaDiem = diadiem.MaDiaDiem and diadiem.matinh = tinh.matinh and DonGia >6000000";
        } else {
            $search_sql = "SELECT * FROM tour,diadiem,tinh
            where tour.MaDiaDiem = diadiem.MaDiaDiem and diadiem.matinh = tinh.matinh and diadiem.MaTinh = '$search_province' and DonGia >6000000";
        }
        
    } else if($search_province && $search_province != "default") {
        $search_sql = "SELECT * FROM tour,diadiem,tinh
        where tour.MaDiaDiem = diadiem.MaDiaDiem and diadiem.matinh = tinh.matinh and diadiem.MaTinh = '$search_province'";
    } else if(!search_province || $search_province == "default") {
        $search_sql = "SELECT * FROM tour,diadiem,tinh
        where tour.MaDiaDiem = diadiem.MaDiaDiem and diadiem.matinh = tinh.matinh";
    } else {
        $search_sql = "SELECT * FROM tour,diadiem,tinh
        where tour.MaDiaDiem = diadiem.MaDiaDiem and diadiem.matinh = tinh.matinh";
    }
    getData($search_sql);

    // PROPOSALS
    $search_proposedTours_sql = "SELECT * FROM TOUR, DIADIEM WHERE TOUR.MaDiaDiem = DIADIEM.MaDiaDiem LIMIT 3";
    $search_proposedTours_result = mysqli_query($conn, $search_proposedTours_sql);
    $search_proposedTours_data = mysqli_fetch_all($search_proposedTours_result, MYSQLI_ASSOC);

    $search_proposedTours_html = "";
    for($i = 0; $i < count($search_proposedTours_data); $i++) {
        $search_proposedTour_id = $search_proposedTours_data[$i]['MaTour'];
        $search_proposedTour_placeId = $search_proposedTours_data[$i]['MaDiaDiem'];
        $search_proposedTour_name = $search_proposedTours_data[$i]['TenTour'];
        $search_proposedTour_price = $search_proposedTours_data[$i]['DonGia'];
        $search_proposedTour_placeIntro = $search_proposedTours_data[$i]['GioiThieu'];

        $search_proposedTour_placeIntro = truncate($search_proposedTour_placeIntro, 100);

        $search_proposedTour_price = number_format($search_proposedTour_price, 0, ",", ".");

        // SELECT OTHER TOUR IMAGE
        $search_proposedTour_image_sql = "SELECT * from ANH WHERE ANH.MaDiaDiem = '$search_proposedTour_placeId'";
        $search_proposedTour_image_result = mysqli_query($conn, $search_proposedTour_image_sql);
        $search_proposedTour_image_data = mysqli_fetch_all($search_proposedTour_image_result, MYSQLI_ASSOC);

        $search_proposedTour_image_link = $search_proposedTour_image_data[0]['Link'];

        // OTHER TOURS HTML
        $search_proposedTours_html .= "
            <a href='./details.php?tourId=$search_proposedTour_id' class='proposals__place'>
                <img src='$search_proposedTour_image_link' alt='' class='proposals__img'>
                <div class='proposals__info'>
                    <h6 class='proposals__name'>$search_proposedTour_name</h6>
                    <p class='proposals__desc'>$search_proposedTour_placeIntro</p>
                </div>
            </a>";
    }

    function getData($sql) {
        global $search_html;
        global $conn;
        $result = mysqli_query($conn, $sql);
        $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if(count($data) <= 0) {
            $search_html = "<p style='text-align: center; width: 100%'>Không có tour nào.</p>";
            return;
        }

        for($i = 0; $i < count($data); $i++) {
            $search_tour_id = $data[$i]['MaTour'];
            $search_tour_name = $data[$i]['TenTour'];
            $search_tour_place = $data[$i]['TenDiaDiem'];
            $search_tour_placeId = $data[$i]['MaDiaDiem'];
            $search_tour_province = $data[$i]['TenTinh'];
            $search_tour_intro = $data[$i]['GioiThieu'];

            $image_sql = "SELECT Link from ANH WHERE ANH.MaDiaDiem = '$search_tour_placeId' LIMIT 1";
            $image_result = mysqli_query($conn, $image_sql);
            $image_data = mysqli_fetch_all($image_result, MYSQLI_ASSOC);

            $search_tour_link = $image_data[0]['Link'];

            $found_tour_html = "
                <div class='col l-4'>
                    <div class='tour-rectangle__place'>
                        <img src='$search_tour_link' alt='{$search_tour_place}' class='tour-rectangle__place--img'>
                        <div class='tour-rectangle__place--content'>
                            <div style='display: flex; justify-content: space-between; align-items: flex-end;'>
                                <h3 class='tour-rectangle__place--name'>{$search_tour_name}</h3>
                                <h6 class='tour-rectangle__place--province' style='white-space: nowrap'>
                                    <i class='fa-solid fa-location-dot' style='margin-right: 5px;'></i>
                                    {$search_tour_province}
                                </h6>
                            </div>
                            <p class='tour-rectangle__place--desc'>
                                {$search_tour_intro}
                            </p>
                            <a href='./details.php?tourId={$search_tour_id}' class='tour-rectangle__place--btn'>Tìm hiểu</a>
                        </div>
                    </div>
                </div>";

            $search_html .= $found_tour_html;
        }
    }

    function truncate($string, $length=100, $append="&hellip;") {
      $string = trim($string);

      if(strlen($string) > $length) {
        $string = wordwrap($string, $length);
        $string = explode("\n", $string, 2);
        $string = $string[0] . $append;
      }

      return $string;
    }

    $search_place_sql = "SELECT * FROM Tinh";
    $search_place_result = mysqli_query($conn, $search_place_sql);
    $search_place_data = mysqli_fetch_all($search_place_result, MYSQLI_ASSOC);

    mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MTP Travel</title>
    <link rel="icon" href="favicon.svg" sizes="any" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/grid.css">
    <link rel="stylesheet" href="../assets/css/index.css">
    <link rel="stylesheet" href="../assets/css/base.css">
    <link rel="stylesheet" href="../assets/css/search.css">
</head>
<body>
    <?php include "./header.php" ?>
    <!-- banner -->
    <div class="banner" style="height: 600px; background-image: url(https://dulichbiendanang.net/wp-content/uploads/2020/12/cau-vang-ba-na-hill2.jpg);">
        <!-- search -->
        <div class="search">
            <h1 class="search__heading1 text-shadow">Tìm kiếm kỳ nghỉ mà bạn thích</h1>
            <h1 class="search__heading2 text-shadow">Đừng bỏ lỡ những ưu đãi cực lớn</h1>
            <form action="" name="" method="" class="search__form">
                <select name="province" id="" class="search__select">
                    <option value="default" class="search__option">Địa điểm</option>
                    <?php
                        for($i = 0; $i < count($search_place_data); $i++) {
                            $search_option_provinceId = $search_place_data[$i]['MaTinh'];
                            $selected = $search_province == $search_option_provinceId? "selected": "";
                            
                            echo "<option value='{$search_option_provinceId}' {$selected} class='search__option'>{$search_place_data[$i]['TenTinh']}</option>";
                        }
                    ?>
                </select>
                <select name="price" id="" class="search__select">
                    <option value="default" class="search__option">Giá tiền</option>
                    <option value="Dưới 2 triệu" <?php echo $search_price == "Dưới 2 triệu"? "selected": "";  ?> class="search__option">Dưới 2 triệu</option>
                    <option value="2 triệu - 4 triệu" <?php echo $search_price == "2 triệu - 4 triệu"? "selected": "";  ?> class="search__option">2 triệu - 4 triệu</option>
                    <option value="4 triệu - 6 triệu" <?php echo $search_price == "4 triệu - 6 triệu"? "selected": "";  ?> class="search__option">4 triệu - 6 triệu</option>
                    <option value="Trên 6 triệu" <?php echo $search_price == "Trên 6 triệu"? "selected": "";  ?> class="search__option">Trên 6 triệu</option>                
                </select>
                <div class="search__discount">
                    <label for="discount" class="search__discount--label">Ưu đãi</label>
                    <input type="checkbox" name="discount" id="discount" class="search__discount--input">
                </div>
                <button type="submit" class="search__btn"></button>
            </form>
        </div>
    </div>
    <!-- content -->
    <div class="content">
        <div class="grid wide">
            <div class="row">
                <div class="col l-3">
                    <!-- đề xuất -->
                    <div class="proposals">
                        <h3 class="proposals__title">Gợi ý cho bạn</h3>
                        <?php echo $search_proposedTours_html; ?>
                    </div>
                </div>
                <div class="col l-9">
                    <div class="row">
                        <?php echo $search_html; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- footer -->
    <?php include "./footer.php" ?>

    <p class="copyright-text">&copy; All rights reserved. <strong>MTP Travel</strong></p>
    <script type="module" src="../assets/js/search.js"></script>
</body>
</html>