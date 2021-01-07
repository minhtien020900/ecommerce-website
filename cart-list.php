<?php
session_start();
require_once './config/database.php';
require_once './config/config.php';
spl_autoload_register(function ($className) {
    require './app/models/' . $className . '.php';
});
$CategoryModel = new CategoryModel();
$BrandModel = new BrandModel();
$brandModel = new BrandModel();
$ProductModel = new ProductModel();
$CartModel = new CartModel();

$isLogin = false;

if (isset($_SESSION['isLogin'])) {
    $isLogin = $_SESSION['isLogin'];
}

$cart_qlt =0;
$totalPrice = 0;
if (isset($_SESSION['buynow'])) {
    var_dump($_SESSION['buynow']);
    echo $_SESSION['buynow'];
    unset($_SESSION['buynow']);
}
if (!empty($_SESSION['user_id'])) {
    $cartList_User = $CartModel->getCartByUser($_SESSION['user_id']);
    foreach ($cartList_User as $value) {
        $cart_qlt += $value['product_quanlity'];
        $totalPrice += $value['product_quanlity'] * $value['product_price'];
    }
}
$isDelete = false;
if (isset($_POST['cartId'])) {
    if ($CartModel->DeleteCart($_POST['cartId'])) {
            header('location:cart-list.php');
    }
}

?>
<!doctype html>
<html class="no-js" lang="en">


<!-- Mirrored from demo.devitems.com/subas-preview/subas/cart.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 11 Oct 2019 10:55:43 GMT -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Subas || Shopping Cart</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="/<?php echo BASE_URL ?>/parent/img/icon/favicon.png">

    <!-- All CSS Files -->
    <!-- Bootstrap fremwork main css -->
    <link rel="stylesheet" href="/<?php echo BASE_URL ?>/parent/css/bootstrap.min.css">
    <!-- Nivo-slider css -->
    <link rel="stylesheet" href="/<?php echo BASE_URL ?>/parent/lib/css/nivo-slider.css">
    <!-- This core.css file contents all plugings css file. -->
    <link rel="stylesheet" href="/<?php echo BASE_URL ?>/parent/css/core.css">
    <!-- Theme shortcodes/elements style -->
    <link rel="stylesheet" href="/<?php echo BASE_URL ?>/parent/css/shortcode/shortcodes.css">
    <!-- Theme main style -->
    <link rel="stylesheet" href="/<?php echo BASE_URL ?>/parent/style.css">
    <!-- Responsive css -->
    <link rel="stylesheet" href="/<?php echo BASE_URL ?>/parent/css/responsive.css">
    <!-- User style -->
    <link rel="stylesheet" href="/<?php echo BASE_URL ?>/parent/css/custom.css">

    <!-- Style customizer (Remove these two lines please) -->
    <link rel="stylesheet" href="/<?php echo BASE_URL ?>/parent/css/style-customizer.css">
    <link rel="stylesheet" href="/<?php echo BASE_URL ?>/public/css/style.css">
    <link href="#" data-style="styles" rel="stylesheet">

    <!-- Modernizr JS -->
    <script src="/<?php echo BASE_URL ?>/parent/js/vendor/modernizr-2.8.3.min.js"></script>
    <script>
        function deleteConfirm(){
            return confirm('Bạn có muốn xóa sản phẩm này khỏi giỏ hàng không?');
        }
    </script>

</head>

<body>
    <!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    <!-- Body main wrapper start -->
    <div class="wrapper">

        <!-- START HEADER AREA -->
        <header class="header-area header-wrapper">
            <!-- header-top-bar -->
            <div class="header-top-bar plr-185">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6 hidden-xs">
                            <div class="call-us">
                                <p class="mb-0 roboto">(+84) 987380249 </p>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <div class="top-link clearfix">
                                <ul class="link f-right">
                                    <?php if ($isLogin==true) { ?>
                                    <li>
                                        <a href="/<?php echo BASE_URL; ?>/my-account.php">
                                            <i class="zmdi zmdi-account"></i>
                                            Account
                                        </a>
                                    </li>
                                    <?php }?>
                                    <?php if ($isLogin==true) { ?>
                                    <li>
                                        <a href="/<?php echo BASE_URL; ?>/wishlist.php">
                                            <i class="zmdi zmdi-favorite"></i>
                                            Wishlist
                                        </a>
                                    </li>
                                    <?php }?>
                                    <?php if ($isLogin==false) { ?>
                                    <li>
                                        <a href="/<?php echo BASE_URL?>/login.php">
                                            <i class="zmdi zmdi-lock"></i>
                                            Login
                                        </a>
                                    </li>
                                    <?php   }?>

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- header-middle-area -->
            <div id="sticky-header" class="header-middle-area plr-185">
                <div class="container-fluid">
                    <div class="full-width-mega-dropdown">
                        <div class="row">
                            <!-- logo -->
                            <div class="col-md-2 col-sm-6 col-xs-12">
                                <div class="logo">
                                    <a href="/<?php echo BASE_URL ?>/index.php">
                                        <img src="/<?php echo BASE_URL ?>/parent/img/logo/logo.png" alt="main logo">
                                    </a>
                                </div>
                            </div>
                            <!-- primary-menu -->
                            <div class="col-md-8 hidden-sm hidden-xs">
                                <nav id="primary-menu">
                                    <ul class="main-menu text-center">
                                        <li><a href="/<?php echo BASE_URL ?>/index.php">Trang chủ</a>
                                        </li>

                                        <li class="mega-parent"><a href="/<?php echo BASE_URL ?>/shop.php">Sản phẩm</a>
                                        </li>
                                        <li class="mega-parent"><a href="#">Pages</a>
                                        </li>
                                        <li><a href="#">Blog</a>
                                        </li>
                                        <li>
                                            <a href="#">About us</a>
                                        </li>
                                        <li>
                                            <a href="#">Contact</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                            <!-- header-search & total-cart -->
                            <div class="col-md-2 col-sm-6 col-xs-12">
                                <div class="search-top-cart  f-right">
                                    <!-- header-search -->
                                    <div class="header-search f-left">
                                        <div class="header-search-inner">
                                            <button class="search-toggle">
                                                <i class="zmdi zmdi-search"></i>
                                            </button>
                                            <form action="/<?php echo BASE_URL?>/resultsearch" method ="get">
                                                <div class="top-search-box">
                                                    <input type="text" name="keyword" placeholder="Search here your product...">
                                                    <button type="submit">
                                                        <i class="zmdi zmdi-search"></i>
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- total-cart -->
                                    <div class="total-cart f-left">
                                        <div class="total-cart-in">
                                            <div class="cart-toggler">
                                                <a <?php if ($isLogin == false) {
    echo 'href=/' . BASE_URL . '/login.php';
    if (isset($_SERVER['HTTP_REFERER'])) {
        $_SESSION['pagePre'] = $_SERVER['HTTP_REFERER'];
    }
} else {
    echo 'href=/' . BASE_URL . '/cart-list.php';
}?>>
                                                    <span class="cart-quantity"><?php echo $cart_qlt ?></span><br>
                                                    <span class="cart-icon">
                                                        <i class="zmdi zmdi-shopping-cart-plus"></i>
                                                    </span>
                                                </a>
                                            </div>
                                            <ul>
                                                <li>
                                                    <div class="top-cart-inner your-cart">
                                                        <h5 class="text-capitalize">Giỏ hàng</h5>
                                                    </div>
                                                </li>
                                                <li>
                                                    <?php $i = 0?>
                                                    <div class="total-cart-pro">
                                                        <!-- single-cart -->
                                                        <?php if (!empty($cartList_User)) {?>
                                                        <?php foreach ($cartList_User as $cart_value) {
    $brandName = $brandModel->getBrandNamebyProductId($cart_value['product_id'])['brand_name'];
    $i++;
    ?>
                                                        <?php if ($i <= 3) {?>

                                                        <div class="single-cart clearfix">
                                                            <div class="cart-img f-left">
                                                                <a href="#">
                                                                    <img id="image-thumnail"
                                                                        src="/<?php echo BASE_URL ?>/public/images/<?php echo $cart_value['cart_image'] ?>"
                                                                        alt="Cart Product">
                                                                </a>
                                                                <div class="del-icon">
                                                                    <form action="<?php echo $_SERVER['REQUEST_URI'] ?>"
                                                                        method="post">
                                                                        <input type="hidden" name="cartId"
                                                                            value="<?php echo $cart_value['cart_id'] ?>">
                                                                        <button type="submit"><i
                                                                                class="zmdi zmdi-close"></i></button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                            <div class="cart-info f-left">
                                                                <h6 class="text-capitalize">
                                                                    <a
                                                                        href="#"><?php echo mb_substr($cart_value['product_name'], 0, 25) . '...' ?></a>
                                                                </h6>
                                                                <p>
                                                                    <span>Brand<strong>:</strong></span><?php echo $brandName ?>
                                                                </p>
                                                                <p>
                                                                    <span>Total<strong>:</strong></span><?php echo $cart_value['product_quanlity'] ?>
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <?php }?>
                                                        <?php }?>
                                                    </div>
                                                    <?php }?>
                                                </li>
                                                <li>
                                                    <div class="top-cart-inner subtotal">
                                                        <h4 class="text-uppercase g-font-2">
                                                            Tổng tiền:
                                                            <span><?php echo number_format($totalPrice, 2, ',', '.'); ?></span>
                                                        </h4>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="top-cart-inner view-cart">
                                                        <h4 class="text-uppercase">
                                                            <a href="/<?php echo BASE_URL ?>/cart-list.php">Xem giỏ
                                                                hàng</a>
                                                        </h4>
                                                    </div>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- END HEADER AREA -->

        <!-- START MOBILE MENU AREA -->
        <div class="mobile-menu-area hidden-lg hidden-md">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="mobile-menu">
                            <nav id="dropdown">
                                <ul>
                                    <li><a href="/<?php echo BASE_URL ?>/index.php">Home</a>
                                    </li>
                                    <li>
                                        <a href="/<?php echo BASE_URL ?>/shop.php">Sản phẩm</a>
                                    </li>
                                    <li><a href="#">Pages</a>
                                    </li>
                                    <li><a href="#">Blog</a>
                                    </li>
                                    <li>
                                        <a href="#l">About Us</a>
                                    </li>
                                    <li>
                                        <a href="#">Contact</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MOBILE MENU AREA -->

        <!-- BREADCRUMBS SETCTION START -->
        <div class="breadcrumbs-section plr-200 mb-80">
            <div class="breadcrumbs overlay-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="breadcrumbs-inner">
                                <h1 class="breadcrumbs-title">Giỏ hàng</h1>
                                <ul class="breadcrumb-list">
                                    <li><a href="/<?php echo BASE_URL ?>/index.php">Trang chủ</a></li>
                                    <li>Giỏ hàng</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- BREADCRUMBS SETCTION END -->

        <!-- Start page content -->
        <section id="page-content" class="page-wrapper">

            <!-- SHOP SECTION START -->
            <div class="shop-section mb-80">
                <div class="container">
                    <div class="row">
                        <div class="col-md-2 col-sm-12">
                            <ul class="cart-tab">
                                <li>
                                    <a class="active" href="#shopping-cart" data-toggle="tab">
                                        <span>01</span>
                                        Giỏ hàng
                                    </a>
                                </li>
                                <li>
                                    <a href="#wishlist" data-toggle="tab">
                                        <span>02</span>
                                        Sản phẩm yêu thích
                                    </a>
                                </li>
                                <li>
                                    <a href="#checkout" data-toggle="tab">
                                        <span>03</span>
                                        Thanh toán
                                    </a>
                                </li>
                                <li>
                                    <a href="#order-complete" data-toggle="tab">
                                        <span>04</span>
                                        Đơn hàng đã đặt
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-10 col-sm-12">
                            <!-- Tab panes -->
                            <div class="tab-content">
                                <!-- shopping-cart start -->
                                <div class="tab-pane active" id="shopping-cart">
                                    <div class="shopping-cart-content">
                                        
                                            <div class="table-content table-responsive mb-50">
                                                <table class="text-center">
                                                    <thead>
                                                        <tr>
                                                            <th class="product-thumbnail">Sản phẩm</th>
                                                            <th class="product-price">Đơn giá</th>
                                                            <th class="product-quantity">Số lượng</th>
                                                            <th class="product-subtotal">Tổng cộng</th>
                                                            <th class="product-remove">Xóa</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!-- tr -->
                                                        <?php if (!empty($cartList_User)) {?>
                                                        <?php foreach ($cartList_User as $cartValue) {
                                            $brandName = $brandModel->getBrandNamebyProductId($cartValue['product_id'])['brand_name'];
            
                                                        ?>
                                                        <tr>
                                                            <td class="product-thumbnail">
                                                                <div class="pro-thumbnail-img">
                                                                    <img src="/<?php echo BASE_URL ?>/public/images/<?php echo $cartValue['cart_image']?>"
                                                                        alt="<?php echo $cartValue['product_name']?>">

                                                                </div>
                                                                <div class="pro-thumbnail-info text-left">
                                                                    <h6 class="product-title-2">
                                                                        <a
                                                                            href="#"><?php echo $cartValue['product_name']?></a>
                                                                    </h6>
                                                                    <p><?php echo $brandName?></p>

                                                                </div>
                                                            </td>
                                                            <td class="product-price">
                                                                <?php echo number_format($cartValue['product_price'], 2, ',', '.')?>
                                                            </td>
                                                            <td class="product-quantity">
                                                                <input type="hidden" name="soluong_product">
                                                                <div class="cart-plus-minus f-left">
                                                                    <input type="text"
                                                                        value="<?php echo $cartValue['product_quanlity']?>"
                                                                        name="qtybutton" class="cart-plus-minus-box">
                                                                </div>
                                                            </td>
                                                            <td class="product-subtotal">
                                                                <input type="hidden" name="price" value="<?php echo $cartValue['product_price']?>">
                                                                <div id="total">
                                                                <?php echo number_format($cartValue['product_price']*$cartValue['product_quanlity'], 2, ',', '.')?>
                                                                </div>
                                                            </td>
                                                            
                                                            <td class="product-remove">
                                                                <form action="/<?php echo BASE_URL ?>/cart-list.php" method="post" onsubmit = "return deleteConfirm();">
                                                                <input type="hidden" name="cartId" value="<?php echo $cartValue['cart_id']?>">
                                                                <button type="submit"><i class="zmdi zmdi-close"></i></button>
                                                                </form>
                                                        </td>
                                                            
                                                        </tr>
                                                        <?php }?>
                                                        <?php }?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="coupon-discount box-shadow p-30 mb-50">
                                                        <h6 class="widget-title border-left mb-20">coupon discount</h6>
                                                        <p>Enter your coupon code if you have one!</p>
                                                        <input type="text" name="name"
                                                            placeholder="Enter your code here.">
                                                        <button class="submit-btn-1 black-bg btn-hover-2"
                                                            type="submit">apply coupon</button>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="payment-details box-shadow p-30 mb-50">
                                                        <h6 class="widget-title border-left mb-20">Chi tiết thanh toán</h6>
                                                        <table>
                                                            <tr>
                                                                <td class="td-title-1">Tổng tiền giỏ hàng</td>
                                                                <td class="td-title-2">$155.00</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="td-title-1">Shipping and Handing</td>
                                                                <td class="td-title-2">$15.00</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="td-title-1">Vat</td>
                                                                <td class="td-title-2">$00.00</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="order-total">Order Total</td>
                                                                <td class="order-total-price">$170.00</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        
                                    </div>
                                </div>
                                <!-- shopping-cart end -->
                                <!-- wishlist start -->
                                <div class="tab-pane" id="wishlist">
                                    <div class="wishlist-content">
                                        <form action="#">
                                            <div class="table-content table-responsive mb-50">
                                                <table class="text-center">
                                                    <thead>
                                                        <tr>
                                                            <th class="product-thumbnail">product</th>
                                                            <th class="product-price">price</th>
                                                            <th class="product-stock">Stock status</th>
                                                            <th class="product-add-cart">add to cart</th>
                                                            <th class="product-remove">remove</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!-- tr -->
                                                        <tr>
                                                            <td class="product-thumbnail">
                                                                <div class="pro-thumbnail-img">
                                                                    <img src="img/cart/1.jpg" alt="">
                                                                </div>
                                                                <div class="pro-thumbnail-info text-left">
                                                                    <h6 class="product-title-2">
                                                                        <a href="#">dummy product name</a>
                                                                    </h6>
                                                                    <p>Brand: Brand Name</p>
                                                                    <p>Model: Grand s2</p>
                                                                    <p> Color: Black, White</p>
                                                                </div>
                                                            </td>
                                                            <td class="product-price">$560.00</td>
                                                            <td class="product-stock text-uppercase">in stoct</td>
                                                            <td class="product-add-cart">
                                                                <a href="#" title="Add To Cart">
                                                                    <i class="zmdi zmdi-shopping-cart-plus"></i>
                                                                </a>
                                                            </td>
                                                            <td class="product-remove">
                                                                <a href="#"><i class="zmdi zmdi-close"></i></a>
                                                            </td>
                                                        </tr>
                                                        <!-- tr -->
                                                        <tr>
                                                            <td class="product-thumbnail">
                                                                <div class="pro-thumbnail-img">
                                                                    <img src="img/cart/2.jpg" alt="">
                                                                </div>
                                                                <div class="pro-thumbnail-info text-left">
                                                                    <h6 class="product-title-2">
                                                                        <a href="#">dummy product name</a>
                                                                    </h6>
                                                                    <p>Brand: Brand Name</p>
                                                                    <p>Model: Grand s2</p>
                                                                    <p> Color: Black, White</p>
                                                                </div>
                                                            </td>
                                                            <td class="product-price">$560.00</td>
                                                            <td class="product-stock text-uppercase">in stoct</td>
                                                            <td class="product-add-cart">
                                                                <a href="#" title="Add To Cart">
                                                                    <i class="zmdi zmdi-shopping-cart-plus"></i>
                                                                </a>
                                                            </td>
                                                            <td class="product-remove">
                                                                <a href="#"><i class="zmdi zmdi-close"></i></a>
                                                            </td>
                                                        </tr>
                                                        <!-- tr -->
                                                        <tr>
                                                            <td class="product-thumbnail">
                                                                <div class="pro-thumbnail-img">
                                                                    <img src="img/cart/3.jpg" alt="">
                                                                </div>
                                                                <div class="pro-thumbnail-info text-left">
                                                                    <h6 class="product-title-2">
                                                                        <a href="#">dummy product name</a>
                                                                    </h6>
                                                                    <p>Brand: Brand Name</p>
                                                                    <p>Model: Grand s2</p>
                                                                    <p> Color: Black, White</p>
                                                                </div>
                                                            </td>
                                                            <td class="product-price">$560.00</td>
                                                            <td class="product-stock text-uppercase">in stoct</td>
                                                            <td class="product-add-cart">
                                                                <a href="#" title="Add To Cart">
                                                                    <i class="zmdi zmdi-shopping-cart-plus"></i>
                                                                </a>
                                                            </td>
                                                            <td class="product-remove">
                                                                <a href="#"><i class="zmdi zmdi-close"></i></a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- wishlist end -->
                                <!-- checkout start -->
                                <div class="tab-pane" id="checkout">
                                    <div class="checkout-content box-shadow p-30">
                                        <form action="#">
                                            <div class="row">
                                                <!-- billing details -->
                                                <div class="col-md-6">
                                                    <div class="billing-details pr-10">
                                                        <h6 class="widget-title border-left mb-20">billing details</h6>
                                                        <input type="text" placeholder="Your Name Here...">
                                                        <input type="text" placeholder="Email address here...">
                                                        <input type="text" placeholder="Phone here...">
                                                        <input type="text" placeholder="Company neme here...">
                                                        <select class="custom-select">
                                                            <option value="defalt">country</option>
                                                            <option value="c-1">Australia</option>
                                                            <option value="c-2">Bangladesh</option>
                                                            <option value="c-3">Unitd States</option>
                                                            <option value="c-4">Unitd Kingdom</option>
                                                        </select>
                                                        <select class="custom-select">
                                                            <option value="defalt">State</option>
                                                            <option value="c-1">Melbourne</option>
                                                            <option value="c-2">Dhaka</option>
                                                            <option value="c-3">New York</option>
                                                            <option value="c-4">London</option>
                                                        </select>
                                                        <select class="custom-select">
                                                            <option value="defalt">Town/City</option>
                                                            <option value="c-1">Victoria</option>
                                                            <option value="c-2">Chittagong</option>
                                                            <option value="c-3">Boston</option>
                                                            <option value="c-4">Cambridge</option>
                                                        </select>
                                                        <textarea class="custom-textarea"
                                                            placeholder="Your address here..."></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <!-- our order -->
                                                    <div class="payment-details pl-10 mb-50">
                                                        <h6 class="widget-title border-left mb-20">our order</h6>
                                                        <table>
                                                            <tr>
                                                                <td class="td-title-1">Dummy Product Name x 2</td>
                                                                <td class="td-title-2">$1855.00</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="td-title-1">Dummy Product Name</td>
                                                                <td class="td-title-2">$555.00</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="td-title-1">Cart Subtotal</td>
                                                                <td class="td-title-2">$2410.00</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="td-title-1">Shipping and Handing</td>
                                                                <td class="td-title-2">$15.00</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="td-title-1">Vat</td>
                                                                <td class="td-title-2">$00.00</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="order-total">Order Total</td>
                                                                <td class="order-total-price">$2425.00</td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <!-- payment-method -->
                                                    <div class="payment-method">
                                                        <h6 class="widget-title border-left mb-20">payment method</h6>
                                                        <div id="accordion">
                                                            <div class="panel">
                                                                <h4 class="payment-title box-shadow">
                                                                    <a data-toggle="collapse" data-parent="#accordion"
                                                                        href="#bank-transfer">
                                                                        direct bank transfer
                                                                    </a>
                                                                </h4>
                                                                <div id="bank-transfer"
                                                                    class="panel-collapse collapse in">
                                                                    <div class="payment-content">
                                                                        <p>Lorem Ipsum is simply in dummy text of the
                                                                            printing and type setting industry. Lorem
                                                                            Ipsum has been.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="panel">
                                                                <h4 class="payment-title box-shadow">
                                                                    <a class="collapsed" data-toggle="collapse"
                                                                        data-parent="#accordion" href="#collapseTwo">
                                                                        cheque payment
                                                                    </a>
                                                                </h4>
                                                                <div id="collapseTwo" class="panel-collapse collapse">
                                                                    <div class="payment-content">
                                                                        <p>Please send your cheque to Store Name, Store
                                                                            Street, Store Town, Store State / County,
                                                                            Store Postcode.</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="panel">
                                                                <h4 class="payment-title box-shadow">
                                                                    <a data-toggle="collapse" data-parent="#accordion"
                                                                        href="#collapseThree">
                                                                        paypal
                                                                    </a>
                                                                </h4>
                                                                <div id="collapseThree" class="panel-collapse collapse">
                                                                    <div class="payment-content">
                                                                        <p>Pay via PayPal; you can pay with your credit
                                                                            card if you don't have a PayPal account.</p>
                                                                        <ul class="payent-type mt-10">
                                                                            <li><a href="#"><img src="img/payment/1.png"
                                                                                        alt=""></a></li>
                                                                            <li><a href="#"><img src="img/payment/2.png"
                                                                                        alt=""></a></li>
                                                                            <li><a href="#"><img src="img/payment/3.png"
                                                                                        alt=""></a></li>
                                                                            <li><a href="#"><img src="img/payment/4.png"
                                                                                        alt=""></a></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- payment-method end -->
                                                    <button class="submit-btn-1 mt-30 btn-hover-1" type="submit">place
                                                        order</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- checkout end -->
                                <!-- order-complete start -->
                                <div class="tab-pane" id="order-complete">
                                    <div class="order-complete-content box-shadow">
                                        <div class="thank-you p-30 text-center">
                                            <h6 class="text-black-5 mb-0">Thank you. Your order has been received.</h6>
                                        </div>
                                        <div class="order-info p-30 mb-10">
                                            <ul class="order-info-list">
                                                <li>
                                                    <h6>order no</h6>
                                                    <p>m 2653257</p>
                                                </li>
                                                <li>
                                                    <h6>order no</h6>
                                                    <p>m 2653257</p>
                                                </li>
                                                <li>
                                                    <h6>order no</h6>
                                                    <p>m 2653257</p>
                                                </li>
                                                <li>
                                                    <h6>order no</h6>
                                                    <p>m 2653257</p>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="row">
                                            <!-- our order -->
                                            <div class="col-md-6">
                                                <div class="payment-details p-30">
                                                    <h6 class="widget-title border-left mb-20">our order</h6>
                                                    <table>
                                                        <tr>
                                                            <td class="td-title-1">Dummy Product Name x 2</td>
                                                            <td class="td-title-2">$1855.00</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="td-title-1">Dummy Product Name</td>
                                                            <td class="td-title-2">$555.00</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="td-title-1">Cart Subtotal</td>
                                                            <td class="td-title-2">$2410.00</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="td-title-1">Shipping and Handing</td>
                                                            <td class="td-title-2">$15.00</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="td-title-1">Vat</td>
                                                            <td class="td-title-2">$00.00</td>
                                                        </tr>
                                                        <tr>
                                                            <td class="order-total">Order Total</td>
                                                            <td class="order-total-price">$2425.00</td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="bill-details p-30">
                                                    <h6 class="widget-title border-left mb-20">billing details</h6>
                                                    <ul class="bill-address">
                                                        <li>
                                                            <span>Address:</span>
                                                            28 Green Tower, Street Name, New York City, USA
                                                        </li>
                                                        <li>
                                                            <span>email:</span>
                                                            info@companyname.com
                                                        </li>
                                                        <li>
                                                            <span>phone : </span>
                                                            (+880) 19453 821758
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="bill-details pl-30">
                                                    <h6 class="widget-title border-left mb-20">billing details</h6>
                                                    <ul class="bill-address">
                                                        <li>
                                                            <span>Address:</span>
                                                            28 Green Tower, Street Name, New York City, USA
                                                        </li>
                                                        <li>
                                                            <span>email:</span>
                                                            info@companyname.com
                                                        </li>
                                                        <li>
                                                            <span>phone : </span>
                                                            (+880) 19453 821758
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- order-complete end -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- SHOP SECTION END -->

        </section>
        <!-- End page content -->

        <!-- START FOOTER AREA -->
        <footer id="footer" class="footer-area">
            <div class="footer-top">
                <div class="container-fluid">
                    <div class="plr-185">
                        <div class="footer-top-inner gray-bg">
                            <div class="row">
                                <div class="col-lg-4 col-md-5 col-sm-4">
                                    <div class="single-footer footer-about">
                                        <div class="footer-logo">
                                            <img src="img/logo/logo.png" alt="">
                                        </div>
                                        <div class="footer-brief">
                                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting
                                                industry. Lorem Ipsum has been the subas industry's standard dummy text
                                                ever since the 1500s,</p>
                                            <p>When an unknown printer took a galley of type and If you are going to use
                                                a passage of Lorem Ipsum scrambled it to make.</p>
                                        </div>
                                        <ul class="footer-social">
                                            <li>
                                                <a class="facebook" href="#" title="Facebook"><i
                                                        class="zmdi zmdi-facebook"></i></a>
                                            </li>
                                            <li>
                                                <a class="google-plus" href="#" title="Google Plus"><i
                                                        class="zmdi zmdi-google-plus"></i></a>
                                            </li>
                                            <li>
                                                <a class="twitter" href="#" title="Twitter"><i
                                                        class="zmdi zmdi-twitter"></i></a>
                                            </li>
                                            <li>
                                                <a class="rss" href="#" title="RSS"><i class="zmdi zmdi-rss"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-2 hidden-md hidden-sm">
                                    <div class="single-footer">
                                        <h4 class="footer-title border-left">Shipping</h4>
                                        <ul class="footer-menu">
                                            <li>
                                                <a href="#"><i class="zmdi zmdi-circle"></i><span>New
                                                        Products</span></a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="zmdi zmdi-circle"></i><span>Discount
                                                        Products</span></a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="zmdi zmdi-circle"></i><span>Best Sell
                                                        Products</span></a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="zmdi zmdi-circle"></i><span>Popular
                                                        Products</span></a>
                                            </li>
                                            <li>
                                                <a href="#"><i
                                                        class="zmdi zmdi-circle"></i><span>Manufactirers</span></a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="zmdi zmdi-circle"></i><span>Suppliers</span></a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="zmdi zmdi-circle"></i><span>Special
                                                        Products</span></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-2 col-md-3 col-sm-4">
                                    <div class="single-footer">
                                        <h4 class="footer-title border-left">my account</h4>
                                        <ul class="footer-menu">
                                            <li>
                                                <a href="#"><i class="zmdi zmdi-circle"></i><span>My Account</span></a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="zmdi zmdi-circle"></i><span>My Wishlist</span></a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="zmdi zmdi-circle"></i><span>My Cart</span></a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="zmdi zmdi-circle"></i><span>Sign In</span></a>
                                            </li>
                                            <li>
                                                <a href="#"><i
                                                        class="zmdi zmdi-circle"></i><span>Registration</span></a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="zmdi zmdi-circle"></i><span>Check out</span></a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="zmdi zmdi-circle"></i><span>Oder
                                                        Complete</span></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4">
                                    <div class="single-footer">
                                        <h4 class="footer-title border-left">Get in touch</h4>
                                        <div class="footer-message">
                                            <form action="#">
                                                <input type="text" name="name" placeholder="Your name here...">
                                                <input type="text" name="email" placeholder="Your email here...">
                                                <textarea class="height-80" name="message"
                                                    placeholder="Your messege here..."></textarea>
                                                <button class="submit-btn-1 mt-20 btn-hover-1" type="submit">submit
                                                    message</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom black-bg">
                <div class="container-fluid">
                    <div class="plr-185">
                        <div class="copyright">
                            <div class="row">
                                <div class="col-sm-6 col-xs-12">
                                    <div class="copyright-text">
                                        <p>&copy; <a href="#" target="_blank">DevItems</a> 2017. All Rights Reserved.
                                        </p>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <ul class="footer-payment text-right">
                                        <li>
                                            <a href="#"><img src="img/payment/1.jpg" alt=""></a>
                                        </li>
                                        <li>
                                            <a href="#"><img src="img/payment/2.jpg" alt=""></a>
                                        </li>
                                        <li>
                                            <a href="#"><img src="img/payment/3.jpg" alt=""></a>
                                        </li>
                                        <li>
                                            <a href="#"><img src="img/payment/4.jpg" alt=""></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- END FOOTER AREA -->

        <!--style-customizer start -->
        <div class="style-customizer closed">
            <div class="buy-button">
                <a href="index.html" class="customizer-logo"><img src="images/logo/logo.png" alt="Theme Logo"></a>
                <a class="opener" href="#"><i class="zmdi zmdi-settings"></i></a>
            </div>
            <div class="clearfix content-chooser">
                <h3>Layout Options</h3>
                <p>Which layout option you want to use?</p>
                <ul class="layoutstyle clearfix">
                    <li class="wide-layout selected" data-style="wide" title="wide"> Wide </li>
                    <li class="boxed-layout" data-style="boxed" title="boxed"> Boxed </li>
                </ul>
                <h3>Color Schemes</h3>
                <p>Which theme color you want to use? Select from here.</p>
                <ul class="styleChange clearfix">
                    <li class="skin-default selected" title="skin-default" data-style="skin-default"></li>
                    <li class="skin-green" title="green" data-style="skin-green"></li>
                    <li class="skin-purple" title="purple" data-style="skin-purple"></li>
                    <li class="skin-blue" title="blue" data-style="skin-blue"></li>
                    <li class="skin-cyan" title="cyan" data-style="skin-cyan"></li>
                    <li class="skin-amber" title="amber" data-style="skin-amber"></li>
                    <li class="skin-blue-grey" title="blue-grey" data-style="skin-blue-grey"></li>
                    <li class="skin-teal" title="teal" data-style="skin-teal"></li>
                </ul>
                <h3>Background Patterns</h3>
                <p>Which background pattern you want to use?</p>
                <ul class="patternChange clearfix">
                    <li class="pattern-1" data-style="pattern-1" title="pattern-1"></li>
                    <li class="pattern-2" data-style="pattern-2" title="pattern-2"></li>
                    <li class="pattern-3" data-style="pattern-3" title="pattern-3"></li>
                    <li class="pattern-4" data-style="pattern-4" title="pattern-4"></li>
                    <li class="pattern-5" data-style="pattern-5" title="pattern-5"></li>
                    <li class="pattern-6" data-style="pattern-6" title="pattern-6"></li>
                    <li class="pattern-7" data-style="pattern-7" title="pattern-7"></li>
                    <li class="pattern-8" data-style="pattern-8" title="pattern-8"></li>
                </ul>
                <h3>Background Images</h3>
                <p>Which background image you want to use?</p>
                <ul class="patternChange main-bg-change clearfix">
                    <li class="main-bg-1" data-style="main-bg-1" title="Background 1"> <img
                            src="images/customizer/bodybg/01.jpg" alt=""></li>
                    <li class="main-bg-2" data-style="main-bg-2" title="Background 2"> <img
                            src="images/customizer/bodybg/02.jpg" alt=""></li>
                    <li class="main-bg-3" data-style="main-bg-3" title="Background 3"> <img
                            src="images/customizer/bodybg/03.jpg" alt=""></li>
                    <li class="main-bg-4" data-style="main-bg-4" title="Background 4"> <img
                            src="images/customizer/bodybg/04.jpg" alt=""></li>
                    <li class="main-bg-5" data-style="main-bg-5" title="Background 5"> <img
                            src="images/customizer/bodybg/05.jpg" alt=""></li>
                    <li class="main-bg-6" data-style="main-bg-6" title="Background 6"> <img
                            src="images/customizer/bodybg/06.jpg" alt=""></li>
                    <li class="main-bg-7" data-style="main-bg-7" title="Background 7"> <img
                            src="images/customizer/bodybg/07.jpg" alt=""></li>
                    <li class="main-bg-8" data-style="main-bg-8" title="Background 8"> <img
                            src="images/customizer/bodybg/08.jpg" alt=""></li>
                </ul>
                <ul class="resetAll">
                    <li><a class="button button-border button-reset" href="#">Reset All</a></li>
                </ul>
            </div>
        </div>
        <!--style-customizer end -->
    </div>
    <!-- Body main wrapper end -->


    <!-- Placed JS at the end of the document so the pages load faster -->

    <!-- jquery latest version -->
    <script src="/<?php echo BASE_URL ?>/parent/js/vendor/jquery-3.1.1.min.js"></script>
    <!-- Bootstrap framework js -->
    <script src="/<?php echo BASE_URL ?>/parent/js/bootstrap.min.js"></script>
    <!-- jquery.nivo.slider js -->
    <script src="/<?php echo BASE_URL ?>/parent/lib/js/jquery.nivo.slider.js"></script>
    <!-- All js plugins included in this file. -->
    <script src="/<?php echo BASE_URL ?>/parent/js/plugins.js"></script>
    <!-- Main js file that contents all jQuery plugins activation. -->
    <script src="/<?php echo BASE_URL ?>/parent/js/main.js"></script>

</body>


<!-- Mirrored from demo.devitems.com/subas-preview/subas/cart.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 11 Oct 2019 10:55:43 GMT -->

</html>