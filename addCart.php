<?php
ob_start();
session_start();
    include("Setup.php");
    include("functions.php");
    $user_data = check_login($con);
    if($user_data!=0){
        $UserID = $user_data['user_id'];
    }else{
        $UserID = 0;
    }
    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        if(isset($_POST['PrID'])){
            $productID = $_POST['PrID'];

            $query2 = "SELECT COUNT(id) as num ,user_cart.quantity as quan From user_cart where user_cart.product_id = ? AND user_cart.user_id = ?";
            $stm1 = $con->prepare($query2);
            $stm1->bind_param("ii",$productID,$UserID);
            $stm1->execute();
            $results = $stm1->get_result();
            $row = mysqli_fetch_array($results);
            $Quan = $row['num'];
            if($Quan>0){
                $Quan=$row['quan']+1;
                $query = "UPDATE user_cart SET user_cart.quantity=? WHERE user_cart.product_id = ? AND user_cart.user_id = ?";
                $stm = $con->prepare($query);
                $stm->bind_param("iii",$Quan,$productID,$UserID);
            }else{
                $query = "INSERT into user_cart (user_id,product_id,quantity) values (?,?,1)";
                $stm = $con->prepare($query);
                $stm->bind_param("ii",$UserID,$productID);
            }
            $stm->execute();
            unset($_POST['PrID']);

            $query3 = "SELECT * From products where products.id = ?";
            $stm2 = $con->prepare($query3);
            $stm2->bind_param("i",$productID);
            $stm2->execute();
            $results2 = $stm2->get_result();
            $row2 = mysqli_fetch_array($results2);

            $ProductName = $row2['product_name'];
            $Productimage= base64_encode($row2['product_image']);

            echo '<p id="Remove" class="AddCartResult active">
            <img class="cartImageAdded" src="data:Images/jpg;charset=utf8;base64,' . $Productimage . ' " alt="">
            <span class="cartImageAddedText">
                <span class="AddedName">'. $ProductName .' Added</span>
                <span style="display: flex; gap: 20px;">
                    <button class="ContinueAddedItem" id="btnremove" name="ContinueBut" onClick = "GFG_Fun()">Continue</button>
                    <a href="mycart.php" class="ContinueToCart">GoToCart</a> 
                </span>
            </span>
        </p>';
            die;
        }
    }