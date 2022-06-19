<?php   
ob_start();
session_start();
    include("Setup.php");
    include("functions.php");

    $user_data = check_login($con);
    Register();
    Login();
    if($user_data!=0){
        $UserID = $user_data['user_id'];
    }else{
        $UserID = 0;
    }

    
    if($user_data!=0){ 
        if($user_data['property']!='admin'){
            header("Location: index.php");
        }
    }else{
        header("Location: index.php");
    }

    $category="";


    $warn="";
    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        if(isset($_POST['headercategory'])){
            $category=$_POST['headercategory'];
        }
        if(isset($_POST['upload'])){
            $image_name = $_FILES['filename']['name'];
            $productname = $_POST['productname'];
            $productcategoty = $_POST['productcategoty'];
            $headercategory = $_POST['headercategory'];
            $Price = $_POST['Price'];
            if(!empty($image_name))
            {
                $FileName = $_FILES['filename']['name'];
                $TmpName = $_FILES['filename']['tmp_name'];

                $imgContent = addslashes(file_get_contents($TmpName)); 
            }

            if(!empty($image_name) && !empty($productname) && !empty($productcategoty) && !empty($Price) && !empty($headercategory))
            {
                //save to database
                $query = "INSERT into products (product_name,inCategory_name,category_name,price,product_image) values ('$productname','$productcategoty','$headercategory','$Price','$imgContent')";
                mysqli_query($con,$query);

                header("Location: index.php");
            }else
            {
                $warn = "Please Enter Valid Info";
            }
        }
    }
    
?>  

<html>

<head>
    <link rel="stylesheet" href="css/style.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="script.js" defer></script>
</head>
<body class="body">
    <div class="box">
    <?php include "header.php"; ?>
        <form method="post" enctype="multipart/form-data">
                <div class="newProductLabel">
                    <div class="insideProductLabel">
                        <div class="Title">New Product</div>
                        <p class='Warnings'><?php echo $warn;?></p>
                        <div class="ColorWhite">Select Product Info</div><br>
                        <input class="loginButton inputFields" type="file" name="filename" id="filename" value="<?php if(isset($_FILES['filename'])){echo $_FILES['filename'];}?>"><br><br>
                        <input class="form-control inputFields" id="Pname" type="text" name="productname" value="<?php if(isset($_POST['productname'])){echo $_POST['productname'];}?>" placeholder="Product Name"><br>
                        <select class="form-control inputFields" name="headercategory" id="headercategory">
                            <optgroup label="Header Category">
                                <?php $result = mysqli_query($con,"SELECT * FROM category ORDER BY id DESC");
                                while($row = mysqli_fetch_array($result)){ 
                                ?>
                                <option class="form-control inputFields" value="<?=$row['category_name']?>" <?php if(isset($_POST['headercategory'])){if($_POST['headercategory']==$row['category_name']){echo "selected";}}?>><?=$row['category_name']?></option><br>
                                <?php }?>
                            </optgroup>
                        </select>
                        <button type="submit" class="btn buttonsDesign">Confirm</button>
                        <?php if(isset($_POST['headercategory'])){ ?>
                        <select class="form-control inputFields" name="productcategoty" id="productcategoty">
                            <optgroup label="Product Category">
                                <div class="CallMe"></div>
                                <?php
                                $result = mysqli_query($con,"SELECT * FROM incategory where incategory.category_name = '$category' ORDER BY id DESC");
                                while($row = mysqli_fetch_array($result)){ 
                                    ?>
                                <option class="form-control inputFields" type="text" value="<?=$row['semi_category']?>"><?=$row['semi_category']?></option><br>
                                <?php }?>
                            </optgroup>
                        </select>
                        <input class="form-control inputFields" type="number" step="0.01" name="Price" placeholder="Price"><br>
                        <input class="btn buttonsDesign" name="upload" type="submit" value="Upload">
                        <?php }?>
                    </div>
                </div>
                
            </form>
    </div>

</body>
</html>