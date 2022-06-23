<?php include "../html/database.php" ?>
<?php
    session_start();
    $loggedIn_username_or_email = $_SESSION["check_user"];

    $loggedIn_member_sql = "SELECT * from THANHVIEN WHERE username = '$loggedIn_username_or_email' or Email='$loggedIn_username_or_email'";
    $loggedIn_member_result = mysqli_query($conn, $loggedIn_member_sql);
    $loggedIn_member_data = mysqli_fetch_all($loggedIn_member_result, MYSQLI_ASSOC);

    $loggedIn_memberId = $loggedIn_member_data[0]["MaThanhVien"];
    $loggedIn_memberName = $loggedIn_member_data[0]["TenThanhVien"];

    mysqli_close($conn);
?>


<div class="content__user">
    <div class="content__user--img" title="Trang cá nhân của bạn">
        <img src="../assets/img/sticker/user.jpg" alt="">
    </div>
    <i class="fa-solid fa-caret-down content__user--down"></i>
    <i class="fa-solid fa-caret-up content__user--up"></i>
    <div class="content__user--menu">
        <div class="content__user--menu--heading">
            <img src="../assets/img/sticker/user.jpg" alt="" class="content__user--menu--heading--avt">
            <div class="content__user--menu--heading--name"><?php echo $loggedIn_memberName; ?></div>
        </div>
        <ul class="content__user--menu--list">
            <li class="content__user--menu--item">
                <a href="#" class="content__user--menu--link">Trang cá nhân</a>
            </li>
            <li class="content__user--menu--item">
                <a href="../html/favorites.php" class="content__user--menu--link">Địa điểm yêu thích</a>
            </li>
            <li class="content__user--menu--item">
                <a href="./index.php" class="content__user--menu--link">Quản lý</a>
            </li>
            <li class="content__user--menu--item">
                <a href="#" class="content__user--menu--link">Cài đặt</a>
            </li>
            <li class="content__user--menu--item">
                <a href="../html/logout.php" class="content__user--menu--link">Đăng xuất</a>
            </li>
        </ul>
    </div>
</div>