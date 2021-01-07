<?php
session_start();
require_once './config/database.php';
require_once './config/config.php';
spl_autoload_register(function ($className) {
    require './app/models/' . $className . '.php';
});
$CategoryModel = new CategoryModel();
$BrandModel = new BrandModel();
$ProductModel = new ProductModel();
$CartModel = new CartModel();

$brandList = $BrandModel->getBrandList();
$productListFeatrue = $ProductModel->getProductByFeatrue(1);

$isLogin=false;
if (isset($_SESSION['isLogin'])) {
    $isLogin = $_SESSION['isLogin'];
}
$cart_qlt = 0;
$totalPrice = 0;
if (!empty($_SESSION['user_id'])) {
    $cartList_User = $CartModel->getCartByUser($_SESSION['user_id']);
    foreach ($cartList_User as $value) {
        $cart_qlt += $value['product_quanlity'];
        $totalPrice += $value['product_quanlity'] * $value['product_price'];
    }
}
if (isset($_SESSION['success'])) {
    echo $_SESSION['success'];
    unset($_SESSION['success']);
}
if (isset($_POST['cartId'])) {
    $pro_Id = $CartModel->getCartByCartId($_POST['cartId'])[0]['product_id'];
    if ($CartModel->DeleteCart($_POST['cartId'])) {
        unset($_SESSION['cart'][$pro_Id]['qty']);
        header('location:' . $_SERVER['REQUEST_URI']);
    }
}
function utf8convert($str)
{
    if (!$str) {
        return false;
    }

    $utf8 = array(

        'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',

        'd' => 'đ|Đ',

        'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',

        'i' => 'í|ì|ỉ|ĩ|ị|Í|Ì|Ỉ|Ĩ|Ị',

        'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ|Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',

        'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',

        'y' => 'ý|ỳ|ỷ|ỹ|ỵ|Ý|Ỳ|Ỷ|Ỹ|Ỵ',

    );

    foreach ($utf8 as $ascii => $uni) {
        $str = preg_replace("/($uni)/i", $ascii, $str);
    }

    return $str;
}
?>
<!doctype html>
<html class="no-js" lang="en">


<!-- Mirrored from demo.devitems.com/subas-preview/subas/index.php by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 11 Oct 2019 10:54:49 GMT -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Subas || Trang chủ</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="/<?php echo BASE_URL; ?>/parent/img/icon/favicon.png">

    <!-- All CSS Files -->
    <!-- Bootstrap fremwork main css -->
    <link rel="stylesheet" href="/<?php echo BASE_URL; ?>/parent/css/bootstrap.min.css">
    <!-- Nivo-slider css -->
    <link rel="stylesheet" href="/<?php echo BASE_URL; ?>/parent/lib/css/nivo-slider.css">
    <!-- This core.css file contents all plugings css file. -->
    <link rel="stylesheet" href="/<?php echo BASE_URL; ?>/parent/css/core.css">
    <!-- Theme shortcodes/elements style -->
    <link rel="stylesheet" href="/<?php echo BASE_URL; ?>/parent/css/shortcode/shortcodes.css">
    <!-- Theme main style -->
    <link rel="stylesheet" href="/<?php echo BASE_URL; ?>/parent/style.css">
    <!-- Responsive css -->
    <link rel="stylesheet" href="/<?php echo BASE_URL; ?>/parent/css/responsive.css">
    <!-- User style -->
    <link rel="stylesheet" href="/<?php echo BASE_URL; ?>/parent/css/custom.css">

    <!-- Style customizer (Remove these two lines please) -->
    <link rel="stylesheet" href="/<?php echo BASE_URL; ?>/parent/css/style-customizer.css">
    <link rel="stylesheet" href="/<?php echo BASE_URL ?>/public/css/style.css">

    <link href="#" data-style="styles" rel="stylesheet">

    <!-- Modernizr JS -->
    <script src="/<?php echo BASE_URL; ?>/parent/js/vendor/modernizr-2.8.3.min.js"></script>

    <style>
        .single-brand-product img {
            width: 100%;
            height: 100px;
            width: 120px;
        }
    </style>
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
                                    <a href="/<?php echo BASE_URL?>/index.php">
                                        <img src="/<?php echo BASE_URL; ?>/parent/img/logo/logo.png" alt="main logo">
                                    </a>
                                </div>
                            </div>
                            <!-- primary-menu -->
                            <div class="col-md-8 hidden-sm hidden-xs">
                                <nav id="primary-menu">
                                    <ul class="main-menu text-center">
                                        <li><a href="/<?php echo BASE_URL?>/index.php">Trang chủ</a>
                                        </li>
                                        </li>
                                        <li class="mega-parent"><a href="/<?php echo BASE_URL?>/shop.php">Sản phẩm</a>
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
    $brandName = $BrandModel->getBrandNamebyProductId($cart_value['product_id'])['brand_name'];
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
                                                            <a <?php if ($isLogin == false) {
                                        echo 'href=/' . BASE_URL . '/login.php';
                                        if (isset($_SERVER['HTTP_REFERER'])) {
                                            $_SESSION['pagePre'] = $_SERVER['HTTP_REFERER'];
                                        }
                                    } else {
                                        echo 'href=/' . BASE_URL . '/cart-list.php';
                                    }?>>Xem giỏ
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
                                    <li><a href="/<?php echo BASE_URL?>/index.php">Home</a>
                                    </li>
                                    <li>
                                        <a href="/<?php echo BASE_URL?>/shop.php">Sản phẩm</a>
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

        <!-- START SLIDER AREA -->
        <div class="slider-area  plr-185  mb-80">
            <div class="container-fluid">
                <div class="slider-content">
                    <div class="row">
                        <div class="active-slider-1 slick-arrow-1 slick-dots-1">
                            <!-- layer-1 Start -->
                            <div class="col-md-12">
                                <div class="layer-1">
                                    <div class="slider-img">
                                        <img src="/<?php echo BASE_URL; ?>/parent/img/slider/slider-1/1.jpg" alt="">
                                    </div>
                                    <div class="slider-info gray-bg">
                                        <div class="slider-info-inner">
                                            <h1 class="slider-title-1 text-uppercase text-black-1">WaterProof smartphone
                                            </h1>
                                            <div class="slider-brief text-black-2">
                                                <p>There are many variations of passages of Lorem Ipsum available, but
                                                    the majority have suffered alteration in some form, by injected
                                                    humour, or randomised words which don't look even slightly
                                                    believable. If you are going to use a passage of Lorem Ipsum,</p>
                                            </div>
                                            <a href="#" class="button extra-small button-black">
                                                <span class="text-uppercase">Buy now</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- layer-1 end -->
                            <!-- layer-1 Start -->
                            <div class="col-md-12">
                                <div class="layer-1">
                                    <div class="slider-img">
                                        <img src="/<?php echo BASE_URL; ?>/parent/img/slider/slider-1/2.jpg" alt="">
                                    </div>
                                    <div class="slider-info gray-bg">
                                        <div class="slider-info-inner">
                                            <h1 class="slider-title-1 text-uppercase text-black-1">WaterProof smartphone
                                            </h1>
                                            <div class="slider-brief text-black-2">
                                                <p>There are many variations of passages of Lorem Ipsum available, but
                                                    the majority have suffered alteration in some form, by injected
                                                    humour, or randomised words which don't look even slightly
                                                    believable. If you are going to use a passage of Lorem Ipsum,</p>
                                            </div>
                                            <a href="#" class="button extra-small button-black">
                                                <span class="text-uppercase">Buy now</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- layer-1 end -->
                            <!-- layer-1 Start -->
                            <div class="col-md-12">
                                <div class="layer-1">
                                    <div class="slider-img">
                                        <img src="/<?php echo BASE_URL; ?>/parent/img/slider/slider-1/1.jpg" alt="">
                                    </div>
                                    <div class="slider-info gray-bg">
                                        <div class="slider-info-inner">
                                            <h1 class="slider-title-1 text-uppercase text-black-1">WaterProof smartphone
                                            </h1>
                                            <div class="slider-brief text-black-2">
                                                <p>There are many variations of passages of Lorem Ipsum available, but
                                                    the majority have suffered alteration in some form, by injected
                                                    humour, or randomised words which don't look even slightly
                                                    believable. If you are going to use a passage of Lorem Ipsum,</p>
                                            </div>
                                            <a href="#" class="button extra-small button-black">
                                                <span class="text-uppercase">Buy now</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- layer-1 end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END SLIDER AREA -->

        <!-- Start page content -->
        <section id="page-content" class="page-wrapper">

            <!-- BY BRAND SECTION START-->
            <div class="by-brand-section mb-80">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="section-title text-left mb-40">
                                <h2 class="uppercase">Thương hiệu</h2>
                                <h6>Có rất nhiều sản phẩm theo thương hiệu</h6>
                            </div>
                        </div>
                    </div>
                    <div class="by-brand-product">
                        <div class="row active-by-brand slick-arrow-2">
                            <!-- single-brand-product start -->
                            <?php foreach ($brandList as $BrandValue) { ?>
                            <div class="col-xs-12">
                                <div class="single-brand-product">
                                    <a href="/<?php echo BASE_URL?>/shop.php?brand=<?php echo $BrandValue['brand_id']?>"><img
                                            src="/<?php echo BASE_URL; ?>/public/images/<?php echo $BrandValue['brand_image']?>"
                                            alt=""></a>

                                </div>
                            </div>
                            <?php  }?>

                            <!-- single-brand-product end -->

                        </div>
                    </div>
                </div>
            </div>
            <!-- BY BRAND SECTION END -->

            <!-- FEATURED PRODUCT SECTION START -->
            <div class="featured-product-section mb-50">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="section-title text-left mb-40">
                                <h2 class="uppercase">Sản phẩm nổi bật</h2>
                                <h6>Sản phẩm nổi bật nhất</h6>
                            </div>
                        </div>
                    </div>
                    <div class="featured-product">
                        <div class="row active-featured-product slick-arrow-2">
                            <!-- product-item start -->
                            <?php foreach ($productListFeatrue as $Provalue) { 
                                ?>
                            <div class="col-xs-12">
                                <div class="product-item">
                                    <div class="product-img">
                                        <a
                                            href="/<?php echo BASE_URL ?>/detail.php/<?php echo str_replace(' ', '-', strtolower(utf8convert($Provalue['product_name']))) . '-' . $Provalue['product_id'] ?>">
                                            <img src="/<?php echo BASE_URL; ?>/public/images/<?php echo $Provalue['product_image']?>"
                                                alt="" />
                                        </a>
                                    </div>
                                    <div class="product-info">
                                        <h6 class="product-title">
                                            <a
                                                href="/<?php echo BASE_URL ?>/detail.php/<?php echo str_replace(' ', '-', strtolower(utf8convert($Provalue['product_name']))) . '-' . $Provalue['product_id'] ?>"><?php echo $Provalue['product_name']?></a>
                                        </h6>
                                        <div class="pro-rating">
                                            <a href="#"><i class="zmdi zmdi-star"></i></a>
                                            <a href="#"><i class="zmdi zmdi-star"></i></a>
                                            <a href="#"><i class="zmdi zmdi-star"></i></a>
                                            <a href="#"><i class="zmdi zmdi-star-half"></i></a>
                                            <a href="#"><i class="zmdi zmdi-star-outline"></i></a>
                                        </div>
                                        <h3 class="pro-price">
                                            <?php echo number_format($Provalue['product_price'], 2, ',', '.'); ?></h3>
                                        <ul class="action-button">
                                            <li>
                                                <a href="#" title="Wishlist"><i class="zmdi zmdi-favorite"></i></a>
                                            </li>
                                            <li>
                                                <a href="#" data-toggle="modal"
                                                    data-target="#<?php echo 'product' .$Provalue['product_id'] ?>"
                                                    title="Quickview"><i class="zmdi zmdi-zoom-in"></i></a>
                                            </li>
                                            <li>
                                                <a href="#" title="Compare"><i class="zmdi zmdi-refresh"></i></a>
                                            </li>
                                            <li>
                                                <a href="/<?php echo BASE_URL ?>/addcart.php?id=<?php echo $Provalue['product_id'] ?>"
                                                    title="Thêm vào giỏ hàng"><i
                                                        class="zmdi zmdi-shopping-cart-plus"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <?php }?>
                            <!-- product-item end -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- FEATURED PRODUCT SECTION END -->

            <!-- UP COMMING PRODUCT SECTION START -->
            <!-- UP COMMING PRODUCT SECTION END -->

            <!-- PRODUCT TAB SECTION START -->

            <!-- PRODUCT TAB SECTION END -->

            <!-- BLOG SECTION START -->
            <div class="blog-section mb-50">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="section-title text-left mb-40">
                                <h2 class="uppercase">Latest blog</h2>
                                <h6>There are many variations of passages of brands available,</h6>
                            </div>
                        </div>
                    </div>
                    <div class="blog">
                        <div class="row active-blog">
                            <!-- blog-item start -->
                            <div class="col-xs-12">
                                <div class="blog-item">
                                    <img src="/<?php echo BASE_URL; ?>/parent/img/blog/1.jpg" alt="">
                                    <div class="blog-desc">
                                        <h5 class="blog-title"><a href="single-blog.html">dummy Blog name</a></h5>
                                        <p>There are many variations of passages of psum available, but the majority
                                            have suffered alterat on in some form, by injected humour, randomis words
                                            which don't look even slightly.</p>
                                        <div class="read-more">
                                            <a href="single-blog.html">Read more</a>
                                        </div>
                                        <ul class="blog-meta">
                                            <li>
                                                <a href="#"><i class="zmdi zmdi-favorite"></i>89 Like</a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="zmdi zmdi-comments"></i>59 Comments</a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="zmdi zmdi-share"></i>29 Share</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- blog-item end -->
                            <!-- blog-item start -->
                            <div class="col-xs-12">
                                <div class="blog-item">
                                    <img src="/<?php echo BASE_URL; ?>/parent/img/blog/2.jpg" alt="">
                                    <div class="blog-desc">
                                        <h5 class="blog-title"><a href="single-blog.html">dummy Blog name</a></h5>
                                        <p>There are many variations of passages of psum available, but the majority
                                            have suffered alterat on in some form, by injected humour, randomis words
                                            which don't look even slightly.</p>
                                        <div class="read-more">
                                            <a href="single-blog.html">Read more</a>
                                        </div>
                                        <ul class="blog-meta">
                                            <li>
                                                <a href="#"><i class="zmdi zmdi-favorite"></i>89 Like</a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="zmdi zmdi-comments"></i>59 Comments</a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="zmdi zmdi-share"></i>29 Share</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- blog-item end -->
                            <!-- blog-item start -->
                            <div class="col-xs-12">
                                <div class="blog-item">
                                    <img src="/<?php echo BASE_URL; ?>/parent/img/blog/3.jpg" alt="">
                                    <div class="blog-desc">
                                        <h5 class="blog-title"><a href="single-blog.html">dummy Blog name</a></h5>
                                        <p>There are many variations of passages of psum available, but the majority
                                            have suffered alterat on in some form, by injected humour, randomis words
                                            which don't look even slightly.</p>
                                        <div class="read-more">
                                            <a href="single-blog.html">Read more</a>
                                        </div>
                                        <ul class="blog-meta">
                                            <li>
                                                <a href="#"><i class="zmdi zmdi-favorite"></i>89 Like</a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="zmdi zmdi-comments"></i>59 Comments</a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="zmdi zmdi-share"></i>29 Share</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- blog-item end -->
                            <!-- blog-item start -->
                            <div class="col-xs-12">
                                <div class="blog-item">
                                    <img src="/<?php echo BASE_URL; ?>/parent/img/blog/1.jpg" alt="">
                                    <div class="blog-desc">
                                        <h5 class="blog-title"><a href="single-blog.html">dummy Blog name</a></h5>
                                        <p>There are many variations of passages of psum available, but the majority
                                            have suffered alterat on in some form, by injected humour, randomis words
                                            which don't look even slightly.</p>
                                        <div class="read-more">
                                            <a href="single-blog.html">Read more</a>
                                        </div>
                                        <ul class="blog-meta">
                                            <li>
                                                <a href="#"><i class="zmdi zmdi-favorite"></i>89 Like</a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="zmdi zmdi-comments"></i>59 Comments</a>
                                            </li>
                                            <li>
                                                <a href="#"><i class="zmdi zmdi-share"></i>29 Share</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- blog-item end -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- BLOG SECTION END -->
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
                                                <a href="my-account.html"><i class="zmdi zmdi-circle"></i><span>My
                                                        Account</span></a>
                                            </li>
                                            <li>
                                                <a href="wishlist.html"><i class="zmdi zmdi-circle"></i><span>My
                                                        Wishlist</span></a>
                                            </li>
                                            <li>
                                                <a href="cart.html"><i class="zmdi zmdi-circle"></i><span>My
                                                        Cart</span></a>
                                            </li>
                                            <li>
                                                <a href="login.html"><i class="zmdi zmdi-circle"></i><span>Sign
                                                        In</span></a>
                                            </li>
                                            <li>
                                                <a href="login.html"><i
                                                        class="zmdi zmdi-circle"></i><span>Registration</span></a>
                                            </li>
                                            <li>
                                                <a href="checkout.html"><i class="zmdi zmdi-circle"></i><span>Check
                                                        out</span></a>
                                            </li>
                                            <li>
                                                <a href="order.html"><i class="zmdi zmdi-circle"></i><span>Oder
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
                                            <a href="#"><img src="/<?php echo BASE_URL; ?>/parent/img/payment/1.jpg"
                                                    alt=""></a>
                                        </li>
                                        <li>
                                            <a href="#"><img src="/<?php echo BASE_URL; ?>/parent/img/payment/2.jpg"
                                                    alt=""></a>
                                        </li>
                                        <li>
                                            <a href="#"><img src="/<?php echo BASE_URL; ?>/parent/img/payment/3.jpg"
                                                    alt=""></a>
                                        </li>
                                        <li>
                                            <a href="#"><img src="/<?php echo BASE_URL; ?>/parent/img/payment/4.jpg"
                                                    alt=""></a>
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

        <!-- START QUICKVIEW PRODUCT -->
        <div id="quickview-wrapper">
            <?php foreach ($productListFeatrue as $Provalue) {?>
            <!-- Modal -->

            <div class="modal fade" id="<?php  echo 'product' .$Provalue['product_id'] ?>" tabindex="-1" role="dialog"
                style="display: none;">
                <div class="modal-dialog" role="document" style="    margin: 5% auto;
        max-width: 96%;
        min-height: 300px;
        padding: 20px;
        width: 870px;
    }">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                            <div class="modal-product clearfix">
                                <div class="product-images">
                                    <div class="main-image images">
                                        <img alt=""
                                            src="/<?php echo BASE_URL ?>/public/images/<?php echo $Provalue['product_image'] ?>">
                                    </div>
                                </div><!-- .product-images -->

                                <div class="product-info">
                                    <h1><?php echo $Provalue['product_name'] ?></h1>
                                    <div class="price-box-3">
                                        <div class="s-price-box">
                                            <span class="new-price"><?php echo $Provalue['product_price'] ?></span>

                                        </div>
                                    </div>
                                    <a href="/<?php echo BASE_URL ?>/detail.php/<?php echo str_replace(' ', '-', strtolower(utf8convert($Provalue['product_name']))) . '-' . $Provalue['product_id'] ?>"
                                        class="see-all">See all features</a>
                                    <div class="quick-add-to-cart">
                                        <form method="post" class="cart"
                                            action="/<?php echo BASE_URL ?>/addcart.php?id=<?php echo $Provalue['product_id'] ?>">
                                            <button class="single_add_to_cart_button" type="submit">Thêm vào giỏ
                                                hàng</button>
                                        </form>
                                    </div>
                                    <div class="quick-desc">
                                        <?php echo mb_substr($Provalue['product_desc'], 0, 120) . '...' ?>
                                    </div>
                                    <div class="social-sharing">
                                        <div class="widget widget_socialsharing_widget">
                                            <h3 class="widget-title-modal">Share this product</h3>
                                            <ul class="social-icons clearfix">
                                                <li>
                                                    <a class="facebook" href="#" target="_blank" title="Facebook">
                                                        <i class="zmdi zmdi-facebook"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="google-plus" href="#" target="_blank" title="Google +">
                                                        <i class="zmdi zmdi-google-plus"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="twitter" href="#" target="_blank" title="Twitter">
                                                        <i class="zmdi zmdi-twitter"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="pinterest" href="#" target="_blank" title="Pinterest">
                                                        <i class="zmdi zmdi-pinterest"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="rss" href="#" target="_blank" title="RSS">
                                                        <i class="zmdi zmdi-rss"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div><!-- .product-info -->
                            </div><!-- .modal-product -->
                        </div><!-- .modal-body -->
                    </div><!-- .modal-content -->
                </div><!-- .modal-dialog -->
            </div>
            <!-- END Modal -->
            <?php }?>
        </div>
        <!-- END QUICKVIEW PRODUCT -->

        <!--style-customizer start -->
        <div class="style-customizer closed">
            <div class="buy-button">
                <a href="index.php" class="customizer-logo"><img
                        src="/<?php echo BASE_URL?>/parent/images/logo/logo.png" alt="Theme Logo"></a>
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
                            src="/<?php echo BASE_URL; ?>/parent/images/customizer/bodybg/01.jpg" alt=""></li>
                    <li class="main-bg-2" data-style="main-bg-2" title="Background 2"> <img
                            src="/<?php echo BASE_URL; ?>/parent/images/customizer/bodybg/02.jpg" alt=""></li>
                    <li class="main-bg-3" data-style="main-bg-3" title="Background 3"> <img
                            src="/<?php echo BASE_URL; ?>/parent/images/customizer/bodybg/03.jpg" alt=""></li>
                    <li class="main-bg-4" data-style="main-bg-4" title="Background 4"> <img
                            src="/<?php echo BASE_URL; ?>/parent/images/customizer/bodybg/04.jpg" alt=""></li>
                    <li class="main-bg-5" data-style="main-bg-5" title="Background 5"> <img
                            src="/<?php echo BASE_URL; ?>/parent/images/customizer/bodybg/05.jpg" alt=""></li>
                    <li class="main-bg-6" data-style="main-bg-6" title="Background 6"> <img
                            src="/<?php echo BASE_URL; ?>/parent/images/customizer/bodybg/06.jpg" alt=""></li>
                    <li class="main-bg-7" data-style="main-bg-7" title="Background 7"> <img
                            src="/<?php echo BASE_URL; ?>/parent/images/customizer/bodybg/07.jpg" alt=""></li>
                    <li class="main-bg-8" data-style="main-bg-8" title="Background 8"> <img
                            src="/<?php echo BASE_URL; ?>/parent/images/customizer/bodybg/08.jpg" alt=""></li>
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
    <script src="/<?php echo BASE_URL; ?>/parent/js/vendor/jquery-3.1.1.min.js"></script>
    <!-- Bootstrap framework js -->
    <script src="/<?php echo BASE_URL; ?>/parent/js/bootstrap.min.js"></script>
    <!-- jquery.nivo.slider js -->
    <script src="/<?php echo BASE_URL; ?>/parent/lib/js/jquery.nivo.slider.js"></script>
    <!-- All js plugins included in this file. -->
    <script src="/<?php echo BASE_URL; ?>/parent/js/plugins.js"></script>
    <!-- Main js file that contents all jQuery plugins activation. -->
    <script src="/<?php echo BASE_URL; ?>/parent/js/main.js"></script>

</body>


<!-- Mirrored from demo.devitems.com/subas-preview/subas/index.php by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 11 Oct 2019 10:55:07 GMT -->

</html>