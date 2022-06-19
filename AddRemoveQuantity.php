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
        if(isset($_POST['RemoveQuantity'])){
            $productID = $_POST['RemoveQuantity'];

            $query2 = "SELECT COUNT(id) as num ,user_cart.quantity as quan From user_cart where user_cart.product_id = ? AND user_cart.user_id = ?";
            $stm1 = $con->prepare($query2);
            $stm1->bind_param("ii",$productID,$UserID);
            $stm1->execute();
            $results = $stm1->get_result();
            $row = mysqli_fetch_array($results);
            $Quan = $row['num'];
            if($Quan>0){
                $Quan=$row['quan'];
                if($Quan>1){
                    $Quan=$row['quan']-1;
                    $query = "UPDATE user_cart SET user_cart.quantity=? WHERE user_cart.product_id = ? AND user_cart.user_id = ?";
                    $stm = $con->prepare($query);
                    $stm->bind_param("iii",$Quan,$productID,$UserID);
                }else{
                    $query = "DELETE FROM  user_cart WHERE user_cart.product_id = ? AND user_cart.user_id = ?";
                    $stm = $con->prepare($query);
                    $stm->bind_param("ii",$productID,$UserID);
                }
            }
            $stm->execute();
            unset($_POST['RemoveQuantity']);
            header("Location: mycart.php");
            die;
        }
        if(isset($_POST['AddQuantity'])){
            $productID = $_POST['AddQuantity'];

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
            }
            $stm->execute();
            unset($_POST['AddQuantity']);
            header("Location: mycart.php");
            die;
        }
    }
    header("Location: mycart.php");