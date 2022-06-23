<?php
    $connect = mysqli_connect("localhost", "root", "Tan@1204", "qlbantour");
    $currentPage = 1;
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["page"]))
            $currentPage = $_POST['page'];
        elseif (isset($_POST["delete"])) {
            $ID = $_POST["delete"];

            $sql = "DELETE FROM thanhvien WHERE MaThanhVien = $ID";
            mysqli_query($connect, $sql);
        }
        else {
            if (isset($_POST["member-name"]))
                $memberName = $_POST["member-name"];
            if (isset($_POST["member-address"]))
                $memberAddress = $_POST["member-address"];
            if (isset($_POST["member-email"]))
                $memberEmail = $_POST["member-email"];
            if (isset($_POST["member-phone"]))
                $memberPhone = $_POST["member-phone"];
            if (isset($_POST["member-username"]))
                $memberUsername = $_POST["member-username"];
            if (isset($_POST["member-password"]))
                $memberPassword = $_POST["member-password"];
            if (isset($_POST["member-role"]))
                $memberRole = $_POST["member-role"];

            if (isset($_POST["id"])) {
                $ID = $_POST["id"];    
    
                $sql = "UPDATE thanhvien
                        SET TenThanhVien = '$memberName',
                            DiaChi = '$memberAddress',
                            Email = '$memberEmail',
                            SDT = '$memberPhone',
                            pass = '$memberPassword',
                            role = '$memberRole'
                        WHERE MaThanhVien = $ID
                        ";
                mysqli_query($connect, $sql);
                echo "<script> alert('Cập nhật thành công !') </script>";
            }
            else {
                $sql = "INSERT INTO thanhvien(TenThanhVien, DiaChi, Email, SDT, username, pass, role)
                        VALUES ('$memberName', '$memberAddress', '$memberEmail', '$memberPhone', '$memberUsername', '$memberPassword', '$memberRole')
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
    <title>Quản Lý Thành Viên</title>
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
                <li class="menu__item active">
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
                    <h1 class="content__tour--title">Thành Viên</h1>
                    
                    <?php include "./user-menu.php" ?>
                </div>
    
                <div class="container">
                    <div class="func-group">
                        <button class="add-btn">Thêm mới</button>
                        <div class="search">
                            <label for="search-input">Tìm kiếm:</label>
                            <input type="text" id="search-input" placeholder="Nhập tên thành viên muốn tìm kiếm" class="">
                        </div>
                    </div>
                    <div class="table-container">

                        <table style="width: 2000px;">
                            <thead>
                                <tr>
                                    <th style="width: 160px;">Mã Thành Viên</th>
                                    <th style="width: 300px;">Tên Thành Viên</th>
                                    <th style="width: 400px;">Địa Chỉ</th>
                                    <th style="width: 280px;">Email</th>
                                    <th style="width: 200px;">Số Điện Thoại</th>
                                    <th style="width: 200px;">Username</th>
                                    <th style="width: 200px;">Password</th>
                                    <th style="width: 100px;">Role</th>
                                    <th style="width: 160px;"> </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $sql = "SELECT MaThanhVien, TenThanhVien, DiaChi, Email, SDT, username, pass, role
                                            FROM thanhvien";
                                    $rows = mysqli_fetch_all(mysqli_query($connect, $sql), MYSQLI_ASSOC);
                                    $page = ceil(count($rows) / 10);
                                    if ($currentPage == $page) {
                                        for ($i = (($currentPage - 1) * 10); $i < count($rows); $i++) {
                                            echo "
                                                <tr class='table-row'>
                                                    <td class='text-center'>" . $rows[$i]['MaThanhVien'] . "</td>
                                                    <td class='text-center'>" . $rows[$i]['TenThanhVien'] . "</td>
                                                    <td class='text-center'>" . $rows[$i]['DiaChi'] . "</td>
                                                    <td class='text-center'>" . $rows[$i]['Email'] . "</td>
                                                    <td class='text-center'>" . $rows[$i]['SDT'] . "</td>
                                                    <td class='text-center'>" . $rows[$i]['username'] . "</td>
                                                    <td class='text-center'>" . $rows[$i]['pass'] . "</td>
                                                    <td class='text-center'>" . $rows[$i]['role'] . "</td>
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
                                                <td class='text-center'>" . $rows[$i]['MaThanhVien'] . "</td>
                                                <td class='text-center'>" . $rows[$i]['TenThanhVien'] . "</td>
                                                <td class='text-center'>" . $rows[$i]['DiaChi'] . "</td>
                                                <td class='text-center'>" . $rows[$i]['Email'] . "</td>
                                                <td class='text-center'>" . $rows[$i]['SDT'] . "</td>
                                                <td class='text-center'>" . $rows[$i]['username'] . "</td>
                                                <td class='text-center'>" . $rows[$i]['pass'] . "</td>
                                                <td class='text-center'>" . $rows[$i]['role'] . "</td>
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
                    <label for="member-name" class="form-label">Tên thành viên:</label>
                    <input id="member-name" name="member-name" class="form-input" placeholder="Tên thành viên" required></input>
                    <span class="form-message"></span>
                </div>

                <div class="form-group">
                    <label for="member-address" class="form-label">Địa chỉ: </label>
                    <input id="member-address" name="member-address" class="form-input" placeholder="Địa chỉ" required></input>
                    <span class="form-message"></span>
                </div>

                <div class="form-group">
                    <label for="member-email" class="form-label">Email:</label>
                    <input id="member-email" name="member-email" class="form-input" placeholder="Email" required></input>
                    <span class="form-message"></span>
                </div>

                <div class="form-group">
                    <label for="member-phone" class="form-label">Số điện thoại:</label>
                    <input id="member-phone" name="member-phone" class="form-input" placeholder="Số điện thoại" required></input>
                    <span class="form-message"></span>
                </div>

                <div class="form-group">
                    <label for="member-username" class="form-label">Username:</label>
                    <input id="member-username" name="member-username" class="form-input" placeholder="Username" required></input>
                    <span class="form-message"></span>
                </div>

                <div class="form-group">
                    <label for="member-password" class="form-label">Password:</label>
                    <input id="member-password" name="member-password" class="form-input" placeholder="Password" required></input>
                    <span class="form-message"></span>
                </div>

                <div class="form-group">
                    <label for="member-role" class="form-label">Role:</label>
                    <select name="member-role" id="member-role" class="form-input" required>
                        <option value="" class="form-option">Role</option>
                        <option value="1" class="form-option">1</option>
                        <option value="0" class="form-option">0</option>
                    </select>
                    <span class="form-message"></span>
                </div>

                <div class="form-btn text-center">
                    <button class="btn-submit"></button>
                    <button type="button" class="btn-cancel">Hủy</button>
                </div>

                <?php
                
                    
                    $usernameInput = "temp";
                    echo "
                        <script>
                            let updateBtns = document.querySelectorAll('.update-btn')
                            let memberUsername = document.getElementById('member-username')

                            updateBtns.forEach(updateBtn => updateBtn.addEventListener('click', ()  => {
                                memberUsername.disabled = true
                            }))

                            document.querySelector('.btn-cancel').addEventListener('click', () => memberUsername.disabled = false)
                            document.querySelector('.form-container').addEventListener('click', () => memberUsername.disabled = false)
                        </script>
                    ";
                    
                ?>

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
    <script type="module" src="../assets/js/member-manager.js"></script>
</body>
</html>