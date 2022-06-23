<?php 
	include "./database.php";

	session_start();

	$tourId = $_GET["tourId"];
	if(!$tourId) {
		mysqli_close();
		header("Location: ./index.php");
		exit();
	}

	$loggedIn_username_or_email = $_SESSION["check_user"];

  	$loggedIn_member_sql = "SELECT * from THANHVIEN WHERE username = '$loggedIn_username_or_email' or Email='$loggedIn_username_or_email'";
  	$loggedIn_member_result = mysqli_query($conn, $loggedIn_member_sql);
  	$loggedIn_member_data = mysqli_fetch_all($loggedIn_member_result, MYSQLI_ASSOC);

	$loggedIn_memberId = $loggedIn_member_data[0]["MaThanhVien"];
	if(!$loggedIn_memberId && $_SERVER["REQUEST_METHOD"] == "POST") {
		$add_review_alert = "<p style='color: red'>Bạn cần đăng nhập để tiếp tục.</p>";
	} else {
		$tourDetails_sql = "SELECT DIADIEM.MaDiaDiem, TenDiaDiem, TenTour, TenTinh, TINH.MaTinh, MIEN.MaMien, TenMien, TOUR.MoTa, DIADIEM.DonGia, DIADIEM.GioiThieu from TOUR, MIEN, DIADIEM, TINH WHERE TOUR.MaDiaDiem = DIADIEM.MaDiaDiem and MIEN.MaMien = tinh.MaMien and diadiem.MaTinh = tinh.MaTinh and TOUR.MaTour = '$tourId'";
		$tourDetails_result = mysqli_query($conn, $tourDetails_sql);
		$tourDetails_data = mysqli_fetch_all($tourDetails_result, MYSQLI_ASSOC);

		$placeId = $tourDetails_data[0]['MaDiaDiem'];

		$addStarsText = $_POST["stars"];
		$addReviewText = htmlspecialchars($_POST["review"]);

	    if($addReviewText && $addStarsText) {
	    	// check review exist
	    	$check_exist_review_sql = "SELECT COUNT(1) as 'c'
				FROM ythichdgia
				WHERE ythichdgia.MaThanhVien = '$loggedIn_memberId' and ythichdgia.MaDiaDiem = '$placeId'";

	    	$check_exist_review_result = mysqli_query($conn, $check_exist_review_sql);
	    	$check_exist_review_data = mysqli_fetch_all($check_exist_review_result, MYSQLI_ASSOC);

	    	$doesExistsMemberReview = $check_exist_review_data[0]['c'] == 1;

	    	// Review data
			$reviewed_stars = $addStarsText;
	    	if(!isset($_POST["favorite"])) $isFavorite = 0;
	    	if($_POST["favorite"] == "on") $isFavorite = 1;

	    	$added_review = mysqli_real_escape_string($conn, $addReviewText);
	    	// SET TIMEZONE IN VIETNAM (HO CHI MINH City)
	    	date_default_timezone_set('Asia/Ho_Chi_Minh');
	    	$added_review_date = date("Y/m/d H:i:s");

	    	if($doesExistsMemberReview) {

		    	$review_update_sql = "UPDATE YTHICHDGIA SET Sao = $reviewed_stars, NhanXet = '$added_review', YeuThich = $isFavorite, NgayDanhGia = '$added_review_date' 
		    		WHERE MaThanhVien = '$loggedIn_memberId' and MaDiaDiem = '$placeId'";
	    		$review_update_result = mysqli_query($conn, $review_update_sql);

	    	} else {
		    	$review_add_sql = "INSERT INTO YTHICHDGIA VALUES ('$loggedIn_memberId', '$placeId', $reviewed_stars, '$added_review', $isFavorite, '$added_review_date')";
	    		$review_add_result = mysqli_query($conn, $review_add_sql);

	    		if(!$review_add_result) {
	    			// echo "<script type='text/javascript'>alert('Bạn chỉ được nhận xét 1 lần.')</script>";
	    		}
	    	}

			$addStarsText = "";
			$addReviewText = "";

	    } else if ($addReviewText && !$addStarsText) {
	    	$undone_review = $addReviewText;
			$add_review_alert = "<p style='color: red'>Xin nhập số sao của bạn cho địa điểm này</p>";
	    } else if (!$addReviewText && $addStarsText) {
	    	$undone_stars = $addStarsText;
			$add_review_alert = "<p style='color: red'>Xin nhập nhận xét của bạn cho địa điểm này</p>";
	    } else {
	    	$add_review_alert = "<p style='color: red'>Nhập nhận xét và sao để tiếp tục</p>";
	    }
	}

	$_SESSION['add_review_alert'] = $add_review_alert;
	$_SESSION['undone_review'] = $undone_review;
	$_SESSION['undone_stars'] = $undone_stars;

	mysqli_close();
	header("Location: ./details.php?tourId=$tourId");
	exit();
?>
