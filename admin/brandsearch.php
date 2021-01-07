<?php
session_start();
require_once '../config/database.php';
require_once '../config/config.php';
spl_autoload_register(function ($className) {
    require '../app/models/' . $className . '.php';
});

$CategoryModel = new CategoryModel();
$BrandModel = new BrandModel();
$pagination = new Pagination();

$notification = '';
$isDelete = false;
$active = '';

$keyword = '';
if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];
    $brandList = $BrandModel->searchBrand($_GET['keyword']);
}


if (isset($_POST['brandId'])) {
    if ($BrandModel->deleleBrand($_POST['brandId'])) {
        $isDelete = true;
        $active = 'success';
        $notification = "Xóa thành công !";
        // echo "<script>window.location.assign('listcategory.php')</script>";
        

    } else {
        $notification = "Xóa không thành công!";
        $active = 'danger';
    }
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | List Brand</title>
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
  <link rel="stylesheet" href="./css/style.css">
  <style>
    .table-bordered thead td,
    .table-bordered thead th {
      text-align: center;
    }

    .table-bordered td,
    .table-bordered th {
      text-align: center;
    }
  </style>

  <script>
    function deleteConfirm() {
      return confirm('Bạn có chắc muốn xóa danh mục này?');
    }
    function reload() {
      //window.location:'listcategory.php';
      location.reload();
    }
  </script>
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
          <a class="nav-link" href="<?php echo BASE_URL ?>/logout.php">
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
              <a href="/<?php echo BASE_URL; ?>/admin/admmanage.php" class="nav-link active">
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
                  <a href="/<?php echo BASE_URL ?>/admin/addcategory.php" class="nav-link">
                    <i class="fas fa-plus-square nav-icon"></i>
                    <p>Thêm danh mục</p>
                  </a>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="/<?php echo BASE_URL ?>/admin/listcategory.php" class="nav-link">
                    <i class="fas fa-list-alt nav-icon"></i>
                    <p>Danh sách danh mục</p>
                  </a>
                </li>
              </ul>
            </li>
            <li>
              <hr>
            </li>
            <li class="nav-item has-treeview menu-open">
              <a href="#" class="nav-link active">
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
                <li class="nav-item active">
                  <a href="/<?php echo BASE_URL ?>/admin/listbrand.php" class="nav-link active">
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
              <h1>Danh sách thương hiệu</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/<?php echo BASE_URL ?>/admin/admmanage.php">Home</a></li>
                <li class="breadcrumb-item active">List Brand</li>
              </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8"></div>
            <div class="col-md-4">
              <div class="search-box">      
                <form class="search-form" action="/<?php echo BASE_URL?>/admin/brandsearch.php" method="get">
                  <input class="form-control" placeholder="Nhập tên thương hiệu cần tìm" type="text" name="keyword">
                  <button class="btn btn-link search-btn"><i class="fa fa-search" aria-hidden="true"></i></button>
                </form>
              </div>
            </div>
          </div>
          </div>
        <!-- /.container-fluid -->
      </section>
      <!-- Main content -->

      <section class="content">
        <div class="card-body">
          <div class="form-group">
            <?php
if ($isDelete == true) {
  echo  "<div class ='alert alert-" . $active . "' role='alert'>" . $notification .
  '<a href='.'listcategory.php'.'> Reload</a>'.'<br><small>Nếu thấy lỗi hãy reload lại</small>'
  ."</div>";
} else {
    echo "<div class ='alert alert-" . $active . "' role='alert'>" . $notification .
        "</div>";
}?>
          </div>
        </div>
        <table class="table table-bordered table-striped table-hover ">
          <thead class="">
            <tr class="table-success">
              <th scope="col">Brand ID</th>
              <th scope="col">Brand Name</th>
              <th scope="col">Logo</th>
              <th scope="col" colspan="2">Acction</th>
            </tr>
          </thead>
          <tbody>
            <?php
foreach ($brandList as $brandValue) {
    ?>
            <tr>
              <th scope="row"><?php echo $brandValue['brand_id']; ?></th>
              <td>
              <?php 
                 echo $brandValue['brand_name'];
              ?>
              </td>
              <td>
                <img style="width: 100px; height:auto"
                  src="/<?php echo BASE_URL ?>/public/images/<?php echo $brandValue['brand_image']?>" alt=""
                  class="img-fluid"></td>
              <td><a href="/<?php echo BASE_URL ?>/admin/addbrand?id=<?php echo $brandValue['brand_id'] ?>"><i
                    class="fas fa-edit"></i></a></td>              <td>
                <form action="/<?php echo BASE_URL ?>/admin/listbrand.php" method="post"
                  onsubmit="return deleteConfirm()">
                  <input type="hidden" name="brandId" value="<?php echo $brandValue['brand_id'] ?>">
                  <button type="submit"><i class="fas fa-times"></i></button>
                </form>
              </td>
              
            </tr>
            <?php }?>
          </tbody>
        </table>
        <?php
// echo $pagination->createPageLinks('listbrand.php', $totalRow, $perPage, $page);
?>
    </div>
  </div>
  <!-- /.card-body -->

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