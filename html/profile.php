<?php 
    include "./database.php";
    // START SESSION
    session_start();

    $loggedIn_username_or_email = $_SESSION['check_user'];
    $profile_sql = "SELECT * FROM thanhvien WHERE username = '$loggedIn_username_or_email' or Email = '$loggedIn_username_or_email'";
    $profile_result = mysqli_query($conn, $profile_sql);
    $profile_data = mysqli_fetch_all($profile_result, MYSQLI_ASSOC);

    $profile_html = "";
    if(!$profile_data || !$profile_data[0]['MaThanhVien']) {
        $profile_html = "<p style='text-align: center'>Hãy đăng nhập để tiếp tục. <a href='./login.php' style='text-decoration: underline'>Đăng nhập</a></p>";
        header("Location: login.php");
        exit();
    } else {
        // $profile_memberId = $profile_data[0]['MaThanhVien'];
        $profile_userName = $profile_data[0]['TenThanhVien'];
        $profile_userAvatar = $profile_data[0]['Avatar'];
        $profile_userAddress = $profile_data[0]['DiaChi'];
        $profile_userEmail = $profile_data[0]['Email'];
        $profile_userPhone = $profile_data[0]['SDT'];
        $profile_userUsername = $profile_data[0]['username'];
        $profile_userPassword = $profile_data[0]['pass'];
        $profile_userRole = $profile_data[0]['role'];

        $profile_userAvatar = $profile_userAvatar? $profile_userAvatar : "../assets/img/sticker/user.jpg";
    }

    $uploadAvatarAlert = $_SESSION["uploadAvatarAlert"];
    $_SESSION["uploadAvatarAlert"] = "";

    mysqli_close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MTP Travel | Profile</title>
    <link rel="icon" href="favicon.svg" sizes="any" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <link rel="stylesheet" href="../assets/css/grid.css">
	<link rel="stylesheet" href="../assets/css/index.css">
    <link rel="stylesheet" href="../assets/css/base.css">
	<link rel="stylesheet" type="text/css" href="../assets/css/profile.css">
</head>
<body>
    
    <?php include "./header.php"; ?>

    <div class="profile">
        <div class="profile-container">
            <?php echo $profile_html; ?>

            <div class="profile__header">
                <div class="profile__header-image">
                    <img src="<?php echo $profile_userAvatar; ?>" alt="Avatar">
                </div>
                <div class="profile__header-userInfo">
                    <div class="profile__header-userName"><?php echo $profile_userName; ?></div>
                    <div class="profile__header-userUsername"><?php echo $profile_userUsername; ?></div>
                    <div class="profile__header-userEmail">
                        Email: <?php echo $profile_userEmail; ?>
                    </div>
                </div>
            </div>
            <div class="profile__main">
                <div class="profile__main-title">Thông tin cá nhân</div>
                <div class="profile__update-form">
                    <form id="update-form" action="./update_profile.php" method="post" enctype="multipart/form-data">
                        <div class="profile__update-form-row">
                            <label for="member-name">Họ tên: </label>
                            <div class="profile__update-form__input-container">
                                <input type="text" name="memberName" id="member-name" spellcheck="false" value='<?php echo $profile_userName; ?>'>
                            </div>
                        </div>

                        <div class="profile__update-form-row">
                            <label for="member-address">Địa chỉ: </label></td>
                            <div class="profile__update-form__input-container">
                                <input type="text" name="memberAddress" id="member-address" spellcheck="false" value="<?php echo $profile_userAddress; ?>">
                            </div>
                        </div>
                        
                        <div class="profile__update-form-row">
                            <label for="member-phone">Số điện thoại: </label>
                            <div class="profile__update-form__input-container">
                                <input type="text" name="memberPhone" id="member-phone" spellcheck="false" value="<?php echo $profile_userPhone; ?>">
                            </div>
                        </div>
                        
                        <div class="profile__update-form-row">
                            <label for="member-avatar">Ảnh đại diện: </label>
                            <div>
                                <div style="display: flex">
                                    <img class="profile__update-form-avatar" src="<?php echo $profile_userAvatar; ?>" alt="Avatar">
                                    <div>
                                        <input type="file" name="memberAvatar" id="member-avatar">
                                    </div>
                                </div>
                                <?php echo $uploadAvatarAlert; ?>
                            </div>
                        </div>

                        <div class="profile__update-form-row">
                            <label for="avatar-removed">Xóa ảnh đại diện</label>
                            <input type="checkbox" name="avatarRemoved" id="avatar-removed">
                        </div>
                        
                        <div class="profile__update-form-row">
                            <label for="member-password">Mật khẩu: </label>
                            <div class="profile__update-form__input-container">
                                <input type="text" name="memberPassword" id="member-password" spellcheck="false" value="<?php echo $profile_userPassword; ?>">
                            </div>
                        </div>
                        
                        <div class="profile__update-form-row">
                            <button type="submit" class="submit-btn">Cập nhật</button>
                            <button type="button" class="cancel-btn">Hủy</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include "./footer.php" ?>
    <script type="text/javascript">
        const PROFILE_DATA = {
            name: `<?php echo $profile_userName; ?>`,
            address: `<?php echo $profile_userAddress; ?>`,
            phone: `<?php echo $profile_userPhone; ?>`, 
            avatar: `<?php echo $profile_userAvatar; ?>`,
            deleteAvt: false,
            pw: `<?php echo $profile_userPassword; ?>`
        };
    </script>
    <script src="../assets/js/profile.js"></script>
</body>
</html>