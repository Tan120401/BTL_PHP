<?php 
    $conn = mysqli_connect("localhost", "root", "Tan@1204", "qlbantour");
    if (!$conn) {
      die("Connection failed");
    }

    // SEARCH
    $index_search_place_sql = "SELECT * FROM TINH ";
    $index_search_place_result = mysqli_query($conn, $index_search_place_sql);
    $index_search_place_data = mysqli_fetch_all($index_search_place_result, MYSQLI_ASSOC);

    $options_html = "";
    for($i = 0; $i < count($index_search_place_data); $i++) {
        $index_option_provinceId = $index_search_place_data[$i]['MaTinh'];

        $options_html .= "<option value='{$index_option_provinceId}' class='search__option'>{$index_search_place_data[$i]['TenTinh']}</option>";
    }

    // OUTSTANDING PLACES
    $index_outstanding_sql = "SELECT Tour.MaTour, Link,DonGia,TenTinh,diadiem.MaDiaDiem,TenDiaDiem, AVG(sao) FROM diadiem,anh,tinh,ythichdgia, tour 
    WHERE tour.madiadiem = diadiem.madiadiem and anh.MaDiaDiem = diadiem.MaDiaDiem and tinh.MaTinh = diadiem.MaTinh and diadiem.madiadiem= ythichdgia.MaDiaDiem
    GROUP BY diadiem.MaDiaDiem
    ORDER BY AVG(sao) DESC LImit 6";

    $index_outstanding_result = mysqli_query($conn,$index_outstanding_sql);
    $index_outstanding_row = mysqli_fetch_all($index_outstanding_result, MYSQLI_ASSOC);

    // BANNER 2
    $banner2_result= mysqli_query($conn, "SELECT * FROM mien,tinh,diadiem, tour
    where tour.madiadiem = diadiem.madiadiem and mien.mamien=tinh.mamien and tinh.matinh= diadiem.matinh and mien.mamien='MTay'");
    $banner2_row =mysqli_fetch_all($banner2_result, MYSQLI_ASSOC);

    // SLIDER
    $slider_sql = "SELECT  * FROM diadiem, tour
    where tour.madiadiem = diadiem.madiadiem and diadiem.madiadiem= 3 ";
    $slider_result = mysqli_query($conn,$slider_sql);
    $slider_row = mysqli_fetch_assoc($slider_result);

    // FAMOUS TOURS
     $famous_tours_sql = "SELECT  * FROM diadiem,anh,tinh, tour
    where tour.madiadiem = diadiem.madiadiem and anh.MaDiaDiem = diadiem.MaDiaDiem and tinh.MaTinh = diadiem.MaTinh
     GROUP BY diadiem.MaDiaDiem
     ORDER BY SLTruyCap DESC 
     LIMIT 3";
     $famous_tours_result = mysqli_query($conn,$famous_tours_sql);
     $famous_tours_row = mysqli_fetch_all($famous_tours_result, MYSQLI_ASSOC);

     // TOUR CITIES
     $north_tourCities_result= mysqli_query($conn, "SELECT * FROM diadiem,mien,tinh,anh, tour
    where tour.madiadiem = diadiem.madiadiem and  diadiem.madiadiem= anh.madiadiem and diadiem.matinh= tinh.matinh and tinh.mamien= mien.mamien and mien.mamien='MB'
        group by diadiem.madiadiem
        Limit 4");
     $north_tourCities_row= mysqli_fetch_all($north_tourCities_result, MYSQLI_ASSOC);


     $north_cities_result = mysqli_query($conn, "SELECT * FROM mien,tinh WHERE mien.MaMien= tinh.MaMien and mien.MaMien = 'MB' limit 5");
     $north_cities_row = mysqli_fetch_all($north_cities_result, MYSQLI_ASSOC);
    

     $south_tourCities_result= mysqli_query($conn, "SELECT * FROM diadiem,mien,tinh,anh, tour
    where tour.madiadiem = diadiem.madiadiem and  diadiem.madiadiem= anh.madiadiem and diadiem.matinh= tinh.matinh and tinh.mamien= mien.mamien and (mien.mamien='MN' or mien.mamien='MTay')
     group by diadiem.madiadiem
     Limit 4");
     $south_tourCities_row= mysqli_fetch_all($south_tourCities_result, MYSQLI_ASSOC);

     $south_cities_result = mysqli_query($conn, "SELECT * FROM mien,tinh WHERE mien.MaMien= tinh.MaMien and mien.MaMien = 'MN' limit 5");
     $south_cities_row = mysqli_fetch_all($south_cities_result, MYSQLI_ASSOC);
                                

     // TRUNCATE STRING
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
<?php 
    session_start();
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
    <link rel="stylesheet" href="../assets/css/index.css">
</head>
<body>
    <?php require_once 'database.php'?>
    <?php include "./header.php" ?>
    <!-- banner -->
    <div class="banner" style="height: 800px; background-image: url(../assets/img/place/index-banner.jpg);">
        <!-- search -->
        <div class="search">
            <h1 class="search__heading1 text-shadow">Tìm kiếm kỳ nghỉ mà bạn thích</h1>
            <h1 class="search__heading2 text-shadow">Đừng bỏ lỡ những ưu đãi cực lớn</h1>
            <form action="search.php" name="" method="" class="search__form">
                <select name="province" id="" class="search__select">
                    <option value="default" class="search__option">Địa điểm</option>
                    <?php echo $options_html; ?>
                </select>
                <select name="price" id="" class="search__select">
                    <option value="default" class="search__option">Giá tiền</option>
                    <option value="Dưới 2 triệu" class="search__option">Dưới 2 triệu</option>
                    <option value="2 triệu - 4 triệu" class="search__option">2 triệu - 4 triệu</option>
                    <option value="4 triệu - 6 triệu" class="search__option">4 triệu - 6 triệu</option>
                    <option value="Trên 6 triệu" class="search__option">Trên 6 triệu</option>                
                </select>
                <div class="search__discount">
                    <label for="discount" class="search__discount--label">Ưu đãi</label>
                    <input type="checkbox" name="discount" id="discount" class="search__discount--input">
                </div>
                <button type="submit" class="search__btn"></button>
            </form>
        </div>
    </div>
    
    <!-- content -->
    <div class="content">
        <!-- outstanding tours -->
        <div class="grid wide tours outstanding-tours">
            <div class="tours__heading">
                <h6 class="tours__desc">CÓ THỂ BẠN SẼ THÍCH</h6>
                <h3 class="tours__title">CÁC ĐỊA ĐIỂM ĐÁNG CHÚ Ý</h3>
            </div>

            <div class="row">
                <?php
                    for($i=0;$i<count($index_outstanding_row);$i++){
                        $dongia = number_format($index_outstanding_row[$i]['DonGia'], 0, ".", ",");
                        echo "
                            <div class='col l-4'>
                                <div class='tour-square__place'>
                                    <img src='". $index_outstanding_row[$i]['Link']. "' alt='' class='tour-square__place--img'>
                                    <div class='tour-square__place--desc'>
                                        <h3 class='tour-square__place--name text-shadow'>".$index_outstanding_row[$i]['TenDiaDiem']."</h3>
                                        <h6 class='tour-square__place--province text-shadow'>".$index_outstanding_row[$i]['TenTinh']."</h6>
                                    </div>
                                    <div class='tour-square__place--details'>
                                        <h3 class='tour-square__place--details--name'>" .$index_outstanding_row[$i]['TenDiaDiem']."</h3>
                                        <div class='tour-square__place--details--rate'>
                                            <div class='rate' >
                                                <i class='fa-solid fa-star'></i>
                                                <i class='fa-solid fa-star'></i>
                                                <i class='fa-solid fa-star'></i>
                                                <i class='fa-solid fa-star'></i>
                                                <i class='fa-solid fa-star'></i>
                                            </div>
                                            <div class='rate rate-active' style=' width: ".($index_outstanding_row[$i]['AVG(sao)'] /5*100)."% '>
                                                <i class='fa-solid fa-star'></i>
                                                <i class='fa-solid fa-star'></i>
                                                <i class='fa-solid fa-star'></i>
                                                <i class='fa-solid fa-star'></i>
                                                <i class='fa-solid fa-star'></i>
                                            </div>
                                        </div>
                                        <h6 class='tour-square__place--details--price'>Giá: ".$dongia." đ</h6>
                                        <a href='details.php?tourId=".$index_outstanding_row[$i]['MaTour']."' class='tour-square__place--details--btn'>XEM NGAY</a>
                                    </div>
                                </div>
                            </div>
                        ";   
                    }
                ?>           
            </div>
        </div>
        <!-- banner 2 -->
        <div class="banner-2">
            <?php
                echo "<h2 class='banner-2__title text-shadow'>PHÁ ĐẢO ".$banner2_row[0]['TenMien']."</h2>
                <h4 class='banner-2__desc text-shadow'>".$banner2_row[0]['MoTa']."</h4>
                <a href='./details.php?tourId=55' class='banner-2__btn'>Xem ngay</a>"
            ?>
        </div>
        <!-- slide -->
        <div class="tour-slider">
            <div class="tour-slider__content">
                <?php 
                     echo "
                            <h6 class='tour-slider__name'>Biển ".$slider_row['TenDiaDiem']."</h6>
                            <p class='tour-slider__desc'>
                                ".$slider_row['GioiThieu']."
                            </p>

                            <div class='tour-slider__details--rate'>
                                <div class='rate'>
                                    <i class='fa-solid fa-star'></i>
                                    <i class='fa-solid fa-star'></i>
                                    <i class='fa-solid fa-star'></i>
                                    <i class='fa-solid fa-star'></i>
                                    <i class='fa-solid fa-star'></i>
                                </div>
                                <div class='rate rate-active'>
                                    <i class='fa-solid fa-star'></i>
                                    <i class='fa-solid fa-star'></i>
                                    <i class='fa-solid fa-star'></i>
                                    <i class='fa-solid fa-star'></i>
                                    <i class='fa-solid fa-star'></i>
                                </div>
                            </div>
                            <h6 class='tour-slider__details--price'>".number_format($slider_row['DonGia'], 0, ".", ",")." đ</h6>
                            <a href = 'details.php?tourId=".$slider_row['MaTour']."' class='tour-slider__details--btn'>XEM NGAY</a>
                        "
                ?>
                
            </div>
            <!-- slider -->
            <div class="slideshow">

                <div class="slides">
                    
                    <!-- radio btn -->
                    <input type="radio" name="slide-img" id="slide_1" class="slide-radio">
                    <input type="radio" name="slide-img" id="slide_2" class="slide-radio">
                    <input type="radio" name="slide-img" id="slide_3" class="slide-radio">
                    <input type="radio" name="slide-img" id="slide_4" class="slide-radio">

                    <!-- slide img -->
                    <img src="https://busvietnam.net/wp-content/uploads/2019/05/nha-trang-1.jpg" alt="" class="slide-img first">
                        
                            <img src="http://dulichvietnam.com.vn/data/du-lich-hawaii-1.jpg" alt="" class="slide-img second">

                            <img src="https://i.ytimg.com/vi/5Ok7-XHPGdA/maxresdefault.jpg" alt="" class="slide-img third">

                            <img src="https://images.fineartamerica.com/images/artworkimages/mediumlarge/1/kealani-sunset-a-colorful-sunset-in-wailea-maui-hawaii-nature-photographer.jpg" alt="" class="slide-img final">

                    <!-- navigation auto -->
                    <div class="navigation-auto">
                        <div class="auto-btn1"></div>
                        <div class="auto-btn2"></div>
                        <div class="auto-btn3"></div>
                        <div class="auto-btn4"></div>
                    </div>
                </div>

                <!-- manual navigation -->
                <div class="navigation-manual">
                    <label for="slide_1" class="manual-btn"></label>
                    <label for="slide_2" class="manual-btn"></label>
                    <label for="slide_3" class="manual-btn"></label>
                    <label for="slide_4" class="manual-btn"></label>
                </div>

            </div>
        </div>
        <!-- famous tour -->
        <div class="grid wide tours famous-tours">
            <div class="tours__heading">
                <h6 class="tours__desc">CÓ THỂ BẠN SẼ THÍCH</h6>
                <h3 class="tours__title">NHỮNG TOUR DU LỊCH NỔI TIẾNG</h3>
            </div>
            <div class="row">
                <?php
                     for($i=0;$i<count($famous_tours_row);$i++){
                        $famous_tour_desc = truncate($famous_tours_row[$i]['GioiThieu'], 250);
                         echo "
                                <div class='col l-4'>
                                    <div class='tour-rectangle__place'>
                                        <img src=".$famous_tours_row[$i]['Link']." alt='' class='tour-rectangle__place--img'>
                                        <div class='tour-rectangle__place--content'>
                                            <div style='display: flex; justify-content: space-between; align-items: flex-end;'>
                                                <h3 class='tour-rectangle__place--name'>".$famous_tours_row[$i]['TenDiaDiem']."</h3>
                                                <h6 class='tour-rectangle__place--province'>
                                                    <i class='fa-solid fa-location-dot' style='margin-right: 5px;'></i>
                                                    ".$famous_tours_row[$i]['TenTinh']."
                                                </h6>
                                            </div>
                                            <p class='tour-rectangle__place--desc'>
                                                    ".$famous_tour_desc."
                                            </p>
                                            <a href='details.php?tourId=".$famous_tours_row[$i]['MaTour']."' class='tour-rectangle__place--btn'>Tìm hiểu</a>
                                        </div>
                                    </div>
                                </div>
                         
                         ";
                     }
                ?>
            </div>
        </div>
        <!-- tours cities -->
        <div class="grid wide tours tour-cities">
            <div class="tours__heading">
                <h6 class="tours__desc">CÓ THỂ BẠN SẼ THÍCH</h6>
                <h3 class="tours__title">CÁC THÀNH PHỐ DU LỊCH</h3>
            </div>
            <div class="row">
                <div class="col l-6">
                    <div class="row">
                        <?php  
                            for($i=0;$i<count($north_tourCities_row);$i++){
                                echo "
                                    <div class='col l-6'>
                                        <div class='tour-cities__place'>
                                            <img src='".$north_tourCities_row[$i]['Link']."' alt='' class='tour-cities__place--img'>
                                            <div class='tour-cities__place--content'>
                                                <h3 class='tour-cities__place--name text-shadow'>".$north_tourCities_row[$i]['TenDiaDiem']."</h3>
                                                <h6 class='tour-cities__place--price text-shadow'>".number_format($north_tourCities_row[$i]['DonGia'], 0, ".", ",")." đ</h6>
                                                <a href = 'details.php?tourId=".$north_tourCities_row[$i]['MaTour']."' class='tour-cities__place--btn'>Xem ngay</a>
                                            </div>
                                            
                                        </div>
                                    </div>
                                ";
                             }
                        ?>  
                    </div>
                </div>
                <div class="col l-6">
                    <div class="tour-cities__container">
                        <div class="tour-cities__map">
                            <img src="../assets/img/place/VN-NorthSide.png" alt="" class="tour-cities__map--img">
                        </div>
                        <?php
                            echo "
                                <div class='tour-cities__details'>
                                    <h3 class='tour-cities__title'>".$north_cities_row[0]['TenMien']."</h3>
                                    <p class='tour-cities__desc'>
                                    ". $north_cities_row[0]['MoTa']."
                                    </p>
                                    <div class='tour-cities__list'>
                                        <h6 class='tour-cities__list--heading'>Các thành phố du lịch</h6>
                                        <li class='tour-cities__item' name='Hà Nội'>" .$north_cities_row[0]['TenTinh']."</li>
                                        <li class='tour-cities__item' name='Hà Giang'>".$north_cities_row[1]['TenTinh']."</li>
                                        <li class='tour-cities__item' name='Sapa'>".$north_cities_row[2]['TenTinh']."</li>
                                        <li class='tour-cities__item' name='Hải Dương'>".$north_cities_row[3]['TenTinh']."</li>
                                        <li class='tour-cities__item' name='Vinh'>".$north_cities_row[4]['TenTinh']."</li>
                                    </div>
                                </div>
                            ";
                        ?>
                    </div>                 
                </div>
                <div class="col l-6">
                    <div class="tour-cities__container">
                        <div class="tour-cities__map">
                            <img src="../assets/img/place/VN-SouthSide.png" alt="" class="tour-cities__map--img">
                        </div>
                            <?php
                                echo "
                                    <div class='tour-cities__details'>
                            
                                        <h3 class='tour-cities__title'>".$south_cities_row[0]['TenMien']."</h3>
                                        <p class='tour-cities__desc'>
                                        ". $south_cities_row[0]['MoTa']."
                                        </p>

                                        <div class='tour-cities__list'>
                                            <h6 class='tour-cities__list--heading'>Các thành phố du lịch</h6>
                                            <li class='tour-cities__item' name='Hà Nội'>" .$south_cities_row[0]['TenTinh']."</li>
                                            <li class='tour-cities__item' name='Hà Giang'>".$south_cities_row[1]['TenTinh']."</li>
                                            <li class='tour-cities__item' name='Sapa'>".$south_cities_row[2]['TenTinh']."</li>
                                            <li class='tour-cities__item' name='Hải Dương'>".$south_cities_row[3]['TenTinh']."</li>
                                            <li class='tour-cities__item' name='Vinh'>".$south_cities_row[4]['TenTinh']."</li>
                                        </div>
                                    </div>
                                    ";
                            ?>
                    </div>                 
                </div>
                <div class="col l-6">
                    <div class="row">
                        <?php
                            for($i=0;$i<count($south_tourCities_row);$i++){
                                $south_city_price = number_format($south_tourCities_row[$i]['DonGia'], 0, ".", ",");

                                echo "
                                    <div class='col l-6'>
                                    <div class='tour-cities__place'>
                                        <img src='".$south_tourCities_row[$i]['Link']."' alt='' class='tour-cities__place--img'>
                                        <div class='tour-cities__place--content'>
                                            <h3 class='tour-cities__place--name text-shadow'>".$south_tourCities_row[$i]['TenDiaDiem']."</h3>
                                            <h6 class='tour-cities__place--price text-shadow'>".$south_city_price." đ</h6>
                                            <a href = 'details.php?tourId=".$south_tourCities_row[$i]['MaTour']."' class='tour-cities__place--btn'>Xem ngay</a>
                                        </div>
                                        
                                    </div>
                                    </div>
                                ";
                            }
                            ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- footer -->
    <?php include "./footer.php" ?>

    <p class="copyright-text">&copy; All rights reserved. <strong>MTP Travel</strong></p>
    <script type="module" src="../assets/js/index.js"></script>
    

</body>
</html>
