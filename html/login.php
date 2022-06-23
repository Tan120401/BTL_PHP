<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập - MTP Travel</title>
    <link rel="icon" href="favicon.svg" sizes="any" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/base.css">
    <link rel="stylesheet" href="../assets/css/login.css">

</head>
<body>
    <!-- ket noi database -->
    <?php include_once 'database.php'?>
    <!-- dang nhap -->
    <?php 
        $activeClass = "login";
        if($_POST["register"] == "register") {
            $activeClass = "register";
        }

    ?>
    <div class="main">
        <div class="container <?php echo $activeClass; ?>">
            <div id="form1">

                <div class="form-heading">
                        <div class="form-heading__item <?php echo $activeClass == "login"? "active": "" ?>" data="login">Đăng nhập</div>
                        <div class="form-heading__item <?php echo $activeClass == "register"? "active": "" ?>" data="register">Đăng ký</div>
                </div>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" class="form form-login">
                    <div class="form-group">
                        <input type="text" name="user_name_or_email" placeholder="Email hoặc username" class="form-input">
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" placeholder="Mật khẩu" class="form-input">

                        <div class="form-icon">
                            <img src="../assets/img/sticker/eye.png" alt="" name="eye" class="active">
                            <img src="../assets/img/sticker/eye-slash.png" alt="" name="eye-slash" class="">
                        </div>
                    </div>

                    <!-- check login -->
                    <?php include 'check_login.php';?>
                    <!-- ----------- -->

                    <a href="" class="form-forget-pass">Quên mật khẩu ?</a>
                    <button type="submit" class="form-btn" name="login" value="login">Đăng nhập</button>
                </form>
                
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" class="form form-register">
                    <div class="form-group">
                        <input type="text" name="fullname" value="<?php echo $_POST["fullname"]; ?>" placeholder="Họ và tên" class="form-input">
                        <span class="form-message"></span>
                    </div>
                    <div class="form-group">
                        <input type="type" name="address" value="<?php echo $_POST["address"]; ?>" placeholder="Địa chỉ" class="form-input">
                        <span class="form-message"></span>
                    </div>
                    <div class="form-group">
                        <input type="text" name="email" value="<?php echo $_POST["email"]; ?>" placeholder="Email" class="form-input">
                        <span class="form-message"></span>
                    </div>
                    
                    <div class="form-group">
                        <input type="type" name="phone" value="<?php echo $_POST["phone"]; ?>" placeholder="Số điện thoại" class="form-input">
                        <span class="form-message"></span>
                    </div>
                    <div class="form-group">
                        <input type="text" name="user" value="<?php echo $_POST["user"]; ?>" placeholder="Tên tài khoản" class="form-input">
                        <span class="form-message"></span>
                        <?php include "./register.php" ?>
                    </div>

                    <div class="form-group">
                        <input type="text" name="create-password" value="<?php echo $_POST["create-password"]; ?>" placeholder="Mật khẩu" class="form-input">
                        <span class="form-message"></span>
                    </div>
                    <button type="submit" class="form-btn" name="register" value="register">Đăng ký</button>
                </form>
            </div>
            <div class="account-banner">
                <img src="../assets/img/sticker/account-banner.png" alt="" class="account-banner__img">
                <div class="account-banner__desc">
                    <h2 class="account-banner__heading">Chúc bạn một ngày tốt lành</h2>
                    <p class="account-banner__details">Đồng hành cũng chúng tôi để tạo ra những chuyến đi thật đáng nhớ !</p>
                </div>
            </div>    
        </div>
    </div>
    
    <script  src="../assets/js/login.js"></script>
    <?php 
            $connect = mysqli_connect("localhost", "root", "Tan@1204", "qlbantour");

            $sql = "SELECT username FROM thanhvien";
            $results = mysqli_fetch_all(mysqli_query($connect, $sql), MYSQLI_ASSOC);
            echo "
                <script>
                    let leng = 15
                    let usernames = []
            ";
            for ($i = 0; $i < count($results); $i++) {
                echo "
                    usernames.push('" . $results[$i]['username'] . "')
                    ";
            }
        ?>
         
            let usernameInput = document.querySelector('.form-input[name="user"]')
            usernameInput.addEventListener("blur",() => {
                let checkExist = true
                usernames.forEach(username => {
                    if (username == usernameInput.value) {
                        checkExist = false
                    }
                })  
                if (usernameInput.value== '') {
                    usernameInput.nextElementSibling.innerText = 'Vui lòng điền trường này'
                    usernameInput.style.borderColor = '#f33a58'
                    check = false
                }
                else if (!checkExist) {
                    usernameInput.nextElementSibling.innerText = 'Tên đăng nhập đã tồn tại'
                    usernameInput.style.borderColor = '#f33a58'
                }
                else {
                    usernameInput.nextElementSibling.innerText = ''
                    usernameInput.style.borderColor = '#ccc'
                    check = true
                }
               
                
                    
            })
            
        </script>
    
</body>
</html>