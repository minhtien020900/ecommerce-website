<?php
session_start();
require_once '../config/database.php';
require_once '../config/config.php';
spl_autoload_register(function ($className) {
    require '../app/models/' . $className . '.php';
});
date_default_timezone_set('Asia/Ho_Chi_Minh');
$RoleModel = new RoleModel();
$UserModel = new UserModel();

$roleList = $RoleModel->getRoleList();

$user_name = '';
$user_image = '';
$date_update = (string) date('d-m-Y H:i:s');

if ($_SESSION['isLogin'] == true) {
    $user_name = $_SESSION['user_name'];
    $user_image = $_SESSION['user_image'];
} else {
    header('location:../login.php');
}
if (!empty($_POST['name'])) {
    $user_name = $_POST['name'];
    if (!empty($_FILES['user_image']['name'])) {
        $user_image = '../public/images/' . basename($_FILES['user_image']['name']);
        if (is_uploaded_file($_FILES['user_image']['tmp_name']) && move_uploaded_file($_FILES['user_image']['tmp_name'], $user_image)) {
            if ($UserModel->updateProfile($_SESSION['user_id'], $user_name, basename($user_image), $date_update)) {
                $_SESSION['user_name'] = $user_name;
                $_SESSION['user_image'] = $user_image;
            }
        }

    } else {
        $user_image = $_POST['old_user_image'];
        if ($UserModel->updateProfile($_SESSION['user_id'], $user_name, basename($user_image), $date_update)) {
            $_SESSION['user_name'] = $user_name;
            $_SESSION['user_image'] = $user_image;
        }
    }
}
$isErrorPass = false;
$errorMessPass = '';
if (!empty($_POST['oldpassword']) && !empty($_POST['newpassword'])) {
    if ($_SESSION['user_pass'] == hash('md5',$_POST['oldpassword'])) {
        if ($UserModel->updatePass($_SESSION['user_id'], md5($_POST['newpassword']), $date_update)) {
            $_SESSION['user_pass'] = hash('md5',$_POST['newpassword']);
        }
    } else {
        $isErrorPass = true;
        $errorMessPass = 'Mật khẩu không chính xác';
    }
}

// if (!empty($_POST['oldpassword'])) {
//     if ($_POST['oldpassword'] != $UserModel->getUserby($id)['user_pass']) {
//         $isErrorPass = true;
//         $errorMessPass = 'Mật khẩu cũ không chính xác!';
//     }
//     else {
//       if ($UserModel->updatePass($id,md5($_POST['newpassword']))) {
//         $isUpdateUser = true;
//         $active = 'success';
//         $notice = 'Cập nhật thành công';
//       }
//     }
// }
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | User Profile</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="/<?php echo BASE_URL ?>/public/css/bootstrap.min.css">
  <link rel="stylesheet" href="/<?php echo BASE_URL ?>/admin/plugins/fontawesome-free/css/all.min.css">

  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/<?php echo BASE_URL ?>/admin/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <style>

    #error {
     color: red;
     margin-top:10px;
    }

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

  <script>
    $(document).ready(function () {

    });
    function validateForm() {
      if ($('#form-update-profile')[0].checkValidity() === false) {
        event.preventDefault(); //Chặn không cho gửi form đi
        event.stopPropagation(); //Ngưng các sự kiện được kế thừa
      }
      $('#form-update-profile').addClass('was-validated'); //addClass(): thêm một class vào một tag
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
      var passconfirm = document.getElementById("passwordconfirm").value;
      if (pass == passconfirm) {
        $('#passwordconfirm')[0].setCustomValidity('');
        return true;
      }
      else {
        $('#passwordconfirm')[0].setCustomValidity('Mật khẩu xác nhận sai');
        return false;
      }
    }
  </script>
</head>

<body class="hold-transition sidebar-mini">
  <div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="<?php echo BASE_URL ?>/admin/admmanage.php" class="nav-link">Home</a>
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
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="/<?php echo BASE_URL ?>/public/images/<?php echo basename($user_image) ?>"
              class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block"><?php echo $user_name ?></a>
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
            <?php if ($_SESSION['user_role'] == 3) {?>
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
            <li class="nav-item has-treeview menu-open">
              <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-user"></i>
                <p>
                  Tài khoản
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="/<?php echo BASE_URL ?>/admin/profile.php" class="nav-link active">
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
              <h1>Profile</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/<?php echo BASE_URL ?>/admin/admmanage.php">Home</a></li>
                <li class="breadcrumb-item active">User Profile</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="card">
            <div class="card-header p-2">
              <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Thông tin</a></li>
                <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Cập nhật thông tin</a></li>
                <li class="nav-item"><a class="nav-link" href="#changepassword" data-toggle="tab">Đổi mật khẩu</a></li>
              </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
              <div class="tab-content">
                <div class="active tab-pane" id="activity">
                  <div class="card-body box-profile">
                    <div class="row">
                      <div class="col-md-5">
                        <div class="text-center">
                          <img class="profile-user-img img-fluid img-circle"
                            src="/<?php echo BASE_URL ?>/public/images/<?php echo basename($user_image) ?>"
                            alt="User profile picture">
                        </div>
                        <h3 class="profile-username text-center"><?php echo $user_name ?></h3>
                        <br>
                      </div>
                      <div class="col-md-7">
                        <ul class="list-group list-group-unbordered mb-3">
                          <li class="list-group-item">
                            <b><i class="fas fa-file-signature"></i></b> <b
                              class="float-right"><?php echo $user_name ?></b>
                          </li>
                          <li class="list-group-item">
                            <b><i class="fas fa-phone-alt"></i></b> <b
                              class="float-right"><?php echo $_SESSION['user_phone'] ?></b>
                          </li>
                          <li class="list-group-item">
                            <b><i class="fas fa-envelope"></i></b> <b
                              class="float-right"><?php echo $_SESSION['user_email'] ?></b>
                          </li>
                          <li class="list-group-item"><a href="#"></a>
                            <b> <i class="fas fa-calendar-check"></i></b> <b
                              class="float-right"><?php echo $_SESSION['user_date_create'] ?></b>
                          </li>

                        </ul>
                      </div>
                    </div>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="settings">
                  <form class="form-horizontal" action="/<?php echo BASE_URL ?>/admin/profile.php" method="post"
                    id="form-update-profile" novalidate onsubmit="return validateForm();" enctype="multipart/form-data">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group row">
                          <label for="name" class="col-sm-3 col-form-label">Tên</label>
                          <div class="col-sm-9">
                            <input type="text" class="form-control" name="name" id="name" aria-describedby="helpId"
                              value="<?php echo $user_name ?>" placeholder="Nhập tên" required>
                            <div class="invalid-feedback">Tên không được bỏ trống</div>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="email" class="col-sm-3 col-form-label">Email</label>
                          <div class="col-sm-9">
                            <input disabled type="email" class="form-control" name="email" id="email"
                              aria-describedby="helpId" value="<?php echo $_SESSION['user_email'] ?>">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="phone" class="col-sm-3 col-form-label">Điện
                            thoại</label>
                          <div class="col-sm-9">
                            <input disabled type="text" class="form-control" name="phone" id="phone"
                              aria-describedby="helpId" value="<?php echo $_SESSION['user_phone'] ?>">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="role" class="col-sm-3 col-form-label">Phân quyền</label>
                          <div class="col-sm-9">
                            <div class="form-group">
                              <div class="form-group">
                                <input disabled type="text" class="form-control" name="role" id="roloe"
                                  aria-describedby="helpId" value="<?php foreach ($roleList as $value) {
    if ($value['role_id'] == $_SESSION['user_role']) {
        echo $value['role_name'];
    }
}?>">
                              </div>
                            </div>
                          </div>
                        </div>
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

                <div class="tab-pane" id="changepassword">
                  <form method ="post" id="form-changepass" class="form-horizontal" action='/<?php echo BASE_URL ?>/admin/profile.php?action=changepassword' novalidate onsubmit="return validateFormChangepass();">
                    <div class="form-group row">
                      <label for="oldpassword" class="col-sm-3 col-form-label">Mật khẩu cũ</label>
                      <div class="col-sm-9">
                        <input type="password" class="form-control" id="oldpassword" name="oldpassword" aria-describedby="helpId"
                           placeholder="Nhập mật khẩu cũ"  required>
                        <div class="invalid-feedback">Mật khẩu không được để trống</div>
                        <?php if ($isErrorPass == true) {?>
                        <p id="error"><?php echo $errorMessPass ?></p>
                        <?php }?>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="newpassword" class="col-sm-3 col-form-label">Mật khẩu</label>
                      <div class="col-sm-9">
                        <input type="password" class="form-control" id="newpassword" name="newpassword" aria-describedby="helpId"
                          placeholder="Nhập mật khẩu mới" required>
                        <div class="invalid-feedback">Mật khẩu mới không được để trống</div>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="passwordconfirm" class="col-sm-3 col-form-label">Xác nhận mật khẩu</label>
                      <div class="col-sm-9">
                        <input type="password" class="form-control" id="passwordconfirm" name="passwordconfirm" aria-describedby="helpId"
                         placeholder="Xác nhận mật khẩu mới" required>
                        <div class="invalid-feedback">Nhập sai mật khẩu xác nhận</div>
                      </div>
                    </div>
                    <!-- <div class="form-group row"> -->
                      <div class="offset-sm-3 col-sm-9">
                        <button type="submit" class="btn btn-success">Đổi</button>
                      </div>
                    <!-- </div> -->

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
  <script src="/<?php echo BASE_URL ?>/public/js/jquery-3.4.1.min.js"></script>
    <script src="/<?php echo BASE_URL ?>/public/js/bootstrap.min.js"></script>
  <script src="/<?php echo BASE_URL ?>/admin/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="/<?php echo BASE_URL ?>/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="/<?php echo BASE_URL ?>/admin/dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="/<?php echo BASE_URL ?>/admin/dist/js/demo.js"></script>
</body>

</html>