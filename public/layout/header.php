<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$pageTitle ?></title>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- CUSTOM -->
    <link rel="stylesheet" href="./css/style.css">
</head>
<body>
        
    <?php
        if (isset($_SESSION['id'])) {
            $menu = '<a href="myPage.php">My page</a> | <a href="logout.php">Logout</a>';
        } else {
            $menu = '<a href="registerUser.php">Register</a> | <a href="login.php">Log in</a>';
        }
    ?>


    <div id="header-container">
        <div id="nav-1">







        
        <div class="dropdown">
            <button class="dropbtn">Cart</button>
            <div class="dropdown-content">
                <div class="shopping-cart">
                    <div class="shopping-cart-header">
                        <span class="items-in-cart">3</span>
                        <div class="shopping-cart-total">
                            <span>Total: $2,229.97</span>
                        </div>
                    </div>

                    <ul class="shopping-cart-items">
                    <div class="clearfix">
                        <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/195612/cart-item1.jpg" alt="item1" />
                        <span class="item-name">Sony DSC-RX100M III</span>
                        <span class="item-price">$849.99</span>
                        <span class="item-quantity">Quantity: 01</span>
                    </div>

                    <div class="clearfix">
                        <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/195612/cart-item2.jpg" alt="item1" />
                        <span class="item-name">KS Automatic Mechanic...</span>
                        <span class="item-price">$1,249.99</span>
                        <span class="item-quantity">Quantity: 01</span>
                    </div>

                    <div class="clearfix">
                        <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/195612/cart-item3.jpg" alt="item1" />
                        <span class="item-name">Kindle, 6" Glare-Free To...</span>
                        <span class="item-price">$129.99</span>
                        <span class="item-quantity">Quantity: 01</span>
                    </div>
                    </ul>

                    <a href="#" class="checkoutBtn">Checkout</a>
                </div>
            </div>
        </div>







            

            <a href="index.php">Shop</a>
            <a href="admin">Admin</a>
            <?= $menu ?>
        </div>

        <div id="logo-con">
            <h3>LOGO</h3>
        </div>

        <div id="nav-2">
        <a href="index.php">Shop</a> 
        <a href="about">Om</a>
        <a href="about">Hitta hit</a>
        </div>
    </div>