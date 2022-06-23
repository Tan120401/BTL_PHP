<?php 
	$conn = mysqli_connect("localhost", "root", "Tan@1204", "qlbantour");

	if(!$conn) {
		die("Connection Failed");
	}


	// ALL NEWS
	$selectAll_news_sql = "SELECT * FROM TINTUC";
	$selectAll_news_result = mysqli_query($conn, $selectAll_news_sql);
	$selectAll_news = mysqli_fetch_all($selectAll_news_result, MYSQLI_ASSOC);


	$allNews_html = "";

	for($i = 0; $i < count($selectAll_news); $i++) {
		$selectAll_news_placeId = $selectAll_news[$i]['MaDiaDiem'];
		$news_cover_sql = "SELECT * FROM ANH WHERE ANH.MaDiaDiem = '$selectAll_news_placeId' LIMIT 1";
		$news_cover_result = mysqli_query($conn, $news_cover_sql);
		$news_cover_data = mysqli_fetch_all($news_cover_result, MYSQLI_ASSOC);

		$news_cover_link = $news_cover_data[0]['Link'];
		$truncated_details = truncate($selectAll_news[$i]['ChiTiet']);
		$news_date = new DateTime($selectAll_news[$i]['NgayDang']);

		$day = $news_date->format('d');
		$month = $news_date->format('m');

		$newsPost = "
				<div class='news__post'>
					<a href='./news-details.php?newsId={$selectAll_news[$i]['MaTinTuc']}'>
						<div class='image'>
							<img src='$news_cover_link' alt='{$selectAll_news[$i]['TieuDe']}'>
						</div>
						<div class='news__post-info'>
							<div class='news__post-title'>
								{$selectAll_news[$i]['TieuDe']}
							</div>
							<div class='news__post-content'>
								{$truncated_details}
							</div>
							<div class='news__post-date'>
								<span class='day'>$day</span>
								<span class='month'>Th $month</span>
							</div>
						</div>
					</a>
				</div>";

		$allNews_html .= $newsPost;
	}


	// LATEST NEWS
	$select_latest_news_sql = "SELECT * from tintuc order by tintuc.NgayDang DESC limit 5";
	$select_latest_news_result = mysqli_query($conn, $select_latest_news_sql);
	$select_latest_news_data = mysqli_fetch_all($select_latest_news_result, MYSQLI_ASSOC);

	$latest_news_html = "";
	for($i = 0; $i < count($select_latest_news_data); $i++) {
		$latest_news_id = $select_latest_news_data[$i]['MaTinTuc'];
		$latest_news_title = $select_latest_news_data[$i]['TieuDe'];
		$latest_news_placeId = $select_latest_news_data[$i]['MaDiaDiem'];
		$latest_news_date = new DateTime($select_latest_news_data[$i]['NgayDang']);

		$latest_news_day = $latest_news_date->format('d');
		$latest_news_month = $latest_news_date->format('m');


		$latest_news_cover_sql = "SELECT * FROM ANH WHERE ANH.MaDiaDiem = '$latest_news_placeId' LIMIT 1";
		$latest_news_cover_result = mysqli_query($conn, $latest_news_cover_sql);
		$latest_news_cover_data = mysqli_fetch_all($latest_news_cover_result, MYSQLI_ASSOC);

		$latest_news_cover_link = $latest_news_cover_data[0]['Link'];

		$latest_news_html .= "
			<a href='./news-details.php?newsId={$latest_news_id}' class='newest__post'>
				<div class='newest__post-image'>
					<img src='{$latest_news_cover_link}' alt=''>
					<div class='newest__post-date'>
						<span class='day'>{$latest_news_day}</span>
						<span class='month'>Th {$latest_news_month}</span>
					</div>
				</div>
				<div class='newest__post-title'>
					{$latest_news_title}
				</div>
			</a>";
	}

	function truncate($string, $length=100, $append="&hellip;") {
	  $string = trim($string);

	  if(strlen($string) > $length) {
	    $string = wordwrap($string, $length);
	    $string = explode("\n", $string, 2);
	    $string = $string[0] . $append;
	  }

	  return $string;
	}

    mysqli_close($conn);
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
    <link rel="stylesheet" href="../assets/css/search.css">
	<link rel="stylesheet" type="text/css" href="../assets/css/news.css">
</head>
<body>
	<?php include "./header.php" ?>
	<div class="news__banner" style="height: 300px;background-image:url(https://images.unsplash.com/photo-1558334466-afce6bf36c69?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=2070&q=80);">
	</div>
	<div class="news">
		<header class="news__header"><span>TIN TỨC</span></header>
		<main class="news__main">
			<section class="news__posts grid-col-span-3">
				<?php echo $allNews_html; ?>
			</section>
			<section class="news__right">
				<div class="news__search">
					<input type="text" placeholder="Tim kiem...">
					<button>
						<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"><path d="M23.809 21.646l-6.205-6.205c1.167-1.605 1.857-3.579 1.857-5.711 0-5.365-4.365-9.73-9.731-9.73-5.365 0-9.73 4.365-9.73 9.73 0 5.366 4.365 9.73 9.73 9.73 2.034 0 3.923-.627 5.487-1.698l6.238 6.238 2.354-2.354zm-20.955-11.916c0-3.792 3.085-6.877 6.877-6.877s6.877 3.085 6.877 6.877-3.085 6.877-6.877 6.877c-3.793 0-6.877-3.085-6.877-6.877z"/></svg>
					</button>
				</div>
				<div class="news__newest">
					<div class="newest__title">BÀI VIẾT MỚI NHẤT</div>
					<div class="newest__posts">
						<?php echo $latest_news_html; ?>
					</div>
				</div>
			</section>
		</main>

	</div>
	<?php include "./footer.php" ?>
</body>
</html>