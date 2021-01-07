<?php
session_start();
require_once './config/database.php';
require_once './config/config.php';
spl_autoload_register(function ($className) {
    require './app/models/' . $className . '.php';
});

$UserModel = new UserModel();
$userList = $UserModel->getAllUser();

$pass_login = '';
$email_login = '';
$pass_data = '';

$user_name = '';
$user_mail = '';
$user_phone = '';
$user_pass = '';
$is_Login = true;

date_default_timezone_set('Asia/Ho_Chi_Minh');
$name_register = '';
$email_register = '';
$phone_register = '';
$pass_register = '';
$date_create = '';
$date_update = '';
$status = 1;

if (!empty($_POST['email']) && !empty($_POST['password'])) {
    $pass_login = $_POST['password'];
    $email_login = $_POST['email'];
    $is_Login = false;
    foreach ($userList as $userValue) {
        if ($userValue['user_email'] == $email_login ||$userValue['user_phone'] == $email_login) {
            if (hash('md5', $pass_login) == $userValue['user_pass']) {
                $_SESSION['isLogin'] = true;
                $_SESSION['user_id'] = $userValue['user_id'];
                $_SESSION['user_name'] = $userValue['user_name'];
                $_SESSION['user_email'] = $userValue['user_email'];
                $_SESSION['user_phone'] = $userValue['user_phone'];
                $_SESSION['user_pass'] = $userValue['user_pass'];
                $_SESSION['user_image'] = $userValue['user_image'];
                $_SESSION['user_role'] = $userValue['user_role'];
                $_SESSION['user_date_create'] = $userValue['user_date_create'];
                $_SESSION['user_last_update'] = $userValue['user_last_update'];
                $_SESSION['user_status'] = $userValue['user_status'];
                if ($userValue['user_role'] ==2 || $userValue['user_role']==3) {
                    header('location:./admin/admmanage.php');
                } else {
                    if (isset($_SESSION['pagePre'])) {
                         header('location:' . $_SESSION['pagePre']);
                         unset($_SESSION['pagePre']);
                    }
                    else {
                        header('location:index.php');
                    }
                    
                }
                break;
            }

        }

    }

}
$isRegister = false;
$isErrorMail = false;
$isErrorPhone = false;

$errorMessEmail = '';
$errorMessPhone = '';

if (!empty($_POST['emailregister']) && !empty($_POST['phoneregister']) && !empty($_POST['nameregister']) && !empty($_POST['passregister'])) {
    $name_register = $_POST['nameregister'];
    $email_register = $_POST['emailregister'];
    $phone_register = $_POST['phoneregister'];
    $pass_register = $_POST['passregister'];
    $date_create = (string) date('d-m-Y H:i:s');

    for ($i = 0; $i < count($userList);) {
        // if ($userList[$i]['user_email'] == $email_register && $userList[$i]['user_phone'] == $phone_register) {
        //     $i++;
        // } else {
        if ($userList[$i]['user_email'] == $email_register) {
            $isErrorMail = true;
            $errorMessEmail = 'Email đã được sử dụng';
        } elseif ($userList[$i]['user_phone'] == $phone_register) {
            $isErrorPhone = true;
            $errorMessPhone = 'Số điện thoại đã được sử dụng';

        }
        $i++;
        // }

    }
    if ($isErrorMail != true && $isErrorPhone != true) {
        if ($UserModel->addUser($name_register, $email_register, $phone_register, md5($pass_register), '', 1, $date_create, $date_update, $status)) {
            $isRegister = true;
        }
    }

}
?>
<!doctype html>
<html class="no-js" lang="en">


<!-- Mirrored from demo.devitems.com/subas-preview/subas/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 11 Oct 2019 10:54:49 GMT -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Subas || Đăng nhập</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="img/icon/favicon.png">

    <!-- All CSS Files -->
    <!-- Bootstrap fremwork main css -->
    <link rel="stylesheet" href="/<?php echo BASE_URL ?>/public/css/bootstrap.min.css">
    <link rel="stylesheet" href="/<?php echo BASE_URL ?>/parent/css/bootstrap.min.css">
    <!-- Nivo-slider css -->
    <link rel="stylesheet" href="lib/css/nivo-slider.css">
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

    <link href="#" data-style="styles" rel="stylesheet">

    <!-- Modernizr JS -->
    <script src="/<?php echo BASE_URL ?>/parent/js/vendor/modernizr-2.8.3.min.js"></script>
    <style>
        #error {
            color: red;
        }
    </style>
    <script>
        function validateFormLogin() {
            if ($('#form-login')[0].checkValidity() === false) {
                event.preventDefault(); //Chặn không cho gửi form đi
                event.stopPropagation(); //Ngưng các sự kiện được kế thừa
            }
            $('#form-login').addClass('was-validated'); //addClass(): thêm một class vào một tag

        }
        function validateFormRegister() {
            confirmPass();
            if ($('#form-register')[0].checkValidity() === false) {
                event.preventDefault(); //Chặn không cho gửi form đi
                event.stopPropagation(); //Ngưng các sự kiện được kế thừa
            }
            $('#form-register').addClass('was-validated'); //addClass(): thêm một class vào một tag
        }
        function confirmPass() {
            var pass = document.getElementById("passregister").value;
            var passconfirm = document.getElementById("checkpassregister").value;
            if (pass == passconfirm) {
                $('#checkpassregister')[0].setCustomValidity('');
                return true;
            }
            else {
                $('#checkpassregister')[0].setCustomValidity('sai');
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
                                <p class="mb-0 roboto">0987 380 249</p>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <div class="top-link clearfix">
                                <ul class="link f-right">
                                    <li>
                                        <a href="my-account.html">
                                            <i class="zmdi zmdi-account"></i>
                                            Tài khoản
                                        </a>
                                    </li>
                                    <li>
                                        <a href="wishlist.html">
                                            <i class="zmdi zmdi-favorite"></i>
                                            Wish List (0)
                                        </a>
                                    </li>
                                    <li>
                                        <a href="login.html">
                                            <i class="zmdi zmdi-lock"></i>
                                            Đăng nhập
                                        </a>
                                    </li>
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
                                        <img src="/<?php echo BASE_URL?>/parent/img/logo/logo.png" alt="main logo">
                                    </a>
                                </div>
                            </div>
                            <!-- primary-menu -->
                            <div class="col-md-8 hidden-sm hidden-xs">
                                <nav id="primary-menu">
                                    <ul class="main-menu text-center">
                                        <li><a href="/<?php echo BASE_URL ?>/index.php">Trang chủ</a>
                                        </li>
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
                                <h1 class="breadcrumbs-title">Đăng nhập / Đăng kí tài khoản</h1>
                                <ul class="breadcrumb-list">
                                    <li><a href="/<?php echo BASE_URL ?>/index.php">Trang chủ</a></li>
                                    <li>Đăng nhập / Đăng kí tài khoản</li>
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
                        <div class="col-md-6">
                            <div class="registered-customers">
                                <h6 class="widget-title border-left mb-50">ĐĂNG NHẬP</h6>
                                <form action="/<?php echo BASE_URL ?>/login.php" method="POST" id="form-login"
                                    novalidate onsubmit="return validateFormLogin();">
                                    <div class="login-account p-30 box-shadow">
                                        <p>Nếu bạn đã có tài khoản. Hãy đăng nhập tại đây</p>

                                        <div class="form-group">
                                            <input type="text" name="email" id="" class="form-control"
                                                placeholder="Email hoặc số điện thoại" aria-describedby="helpId"
                                                value="<?php if ($isRegister == true) {
    echo $email_register;
}?>" required>
                                            <div class="invalid-feedback">Nhập sai Email hoặc Số điện thoại</div>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" placeholder="Mật khẩu" id=""
                                                class="form-control" aria-describedby="helpId" value="<?php if ($isRegister == true) {
    echo $pass_register;
}?>" required>
                                            <div class="invalid-feedback">Nhập sai mật khẩu</div>

                                        </div>
                                        <?php if ($is_Login == false) {
    ?>
                                        <p id="error">Thông tin tài khoản hoặc mật khẩu không chính xác</p>
                                        <?php }?>
                                        <button class="submit-btn-1 btn-hover-1" type="submit">Đăng nhập</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- new-customers -->
                        <div class="col-md-6">
                            <div class="new-customers">
                                <form action="/<?php echo BASE_URL ?>/login.php"  method="POST" id="form-register"
                                    novalidate onsubmit="return validateFormRegister();">
                                    <h6 class="widget-title border-left mb-50">ĐĂNG KÍ TÀI KHOẢN</h6>
                                    <div class="login-account p-30 box-shadow">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <input type="text" name="nameregister" id="" class="form-control"
                                                        placeholder="Nhập tên" aria-describedby="helpId" required>
                                                    <div class="invalid-feedback">Tên không được để trống</div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <input type="text" name="phoneregister" id="" class="form-control"
                                                        placeholder="Nhập số điện thoại" aria-describedby="helpId"
                                                        required>
                                                    <div class="invalid-feedback">Số điện thoại hhông được để trống</div>
                                                    <?php if ($isErrorPhone==true) {?>
                                                        <p id="error"><?php echo $errorMessPhone?></p>
                                                <?php }?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="email" name="emailregister" id="" class="form-control"
                                                placeholder="Nhấp email" aria-describedby="helpId" required>
                                            <div class="invalid-feedback">Nhập sai email đăng kí</div>
                                            <?php if ($isErrorMail==true) {?>
                                                        <p id="error"><?php echo $errorMessEmail?></p>
                                                <?php }?>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="passregister" id="passregister" class="form-control"
                                                placeholder="Nhập mật khẩu" aria-describedby="helpId" required>
                                            <div class="invalid-feedback">Nhập sai mật khẩu</div>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="checkpassregister" id="checkpassregister" class="form-control"
                                                placeholder="Xác nhận mật khẩu" aria-describedby="helpId" required>
                                            <div class="invalid-feedback">Nhập sai mật khẩu xác nhận</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <button class="submit-btn-1 mt-20 btn-hover-1" type="submit"
                                                    value="register">Đăng kí</button>
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
    <script src="/<?php echo BASE_URL ?>/public/js/jquery-3.4.1.min.js"></script>
    <script src="/<?php echo BASE_URL ?>/public/js/bootstrap.min.js"></script>
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


<!-- Mirrored from demo.devitems.com/subas-preview/subas/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 11 Oct 2019 10:54:49 GMT -->

</html>