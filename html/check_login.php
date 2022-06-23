<?php
        session_start();
        if($_POST && $_POST["login"] == "login"){
            $user_name_or_email= $_POST['user_name_or_email'];
            $pass_word= $_POST['password'];
            $result= mysqli_query ($conn, "SELECT *from thanhvien where (username= '$user_name_or_email' or Email='$user_name_or_email') and pass ='$pass_word'");
            $row = mysqli_fetch_assoc($result);
            if($row){
                $_SESSION['check_user'] = $user_name_or_email;
                header("Location: index.php");
                // exit();
            } else echo "<span class='form-message'>Tài khoản hoặc mật khẩu không chính xác. Vui lòng nhập lại !</span>";
        }
?>