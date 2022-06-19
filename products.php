<?php   
ob_start();
session_start();
    include("Setup.php");
    include("functions.php");

    $Category="";
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
    if($_SERVER['REQUEST_METHOD'] == "GET")
    {
        if(isset($_GET['inCategory'])){
            $Category = $_GET['inCategory'];
            $queryCategory = "products.inCategory_name";
        }else if(isset($_GET['Category'])){
            $Category = $_GET['Category'];
            $queryCategory = "products.category_name";
        }
    }
    
?> 


<html>
    <head>
        <link rel="stylesheet" href="css/style.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="script.js" defer></script>
        <script src="addCartscript.js" defer></script>

        <script src="continueCart.js" defer></script>

    </head>
    <body>
        <?php include "header.php"; ?>
        <?php 
                if(empty($queryCategory)){
                    header("Location: index.php");
                }
                $result = mysqli_query($con,"SELECT * FROM products WHERE $queryCategory = '$Category' ORDER BY id DESC");
                while($row = mysqli_fetch_array($result)){ 
                    $ProductID = $row['id'];
                    ?>
        <div class="ProductsBody">
            <div class="Line"></div>
            <div class="ProductInfo">
                <div class="NewPromo">
                        <?php if($user_data!=0){
                            if($user_data['property']=='admin'){?>
                        <form action="removeInfo.php" method="post" class="removeProductMethod">
                            <button class="RemoveProduct" name="RemoveProductID" value="<?=$row['id']?>"></button>
                        </form>
                        <?php }
                            }?>
                    <img class="PromoImages" src="data:Images/jpg;charset=utf8;base64,<?php echo base64_encode($row['product_image']); ?>" alt="">
                    <div class="PromoDescrip"><?=$row['product_name'];?></div>
                    <span class="NewPromoInfo">
                        <span class="NewPromoInfoInside">
                            <img class="PriceTagNewPromo" src="images/price.png" alt="">
                            <span><?=$row['price'];?>€</span>
                        </span>
                    </span>
                </div>
                <div class="ProductDescrip">
                    <?php $result1 = mysqli_query($con,"SELECT * FROM product_info WHERE product_info.product_id='$ProductID'  ORDER BY id");
                    while($row1 = mysqli_fetch_array($result1)){ 
                    ?>
                    <div class="infoBox">
                        <div class="InfoTitle"><?=$row1['Title'];?></div>
                        <div class="Info"><?=$row1['Info'];?></div>
                        <?php if($user_data!=0){
                            if($user_data['property']=='admin'){?>
                        <form action="removeInfo.php" method="post" class="removeInfoMethod">
                            <button class="RemoveInfo" name="RemoveProductInfoID" value="<?=$row1['id']?>"></button>
                        </form>
                        <?php }
                            }?>
                    </div>
                    <?php }?>
                    <?php if($user_data!=0){
                     if($user_data['property']=='admin'){?>
                    <form method="post" action="AddInfo.php">
                        <button type="submit" class="AddInfo" name="addinfo" value="<?=$ProductID?>">
                            <div class="AddInfoImage"></div>
                            <div class="AddInfoText">Add Info</div>
                        </button>
                    </form>
                    <?php }
                    }?>
                </div>
                <!-- <form action="addCart.php" class="addCartForm" method="post"> -->
                    <button class="AddCartButton" type="submit" name="addCart" value="<?=$row['id'];?>">
                        <span class="AddCartText">Add to Cart</span>
                        <img class="AddCartImage" src="images/addCart.png" alt="">
                    </button>
                <!-- </form> -->
            </div>
            <div class="Line"></div>
        </div>
        <?php }?>
        <p id="CartResult">
        
        </p>
    </body>
</html>