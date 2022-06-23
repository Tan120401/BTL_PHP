<?php 
    include "./database.php";
    session_start();

    $loggedIn_username_or_email = $_SESSION['check_user'];
    $profile_sql = "SELECT * FROM thanhvien WHERE username = '$loggedIn_username_or_email' or Email = '$loggedIn_username_or_email'";
    $profile_result = mysqli_query($conn, $profile_sql);
    $profile_data = mysqli_fetch_all($profile_result, MYSQLI_ASSOC);
    
    $memberId = $profile_data[0]["MaThanhVien"];
    $memberCurrentAvatar = $profile_data[0]["Avatar"];

    if(!$memberId || !$profile_data) {
        header("Location: profile.php");
        exit();
    }

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $memberUpdatedName = mysqli_real_escape_string($conn, $_POST["memberName"]);
        $memberUpdatedAddress = mysqli_real_escape_string($conn, $_POST["memberAddress"]);
        $memberUpdatedPhone = $_POST["memberPhone"];
        $memberUpdatedPassword = mysqli_real_escape_string($conn, $_POST["memberPassword"]);

        $memberUpdatedAvatar = $_POST["memberAvatar"];
        // echo $memberUpdatedAvatar;
        $avatarRemoved = $_POST["avatarRemoved"];

        $updateAvatarLink = $memberCurrentAvatar;
        $uploadAvatarAlert = "";

        if($avatarRemoved == "on") {
            // delete avatar
            if(realpath($memberCurrentAvatar)) {
                if(is_writable($memberCurrentAvatar)) {
                    unlink($memberCurrentAvatar);
                }
            }
            $updateAvatarLink = ""; 
        } else {
            // echo "???";
            // file
            // file_uploads = On
            if($_FILES["memberAvatar"]["name"]) {

                $target_dir = "../assets/img/user-avatars/";
                $target_file = $target_dir . basename($_FILES["memberAvatar"]["name"]);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                // echo $target_file . PHP_EOL;
                // Check if image file is a actual image or fake image
                // submit
                $check = getimagesize($_FILES["memberAvatar"]["tmp_name"]);
                if($check !== false) {
                    $uploadOk = 1;
                    // echo "???";
                    // $uploadAvatarAlert = "An image";
                } else {
                    // echo "Check check check...";
                    $uploadAvatarAlert = "<p class='error-mes'>Not an image.</p>";
                    $uploadOk = 0;
                }

                // Check if file already exists
                if (file_exists($target_file)) {
                  $uploadAvatarAlert =  "<p class='error-mes'>Sorry, file already exists.</p>";
                  $uploadOk = 0;
                }

                // Check file size
                if ($_FILES["memberAvatar"]["size"] > 5000000) {
                  $uploadAvatarAlert = "<p class='error-mes'>Sorry, your file is too large.</p>";
                  $uploadOk = 0;
                }

                // Allow certain file formats
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                  $uploadAvatarAlert = "<p class='error-mes'>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</p>";
                  $uploadOk = 0;
                }

                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                  // $uploadAvatarAlert = "<p class='error-mes'>Sorry, your file was not uploaded.</p>" . PHP_EOL;
                // if everything is ok, try to upload file
                } else {
                  if (move_uploaded_file($_FILES["memberAvatar"]["tmp_name"], $target_file)) {
                    // echo "<p class='success-mes'>The file ". htmlspecialchars( basename( $_FILES["memberAvatar"]["name"])). " has been uploaded.</p>";
                    $updateAvatarLink = $target_file;

                    // delete old avatar
                    if(realpath($memberCurrentAvatar)) {
                        if(is_writable($memberCurrentAvatar)) {
                            unlink($memberCurrentAvatar);
                        }
                    }
                    echo "Avatar uploaded successfully." . PHP_EOL;
                  } else {
                    $uploadAvatarAlert = "<p class='error-mes'>Sorry, there was an error uploading your file.</p>" . PHP_EOL;
                  }
                }

                $_SESSION["uploadAvatarAlert"] = $uploadAvatarAlert;
            }

        }
        
        $update_profile_sql = "UPDATE THANHVIEN SET TenThanhVien = '$memberUpdatedName', DiaChi = '$memberUpdatedAddress', SDT = '$memberUpdatedPhone', pass = '$memberUpdatedPassword', Avatar = '$updateAvatarLink' WHERE MaThanhVien = '$memberId'";
        $update_profile_result = mysqli_query($conn, $update_profile_sql);

        // echo $update_profile_sql;
        if(!$update_profile_result) {
            echo "Something went wrong." . PHP_EOL;
        } else echo "Done" . PHP_EOL;
    }
    mysqli_close();
    header("Location: profile.php");
    exit();
?>