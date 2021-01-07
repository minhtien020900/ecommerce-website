<?php
session_start();
require_once '../config/database.php';
require_once '../config/config.php';
spl_autoload_register(function ($className) {
    require '../app/models/' . $className . '.php';
});

$CategoryModel = new CategoryModel();
$categoryList = $CategoryModel->getCategoryList();

$BrandModel = new BrandModel();
$brandList = $BrandModel->getBrandList();

$ProductModel = new ProductModel();
$productList = $ProductModel->getAllproduct();

$productName = '';
$productSoluong = 0;
$productPrice = 0;
$productDesc = '';
$productImage_main = '';
$productImage_other = '';
$Image_Other = array();
$name= array();
$tmp_name = array();
$productType = 0;
$catName = '';
$brandName = '';
$catId = 0;
$brandId = 0;
$isAddCa = false;
$notification = '';
$active = '';
$isEmpty = false;
$isUpdate = false;
$urlId = '';
$id = '';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $urlId = "?id=$id";
    $productItem = $ProductModel->getProductById($id);
    $productName = $productItem['product_name'];
    $productSoluong = $productItem['product_soluong'];
    $productPrice = $productItem['product_price'];
    $productDesc = $productItem['product_desc'];
    $productImage_main = $productItem['product_image'];
    $productType = $productItem['product_featured'];
    $catName = $CategoryModel->getCategoryByProductId($id);
    $catId = $catName['category_id'];
    $brandName = $BrandModel->getBrandNamebyProductId($id);
    $brandId = $brandName['brand_id'];
    $productImage_other = $productItem['product_image_other'];
    $arrImg = explode('/',$productImage_other);

}

if (!empty($_POST['productName']) && !empty($_POST['categoryName']) && !empty($_POST['brandName']) && !empty($_POST['productSoluong']) && !empty($_POST['productDesc']) && !empty($_POST['productPrice'])) {
    $productName = $_POST['productName'];
    $catId = $_POST['categoryName'];
    $brandId = $_POST['brandName'];
    $productSoluong = $_POST['productSoluong'];
    $productPrice = $_POST['productPrice'];
    $productDesc = $_POST['productDesc'];
    $productType = $_POST['productType'];
    // Update Product
    if (isset($_GET['id'])) {
      $isUpdate = true;
        // Kiểm tra có gửi file upload không
        if (!empty($_FILES['mainImg']['name'])) {
            // Đường dẫn lưu file được upload
              $productImage_main = '../public/images/' . basename($_FILES['mainImg']['name']);
              if (!empty($_FILES['imgOther']['name'])) {
                $productImage_other = '';
                // Upload nhiều hình:
                foreach ($_FILES['imgOther']['name'] as  $valueName) {
                  $name[] = $valueName;
                }
                foreach ($_FILES['imgOther']['tmp_name'] as  $valueTmp_name) {
                  $tmp_name[] = $valueTmp_name;
                }
                for ($i=0; $i <count($name) ; $i++) { 
                  $path = '../public/images/' . basename($name[$i]);
                  if (is_uploaded_file($tmp_name[$i])&&move_uploaded_file($tmp_name[$i],$path)) {
                    $str = basename($name[$i]).'/';
                    $productImage_other .=$str;
                  }
                }
                if ($name[0]=='') {
                  $productImage_other = $_POST['oldImgOther'];
                }
              $arrImg = explode('/',rtrim($productImage_other,'/'));
             
              }
 
            // Thực hiện hai công việc upload
            if (is_uploaded_file($_FILES['mainImg']['tmp_name']) && move_uploaded_file($_FILES['mainImg']['tmp_name'], $productImage_main)) {
                //Update:
                if ($ProductModel->updateProduct($id, $productName, $productDesc, $productPrice, basename($productImage_main), $productType, $productSoluong,rtrim($productImage_other,'/'))) {
                  $notification = "Cập nhật sản phẩm thành công!";
                  $active = "success";
                  $ProductModel->updateCateBrand($id, $catId, $brandId);
                }
                else {
                  $notification = "Cập nhật sản phẩm thất bại!";
                  $active = "danger";
                }
            }
        } 
        else {
          $productImage_main = $_POST['oldImgmain'];
          if (!empty($_FILES['imgOther']['name'])) {
              $productImage_other='';
              // Upload nhiều hình:
              foreach ($_FILES['imgOther']['name'] as  $valueName) {
                $name[] = $valueName;
              }
              foreach ($_FILES['imgOther']['tmp_name'] as  $valueTmp_name) {
                $tmp_name[] = $valueTmp_name;
              }
              for ($i=0; $i <count($name) ; $i++) { 
                $path = '../public/images/' . basename($name[$i]);
                if (is_uploaded_file($tmp_name[$i])&&move_uploaded_file($tmp_name[$i],$path)) {
                  $str = basename($name[$i]).'/';
                  $productImage_other .=$str;
                }
              }
              if ($name[0]=='') {
                $productImage_other=$_POST['oldImgOther'];
              }
              $arrImg = explode('/',rtrim($productImage_other,'/'));
          }
            //Update:         
            if ($ProductModel->updateProduct($id, $productName, $productDesc, $productPrice, basename($productImage_main), $productType, $productSoluong,rtrim($productImage_other,'/'))) {
                $isUpdate = true;
                $notification = "Cập nhật sản phẩm thành công!";
                $active = "success";
                $ProductModel->updateCateBrand($id, $catId, $brandId);
            }
            else {
              $notification = "Cập nhật sản phẩm thất bại!";
                $active = "danger";
            }
          
        }
    }
    // Add product
    else {
        $isAddCa = true;
        if (!empty($_FILES['mainImg']['name']) && !empty($_FILES['imgOther']['name'])) {
            // Đường dẫn lưu file được upload
            $productImage_main = '../public/images/' . basename($_FILES['mainImg']['name']);

            // Upload nhiều hình:
            foreach ($_FILES['imgOther']['name'] as  $valueName) {
              $name[] = $valueName;
            }
            foreach ($_FILES['imgOther']['tmp_name'] as  $valueTmp_name) {
              $tmp_name[] = $valueTmp_name;
            }
            for ($i=0; $i <count($name) ; $i++) { 
              $path = '../public/images/' . basename($name[$i]);
              if (is_uploaded_file($tmp_name[$i])&&move_uploaded_file($tmp_name[$i],$path)) {
                $str = basename($name[$i]).'/';
                $productImage_other .=$str;
              }
            }
            $arrImg = explode('/',rtrim($productImage_other,'/'));
           

            // Thực hiện hai công việc upload
            if (is_uploaded_file($_FILES['mainImg']['tmp_name']) && move_uploaded_file($_FILES['mainImg']['tmp_name'], $productImage_main)) {

                //Add
                if ($ProductModel->addProduct($productName, $productDesc, $productPrice, basename($productImage_main), $productType, $productSoluong,rtrim($productImage_other,'/'))) {
                    $isAddCa = true;
                    $productId = $ProductModel->getMaxId();
                    $ProductModel->addProCatBrand($productId['MAX(product_id)'], $catId, $brandId);
                    $notification = "Thêm sản phẩm thành công!";
                    $active = "success";
                }
                else {
                    $notification = "Thêm sản phẩm thất bại!";
                    $active = "danger";
                }
            }

        }
    }  
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/<?php echo BASE_URL ?>/admin/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet"
    href="/<?php echo BASE_URL ?>/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="/<?php echo BASE_URL ?>/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="/<?php echo BASE_URL ?>/admin/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/<?php echo BASE_URL ?>/admin/dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="/<?php echo BASE_URL ?>/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="/<?php echo BASE_URL ?>/admin/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="/<?php echo BASE_URL ?>/admin/plugins/summernote/summernote-bs4.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <style>
    #gallery {
      list-style: none;
      float: left;
      width=23%;
      padding: 10px;
      box-sizing: border-box;
      border: 1px solid #ccc;
      margin: 10px 1%;
    }

    #gallery img {
      max-width: 100%;
      height: 120px;

    }
  </style>
</head>

<body class="hold-transition sidebar-mini">
  <!-- Site wrapper -->
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="/<?php echo BASE_URL ?>/admin/admmanage.php" class="nav-link">Home</a>
        </li>
      </ul>

      <!-- SEARCH FORM -->

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item">
          <a class="nav-link" href="/<?php echo BASE_URL ?>/logout.php">
            <i class="fas fa-sign-out-alt"></i>
          </a>
        </li>
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="#" class="brand-link">
        <img src="/<?php echo BASE_URL ?>/admin/dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
          class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="/<?php echo BASE_URL ?>/public/images/<?php echo basename($_SESSION['user_image'])?>" class="img-circle elevation-2"
              alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block"><?php echo $_SESSION['user_name']?></a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item has-treeview">
              <a href="/<?php echo BASE_URL ?>/admin/admmanage.php" class="nav-link active">
                <i class="nav-icon fas fa-home"></i>
                <p>
                  Home
                </p>
              </a>
            </li>
            <li>
              <hr>
            </li>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-tasks"></i>
                <p>
                  Danh mục sản phẩm
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="/<?php echo BASE_URL?>/admin/addcategory.php" class="nav-link">
                    <i class="fas fa-plus-square nav-icon"></i>
                    <p>Thêm danh mục</p>
                  </a>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="/<?php echo BASE_URL?>/admin/listcategory.php" class="nav-link">
                    <i class="fas fa-list-alt nav-icon"></i>
                    <p>Danh sách danh mục</p>
                  </a>
                </li>
              </ul>
            </li>
            <li>
              <hr>
            </li>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fab fa-elementor"></i>
                <p>
                  Quản lý thương hiệu
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="/<?php echo BASE_URL?>/admin/addbrand.php" class="nav-link">
                    <i class="fas fa-plus-square nav-icon"></i>
                    <p>Thêm thương hiệu</p>
                  </a>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="/<?php echo BASE_URL?>/admin/listbrand.php" class="nav-link">
                    <i class="fas fa-th-list nav-icon"></i>
                    <p>Danh sách thương hiệu</p>
                  </a>
                </li>
              </ul>
            </li>
            <li>
              <hr>
            </li>
            <li class="nav-item has-treeview menu-open">
              <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-edit"></i>
                <p>
                  Quản lý sản phẩm
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="/<?php echo BASE_URL ?>/admin/addproduct.php" class="nav-link active">
                    <i class="fas fa-plus-square nav-icon"></i>
                    <p>Thêm sản phẩm</p>
                  </a>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="/<?php echo BASE_URL ?>/admin/listproduct.php" class="nav-link">
                    <i class="fas fa-list-ul nav-icon"></i>
                    <p>Danh sách sản phẩm</p>
                  </a>
                </li>
              </ul>
            </li>
            <li>
              <hr>
            </li>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-shipping-fast"></i>
                <p>
                  Quản lý đơn hàng
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="/<?php echo BASE_URL ?>/admin/listoder.php" class="nav-link">
                    <i class="fas fa-list-ul nav-icon"></i>
                    <p>Liệt kê đơn hàng</p>
                  </a>
                </li>
              </ul>
            </li>
            <?php if ($_SESSION['user_role']==3) { ?>
            <li>
              <hr>
            </li>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-users-cog"></i>
                <p>
                  Quản lý nhân viên
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="/<?php echo BASE_URL ?>/admin/addadmin.php" class="nav-link">
                    <i class="fas fa-user-plus nav-icon"></i>
                    <p>Thêm nhân viên</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/<?php echo BASE_URL ?>/admin/listadmin.php" class="nav-link">
                    <i class="nav-icon fas fa-user-edit"></i>
                    <p>Danh sách admin</p>
                  </a>
                </li>
              </ul>
            </li>
            <?php }?>
            <li>
              <hr>
            </li>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-user"></i>
                <p>
                  Tài khoản
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="/<?php echo BASE_URL ?>/admin/profile.php" class="nav-link">
                    <i class="fas fa-info-circle nav-icon"></i>
                    <p>Thông tin tài khoản</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/<?php echo BASE_URL ?>/admin/lockscreen.php" class="nav-link">
                    <i class="fas fa-user-lock nav-icon"></i>
                    <p>Khóa màn hình</p>
                  </a>
                </li>
                <li class="nav-item">
                  <a href="/<?php echo BASE_URL ?>/logout.php" class="nav-link">
                    <i class="fas fa-sign-out-alt nav-icon"></i>
                    <p>Đăng xuất</p>
                  </a>
                </li>

              </ul>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>
                <?php if ($isUpdate == true) {
    echo "Cập nhật sản phẩm";
} else {
    echo "Thêm sản phẩm";
}?></h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/<?php echo BASE_URL ?>/admin/admmanage.php">Home</a></li>
                <li class="breadcrumb-item active"><?php if ($isUpdate == true) {
    echo "Cập nhật sản phẩm";
} else {
    echo "Thêm sản phẩm";
}
?></li>
              </ol>
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->
      </section>
    <?php
      if ($isUpdate == true) {
        echo "<div class='container-fluid'>" . "<div class ='alert alert-" . $active . "' role='alert'>" . $notification .
        "</div></div>";
      }
    else {
      echo "<div class='container-fluid'>" . "<div class ='alert alert-" . $active . "' role='alert'>" . $notification .
        "</div></div>";
    }?>

    <!-- Main content -->
    <section class="content">
      <div class="card card-primary">
        <div class="card-body">
          <div class="form-group">
            <form action="/<?php echo BASE_URL ?>/admin/addproduct.php<?php echo $urlId ?>" method="post"
              enctype="multipart/form-data">
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Tên sản phẩm:</label>
                <div class="col-sm-10">
                  <input type="text" name="productName" id="productName" class="form-control"
                    placeholder="Nhập tên sản phẩm..." value="<?php echo $productName ?>">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Danh mục:</label>
                <div class="col-sm-10">
                  <select class="form-control" name="categoryName" id="categoryName">
                    <option>--Chọn danh mục--</option>
                    <?php foreach ($categoryList as $Catvalue) {?>
                    <option value="<?php echo $Catvalue['category_id'] ?>" <?php if ($Catvalue['category_id'] == $catId) {
    echo "selected";}?>><?php echo $Catvalue['category_name'] ?></option>
                    <?php }?>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Thương hiệu:</label>
                <div class="col-sm-10">
                  <select class="form-control" name="brandName" id="brandName">
                    <option>--Chọn thương hiệu--</option>
                    <?php foreach ($brandList as $value) {?>
                    <option value="<?php echo $value['brand_id'] ?>" <?php if ($value['brand_id'] == $brandId) {
    echo "selected";}?>><?php echo $value['brand_name'] ?></option>
                    <?php }
?>
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Số lượng: </label>
                <div class="col-sm-10">
                  <input type="text" name="productSoluong" id="productSoluong" class="form-control"
                    placeholder="Nhập số lượng" value="<?php echo $productSoluong ?>">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Giá:</label>
                <div class="col-sm-10">
                  <input type="text" name="productPrice" id="productPrice" class="form-control"
                    placeholder="Nhập giá bán" value="<?php echo $productPrice ?>">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Mô tả:</label>
                <div class="col-sm-10">
                  <textarea class="form-control" name="productDesc" id="summernote"
                    rows="3"><?php echo $productDesc ?></textarea>
                </div>
              </div>
              <div class="form-group row">
                <label for="mainImg" class="col-sm-2 col-form-label">Ảnh đại diện :</label>
                <div class="col-sm-10">
                  <input type="hidden" name="oldImgmain" value="<?php echo $productImage_main ?>">
                  <input type="file" name="mainImg" id="mainImg">
                  <br>
                  <?php if (!empty($productImage_main)) { ?>
                  <div id="gallery">
                    <img src="/<?php echo BASE_URL ?>/public/images/<?php echo basename($productImage_main);?>" alt="">
                  </div>
                  <?php }?>

                </div>
              </div>
              <div class="form-group row">
                <label for="imgOther" class="col-sm-2 col-form-label">Ảnh khác:</label>
                <div class="col-sm-10">
                  <input type="hidden" name="oldImgOther" value="<?php echo $productImage_other?>">
                  <input type="file" name="imgOther[]" id="imgOther" multiple>
                  <br>
                  <?php if (!empty($productImage_other)) {
                      
                       foreach ($arrImg as  $Imgvalue) { ?>
                  <div id="gallery">
                    <img src="/<?php echo BASE_URL?>/public/images/<?php echo $Imgvalue?>" alt="">
                  </div>
                  <?php  } ?>
                  <?php  }?>

                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-2 col-form-label">Loại sản phẩm:</label>
                <div class="col-sm-10">
                  <select class="form-control" name="productType">
                    <option>-- Chọn loại sản phẩm --</option>
                    <option value="1" <?php if ($productType == 1) {
    echo "selected";
}?>>Nổi bật</option>
                    <option value="0" <?php if ($productType == 0) {
    echo "selected";
}?>>Không nổi bật</option>

                  </select>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-5"></div>
                <div class="col-md-7"> <a href="/<?php echo BASE_URL ?>/admin/admmanage.php"
                    class="btn btn-secondary">Cancel</a>
                  <button type="submit" class="btn btn-success">Submit</button>
                </div>
              </div>

            </form>
          </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
    </div>
    <strong>Copyright Võ Minh Tiến <a href="https://www.facebook.com/Kunboss18">Admin Võ Minh Tiến</a>.</strong> All
    rights
    reserved.
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
  </div>
  <!-- ./wrapper -->

  <!-- jQuery -->
  <script src="/<?php echo BASE_URL ?>/admin/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="/<?php echo BASE_URL ?>/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="/<?php echo BASE_URL ?>/admin/dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="/<?php echo BASE_URL ?>/admin/dist/js/demo.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
    integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
    crossorigin="anonymous"></script>
  <!-- include libraries(jQuery, bootstrap) -->
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.css" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-lite.js"></script>
  <script>
    $('#summernote').summernote({
      height: 250
    });
  </script>


</body>

</html>