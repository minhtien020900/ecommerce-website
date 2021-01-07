<?php
session_start();
require_once '../config/database.php';
require_once '../config/config.php';
spl_autoload_register(function ($className) {
    require '../app/models/' . $className . '.php';
});

$UserModel = new UserModel();
$userList = $UserModel->getAllUser();

$RoleModel = new RoleModel();
$roleList = $RoleModel->getRoleList();

$StatusModel = new StatusModel();
$statusList = $StatusModel->getStatusList();

$user_name = '';
$user_email = '';
$user_email_id = '';
$user_phone_id = '';
$user_phone = '';
$user_pass = '';
$user_image = '';
$user_role = 0;
$user_date_create = '';
$user_last_update = '';
$user_status = 1;
$urlId = '';
$id = '';
date_default_timezone_set('Asia/Ho_Chi_Minh');

$isAddUser = false;
$isUpdateUser = false;
$isErrorMail = false;
$isErrorPhone = false;
$isErrorPass = false;

$errorMessEmail = '';
$errorMessPhone = '';
$errorMessPass = '';
$notice = '';
$active = '';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $urlId = "?id=$id";
    $userItem = $UserModel->getUserby($id);
    $user_name = $userItem['user_name'];
    $user_email = $userItem['user_email'];
    $user_email_id = $userItem['user_email'];
    $user_phone = $userItem['user_phone'];
    $user_phone_id = $userItem['user_phone'];
    $user_pass = $userItem['user_pass'];
    $user_image = $userItem['user_image'];
    $user_role = $userItem['user_role'];
    $user_date_create = $userItem['user_date_create'];
    $user_last_update = $userItem['user_last_update'];
    $user_status = $userItem['user_status'];
    $isUpdateUser = true;
    if (isset($_GET['action'])) {
        if (!empty($_POST['newpassword'])) {
            $user_last_update = (string) date('d-m-Y H:i:s');
            if ($UserModel->updatePass($id, md5($_POST['newpassword']), $user_last_update)) {
                $isUpdateUser = true;
                $notice = 'Cập nhật thành công';
                $active = 'success';
            } else {
                $isUpdateUser = false;
                $notice = 'Cập nhật thất bại';
                $active = 'danger';
            }
        }
    } else {
        if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['phone']) && !empty($_POST['role']) && !empty($_POST['status'])) {
            $user_name = $_POST['name'];
            $user_email = $_POST['email'];
            $user_phone = $_POST['phone'];
            $user_role = $_POST['role'];
            $user_status = $_POST['status'];
            for ($i = 0; $i < count($userList);) {
                if ($userList[$i]['user_email'] == $user_email_id && $userList[$i]['user_phone'] == $user_phone_id) {
                    $i++;
                } else {
                    if ($userList[$i]['user_email'] == $user_email) {
                        $isErrorMail = true;
                        $errorMessEmail = 'Email đã được sử dụng';
                        if ($isUpdateUser == true) {
                            $active = 'danger';
                            $notice = 'Cập nhật thất bại';
                        } else {
                            $active = 'danger';
                            $notice = 'Thêm thất bại';
                        }

                    }
                    if ($userList[$i]['user_phone'] == $user_phone) {
                        $isErrorPhone = true;
                        $errorMessPhone = 'Số điện thoại đã được sử dụng';
                        if ($isUpdateUser == true) {
                            $active = 'danger';
                            $notice = 'Cập nhật thất bại';
                        } else {
                            $active = 'danger';
                            $notice = 'Thêm thất bại';
                        }
                    }
                    $i++;
                }

            }
            if ($errorMessEmail == false && $errorMessPhone == false) {
                $user_last_update = (string) date('d-m-Y H:i:s');
                if (!empty($_FILES['user_image']['name'])) {
                    $user_image = '../public/images/' . basename($_FILES['user_image']['name']);
                    if (is_uploaded_file($_FILES['user_image']['tmp_name']) && move_uploaded_file($_FILES['user_image']['tmp_name'], $user_image)) {
                        if ($UserModel->updateUser($id, $user_name, $user_email, $user_phone, basename($user_image), $user_role, $user_date_create, $user_last_update, $user_status)) {
                            $isUpdateUser = true;
                            $notice = 'Cập nhật thành công';
                            $active = 'success';
                        } else {
                            $notice = 'Cập nhật thất bại';
                            $active = 'danger';
                        }
                    }
                } else {
                    $user_image = $_POST['old_user_image'];
                    if ($UserModel->updateUser($id, $user_name, $user_email, $user_phone, basename($user_image), $user_role, $user_date_create, $user_last_update, $user_status)) {
                        $isUpdateUser = true;
                        $notice = 'Cập nhật thành công';
                        $active = 'success';
                    } else {
                        $notice = 'Cập nhật thất bại';
                        $active = 'danger';
                    }
                }
            }
        }
    }
} else {
    if (!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['phone']) && !empty($_POST['password']) && !empty($_POST['passwordconfirm']) && !empty($_POST['role'])) {
        $user_name = $_POST['name'];
        $user_email = $_POST['email'];
        $user_phone = $_POST['phone'];
        $user_pass = md5($_POST['password']);
        $user_role = $_POST['role'];
        if (!empty($_FILES['user_image']['name'])) {
            $user_image = $_FILES['user_image']['name'];
        } else {
            $user_image = $_POST['old_user_image'];
        }

        foreach ($userList as $userValue) {
            if ($userValue['user_email'] == $user_email) {
                $isErrorMail = true;
                $errorMessEmail = 'Email đã được sử dụng';
                if ($isUpdateUser == true) {
                    $active = 'danger';
                    $notice = 'Cập nhật thất bại';
                } else {
                    $active = 'danger';
                    $notice = 'Thêm thất bại';
                }

            }
            if ($userValue['user_phone'] == $user_phone) {
                $isErrorPhone = true;
                $errorMessPhone = 'Số điện thoại đã được sử dụng';
                if ($isUpdateUser == true) {
                    $active = 'danger';
                    $notice = 'Cập nhật thất bại';
                } else {
                    $active = 'danger';
                    $notice = 'Thêm thất bại';
                }
            }
        }
        if ($errorMessEmail == false && $errorMessPhone == false) {
            $user_date_create = (string) date('d-m-Y H:i:s');
            if (!empty($_FILES['user_image']['name'])) {
                $user_image = '../public/images/' . basename($_FILES['user_image']['name']);
                if (is_uploaded_file($_FILES['user_image']['tmp_name']) && move_uploaded_file($_FILES['user_image']['tmp_name'], $user_image)) {
                    if ($UserModel->addUser($user_name, $user_email, $user_phone, $user_pass, basename($user_image), $user_role, $user_date_create, $user_last_update, $user_status)) {
                        $isAddUser = true;
                        $notice = 'Thêm nhân viên thành công';
                        $active = 'success';
                    } else {
                        $notice = 'Thêm nhân viên thất bại';
                        $active = 'danger';
                    }
                }
            } else {
                $user_image = $_POST['old_user_image'];
                if ($UserModel->addUser($user_name, $user_email, $user_phone, $user_pass, basename($user_image), $user_role, $user_date_create, $user_last_update, $user_status)) {
                    $isAddUser = true;
                    $notice = 'Thêm nhân viên thành công';
                    $active = 'success';
                } else {
                    $notice = 'Thêm nhân viên thất bại';
                    $active = 'danger';
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
      margin-left: 16.5px;
    }

    #gallery img {
      max-width: 100%;
      height: 120px;

    }

    .image {
      text-align: center;
      /* padding-right: 23px; */
    }

    .image b {
      text-align: center;
      font-size: 22.5px;
    }

    .inputfile {
      text-align: center;
      padding-left: 28px;
    }

    .error {
      color: red;
      margin:10px;
      margin-bottom: -1px;
    }
  </style>
  <script>
    $(document).ready(function () {

    });
    function validateForm() {
       confirmPass();
      if ($('#form-register')[0].checkValidity() === false) {
        event.preventDefault(); //Chặn không cho gửi form đi
        event.stopPropagation(); //Ngưng các sự kiện được kế thừa
      }
      $('#form-register').addClass('was-validated'); //addClass(): thêm một class vào một tag
    }
    function validateFormUpdate() {
      if ($('#form-register')[0].checkValidity() === false) {
        event.preventDefault(); //Chặn không cho gửi form đi
        event.stopPropagation(); //Ngưng các sự kiện được kế thừa
      }
      $('#form-register').addClass('was-validated'); //addClass(): thêm một class vào một tag
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
      var passconfirm = document.getElementById("checknewpass").value;
      if (pass == passconfirm) {
        $('#checknewpass')[0].setCustomValidity('');
        return true;
      }
      else {
        $('#checknewpass')[0].setCustomValidity('sai');
        return false;
      }
    }
    function confirmPass() {
      var pass = document.getElementById("password").value;
      var passconfirm = document.getElementById("passwordconfirm").value;
      if (pass == passconfirm) {
        $('#passwordconfirm')[0].setCustomValidity('');
        return true;
      }
      else {
        $('#passwordconfirm')[0].setCustomValidity('sai');
        return false;
      }
    }
  </script>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="/subas/admin/admmanage.php" class="nav-link">Home</a>
        </li>
      </ul>

      <!-- SEARCH FORM -->

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item">
          <a class="nav-link" href="/<?php echo BASE_URL?>/logout.php">
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
                  <a href="/<?php echo BASE_URL ?>/admin/adduser_.php" class="nav-link">
                    <i class="fas fa-plus-square nav-icon"></i>
                    <p>Thêm sản phẩm</p>
                  </a>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="/<?php echo BASE_URL ?>/admin/listuser_.php" class="nav-link">
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
            <li class="nav-item has-treeview menu-open">
              <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-users-cog"></i>
                <p>
                  Quản lý nhân viên
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="/<?php echo BASE_URL ?>/admin/addadmin.php" class="nav-link active">
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
              <h1><?php if ($isUpdateUser == true) {
    echo "Cập nhật nhân viên";
} else {
    echo "Thêm nhân viên";
}?></h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/<?php echo BASE_URL ?>/admin/admmanage.php">Home</a></li>
                <li class="breadcrumb-item active"><?php if ($isUpdateUser == true) {
    echo "Update admin";
} else {
    echo "Add admin";
}?></li>
              </ol>
            </div>
          </div>
        </div>
      </section>
      <?php
if ($isAddUser == true) {
    echo "<div class='container-fluid'>" . "<div class ='alert alert-" . $active . "' role='alert'>" . $notice .
        "</div></div>";
} else {
    echo "<div class='container-fluid'>" . "<div class ='alert alert-" . $active . "' role='alert'>" . $notice .
        "</div></div>";
}?>

      <section class="content">
        <div class="container-fluid">
          <div class="card">
            <div class="card-header p-2">
              <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab"><?php if ($isUpdateUser == true) {
    echo "Cập nhật thông tin";
} else {
    echo "Thêm";
}?></a></li>
                <?php if ($isUpdateUser == true) {?>
                <li class="nav-item"><a class="nav-link " href="#changepassword" data-toggle="tab">Đổi mật khẩu</a></li>
                <?php }?>
              </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
              <div class="tab-content">
                <div class="active tab-pane" id="settings">
                  <div class="form-group">
                    <form class="form-horizontal"
                      action="/<?php echo BASE_URL ?>/admin/addadmin.php<?php echo $urlId ?>" method="post"
                      id="form-register" novalidate onsubmit="<?php if ($isUpdateUser == true) {
    echo "return validateFormUpdate();";
} else {
    echo "return validateForm();";
}?>" enctype="multipart/form-data">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">Tên</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" name="name" id="name" aria-describedby="helpId"
                                value="<?php echo $user_name ?>" placeholder="Nhập tên" required>
                              <div class="invalid-feedback">Nhập sai Tên</div>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="email" class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-9">
                              <input type="email" class="form-control" name="email" id="email" aria-describedby="helpId"
                                value="<?php echo $user_email ?>" placeholder="Nhập email" required
                                pattern="^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$">
                              <p class="error"><?php if ($isErrorMail == true) {
    echo $errorMessEmail;
}?></p>
                              <div class="invalid-feedback">Nhập sai email</div>

                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="phone" class="col-sm-3 col-form-label">Điện
                              thoại</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control" name="phone" id="phone" aria-describedby="helpId"
                                value="<?php echo $user_phone ?>" placeholder="Nhập số điện thoại" required pattern="[0-9]{10,11}">
                              <p class="error"><?php if ($isErrorPhone == true) {
    echo $errorMessPhone;
}?></p>
                              <div class="invalid-feedback">Nhập sai số điện thoại</div>
                            </div>
                          </div>
                          <?php if ($isUpdateUser == false) {?>
                          <div class="form-group row">
                            <label for="password" class="col-sm-3 col-form-label">Mật khẩu</label>
                            <div class="col-sm-9">
                              <input type="password" class="form-control" id="password" name="password"
                                aria-describedby="helpId" placeholder="Nhập mật khẩu" required>
                              <div class="invalid-feedback">Nhập sai mật khẩu</div>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label for="passwordConfirm" class="col-sm-3 col-form-label">Xác nhận mật khẩu</label>
                            <div class="col-sm-9">
                              <input type="password" class="form-control" id="passwordconfirm" name="passwordconfirm"
                                aria-describedby="helpId" placeholder="Nhập lại mật khẩu" required>
                              <div class="invalid-feedback">Nhập sai mật khẩu xác nhận</div>
                            </div>
                          </div>
                          <?php }?>
                          <div class="form-group row">
                            <label for="role" class="col-sm-3 col-form-label">Phân quyền</label>
                            <div class="col-sm-9">
                              <div class="form-group">
                                <select class="form-control" name="role" id="">
                                  <option disabled>Chọn quyền</option>
                                  <?php
foreach ($roleList as $Rolevalue) {?>
                                  <option value="<?php echo $Rolevalue['role_id'] ?>" <?php if ($user_role == $Rolevalue['role_id']) {
    echo "selected";
}?>><?php echo $Rolevalue['role_name'] ?></option>

                                  <?php }
?>
                                </select>
                              </div>
                            </div>
                          </div>
                          <?php if ($isUpdateUser == true) {?>
                          <div class="form-group row">
                            <label for="status" class="col-sm-3 col-form-label">Trạng thái</label>
                            <div class="col-sm-9">
                              <div class="form-group">
                                <select class="form-control" name="status" id="status">
                                  <?php foreach ($statusList as $sttValue) {?>
                                  <option value="<?php echo $sttValue['status_id'] ?>" <?php if ($sttValue['status_id'] == $user_status) {
    echo "selected";
}?>><?php echo $sttValue['status_name'] ?></option>
                                  <?php }?>
                                </select>
                              </div>
                              <div class="invalid-feedback">Nhập sai trạng thái</div>
                            </div>
                          </div>
                          <?php }?>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <div class="col-sm-4"></div>
                            <div class="col-sm-4">
                              <div class="image">
                                <h5><b>Ảnh đại diện</b></h5>
                              </div>
                              <?php if (!empty($user_image)) {?>
                              <input type="hidden" name="old_user_image" value="<?php
echo basename($user_image); ?>">
                              <div id="gallery">
                                <img src="/<?php echo BASE_URL ?>/public/images/<?php echo basename($user_image) ?>"
                                  alt="">
                              </div>
                              <?php }?>

                            </div>
                            <div class="col-sm-4"></div>

                          </div>
                          <div class="form-group row">
                            <div class="col-sm-4"></div>
                            <div class="col-sm-4">
                              <input type="file" name="user_image" id="">
                            </div>
                            <div class="col-md-4"></div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-5"></div>
                        <div class="col-md-7"> <a href="/<?php echo BASE_URL ?>/admin/admmanage.php"
                            class="btn btn-secondary">Cancel</a>
                          <button type="submit" class="btn btn-success">Submit</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.tab-pane -->
                <div class=" tab-pane " id="changepassword">
                  <form class="form-horizontal"
                    action="/<?php echo BASE_URL ?>/admin/addadmin<?php echo $urlId . '&action=changepass' ?>"
                    method="post" id="form-changepass" novalidate onsubmit="return validateFormChangepass();">
                    <!-- <div class="form-group row">
                      <label for="oldpassword" class="col-sm-3 col-form-label">Mật khẩu cũ:</label>
                      <div class="col-sm-9">
                        <input type="password" class="form-control" id="oldpassword" name="oldpassword"
                          aria-describedby="helpId" placeholder="Nhập mật khẩu" required>
                        <div class="invalid-feedback">Nhập sai mật khẩu cũ</div>
                        <p class="error"><?php if ($isErrorPass == true) {
    echo $errorMessPass;
}?></p>
                      </div>
                    </div> -->
                    <div class="form-group row">
                      <label for="newpassword" class="col-sm-3 col-form-label">Mật khẩu mới</label>
                      <div class="col-sm-9">
                        <input type="password" class="form-control" id="newpassword" name="newpassword"
                          aria-describedby="helpId" placeholder="Nhập mật khẩu mới" required>
                        <div class="invalid-feedback">Nhập sai mật khẩu mới</div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="checknewpass" class="col-sm-3 col-form-label">Xác nhận mật khẩu mới</label>
                      <div class="col-sm-9">
                        <input type="password" class="form-control" placeholder = "Nhập lại mật khẩu mới" id="checknewpass" name="checknewpass" required>
                        <div class="invalid-feedback">Nhập sai mật khẩu xác nhận</div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <div class="offset-sm-3 col-sm-9">
                        <button type="submit" class="btn btn-danger">Đổi</button>
                      </div>
                    </div>
                  </form>
                </div>
                <!-- /.tab-pane -->
              </div>
              <!-- /.tab-content -->
            </div><!-- /.card-body -->
          </div>
          <!-- /.nav-tabs-custom -->
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>
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
  <!-- jQuery UI 1.11.4 -->
  <script src="/<?php echo BASE_URL ?>/admin/plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="/<?php echo BASE_URL ?>/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- ChartJS -->
  <script src="/<?php echo BASE_URL ?>/admin/plugins/chart.js/Chart.min.js"></script>
  <!-- Sparkline -->
  <script src="/<?php echo BASE_URL ?>/admin/plugins/sparklines/sparkline.js"></script>
  <!-- JQVMap -->
  <script src="/<?php echo BASE_URL ?>/admin/plugins/jqvmap/jquery.vmap.min.js"></script>
  <script src="/<?php echo BASE_URL ?>/admin/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
  <!-- jQuery Knob Chart -->
  <script src="/<?php echo BASE_URL ?>/admin/plugins/jquery-knob/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="/<?php echo BASE_URL ?>/admin/plugins/moment/moment.min.js"></script>
  <script src="/<?php echo BASE_URL ?>/admin/plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script
    src="/<?php echo BASE_URL ?>/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Summernote -->
  <script src="/<?php echo BASE_URL ?>/admin/plugins/summernote/summernote-bs4.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="/<?php echo BASE_URL ?>/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="/<?php echo BASE_URL ?>/admin/dist/js/adminlte.js"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="/<?php echo BASE_URL ?>/admin/dist/js/pages/dashboard.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="/<?php echo BASE_URL ?>/admin/dist/js/demo.js"></script>
</body>

</html>