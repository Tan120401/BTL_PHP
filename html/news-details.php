<?php 
	$conn = mysqli_connect("localhost", "root", "Tan@1204", "qlbantour");

	if(!$conn) {
		die("Connection Failed");
	}

	if(isset($_GET['newsId'])) {
		$newsId = $_GET['newsId'];
		$select_news_sql = "SELECT * FROM TINTUC WHERE MaTinTuc = '$newsId'";
		$select_news_result = mysqli_query($conn, $select_news_sql);
		$select_news = mysqli_fetch_all($select_news_result, MYSQLI_ASSOC);

		$news_date = new DateTime($select_news[0]['NgayDang']);

		$day = $news_date->format('d');
		$month = $news_date->format('m');
		$news_title = $select_news[0]['TieuDe'];
		$news_desc = $select_news[0]['ChiTiet'];

		// select image
		$newsDetails_placeId = $select_news[0]['MaDiaDiem'];
		$newsDetails_cover_sql = "SELECT * FROM ANH WHERE ANH.MaDiaDiem = '$newsDetails_placeId' LIMIT 1";
		$newsDetails_cover_result = mysqli_query($conn, $newsDetails_cover_sql);
		$newsDetails_cover_data = mysqli_fetch_all($newsDetails_cover_result, MYSQLI_ASSOC);

		$newsDetails_cover_link = $newsDetails_cover_data[0]['Link'];

		// Select previous news, next news
		$prevNews_sql = "SELECT * from TINTUC where MaTinTuc = (select max(MaTinTuc) from TINTUC where MaTinTuc < '$newsId')";
		$select_prevNews_result = mysqli_query($conn, $prevNews_sql);
		$select_prevNews = mysqli_fetch_all($select_prevNews_result, MYSQLI_ASSOC);

		$nextNews_sql = "SELECT * from TINTUC where MaTinTuc = (select min(MaTinTuc) from TINTUC where MaTinTuc > '$newsId')";
		$select_nextNews_result = mysqli_query($conn, $nextNews_sql);
		$select_nextNews = mysqli_fetch_all($select_nextNews_result, MYSQLI_ASSOC);

	}

	// LATEST NEWS
	$select_latest_news_sql = "SELECT * from tintuc WHERE tintuc.MaTinTuc <> '$newsId' order by tintuc.NgayDang DESC limit 5";
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

	// =======================

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
    <link rel="stylesheet" href="../assets/css/base.css">
	<link rel="stylesheet" type="text/css" href="../assets/css/news-details.css">
</head>
<body>
	<?php include "./header.php" ?>
	<div class="news-details grid">
		<main class="row">
			<div class="news-details__main col c-12 m-9 l-9">
				<div class="news-details__main-upper">
					<header class="news-details__header">
						<a href="./news.php">TIN TỨC</a>
						<h1><?php echo $news_title; ?></h1>
					</header>
					<div class="news-details__image">
						<img src="<?php echo $newsDetails_cover_link; ?>" alt="">
						<div class="news-details__post-date">
							<span class="day"><?php echo $day; ?></span>
							<span class="month">Th <?php echo $month; ?></span>
						</div>
					</div>
					<div class="news-details__desc">
						<?php echo $news_desc; ?>
					</div>
					<div class="news-details__nav">

						<?php 

							if(count($select_prevNews) > 0) {
								$prevNews_title = truncate($select_prevNews[0]['TieuDe'], 50);
								echo "
									<a href='./news-details.php?newsId={$select_prevNews[0]['MaTinTuc']}' class='news-details__nav--prev'>
											<svg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24'><path d='M16.67 0l2.83 2.829-9.339 9.175 9.339 9.167-2.83 2.829-12.17-11.996z'/></svg>
										{$prevNews_title}
									</a>";
							}

						?>
						<?php 

							if(count($select_nextNews) > 0) {
								$nextNews_title = truncate($select_nextNews[0]['TieuDe'], 50);
								echo "
									<a href='./news-details.php?newsId={$select_nextNews[0]['MaTinTuc']}' class='news-details__nav--next'>
										{$nextNews_title}
											<svg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24'><path d='M7.33 24l-2.83-2.829 9.339-9.175-9.339-9.167 2.83-2.829 12.17 11.996z'/></svg>
									</a>";
							}
						?>
					</div>
				</div>
				<div class="news-details__main-lower">
					<form action="" method="post">
						<h2>Trả lời </h2>
						<p>
							Email của bạn sẽ không được hiển thị công khai. Các trường bắt buộc được đánh dấu *
						</p>
						<div class="grid">
							<div class="row">
								<div class="col c-12 m-12 l-12">
									<label for="comment-input">Bình luận</label>
									<textarea name="comment" id="comment-input" cols="30" rows="10"></textarea>
								</div>
								<div class="col c-12 m-6 l-6">
									<label for="commentor-name">Tên *</label>
									<input type="text" name="commentor-name" id="commentor-name">
								</div>
								<div class="col c-12 m-6 l-6">
									<label for="commentor-email">Email *</label>
									<input type="text" name="commentor-email" id="commentor-email">
								</div>
							</div>
							<div class="row">
								<div class="col c-12 m-12 l-12">
									<button class="news-details__submit-btn">Phản hồi</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
			<section class="news__right col c-12 m-3 l-3">
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