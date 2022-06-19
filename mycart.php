<?php   
ob_start();
session_start();
    include("Setup.php");
    include("functions.php");

    $totalPro=0;
    $totalPrice=0;

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
    <script src="addFields.js" defer></script>
    <script src="script.js" defer></script>
</head>
<body class="body">
    <div class="box">
    <?php include "header.php"; ?>
    </div>
    <div class="cartBox">
        <div class="CartProductsTable">
            <table class="HeadersTable">
                <tr>
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
                <?php $result = mysqli_query($con,"SELECT products.* , user_cart.quantity as Quantity FROM products,user_cart WHERE user_cart.user_id = $UserID and user_cart.product_id=products.id ORDER BY id DESC");
                while($row = mysqli_fetch_array($result)){ ?>
                <tr>
                    <td><img class="cartImageInspect" src="data:Images/jpg;charset=utf8;base64,<?php echo base64_encode($row['product_image']); ?>" alt="">
                    <td><?=$row['product_name']?></td>                  
                    <td class="Quantity">
                        <form action="AddRemoveQuantity.php" method="post">
                            <button class="QuantityCountChanger" name="RemoveQuantity" value="<?=$row['id']?>">&minus;</button>
                        </form>
                        <p><?=$row['Quantity']?></p>
                        <?php $totalPro+=$row['Quantity'];
                              $totalPrice+=$row['Quantity']*$row['price'];?>
                        <form action="AddRemoveQuantity.php" method="post">
                            <button class="QuantityCountChanger" name="AddQuantity" value="<?=$row['id']?>">&plus;</button>
                        </form>
                    </td>
                    <td><?=$row['price']?>€</td>
                </tr>
                <?php }?>
            </table>
        </div>
        <div class="InfoCartParent">
                <table class="InfoCart">
                <tr>
                    <th>Total Product</th>
                    <th>Total Price</th>
                </tr>
                <tr>
                    <td><?=$totalPro?></td>
                    <td><?=$totalPrice?>€</td>
                </tr>
                </table>
                <button class="ProceedBuy">
                     <div>Proceed</div>
                </button> 
        </div>
    </div>

</body>
</html>