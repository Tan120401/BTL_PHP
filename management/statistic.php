<?php
    $connect = mysqli_connect("localhost", "root", "Tan@1204", "qlbantour");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thống Kê</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/grid.css">
    <link rel="stylesheet" href="../assets/css/base.css">
    <link rel="stylesheet" href="../assets/css/manager.css">
</head>
<body>
    <div class="main" style="display: flex;">
       
        <div class="menu">
            <div class="menu__heading">
                
            </div>
            <ul class="menu__list">
                <li class="menu__item">
                    <a href="index.php" class="menu__link">
                        <i class="fa-solid fa-house menu__icon"></i>
                        Trang chủ
                    </a>
                </li>
                <li class="menu__item">
                    <a href="place-manager.php" class="menu__link">
                        <i class="fa-solid fa-map-location menu__icon"></i>
                        Quản lý địa điểm
                    </a>
                </li>
                <li class="menu__item">
                    <a href="image-manager.php" class="menu__link">
                        <i class="fa-solid fa-map-location menu__icon"></i>
                        Quản lý hình ảnh
                    </a>
                </li>
                <li class="menu__item">
                    <a href="member-manager.php" class="menu__link">
                        <i class="fa-solid fa-users menu__icon"></i>
                        Quản lý thành viên
                    </a>
                </li>
                <li class="menu__item">
                    <a href="news-manager.php" class="menu__link">
                        <i class="fa-solid fa-users menu__icon"></i>
                        Quản lý tin tức
                    </a>
                </li>
                <li class="menu__item">
                    <a href="tour-manager.php" class="menu__link">
                        <i class="fa-solid fa-plane-departure menu__icon"></i>
                        Quản lý tour
                    </a>
                </li>
                <li class="menu__item active">
                    <a href="statistic.php" class="menu__link">
                        <i class="fa-solid fa-chart-column menu__icon"></i>
                        Thống kê
                    </a>
                </li>
            </ul>
    
            <p class="text-center">MTP Travel</p>
        </div>
        <div class="content">
            <div>
                <div class="content__heading">
                    <h1 class="content__tour--title">Thống Kê</h1>
                    
                    <?php include "./user-menu.php" ?>
                </div>
                
                <div style="padding: 30px;">

                    <div class="grid">
                        <div class="row">
                            <div class="col l-4">
                                <div class="statistical pastel-orange">
                                    <p class="statistical__title">Số tour đã bán trong tháng</p>
                                    <?php 
                                        $date = date('Y-m-d');
                                        $sql = "SELECT MaTour FROM ct_tour
                                                WHERE MONTH(ct_tour.NgayKhoiHanh) = MONTH('$date') and YEAR(ct_tour.NgayKhoiHanh) = YEAR('$date') ";
                                        $rows = mysqli_fetch_all(mysqli_query($connect, $sql), MYSQLI_ASSOC);
                                        echo "<h3 class='statistical__quantity'>" . count($rows) . "</h3>";
                                    ?>
                                </div>
                            </div>
                            <div class="col l-4">
                                <div class="statistical pastel-pink">
                                    <?php 
                                        $sql = "SELECT SUM(ThanhTien) as 'doanhthu' FROM ct_tour
                                                    WHERE MONTH(ct_tour.NgayKhoiHanh) = MONTH('$date') and YEAR(ct_tour.NgayKhoiHanh) = YEAR('$date') ";
                                        $rows = mysqli_fetch_all(mysqli_query($connect, $sql), MYSQLI_ASSOC);
                                        $doanhthu = $rows[0]['doanhthu'];
                                    ?>
                                    <p class="statistical__title">Doanh thu trong tháng</p>
                                    <h3 class="statistical__quantity" id="doanh-thu" name="doanh-thu"><?php echo number_format($rows[0]['doanhthu'], 0, ",", "."); ?></h3>
                                </div>
                            </div>
                            
                        </div>
                    </div>

                </div>
            </div>
            <p class="copyright-text">&copy; All rights reserved. <strong>MTP Travel</strong></p>
    </div>
    <script type="text/javascript">
        const doanhThu = document.querySelector("#doanh-thu");
        doanhThu.innerText = compactNumber(<?php echo $doanhthu; ?>);

        function compactNumber(value) {
            const suff = ["", "K", "M", "B", "T"];
            const suffNum = Math.floor(("" + value).length / 3);

            let shortValue = parseFloat((suffNum != 0? (value / Math.pow(1000, suffNum)): value).toPrecision(2));

            if(shortValue % 1 != 0) {
                shortValue = shortValue.toFixed(1);
            }
            return shortValue + suff[suffNum];
        };

    </script>
    <script type="module" src="../assets/js/statistic.js"></script>
</body>
</html>