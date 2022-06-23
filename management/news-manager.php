<?php
    $connect = mysqli_connect("localhost", "root", "Tan@1204", "qlbantour");
    $currentPage = 1;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["page"]))
            $currentPage = $_POST['page'];
        elseif (isset($_POST["delete"])) {
            $ID = $_POST["delete"];

            $sql = "DELETE FROM tintuc WHERE MaTinTuc = $ID";
            mysqli_query($connect, $sql);
        }
        else {
            if (isset($_POST["news-name"]))
                $newsPlaceName = $_POST["news-placeName"];
            if (isset($_POST["news-title"]))
                $newsTitle = $_POST["news-title"];
            if (isset($_POST["news-desc"]))
                $newsDesc = $_POST["news-desc"];
            $newsTime = date("Y-m-d H:i:s", time());
            
            $tempSQL = "SELECT MaDiaDiem FROM diadiem WHERE TenDiaDiem = '$newsPlaceName'";
            $maDiaDiem = mysqli_fetch_all(mysqli_query($connect, $tempSQL), MYSQLI_ASSOC)[0]['MaDiaDiem'];

            if (isset($_POST["id"])) {
                $ID = $_POST["id"];    
    
                $sql = "UPDATE tintuc
                        SET MaDiaDiem = '$maDiaDiem',
                            TieuDe = '$newsTitle',
                            ChiTiet = '$newsDesc',
                        WHERE MaTinTuc = $ID
                        ";
                mysqli_query($connect, $sql);
                echo "<script> alert('Cập nhật thành công !') </script>";
            }
            else {
                $sql = "INSERT INTO tintuc(MaDiaDiem, TieuDe, ChiTiet, NgayDang)
                        VALUES ($maDiaDiem, '$newsTitle', '$newsDesc', '$newsTime')
                        ";
                mysqli_query($connect, $sql);
                echo "<script> alert('Thêm thành công !') </script>";
            }
        }   
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Tin Tức</title>
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
                <li class="menu__item active">
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
                <li class="menu__item">
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
                    <h1 class="content__tour--title">Tin Tức</h1>
                    
                    <?php include "./user-menu.php" ?>
                </div>
    
                <div class="container">
                    <div class="func-group">
                        <button class="add-btn">Thêm mới</button>
                        <div class="search">
                            <label for="search-input">Tìm kiếm:</label>
                            <input type="text" id="search-input" placeholder="Nhập tên địa điểm muốn tìm kiếm" class="">
                        </div>
                    </div>
                    <div class="table-container">

                        <table style="width: 1700px;">
                            <thead>
                                <tr>
                                    <th style="width: 160px;">Mã Tin Tức</th>
                                    <th style="width: 200px;">Tên Địa Điểm</th>
                                    <th style="width: 380px;">Tiêu Đề</th>
                                    <th style="width: 600px;">Chi Tiết</th>
                                    <th style="width: 200px;">Ngày Đăng</th>
                                    <th style="width: 160px;"> </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $sql = "SELECT MaTinTuc, TenDiaDiem, TieuDe, ChiTiet, NgayDang
                                    FROM tintuc t inner join diadiem d on t.MaDiaDiem = d.MaDiaDiem";
                                    $rows = mysqli_fetch_all(mysqli_query($connect, $sql), MYSQLI_ASSOC);
                                    $page = ceil(count($rows) / 10);
                                    if ($currentPage == $page) {
                                        for ($i = (($currentPage - 1) * 10); $i < count($rows); $i++) {
                                            echo "
                                                <tr class='table-row'>
                                                    <td class='text-center'>" . $rows[$i]['MaTinTuc'] . "</td>
                                                    <td class='text-center'>" . $rows[$i]['TenDiaDiem'] . "</td>
                                                    <td class='text-overflow' style='max-width: 400px;'>" . $rows[$i]['TieuDe'] . "</td>
                                                    <td class='text-overflow' style='max-width: 600px;'>" . $rows[$i]['ChiTiet'] . "</td>
                                                    <td class='text-center'>" . $rows[$i]['NgayDang'] . "</td>
                                                    <td class='text-center'>
                                                        <i class='fa-solid fa-pencil update-btn'></i>
                                                        <i class='fa-solid fa-trash-can delete-btn'></i>
                                                    </td>
                                                </tr>
                                            ";
                                        }
                                    }
                                    else {
                                        for ($i = (($currentPage - 1) * 10); $i <= ($currentPage * 10 - 1); $i++) {
                                            echo "
                                            <tr class='table-row'>
                                                <td class='text-center'>" . $rows[$i]['MaTinTuc'] . "</td>
                                                <td class='text-center'>" . $rows[$i]['TenDiaDiem'] . "</td>
                                                <td class='text-center'>" . $rows[$i]['TieuDe'] . "</td>
                                                <td class='text-center'>" . $rows[$i]['ChiTiet'] . "</td>
                                                <td class='text-center'>" . $rows[$i]['NgayDang'] . "</td>
                                                <td class='text-center'>
                                                    <i class='fa-solid fa-pencil update-btn'></i>
                                                    <i class='fa-solid fa-trash-can delete-btn'></i>
                                                </td>
                                            </tr>
                                            ";
                                        }
                                    }
                                ?>                          
                            </tbody>
                        </table>

                    </div>
    
                    <form method="POST" class="page">
                        
                        
                        <?php 
                            echo "
                                <button name='page' class='page-nav page-prev'>
                                    <i class='fa-solid fa-angle-left'></i>
                                </button>
                            ";
                            for ($i = 1; $i <= $page; $i++)
                            {
                                echo "<button name='page' value='$i' class='page-nav page-number'>$i</button>";
                            }
                            $next_btn_value = $currentPage+1;
                            echo "
                                <button name='page' class='page-nav page-next' value='{$next_btn_value}'>
                                    <i class='fa-solid fa-angle-right'></i>
                                </button>
                                
                            ";
                        ?>
                        
                    </form>
                    <script>
                        const currentPage = <?php echo $currentPage; ?>;
                        const page = <?php echo $page; ?>;
                        let changePageBtns = document.querySelectorAll('.page-number')
                        let prevPageBtn = document.querySelector('.page-prev')
                        let nextPageBtn = document.querySelector('.page-next')

                        if ( currentPage == 1)
                            prevPageBtn.disabled = true
                        else
                            prevPageBtn.disabled = false

                        if (currentPage == page)
                            nextPageBtn.disabled = true
                        else
                            nextPageBtn.disabled = false

                        changePageBtns.forEach(changePageBtn => {
                            if (changePageBtn.value == currentPage)
                                changePageBtn.classList.add('active')
                            else
                                changePageBtn.classList.remove('active')
                        })

                        prevPageBtn.onclick = () => {
                            console.log(prevPageBtn.name)
                            if (currentPage > 1)
                                prevPageBtn.value = currentPage - 1;
                        }

                        nextPageBtn.onclick = () => {
                            if (currentPage < page)
                                nextPageBtn.value = currentPage + 1;
                        }
                    </script>
                </div>
            </div>
            <p class="copyright-text">&copy; All rights reserved. <strong>MTP Travel</strong></p>
        </div>
        
        <div class="form-container">
            <form action="" class="form" method="post">

                <h2 class="form-heading text-center">Nhập thông tin mới</h2>

                <input type="text" id="id" name="" style="display: none;">

                <div class="form-group">
                    <label for="news-placeName" class="form-label">Tên Địa Điểm:</label>
                    <select name="news-placeName" id="news-placeName" class="form-input" required>
                        <?php 
                            echo "<option value='' class='form-option'>Tên địa điểm</option>";
                            $sql = "SELECT TenDiaDiem FROM diadiem";
                            $rows = mysqli_fetch_all(mysqli_query($connect, $sql), MYSQLI_ASSOC);
                            for ($i = 0; $i < count($rows); $i++) {
                               echo "<option value='" . $rows[$i]['TenDiaDiem'] . "' class='form-option'>" . $rows[$i]['TenDiaDiem'] . "</option>";
                            } 
                        ?>
                    </select>
                    <span class="form-message"></span>
                </div>

                <div class="form-group">
                    <label for="news-title" class="form-label">Tiêu đề: </label>
                    <textarea id="news-title" name="news-title" class="form-input" rows="3" placeholder="Tiêu đề" required></textarea>
                    <span class="form-message"></span>
                </div>

                <div class="form-group">
                    <label for="news-desc" class="form-label">Chi tiết:</label>
                    <textarea id="news-desc" name="news-desc" class="form-input" rows="5" placeholder="Chi tiết" required></textarea>
                    <span class="form-message"></span>
                </div>

                <div class="form-btn text-center">
                    <button class="btn-submit"></button>
                    <button type="button" class="btn-cancel">Hủy</button>
                </div>

            </form>
        </div>

        <form class="form-delete text-center" method="post">
            <p class="form-delete__message">Hành động này không thể hoàn tác. Bạn có chắc muốn tiếp tục ?</p>
            <div class="form-delete__btn">
                <button name="delete" type="submit" class="form-delete__btn--yes">Có</button>
                <button type="button" class="form-delete__btn--no">Không</button>                
            </div>
        </div>
    </div>
    <script type="module" src="../assets/js/news-manager.js"></script>
</body>
</html>