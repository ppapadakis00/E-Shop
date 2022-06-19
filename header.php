
 <div class="InfoUpPage">
            <span class="Title">
                <img class="EshopIcon" src="images/eshopIcon.png" alt="">
                <span>TECHSTORE</span>
            </span>
            <span class="phone">
                <img class="PhoneImage" src="images/phoneIcon.png" alt="">
                <span>+223-1073920</span>
            </span>
            <a href="mycart.php" class="CartBackground">
                <img class="CartImage" src="images/Cart.png" alt="">
                <span class="Cartbutton-text">My Cart</span>
                <span class="Counter">
                    <?php
                     $Quan=0;
                     $result = mysqli_query($con,"SELECT * FROM user_cart where user_cart.user_id = $UserID ORDER BY id");
                     while($row = mysqli_fetch_array($result)){ 
                        $Quan += $row['quantity'];
                     }?>
                    <span class="CounterText"><?=$Quan?></span>
                </span>
            </a>
        </div>
<div class="header">
            <a href="index.php"  class="links cart-button" data-dropdown-button="">Home</a>
            <div class="dropdown" data-dropdown>
                <button class="links" data-dropdown-button="">Products</button>
                <div class="dropdown-menu grid-content">
                <?php $result = mysqli_query($con,"SELECT * FROM category ORDER BY id");
                while($row = mysqli_fetch_array($result)){ 
                    $categoryName = $row['category_name'];?>
                    <div>
                        <form action="products.php" method="get" class="dropdownForm">
                            <button type="submit" class="dropdown-header" name="Category" value="<?=$row['category_name']?>"><?=$row['category_name']?></button>
                        </form>
                        <!-- <div class="dropdown-header"><?=$row['category_name']?></div> -->
                        <div class="dropdown-links">
                            <?php $result1 = mysqli_query($con,"SELECT * FROM inCategory WHERE inCategory.category_name = '$categoryName' ORDER BY id");
                            while($row1 = mysqli_fetch_array($result1)){ ?>
                            <form action="products.php" method="get" class="dropdownForm">
                                <button type="submit" class="InsideLinks" name="inCategory" value="<?=$row1['semi_category'];?>"><?=$row1['semi_category'];?></button>
                            </form>
                            <?php }?>
                        </div>
                    </div>
                    <?php }?>
                </div>
            </div>
            <?php if($user_data==0){ ?>
            <div class="dropdown Login" data-dropdown>
                <button class="links" data-dropdown-button="">Login</button>
                <div class="dropdown-menu loginMenu">
                    <form method="post" class="formLogin">
                        <label for="email" class="labels">Email</label>
                        <input type="email" name="email" id="email">
                        <label for="password" class="labels">Password</label>
                        <input type="password" name="password" id="password">
                        <label><?=$warnLInfo?></label>
                        <button type="submit" class="LoginButton" name="login">Login</button>
                    </form>
                </div>
            </div>

            <div class="dropdown Login" data-dropdown>
                <button class="links" data-dropdown-button="">Register</button>
                <div class="dropdown-menu loginMenu">
                    <form method="post" class="formLogin">
                        <label for="username" class="labels">Username</label>
                        <input type="text" name="username" id="username">
                        <label><?=$warnInfo?></label>
                        <label for="email" class="labels">Email</label>
                        <input type="email" name="email" id="email">
                        <label><?=$warnEmail?></label>
                        <label for="password" class="labels">Password</label>
                        <input type="password" name="password" id="password">
                        <label><?=$warnPass?></label>
                        <label for="Rpassword" class="labels">Repeat Password</label>
                        <input type="password" name="Rpassword" id="Rpassword">
                        <button type="submit" class="LoginButton" name="register">Register</button>
                    </form>
                </div>
            </div>
            <?php }else{ ?>
                <label class="TextLabels">Welcome, <?php echo $user_data['user_name']; ?></label>
                <a href="logout.php" class="Logout-Button">Logout</a>
            <?php } ?>
            <?php if($user_data!=0){ 
                if($user_data['property']=='admin'){?>
            <a href="newproduct.php"  class="links cart-button" data-dropdown-button="">New Product</a>
            <?php }
            }?>
        </div>