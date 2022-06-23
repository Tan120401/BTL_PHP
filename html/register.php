<?php
    session_start();
    if(isset($_POST) && $_POST["register"] == "register"){
        $fullname = htmlspecialchars($_POST['fullname']);
        $address = htmlspecialchars($_POST['address']);
        $email = htmlspecialchars($_POST['email']);
        $phone = htmlspecialchars($_POST['phone']);
        $user = htmlspecialchars($_POST['user']);
        $cre_password = htmlspecialchars($_POST['create-password']);
        $result =  mysqli_query($conn, "SELECT * FROM thanhvien");
        $register_row = mysqli_fetch_all($result, MYSQLI_ASSOC);

        $check = 0;
        for($i = 0; $i < count($register_row); $i++) {
            if($register_row[$i]['username'] == $user){
                $check = 1;
            }
        }

        if($check != 1){
            $sql = "INSERT INTO thanhvien (TenThanhVien, DiaChi, Email, SDT, username, pass, role )
                    VALUES ('$fullname', '$address', '$email', '$phone', '$user', '$cre_password','1')";

            if ($conn->query($sql) === TRUE) {
                $_SESSION['check_user'] = $user;
                header("Location: index.php");
            }

        } else {
            echo "<span class='form-message'>Vui lòng nhập tên đăng nhập khác</span>";
        }
    }
?>