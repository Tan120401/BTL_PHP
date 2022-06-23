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
	<link rel="stylesheet" type="text/css" href="../assets/css/tours.css">
</head>

<body>
	<?php include "./header.php" ?>

	<?php 
	    $conn = mysqli_connect("localhost", "root", "Tan@1204", "qlbantour");
	    if (!$conn) {
	      die("Connection failed");
	    }


    	// SELECT TOURS (MAIN)
		$tours_per_page = 4;
    	if(isset($_GET['side'])) {
    		$tours_side = $_GET['side'];
		    // PAGINATION
	    	$toursNum_sql = "SELECT COUNT(*) as 'toursNum' FROM TOUR, DIADIEM, TINH, MIEN WHERE TOUR.MaDiaDiem = DIADIEM.MaDiaDiem AND DIADIEM.MaTinh = TINH.MaTinh AND TINH.MaMien = MIEN.MaMien AND MIEN.MaMien = '$tours_side' ";
		    $toursNum_result = mysqli_query($conn, $toursNum_sql);
		    $toursNum_data = mysqli_fetch_all($toursNum_result, MYSQLI_ASSOC);
		    $toursNum = $toursNum_data[0]['toursNum'];

		    $pagesNum = ceil($toursNum / $tours_per_page);

	    	$nth_page = (int)$_GET['page'];

	    	if(!$nth_page || $nth_page > $pagesNum) $nth_page = 1;
	    	$start = $tours_per_page * ($nth_page - 1);
	    	// $end = $start + $tours_per_page;


    		$select_tours_sql = "SELECT * FROM TOUR, MIEN, DIADIEM, TINH WHERE TOUR.MaDiaDiem = DIADIEM.MaDiaDiem AND MIEN.MaMien = tinh.MaMien and diadiem.MaTinh = tinh.MaTinh and MIEN.MaMien = '$tours_side' LIMIT $start, $tours_per_page";
    	} else {
		    // PAGINATION
	    	$toursNum_sql = "SELECT COUNT(*) as 'toursNum' FROM TOUR";
		    $toursNum_result = mysqli_query($conn, $toursNum_sql);
		    $toursNum_data = mysqli_fetch_all($toursNum_result, MYSQLI_ASSOC);
		    $toursNum = $toursNum_data[0]['toursNum'];

		    $pagesNum = ceil($toursNum / $tours_per_page);

	    	$nth_page = (int)$_GET['page'];

	    	if(!$nth_page || $nth_page > $pagesNum) $nth_page = 1;
	    	$start = $tours_per_page * ($nth_page - 1);
	    	// $end = $start + $tours_per_page;


    		$select_tours_sql = "SELECT * FROM TOUR, MIEN, DIADIEM, TINH WHERE TOUR.MaDiaDiem = DIADIEM.MaDiaDiem AND MIEN.MaMien = tinh.MaMien and diadiem.MaTinh = tinh.MaTinh LIMIT $start, $tours_per_page";
    	}

	    $select_tours_result = mysqli_query($conn, $select_tours_sql);
	    $select_tours_data = mysqli_fetch_all($select_tours_result, MYSQLI_ASSOC);

		$html = "";

    	if(count($select_tours_data) == 0) $html = "<p class='text-center' style='width: 100%'>Trang này không có tour nào.</p>";
	    else {
	    	for($i = 0; $i < count($select_tours_data); $i++) {
		    	$sql = "SELECT * from ANH WHERE ANH.MaDiaDiem = '{$select_tours_data[$i]['MaDiaDiem']}'";
		    	$result = mysqli_query($conn, $sql);
		    	$data = mysqli_fetch_all($result, MYSQLI_ASSOC);

		    	$dongia = number_format($select_tours_data[$i]['DonGia'], 0, ",", ".");
		        $el = "<div class='col c-12 m-6 l-3'>
							<a href='./details.php?tourId={$select_tours_data[$i]['MaTour']}' class='tours__item'>
								<div class='tours__item-image'>
								    <img src='{$data[0]['Link']}' alt='{$select_tours_data[$i]['TenDiaDiem']}'>
							    </div>
							    <div class='tours__item-text'>
							    	<div class='tours__item-placeSide'>
									     {$select_tours_data[$i]['TenMien']}
								    </div>
								    <div class='tours__item-title'>
								  	     {$select_tours_data[$i]['TenTour']}
								    </div>
								    <div class='tours__item-price'>
									     {$dongia}<sup>₫</sup>
								    </div>
								    </div>
							</a>
						</div>";
		        $html .= $el;
		    }
	    }

	    // SELECT TOURS (SIDE)
    	$select_otherTours_sql = "SELECT * FROM TOUR, DIADIEM WHERE TOUR.MaDiaDiem = DIADIEM.MaDiaDiem LIMIT 5";
	    $select_otherTours_result = mysqli_query($conn, $select_otherTours_sql);
	    $select_otherTours_data = mysqli_fetch_all($select_otherTours_result, MYSQLI_ASSOC);

	    $select_otherTours_html = "";
	    for($i = 0; $i < count($select_otherTours_data); $i++) {
	    	$otherTour_id = $select_otherTours_data[$i]['MaTour'];
	    	$otherTour_placeId = $select_otherTours_data[$i]['MaDiaDiem'];
	    	$otherTour_name = $select_otherTours_data[$i]['TenTour'];
	    	$otherTour_price = $select_otherTours_data[$i]['DonGia'];

	    	$otherTour_price = number_format($otherTour_price, 0, ",", ".");

	    	// SELECT OTHER TOUR IMAGE
	    	$otherTour_image_sql = "SELECT * from ANH WHERE ANH.MaDiaDiem = '$otherTour_placeId'";
	    	$otherTour_image_result = mysqli_query($conn, $otherTour_image_sql);
	    	$otherTour_image_data = mysqli_fetch_all($otherTour_image_result, MYSQLI_ASSOC);

	    	$otherTour_image_link = $otherTour_image_data[0]['Link'];

	    	// OTHER TOURS HTML
	    	$select_otherTours_html .= "
	    		<a href='./details.php?tourId={$otherTour_id}' class='tours__left-item'>
					<div class='tours__left-item-image'>
						<img src='$otherTour_image_link' alt=''>
					</div>
					<div>
						<p class='tours__left-item-title'>
							{$otherTour_name}
						</p>
						<div class='tours__left-item-price'>
							{$otherTour_price} ₫
						</div>
					</div>
				</a>";
	    }

	    mysqli_close($conn);
	?>
	
	<div class="tours__banner" style="height: 300px;background-image:url(https://images.unsplash.com/photo-1558334466-afce6bf36c69?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2070&q=80);">
		<div class="tours__banner-placeInfo">
			<h1 class="banner__place">Quảng Nam</h1>
			<div style="
				display: flex;
				align-items: center;"
			>
				<span class="banner__province"><svg width="24" height="24" fill="#ffffff95" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M12 10c-1.104 0-2-.896-2-2s.896-2 2-2 2 .896 2 2-.896 2-2 2m0-5c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3m-7 2.602c0-3.517 3.271-6.602 7-6.602s7 3.085 7 6.602c0 3.455-2.563 7.543-7 14.527-4.489-7.073-7-11.072-7-14.527m7-7.602c-4.198 0-8 3.403-8 7.602 0 4.198 3.469 9.21 8 16.398 4.531-7.188 8-12.2 8-16.398 0-4.199-3.801-7.602-8-7.602"/></svg>Việt Nam</span>
				
			</div>
		</div>
	</div>

	<div class="tours">
		<div class="grid">
			<div class="row">
				<div class="tours__left col c-12 m-4 l-3">
					<header><h1>NHỮNG TOUR KHÁC</h1></header>
					<?php echo $select_otherTours_html; ?>
				</div>
				<main class="tours__main col c-12 m-8 l-9 grid">
					<div class="row" style="height: 100%">
						<?php echo $html; ?>
					</div>
					<div class="pages__nums c-12 m-12 l-12">

						<?php 
							$side_param = $tours_side? "&side=$tours_side" : "";
							
							for($p = 1; $p <= $pagesNum; $p++) {
								$isPageActive = $nth_page == $p;
								$additionClassName = $isPageActive? "active": "";
								echo "<a href='./tours.php?page={$p}$side_param' class='pages__num $additionClassName'>{$p}</a>";
							}
						?>

					</div>
				</main>
			</div>			
		</div>
	</div>

	<?php include "./footer.php" ?>
</body>
</html>

<!-- 
	PAGINATION

	https://stackoverflow.com/questions/20089826/php-mysql-limit-to-last-500-then-continue

 -->
<!-- 

https://images.unsplash.com/photo-1528127269322-539801943592?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80

https://images.unsplash.com/photo-1504457047772-27faf1c00561?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1247&q=80

https://images.unsplash.com/photo-1480996408299-fc0e830b5db1?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1169&q=80

https://images.unsplash.com/photo-1588411393236-d2524cca1196?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=765&q=80

https://images.unsplash.com/photo-1522034477175-d97f456a4873?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1074&q=80

https://images.unsplash.com/photo-1553851919-596510268b99?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=388&q=80
 -->