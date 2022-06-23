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
            $north_provinces_lis .= "<li><a href='./search.php?province={$data[$i]['MaTinh']}'>{$data[$i]['TenTinh']}</a></li>";
        }
        if($data[$i]['MaMien'] == "MT") {
            $central_provinces_lis .= "<li><a href='./search.php?province={$data[$i]['MaTinh']}'>{$data[$i]['TenTinh']}</a></li>";
        }
        if($data[$i]['MaMien'] == "MN") {
            $south_provinces_lis .= "<li><a href='./search.php?province={$data[$i]['MaTinh']}'>{$data[$i]['TenTinh']}</a></li>";
        }
    }

    mysqli_close($conn);
?>


<div class="mobile-nav">
    <ul class="mobile__nav-list">
        <li class="mobile-nav__item"><a href="index.php" class="mobile-nav__link">TRANG CHỦ</a></li>
        <li class="mobile-nav__item"><a href="./intro.php" class="mobile-nav__link">GIỚI THIỆU</a></li>
        <li class="mobile-nav__item">
            <a href="./tours.php" class="mobile-nav__link">TOUR</a>
        	<input type="checkbox" id="show-menu" />
        	<label for="show-menu" class="mobile-nav__expand-btn"></label>
            <div class="mobile-nav__menu-l2">
                <ul>
                    <h4>Miền Bắc</h4>
                    <?php echo $north_provinces_lis; ?>
                </ul>
                <ul>
                    <h4>Miền Trung</h4>
                    <?php echo $central_provinces_lis; ?>
                </ul>
                <ul>
                    <h4>Miền Nam</h4>
                    <?php echo $south_provinces_lis; ?>
                </ul>
            </div>
        </li>
        <li class="mobile-nav__item"><a href="./news.php" class="mobile-nav__link">TIN TỨC</a></li>
        <li class="mobile-nav__item"><a href="./contact.php" class="mobile-nav__link">LIÊN HỆ</a></li>
    </ul>
</div>
<link rel="stylesheet" href="../assets/css/mobile-nav.css">