<?php 
   session_start();
?>

<?php 
    $conn = mysqli_connect("localhost", "root", "Tan@1204", "qlbantour");
    if (!$conn) {
      die("Connection failed");
    }

    $sql = "SELECT * FROM TINH, MIEN WHERE TINH.MaMien = MIEN.MaMien";
    $result = mysqli_query($conn, $sql);    
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $north_provinces_lis = "";
    $central_provinces_lis = "";
    $south_provinces_lis = "";

    for($i = 0; $i < count($data); $i++) {
        if($data[$i]['MaMien'] == "MB") {
            $north_provinces_lis .= "<li class='header__nav--menu2--item'><a href='./search.php?province={$data[$i]['MaTinh']}' class='header__nav--menu2--link'>{$data[$i]['TenTinh']}</a></li>";
        }
        if($data[$i]['MaMien'] == "MT") {
            $central_provinces_lis .= "<li class='header__nav--menu2--item'><a href='./search.php?province={$data[$i]['MaTinh']}' class='header__nav--menu2--link'>{$data[$i]['TenTinh']}</a></li>";
        }
        if($data[$i]['MaMien'] == "MN") {
            $south_provinces_lis .= "<li class='header__nav--menu2--item'><a href='./search.php?province={$data[$i]['MaTinh']}' class='header__nav--menu2--link'>{$data[$i]['TenTinh']}</a></li>";
        }
    }
    mysqli_close($conn);
?>
<header class="header">
        <!-- logo -->
        <a href="index.php" class="header__logo">
            <svg class="header__logo--img" xmlns="http://www.w3.org/2000/svg" clip-rule="evenodd" fill-rule="evenodd" image-rendering="optimizeQuality" shape-rendering="geometricPrecision" text-rendering="geometricPrecision" viewBox="0 0 635.7 292.97" style="fill: rgb(0, 0, 0);" role="img">
                <g>
                    <path d="M139.48 186.36c-30.17,18.31 -21.73,29.67 -34.06,45.73 -32.35,-12.03 -56.31,1.96 -62.73,31.22 -10.35,-1.95 -21.22,-2.68 -30.49,3.46 -0.52,0.35 -23.36,22.43 -5.21,25.15 2.24,0.34 7.73,0.22 10.23,0.2 31.33,-0.32 62.79,-0.48 94.34,-0.53 70.43,-79.46 160.03,-143.85 268.8,-193.18 -8.47,-8.63 -18.18,-16.5 -31.39,-21.74 -67.17,-26.66 -145.41,13.86 -144.28,103.63 -28.01,-5.66 -40.9,-8.7 -65.2,6.05z" style="fill: rgb(40, 157, 210);"></path>
                    <path d="M391.33 110.45c-70.25,47.66 -128.76,108.1 -175.55,181.34 140.3,0.61 281.4,2.24 419.62,0.17 2.09,-18.04 -7.46,-33.67 -16.41,-42.67 -28.37,-28.48 -37.03,-2.28 -47.1,-30.36 -1.8,-5.03 -3.02,-7.19 -5.64,-11.3 -16.23,-25.46 -34.58,-32.26 -68.65,-28.28 -5.05,-25.37 -18.27,-38.74 -32.97,-50.56 -16.85,-13.55 -41.82,-15.85 -67.62,-11.87 -1.91,-2.13 -3.79,-4.29 -5.69,-6.47z" style="fill: rgb(247, 247, 247);"></path><path d="M477.21 117.34l5.23 -3.31 3.57 -20.95 8.91 -5.64c1.44,-0.91 1.87,-2.83 0.96,-4.27 -0.91,-1.44 -2.83,-1.87 -4.27,-0.96l-4.2 2.66 3.55 -20.81 7.51 -4.75c1.44,-0.91 1.87,-2.83 0.96,-4.27 -0.91,-1.44 -2.83,-1.87 -4.27,-0.96l-2.81 1.77 2.92 -17.11c20.37,-13.65 37.19,-28.65 33.91,-33.84 -3.28,-5.19 -24.05,3.58 -45.11,16.14l-16.71 -4.7 2.81 -1.77c1.44,-0.91 1.87,-2.83 0.96,-4.27 -0.91,-1.44 -2.83,-1.87 -4.27,-0.96l-7.51 4.75 -20.32 -5.71 4.2 -2.66c1.44,-0.91 1.87,-2.83 0.96,-4.27 -0.91,-1.44 -2.83,-1.87 -4.27,-0.96l-8.91 5.64 -20.46 -5.75 -5.23 3.31 52.56 34.74c-21.32,15.24 -42.2,31.96 -42.2,31.96l-25.29 -7.24 -3.41 2.79 15.17 15.79 -2.85 5.34 6.05 -0.29 7.77 20.47 3.98 -1.89 4.3 -25.96c0,0 24.06,-11.7 46.96,-24.43l8.86 62.38z" style="fill: rgb(40, 157, 210);"></path>
                </g>
            </svg>
        </a>
        <!-- navigation bar -->
        <nav class="header__nav">
            
            <ul class="header__nav--list">
                <li class="header__nav--item"><a href="index.php" class="header__nav--link">TRANG CHỦ</a></li>
                <li class="header__nav--item"><a href="intro.php" class="header__nav--link">GIỚI THIỆU</a></li>
                <li class="header__nav--item">
                    <a href="./tours.php" class="header__nav--link">TOUR</a>
                    <div class="header__nav--menu2">
                        <ul class="header__nav--menu2--list">
                            <h4 class="header__nav--menu2--title">Miền Bắc</h4>
                            <?php echo $north_provinces_lis; ?>
                        </ul>
                        <ul class="header__nav--menu2--list">
                            <h4 class="header__nav--menu2--title">Miền Trung</h4>
                            <?php echo $central_provinces_lis; ?>
                        </ul>
                        <ul class="header__nav--menu2--list">
                            <h4 class="header__nav--menu2--title">Miền Nam</h4>
                            <?php echo $south_provinces_lis; ?>
                        </ul>
                    </div>
                </li>
                <li class="header__nav--item"><a href="./news.php" class="header__nav--link">TIN TỨC</a></li>
                <li class="header__nav--item"><a href="./contact.php" class="header__nav--link">LIÊN HỆ</a></li>
            </ul>
        </nav>
        <?php include "./mobile-nav.php" ?>

        <div style="display:flex">
            <!-- hamburger -->
            <div class="header__hamburger" id="hamburger">
                <div></div>
                <div></div>
                <div></div>
            </div>
            <!-- login -->
            <div class="header__login">
                <button class="header__login--btn">
                    <a href="login.php" style="color: #fff;">Đăng nhập</a>
                </button>
            </div>
            <!-- user -->
            <?php 
                $conn = mysqli_connect("localhost", "root", "Tan@1204", "qlbantour");
                if (!$conn) {
                  die("Connection failed");
                }
                
                $s = isset($_SESSION['check_user']) ? $_SESSION['check_user'] :'';
                $s = trim($_SESSION['check_user']);
                $result = mysqli_query($conn,"SELECT *FROM thanhvien where username= '$s' or Email='$s'");
                $row = mysqli_fetch_all($result, MYSQLI_ASSOC);

                $userAvatar = $row[0]['Avatar']? $row[0]['Avatar']: "../assets/img/sticker/user.jpg";
            ?>
            <div class="header__user">
                <div class="header__user--img" title="Trang cá nhân của bạn">
                    <img src="<?php echo $userAvatar; ?>" alt="">
                </div>
                <div class="header__user--menu">
                    <div class="header__user--menu--heading">
                        <img src="<?php echo $userAvatar; ?>" alt="" class="header__user--menu--heading--avt">
                        <div class='header__user--menu--heading--name'><?php echo $row[0]['TenThanhVien']?></div>
                    </div>
                    <ul class="header__user--menu--list">
                        <li class="header__user--menu--item">
                            <a href="./profile.php" class="header__user--menu--link">Trang cá nhân</a>
                        </li>
                        <li class="header__user--menu--item">
                            <a href="./favorites.php" class="header__user--menu--link">Địa điểm yêu thích</a>
                        </li>
                        <?php
                            $s= isset($_SESSION['check_user']) ? $_SESSION['check_user'] :'';
                            $result = mysqli_query($conn,"SELECT *FROM thanhvien where username= '$s' or Email='$s' ") ;
                            $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
                            if($row[0]['role'] == '0'){
                                echo "
                                    <li class='header__user--menu--item'>
                                        <a href='../management/index.php' class='header__user--menu--link'>Quản lý</a>
                                    </li>
                                ";
                            }
                        ?>
                        <li class="header__user--menu--item">
                            <a href="" class="header__user--menu--link">Cài đặt</a>
                        </li>
                        <li class="header__user--menu--item">
                            <a href="./logout.php" class="header__user--menu--link">Đăng xuất</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
</header>
<div class="mask" id="mask"></div>
<script type="module" src="../assets/js/header.js"></script>