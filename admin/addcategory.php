<?php
session_start();
require_once '../config/database.php';
require_once '../config/config.php';
spl_autoload_register(function ($className) {
    require '../app/models/' . $className . '.php';
});

$categoryModel = new CategoryModel();
$brandModel  = new BrandModel();
$brandList = $brandModel->getBrandList();

$catMaxId = 0;
$brandId = array();
$brandName='';
$catName = '';
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
    $catItem = $categoryModel->getCategoryById($id);
    $catName = $catItem['category_name'];
    $brandByCat = $categoryModel->getBrandByCat($id);
    $brandId = explode('/',$brandByCat['brand_id']);
    $isUpdate = true;
}

if (!empty($_POST['catName'])&&!empty($_POST['brandName'])) {
    $catName = $_POST['catName'];
     $brandId=array();
          $brandName='';
          foreach ($_POST['brandName'] as  $value) {
            $str = $value.'/';
            $brandName .=$str;   
            $brandId[] = $value;         
          }
          
    // Update Category
    if (isset($_GET['id'])) {
         
        if ($categoryModel->updateCategory($catName, $id)) {
            $notification = "Cập nhật danh mục sản phẩm thành công !";
            $active = "success";           
            $categoryModel->updateCatBrand($id,rtrim($brandName,'/'));
        } else {
            $notification = "Cập nhật danh mục sản phẩm thất bại!";
            $active = "danger";
        }
    }
    // Add category
    else {
        if ($categoryModel->addCategory($catName)) {
              $catMaxId=$categoryModel->getMaxId();
              $categoryModel->addCatBrand($catMaxId['MAX(category_id)'],rtrim($brandName,'/'));            
              $notification = "Thêm danh mục sản phẩm thành công!";
              $isAddCa = true;
              $active = "success";
      }
        if ( $isAddCa == false) {
            $notification = "Thêm danh mục sản phẩm thất bại!";
            $active = "danger";
        }
    }

}

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Project Edit</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/<?php echo BASE_URL ?>/admin/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="/<?php echo BASE_URL ?>/admin/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
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
              <!-- <ul class="nav nav-treeview">

            </ul> -->
            </li>
            <li>
              <hr>
            </li>
            <li class="nav-item has-treeview menu-open">
              <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-tasks"></i>
                <p>
                  Danh mục sản phẩm
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="/<?php echo BASE_URL ?>/admin/addcategory.php" <?php if ($isUpdate == true) {
    echo "class='nav-link'";
} else {
    echo "class='nav-link active'";
}?>>
                    <i class="fas fa-plus-square nav-icon"></i>
                    <p>Thêm danh mục</p>
                  </a>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="/<?php echo BASE_URL ?>/admin/listcategory.php" <?php if ($isUpdate == true) {
    echo "class='nav-link active'";
} else {
    echo "class='nav-link'";
}?>>
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
                  <a href="/<?php echo BASE_URL ?>/admin/addbrand.php" class="nav-link">
                    <i class="fas fa-plus-square nav-icon"></i>
                    <p>Thêm thương hiệu</p>
                  </a>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="/<?php echo BASE_URL ?>/admin/listbrand.php" class="nav-link">
                    <i class="fas fa-th-list nav-icon"></i>
                    <p>Danh sách thương hiệu</p>
                  </a>
                </li>
              </ul>
            </li>
            <li>
              <hr>
            </li>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-edit"></i>
                <p>
                  Quản lý sản phẩm
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="/<?php echo BASE_URL ?>/admin/addproduct.php" class="nav-link">
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
                     echo "Cập nhật danh mục sản phẩm";
                    } 
                    else {
                  echo "Thêm danh mục sản phẩm";
                          }?></h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/<?php echo BASE_URL ?>/admin/admmanage.php">Home</a></li>
                <li class="breadcrumb-item active"><?php if ($isUpdate == true) {
    echo "Cập nhật danh mục sản phẩm";
} else {
    echo "Thêm danh mục sản phẩm";
}
?></li>
              </ol>
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->
      </section>
      <?php
if ($isAddCa == true) {
    echo "<div class='container-fluid'>" . "<div class ='alert alert-" . $active . "' role='alert'>" . $notification .
        "</div></div>";
} else {
    echo "<div class='container-fluid'>" . "<div class ='alert alert-" . $active . "' role='alert'>" . $notification .
        "</div></div>";
}
?>

      <!-- Main content -->

      <section class="content">
        <div class="card card-primary">
          <div class="card-body">
            <div class="form-group">
              <form action="/<?php echo BASE_URL ?>/admin/addcategory.php<?php echo $urlId ?>" method="post">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Tên danh mục:</label>
                  <div class="col-sm-9">
                    <input type="text" name="catName" id="catName" class="form-control"
                      placeholder="Nhập tên danh mục..." value="<?php echo $catName ?>">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Gồm các thương hiệu:</label>
                  <div class="col-sm-9">
                    <input disabled type="text" name="" id="catName" class="form-control" placeholder="Chọn thương hiệu"
                      value="<?php foreach ($brandId as  $value) {
                       $x = $brandModel ->getBrandtById($value);
                       $y = '- '.$x['brand_name'].' -';
                       $result = rtrim($y,'-');
                       echo $result;
                      }?>">
                    <select class="form-control" name="brandName[]" id="brandName" multiple>
                      <?php foreach ($brandList as $brandValue) {?>
                      <option value="<?php echo $brandValue['brand_id'] ?>" <?php foreach ($brandId as $valueId) {
                        if ($brandValue['brand_id']==$valueId) {
                          echo "selected";
                        }
                        # code...
                      }?>><?php echo $brandValue['brand_name'] ?></option>
                      <?php }?>
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

</body>

</html>