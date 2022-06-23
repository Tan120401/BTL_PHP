<?php 
		$conn = mysqli_connect("localhost", "root", "Tan@1204", "qlbantour");
    if (!$conn) {
      die("Connection failed");
    }
    // START SESSION
    session_start();

    $placeName = "";
    $tourName = "";
    $province = "";
    $provinceId = "";
    $side = "";
    $desc = "";
    $price = "";

    $loggedIn_username_or_email = $_SESSION["check_user"];

  	$loggedIn_member_sql = "SELECT * from THANHVIEN WHERE username = '$loggedIn_username_or_email' or Email='$loggedIn_username_or_email'";
  	$loggedIn_member_result = mysqli_query($conn, $loggedIn_member_sql);
  	$loggedIn_member_data = mysqli_fetch_all($loggedIn_member_result, MYSQLI_ASSOC);

		$loggedIn_memberId = $loggedIn_member_data[0]["MaThanhVien"];


    if(isset($_GET["tourId"])) {
    	// TOUR INFO
    	$tourId = $_GET["tourId"];

    	$tourDetails_sql = "SELECT DIADIEM.MaDiaDiem, TenDiaDiem, TenTour, TenTinh, TINH.MaTinh, MIEN.MaMien, TenMien, TOUR.MoTa, DIADIEM.DonGia, DIADIEM.GioiThieu, TOUR.NgayKhoiHanh, TOUR.SoNgay from TOUR, MIEN, DIADIEM, TINH WHERE TOUR.MaDiaDiem = DIADIEM.MaDiaDiem and MIEN.MaMien = tinh.MaMien and diadiem.MaTinh = tinh.MaTinh and TOUR.MaTour = '$tourId'";
    	$tourDetails_result = mysqli_query($conn, $tourDetails_sql);
    	$tourDetails_data = mysqli_fetch_all($tourDetails_result, MYSQLI_ASSOC);

    	$placeId = $tourDetails_data[0]['MaDiaDiem'];
    	$placeName = $tourDetails_data[0]['TenDiaDiem'];
    	$tourName = $tourDetails_data[0]['TenTour'];
    	$provinceId = $tourDetails_data[0]['MaTinh'];
    	$province = $tourDetails_data[0]['TenTinh'];
    	$side = $tourDetails_data[0]['TenMien'];
    	$desc = $tourDetails_data[0]['MoTa'];
    	$price = $tourDetails_data[0]['DonGia'];
    	$formatted_price = number_format($price);
    	$intro = $tourDetails_data[0]['GioiThieu'];

    	$tour_startingDate = $tourDetails_data[0]['NgayKhoiHanh'];
    	$tour_days = $tourDetails_data[0]['SoNgay'];

    	// echo $tour_startingDate . PHP_EOL;
    	// echo $tour_days . PHP_EOL;

    	$tourDetails_image_sql = "SELECT * FROM ANH WHERE ANH.MaDiaDiem = '$placeId'";
    	$tourDetails_image_result = mysqli_query($conn, $tourDetails_image_sql);
    	$tourDetails_image_data = mysqli_fetch_all($tourDetails_image_result, MYSQLI_ASSOC);
    	$tourDetails_coverImage_link = htmlspecialchars($tourDetails_image_data[0]['Link']);
    	$tourDetails_bannerImage_link = htmlspecialchars($tourDetails_image_data[1]['Link']);

    	$tour_cover = $tourDetails_coverImage_link;
    	$tour_banner = $tourDetails_bannerImage_link? $tourDetails_bannerImage_link : $tourDetails_coverImage_link;

    	// ORDER USING
    	$order_message = "";
    	if(!$loggedIn_memberId) {
    			$order_message = "<p style='color: orange; margin-top: 15px'>Hãy đăng nhập để đặt tour</p>";
    	} else {
    			$alreadyOrderedMes = $_SESSION['isOrderedAlert'];
    			$successOrdered = $_SESSION['successOrdered'];
    			
    			// undone order info
    			$order_quantity = $_SESSION["order_quantity"];
	        // $order_daysNum = $_SESSION["order_daysNum"];
	        // $order_startingDate = $_SESSION["order_startingDate"];

	        // empty session varibles (not all)	
    			$_SESSION['successOrdered'] = "";
    			$_SESSION['isOrderedAlert'] = "";

    			$_SESSION["order_quantity"] = "";
	        // $_SESSION["order_daysNum"] = "";
	        // $_SESSION["order_startingDate"] = "";

    			if($alreadyOrderedMes) {
    					$alreadyOrdered_html = "<p style='color: red;'>$alreadyOrderedMes</p>";
    			}
    			if($successOrdered) {
    					$successOrdered_html = "<p style='color: green'>$successOrdered</p>";
    			}
    	}

    	// ADD REVIEW CHECK
    	$add_review_alert = $_SESSION["add_review_alert"];
			
			if($add_review_alert) {
					$_SESSION["add_review_alert"] = "";
			}

			$undone_review = $_SESSION['undone_review'];
			$undone_stars = $_SESSION['undone_stars'];

    	// FAVORITE REVIEW
    	$favorite_review_sql = "SELECT * FROM YTHICHDGIA, THANHVIEN, DIADIEM WHERE YTHICHDGIA.MaThanhVien = THANHVIEN.MaThanhVien and YTHICHDGIA.MaDiaDiem = DIADIEM.MaDiaDiem and YTHICHDGIA.MaDiaDiem = '$placeId'";
    	$favorite_review_result = mysqli_query($conn, $favorite_review_sql);
    	$favorite_review_data = mysqli_fetch_all($favorite_review_result, MYSQLI_ASSOC);

    	$favorite_review_qnt = count($favorite_review_data);

    	$favorite_review_html = "";
    	
    	for($i = 0; $i < $favorite_review_qnt; $i++) {
    		// get member's avatar
    		$avatar_data = $favorite_review_data[$i]['Avatar'];
    		$favorite_review_userAvatar = $avatar_data? $avatar_data : "../assets/img/sticker/user.jpg";

    		// review date
    		$review_date = new DateTime($favorite_review_data[$i]['NgayDanhGia']);
    		$review_date_str = date_format($review_date, "d/m/Y H:i:s");

    		// stars
    		$star_html = "";
    		for($j = 0; $j < (int)$favorite_review_data[$i]['Sao']; $j++) {
    			$star_html .= "<svg xmlns='http://www.w3.org/2000/svg' class='star' width='14' height='14' viewBox='0 0 24 24'><path d='M12 .587l3.668 7.568 8.332 1.151-6.064 5.828 1.48 8.279-7.416-3.967-7.417 3.967 1.481-8.279-6.064-5.828 8.332-1.151z'/></svg>
							";
    		}

    		$favorite_review_html .= "
    			<div class='tour__review'>
	    			<div class='tour__review-userInfo'>
							<div class='tour__review-userAvatar'>
								<img src='$favorite_review_userAvatar' alt='' />
							</div>
							<div>
								<div class='tour__review-top'>
									<h4 class='tour__review-author'>{$favorite_review_data[$i]['TenThanhVien']}</h4>
									<div class='tour__review-stars'>{$star_html}</div>
								</div>
								<small class='tour__review-date'><i>{$review_date_str}</i></small>
							</div>
						</div>
						<p class='tour__review-content'>{$favorite_review_data[$i]['NhanXet']}</p>
					</div>
				";
    	}

    	// CAROUSEL
    	$carousel_sql = "SELECT * FROM TOUR, DIADIEM, TINH WHERE TOUR.MaDiaDiem = DIADIEM.MaDiaDiem AND TINH.MaTinh = DIADIEM.MaTinh LIMIT 0, 10";
    	$carousel_result = mysqli_query($conn, $carousel_sql);
    	$carousel_data = mysqli_fetch_all($carousel_result, MYSQLI_ASSOC);

    	$carousel_html = "";

  	  for($i = 0; $i < count($carousel_data); $i++) {
	  		$carousel_tour_price = number_format($carousel_data[$i]['DonGia'], 0, ",", ".");
	  		$carousel_tourPlace_id = $carousel_data[$i]['MaDiaDiem'];

	    	$carousel_tour_image_sql = "SELECT * FROM ANH WHERE ANH.MaDiaDiem = '$carousel_tourPlace_id' LIMIT 1";
	    	$carousel_tour_image_result = mysqli_query($conn, $carousel_tour_image_sql);
	    	$carousel_tour_image_data = mysqli_fetch_all($carousel_tour_image_result, MYSQLI_ASSOC);
	    	$carousel_tour_image_link = $carousel_tour_image_data[0]['Link'];

	  		$carousel_html .= "
						<a href='./details.php?tourId={$carousel_data[$i]['MaTour']}' class='carousel__item col l-3 m-4 c-6'>
								<div class='carousel__item-image'>
										<img src='$carousel_tour_image_link' alt=''>
								</div> 
								<div class='carousel__item-text'>
										<div class='carousel__item-place'>
											{$carousel_data[$i]['TenTinh']}
										</div>
										<div class='carousel__item-title'>
											{$carousel_data[$i]['TenTour']}
										</div>
										<div class='carousel__item-price'>
											{$carousel_tour_price} <sup>₫</sup>
										</div>
								</div>
						</a>";
  		}
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MTP Travel</title>
    <link rel="icon" href="favicon.svg" sizes="any" type="image/svg+xml">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/grid.css">
    <link rel="stylesheet" href="../assets/css/index.css">
    <link rel="stylesheet" href="../assets/css/base.css">
	<link rel="stylesheet" type="text/css" href="../assets/css/details.css">
</head>
<body>
	<?php include "./header.php" ?>
	<div class="tour-details__banner" style="height: 300px;background-image:url(<?php echo $tour_banner; ?>);">
		<div class="tour-details__banner-placeInfo">
			<h1 class="banner__place"><?php echo $placeName; ?></h1>
			<div style="
				display: flex;
				align-items: center;"
			>
				<span class="banner__province"><svg width="24" height="24" fill="#ffffff95" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M12 10c-1.104 0-2-.896-2-2s.896-2 2-2 2 .896 2 2-.896 2-2 2m0-5c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3m-7 2.602c0-3.517 3.271-6.602 7-6.602s7 3.085 7 6.602c0 3.455-2.563 7.543-7 14.527-4.489-7.073-7-11.072-7-14.527m7-7.602c-4.198 0-8 3.403-8 7.602 0 4.198 3.469 9.21 8 16.398 4.531-7.188 8-12.2 8-16.398 0-4.199-3.801-7.602-8-7.602"/></svg><?php echo $province; ?></span>
				<!-- <span class="banner__time">
					<svg width="24" height="24" fill="#ffffff95" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M12 0c6.623 0 12 5.377 12 12s-5.377 12-12 12-12-5.377-12-12 5.377-12 12-12zm0 1c6.071 0 11 4.929 11 11s-4.929 11-11 11-11-4.929-11-11 4.929-11 11-11zm0 11h6v1h-7v-9h1v8z"/></svg>
					<?php //echo $days; ?> ngày
				</span> -->
			</div>
		</div>
	</div>
	<div class="tour-details">
		<!-- <div class="breadcrumbs">
			<ul>
				<li><a href="/study/btl/html/">Trang chủ</a><span>/</span></li>
				<li><a href="/study/btl/html/tours.php">Tour</a><span>/</span></li>
				<li><a href="/study/btl/html/tours.php?s=mien-trung">Miền Trung</a><span>/</span></li>
				<li>Quảng Nam</li>
			</ul>
		</div> -->
		<div class="grid">
			<div class="row tour-details__upper">
				<div class="tour__cover col c-12 m-6 l-6">
					<img src="<?php echo $tour_cover; ?>" alt="<?php echo $placeName; ?>">
				</div>
				<div class="tour__basics col c-12 m-6 l-6">
					<div class="tour__basics-content">

								<div class="tour__title">
									<?php echo $alreadyOrdered_html; echo $successOrdered_html; ?>
									<h1><?php echo $tourName; ?></h1>
								</div>

								<div class="tour__price">
									<?php echo $formatted_price; ?><sup>₫</sup>
								</div>

								<p class="tour__desc">
									<?php echo $intro; ?>
								</p>

							<form action="<?php echo $loggedIn_memberId? "./order.php?tourId=$tourId": "" ?>" method="post">
									<div class="tour-details__options">
											<div class="tour-details__option">
												 <label for="quantity">Số người: </label>
												 <div class="num-input">
												 			<button type="button" class="quantity-btn decrease">&minus;</button>
												  		<input type="number" readonly name="quantity" id="quantity" value="1">
												 			<button type="button" class="quantity-btn increase">&plus;</button>
												 </div>
											</div>
											<div class="tour-details__option">
												 <label for="days">Số ngày đi: </label>
												 <!-- <select name="days" id="days" class="tour-details__days-select" value="<?php //echo $days; ?>">
												 		<?php 
												 			// for($i = 1; $i <= 10; $i++) {
												 			// 	$isDaysSelected = $order_daysNum == $i? "selected": "";

												 			// 	echo "<option value='$i' {$isDaysSelected}>$i</option>";
												 			// }
												 		?>
												 </select> -->

												 <div id="days"><?php echo $tour_days; ?></div>
											</div>
											<div class="tour-details__option">
												 <label for="date">Ngày khởi hành: </label>
												 <div><?php echo $tour_startingDate; ?></div>
											</div>
									</div>

										<button type="submit" class="tour__book-btn" <?php echo $loggedIn_memberId? "": "disabled" ?>>
											ĐẶT NGAY
										</button>
										<?php echo $order_message; ?>

						</form>
					</div>
					<div class="tour__basics-categories">
						<p>
							Danh mục: <a href="./tours.php?side=<?php echo $tourDetails_data[0]['MaMien'] ?>"><?php echo $side; ?></a>, <a href="./search.php?province=<?php echo $provinceId; ?>"><?php echo $province; ?></a>, <a href="./search.php?province=default&price=default">Tour du lịch</a>
						</p>
					</div>
					<div class="tour__basics-socials">
						<a href="#">
							<i class="fa-brands fa-facebook-f"></i>
						</a>
						<a href="#">
							<i class="fa-brands fa-instagram"></i>
						</a>
						<a href="#">
							<i class="fa-brands fa-twitter"></i>
						</a>
					</div>
				</div>
			</div>
			<div class="tour-details__tabs">
				<div class="tour__tabs-titles">
					<button data-title="desc">MÔ TẢ</button>
					<button data-title="addition">THÔNG TIN BỔ SUNG</button>
					<button data-title="schedule">LỊCH TRÌNH</button>
					<button data-title="notes">GHI CHÚ</button>
					<button data-title="review">ĐÁNH GIÁ <span>(<?php echo $favorite_review_qnt; ?>)</span></button>
				</div>
				<div class="tour__tabs-content">
				</div>
			</div>
			<div class="row">
				<div class="carousel">
					<div class="carousel__title row">
						<h1>SẢN PHẨM TƯƠNG TỰ</h1>
					</div>
						
					<div class="carousel__content">
						<div class="carousel__btn carousel__left-btn">
							<button>
								<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"><path d="M16.67 0l2.83 2.829-9.339 9.175 9.339 9.167-2.83 2.829-12.17-11.996z"/></svg>
							</button>
						</div>

						<div class="carousel__items row">
							<?php echo $carousel_html; ?>
						</div>

						<div class="carousel__btn carousel__right-btn">
							<button>
								<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"><path d="M7.33 24l-2.83-2.829 9.339-9.175-9.339-9.167 2.83-2.829 12.17 11.996z"/></svg>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>

	</div>

	<?php include "./footer.php" ?>

	<script type="text/javascript">
			const DATA = {
				originalPrice: <?php echo $price; ?>,
				desc: `<?php echo $desc; ?>`, 
				addition: "",
				schedule: "",
				notes: "",
				review: `
					<div class="tour__reviews">
						<?php echo $favorite_review_html; ?>
					</div>
				`,
				tourId: "<?php echo $tourId; ?>",
				addStarsText: "<?php echo $undone_stars; ?>",
				addReviewText: "<?php echo $undone_review; ?>",
				addReviewAlert: "<?php echo $add_review_alert; ?>"
			}
	</script>
	
	<script src="../assets/js/carousel.js"></script>
	<script src="../assets/js/details.js"></script>
</body>
</html>