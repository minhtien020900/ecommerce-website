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
$UserModel = new UserModel();

$brandList = $BrandModel->getBrandList();
$productListFeatrue = $ProductModel->getProductByFeatrue(1);

$user_name='';
$user_id = '';
$user_phone = '';
$user_email = '';
$user_pass ='';
date_default_timezone_set('Asia/Ho_Chi_Minh');
$isErrorPass=false;
$isLogin=false;
if (isset($_SESSION['isLogin'])) {
   
    $isLogin = $_SESSION['isLogin'];
    $user_name = $_SESSION['user_name'];
    $user_id = $_SESSION['user_id'];
    $user_phone = $_SESSION['user_phone'];
    $user_email = $_SESSION['user_email'];
    $user_pass = $_SESSION['user_pass']; 
    $userItem = $UserModel->getUserby($user_id);
}
if (!empty($_POST['oldpassword']) && !empty($_POST['newpassword']) && !empty($_POST['confirmpassword'])) {
    if (hash("md5",$_POST['oldpassword'])==$userItem['user_pass']) {
        $update = (string) date('d-m-Y H:i:s');
        if ($UserModel->updatePass((int)$user_id,md5($_POST['newpassword']),$update)) {
           echo "<script>alert('Đổi mật khẩu thành công!')</script>";
           
        }
    }
    else {
        $isErrorPass=true;
        echo "<script>alert('Đổi mật khẩu thất bại')</script>";
    }
}
if (!empty($_POST['name'])) {
    
        if ($UserModel->updateCustomer((int)$user_id,$_POST['name'])) {

           header('location:my-account.php');
        }
    
    else {
        $isErrorPass=true;
        echo "<script>alert('Cập nhật thông tin thất bại')</script>";
    }
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
?>
<!doctype html>
<html class="no-js" lang="en">


<!-- Mirrored from demo.devitems.com/subas-preview/subas/my-account.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 11 Oct 2019 10:54:42 GMT -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Subas || My Account</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="img/icon/favicon.png">

    <!-- All CSS Files -->
    <!-- Bootstrap fremwork main css -->
    <link rel="stylesheet" href="/<?php echo BASE_URL ?>/public/css/bootstrap.min.css">
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
    <link rel="stylesheet" href="/<?php echo BASE_URL ?>/public/css/style.css">

    <link rel="stylesheet" href="/<?php echo BASE_URL; ?>/parent/css/style-customizer.css">
    <link href="#" data-style="styles" rel="stylesheet">

    <!-- Modernizr JS -->
    <script src="/<?php echo BASE_URL; ?>/parent/js/vendor/modernizr-2.8.3.min.js"></script>
    <script>
        function validateForm() {

            if ($('#form-changeinfor')[0].checkValidity() === false) {
                event.preventDefault(); //Chặn không cho gửi form đi
                event.stopPropagation(); //Ngưng các sự kiện được kế thừa
            }
            $('#form-changeinfor').addClass('was-validated'); //addClass(): thêm một class vào một tag
        }
        
        function validateFormChangepass() {
            confirmChangePass();
            if ($('#form-changepass')[0].checkValidity() === false) {
                event.preventDefault(); //Chặn không cho gửi form đi
                event.stopPropagation(); //Ngưng các sự kiện được kế thừa
            }
            $('#form-changepass').addClass('was-validated'); //addClass(): thêm một class vào một tag
        }
        function confirmChangePass() {
            var pass = document.getElementById("newpassword").value;
            var passconfirm = document.getElementById("confirmpassword").value;
            if (pass == passconfirm) {
                $('#confirmpassword')[0].setCustomValidity('');
                return true;
            }
            else {
                $('#confirmpassword')[0].setCustomValidity('Mật khẩu xác nhận sai');
                return false;
            }
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

        <!-- BREADCRUMBS SETCTION START -->
        <div class="breadcrumbs-section plr-200 mb-80">
            <div class="breadcrumbs overlay-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="breadcrumbs-inner">
                                <h1 class="breadcrumbs-title">Tài khoản</h1>
                                <ul class="breadcrumb-list">
                                    <li><a href="/<?php echo BASE_URL?>/index.php">Trang chủ</a></li>
                                    <li>Tài khoản</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- BREADCRUMBS SETCTION END -->

        <!-- Start page content -->
        <div id="page-content" class="page-wrapper">

            <!-- LOGIN SECTION START -->
            <div class="login-section mb-80">
                <div class="container">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">
                            <div class="my-account-content" id="accordion2">
                                <!-- My Personal Information -->
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion2"
                                                href="#personal_info">Thông tin cá nhân của tôi</a>
                                        </h4>
                                    </div>
                                    <div id="personal_info" class="panel-collapse collapse in" role="tabpanel">
                                        <div class="panel-body">
                                            <form action="/<?php echo BASE_URL?>/my-account.php" method="post"
                                                    id="form-changeinfor" novalidate onsubmit="return inforvalidateForm();">
                                                <div class="new-customers">
                                                    <div class="p-30">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <input type="text" placeholder="First Name" name="name"
                                                                    value="<?php echo $userItem['user_name'] ?>" required>
                                                                    <div class="invalid-feedback">Tên không được để trống</div>

                                                            </div>
                                                            <div class="col-sm-6">
                                                                <input disabled type="text" placeholder="Số điện thoại"
                                                                    value="<?php echo $user_phone ?>">
                                                            </div>
                                                        </div>
                                                        <input type="text" disabled placeholder="Email address here..."
                                                            value="<?php echo $user_email ?>">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <button class="submit-btn-1 mt-20 btn-hover-1"
                                                                    type="submit">Lưu </button>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <button class="submit-btn-1 mt-20 btn-hover-1 f-right"
                                                                    type="reset">Xóa</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <!-- My shipping address -->
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#accordion2" href="#my_shipping">Đổi
                                                mật khẩu</a>
                                        </h4>
                                    </div>
                                    <div id="my_shipping" class="panel-collapse collapse" role="tabpanel">
                                        <div class="panel-body">
                                            
                                                <form action="/<?php echo BASE_URL?>/my-account.php" method="post"
                                                    id="form-changepass" novalidate onsubmit="return validateFormChangepass();">
                                                    <div class="new-customers p-30">
                                                        <div class="form-group">
                                                            <label for="oldpassword"></label>
                                                            <input type="password" name="oldpassword" id="oldpassword"
                                                                class="form-control" placeholder="Mật khẩu cũ"
                                                                aria-describedby="helpId" required>
                                                            <div class="invalid-feedback">Mật khẩu không được để trống
                                                            </div>
                                                            <?php if ($isErrorPass == true) { ?>
                                                            <p style="color:red; margin-top:10px;">Mật khẩu cũ không
                                                                đúng</p>
                                                            <?php  }?>
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="password" name="newpassword" id="newpassword"
                                                                class="form-control" placeholder="Mật khẩu mới"
                                                                aria-describedby="helpId" required>
                                                            <div class="invalid-feedback">Mật khẩu mới không được để
                                                                trống</div>
                                                        </div>
                                                        <div class="form-group">
                                                            <input type="password" name="confirmpassword"
                                                                id="confirmpassword" class="form-control"
                                                                placeholder="Xác nhận mật khẩu"
                                                                aria-describedby="helpId" required>
                                                            <div class="invalid-feedback">Mật khẩu xác nhận sai</div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <button class="submit-btn-1 mt-20 btn-hover-1"
                                                                    type="submit">Đổi</button>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <button class="submit-btn-1 mt-20 btn-hover-1 f-right"
                                                                    type="reset">Xóa</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- LOGIN SECTION END -->
        </div>
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


<!-- Mirrored from demo.devitems.com/subas-preview/subas/my-account.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 11 Oct 2019 10:54:42 GMT -->

</html>