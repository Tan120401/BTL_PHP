<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;1,300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/grid.css">
    <link rel="stylesheet" href="../assets/css/base.css">
    <link rel="stylesheet" href="../assets/css/index.css">
    <link rel="stylesheet" href="../assets/css/contact.css">
</head>
<body>
    <!-- header -->
    <?php include "./header.php" ?>
    <!-- banner -->
    <div class="map ">
        <iframe  src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3723.4737883168514!2d105.73291811485473!3d21.053730985984767!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31345457e292d5bf%3A0x20ac91c94d74439a!2zVHLGsOG7nW5nIMSQ4bqhaSBo4buNYyBDw7RuZyBuZ2hp4buHcCBIw6AgTuG7mWk!5e0!3m2!1svi!2s!4v1652166330367!5m2!1svi!2s" width=100% height="450" style="margin-top: 69px;" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
    <div class=" container grid  wide">

        <div class="row mt-32">
            <div class="container__left col l-3 l-o-1">
                <img src="../assets/img/contact/contact-people.png" alt="">
            </div>
            <div class="container__right col l-6 l-o-1">
                <div class="container__right--content">
                    <div class="container__right--top">
                        <h1>LIÊN HỆ VỚI CHÚNG TÔI</h1>
                        <p class="mt-16">Chỉ cần đóng gói và đi! Hãy để kế hoạch du lịch của bạn cho các chuyên gia du lịch!</p>
                    </div>
                    <div class="container__right--form grid mt-16">
                        <form action="" method="post">
                            <input class="" type="text" placeholder="Họ và tên">
                            <input type="text" placeholder="Email">
                            <br>
                            <textarea  name="" id="" cols="30" rows="10" placeholder="Nội dung"></textarea>
                            <br>
                            <div style="text-align:center;" class="mt-16">
                                <input type="submit" class="btn" value="GỬI TIN NHẮN">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- content -->
    
    
    <!-- footer -->
    <?php include "./footer.php" ?>
</body>
</html>