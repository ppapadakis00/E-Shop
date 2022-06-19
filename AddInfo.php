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
    if($user_data!=0){
        $UserID = $user_data['user_id'];
    }else{
        $UserID = 0;
    }

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        if(!isset($_POST['addinfo'])){
            header("Location:index.php");
        }
        if(isset($_POST['InfoOne'])){
            $ProductID = $_POST['addinfo'];
            $PostArrayOne = $_POST['InfoOne'];
            $PostArrayTwo = $_POST['InfoTwo'];
            $i=0;
            for($i=0;$i<sizeof($PostArrayOne);$i++){
                $productTitle = $PostArrayOne[$i];
                $productDescription = $PostArrayTwo[$i];

                $query = "INSERT into product_info (product_id,Title,Info) values (?,?,?)";
                $stm = $con->prepare($query);
                $stm->bind_param("iss",$ProductID,$productTitle,$productDescription);
                $stm->execute();
            }
            header("Location:index.php");
        }
     }else{
         header("Location:index.php");
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
        <form method="post">
                <div class="newProductLabel">
                    <div class="insideProductLabel">
                        <div class="Title">AddInfo</div>
                        <?php
                        $ProductID = $_POST['addinfo'];
                        $result = mysqli_query($con,"SELECT * FROM products WHERE products.id='$ProductID'  ORDER BY id");
                        $row = mysqli_fetch_array($result);
                        ?>
                        <img class="PromoImages inspectImage" src="data:Images/jpg;charset=utf8;base64,<?php echo base64_encode($row['product_image']); ?>" alt="">
                        <div class="Fields">
                            <div class="field">
                                <input class="form-control inputFields" type="text" name="InfoOne[]" placeholder="Title"><br>
                                <input class="form-control inputFields" type="text" name="InfoTwo[]" placeholder="Description"><br>
                            </div>
                        </div>
                        <div class="AddField"></div>
                        <input class="btn buttonsDesign" type="submit" value="Upload">
                        <input type="text" value="<?=$ProductID?>" name="addinfo" hidden>
                    </div>
                </div>
                
            </form>
    </div>

</body>
</html>