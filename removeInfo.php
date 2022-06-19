<?php   
ob_start();
session_start();
    include("Setup.php");
    include("functions.php");

    $user_data = check_login($con);
    if($user_data!=0){ 
        if($user_data['property']!='admin'){
            header("Location: index.php");
        }
    }else{
        header("Location: index.php");
    }
    Register();
    Login();

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        if(isset($_POST['RemoveProductInfoID'])){
            $ProductInfoID = $_POST['RemoveProductInfoID'];
            $query = "DELETE FROM product_info WHERE product_info.id = ?";
            $stm = $con->prepare($query);
            $stm->bind_param("i",$ProductInfoID);
            $stm->execute();
            header("Location:index.php");
        }
        if(isset($_POST['RemoveProductID'])){
            $ProductID = $_POST['RemoveProductID'];

            $query = "DELETE FROM user_cart WHERE user_cart.product_id = ?";
            $stm = $con->prepare($query);
            $stm->bind_param("i",$ProductID);
            $stm->execute();

            $query = "DELETE FROM product_info WHERE product_info.product_id = ?";
            $stm = $con->prepare($query);
            $stm->bind_param("i",$ProductID);
            $stm->execute();

            $ProductID = $_POST['RemoveProductID'];
            $query = "DELETE FROM products WHERE products.id = ?";
            $stm = $con->prepare($query);
            $stm->bind_param("i",$ProductID);
            $stm->execute();
            header("Location:index.php");
        }
     }else{
         header("Location:index.php");
     }

    
