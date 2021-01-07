<?php
session_start();
require_once './config/database.php';
require_once './config/config.php';
spl_autoload_register(function ($className) {
    require './app/models/' . $className . '.php';
});

$CartModel = new CartModel();
$ProductModel = new ProductModel();

$user_id = 0;
$product_id = '';
$proQlt = 0;
$isBuynow = false;

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
}

$ProductById = $ProductModel->getProductById($product_id);
$product_name = $ProductById['product_name'];
$proPrice = $ProductById['product_price'];
$proImage = $ProductById['product_image'];

if (isset($_SESSION['user_id'])) {
    $user_id = (int) $_SESSION['user_id'];
    $cartList_User = $CartModel->getCartByUserProduct($user_id, $product_id)[0];
}
if (isset($_POST['product_quanlity'])) {
    $proQlt = (int) $_POST['product_quanlity'];
} elseif (isset($_POST['product_quanlity_buy'])) {
    $proQlt = (int) $_POST['product_quanlity_buy'];
    $isBuynow = true;
} 
elseif (isset($_POST['product_quanlity_quickview'])) {
    $proQlt = (int) $_POST['product_quanlity_quickview'];
}else {
    if (isset($_SESSION['cart'])) {
        if (isset($_SESSION['cart'][$product_id])) {
            // if (!empty($_SESSION['user_id'])) {
            //     $proQlt+=
            // }
            $proQlt = $_SESSION['cart'][$product_id]['qty'] += 1;
        } else {
            $proQlt = $_SESSION['cart'][$product_id]['qty'] = 1;
        }
    } else {
        $proQlt = $_SESSION['cart'][$product_id]['qty'] = 1;
    }
}
if (!empty($cartList_User)) {
    if ($cartList_User['product_id'] == $product_id) {
        $proQlt += $cartList_User['product_quanlity'];
        if ($CartModel->updateCart($user_id, $product_id, $proQlt)) {
            unset($_SESSION['cart'][$product_id]['qty']);
            $_SESSION['success'] = "<script>alert('Thêm vào giỏ hàng thành công')</script>";
        }
    } else {
        $CartModel->addCart($user_id, $product_id, $product_name, $proQlt, $proPrice, $proImage);
        $_SESSION['success'] = "<script>alert('Thêm vào giỏ hàng thành công')</script>";
        unset($_SESSION['cart'][$product_id]['qty']);
    }
} else {
    $CartModel->addCart($user_id, $product_id, $product_name, $proQlt, $proPrice, $proImage);
    $_SESSION['success'] = "<script>alert('Thêm vào giỏ hàng thành công')</script>";
    unset($_SESSION['cart'][$product_id]['qty']);

}
if ($isBuynow == true) {
    $_SESSION['buynow'] = "<script>alert('Thêm vào giỏ hàng thành công')</script>";
    unset($_SESSION['success']);
    header('location:cart-list.php');
} else {
    if (isset($_SERVER['HTTP_REFERER'])) {
        header('location:' . $_SERVER['HTTP_REFERER']);
    }
}
