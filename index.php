<?php   
ob_start();
session_start();
    include("Setup.php");
    include("functions.php");

    $user_data = check_login($con);
    $warnEmail="";
    $warnPass="";
    $warnInfo="";  
    $warnLInfo="";
    Register();
    Login();
    if($user_data!=0){
        $UserID = $user_data['user_id'];
    }else{
        $UserID = 0;
    }

    
?> 

<html>
    <head>
        <link rel="stylesheet" href="css/style.css" />
        <script src="script.js" async></script>
    </head>
    <body>
        <?php include "header.php"; ?>
        <div class="PageStart">
        <?php $result = mysqli_query($con,"SELECT * FROM products ORDER BY id DESC LIMIT 4");
                    while($row = mysqli_fetch_array($result)){ 
                    ?>
            <div class="NewPromo">
                <img class="newImage" src="images/new.png" alt="">
                <img class="PromoImages" src="data:Images/jpg;charset=utf8;base64,<?php echo base64_encode($row['product_image']); ?>" alt="">
                <div class="PromoDescrip"><?=$row['product_name']?></div>
                <span class="NewPromoInfo">
                    <span class="NewPromoInfoInside">
                        <img class="PriceTagNewPromo" src="images/price.png" alt="">
                        <span><?=$row['price']?>€</span>
                    </span>
                </span>
            </div>
            <!-- <div class="NewPromo">
                <img class="newImage" src="images/new.png" alt="">
                <img class="PromoImages" src="images/printer1.png" alt="">
                <div class="PromoDescrip">Aoc 27G2U/BK 27´</div>
                <span class="NewPromoInfo">
                    <span class="NewPromoInfoInside">
                        <img class="PriceTagNewPromo" src="images/price.png" alt="">
                        <span>219.99€</span>
                    </span>
                </span>
            </div>
            <div class="NewPromo">
                <img class="newImage" src="images/new.png" alt="">
                <img class="PromoImages" src="images/keyboard1.jpg" alt="">
                <div class="PromoDescrip">DIERYA DK61E</div>
                <span class="NewPromoInfo">
                    <span class="NewPromoInfoInside">
                        <img class="PriceTagNewPromo" src="images/price.png" alt="">
                        <span>219.99€</span>
                    </span>
                </span>
            </div>
            <div class="NewPromo">
                <img class="newImage" src="images/new.png" alt="">
                <img class="PromoImages" src="Images/ink1.jpg" alt="">
                <div class="PromoDescrip">CANON Ink PG-545XL Black</div>
                <span class="NewPromoInfo">
                    <span class="NewPromoInfoInside">
                        <img class="PriceTagNewPromo" src="images/price.png" alt="">
                        <span>219.99€</span>
                    </span>
                </span>
            </div> -->
            <!-- <img class="PromoImages" src="images/monitor.jpg" alt=""> -->
            <?php }?>
        </div>
    </body>
</html>