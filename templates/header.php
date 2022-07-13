<!DOCTYPE html>
<html lang="id">
<?php
$uri = $_SERVER['REQUEST_URI'];
$is_uri = explode('/', $uri);
// print_r($is_uri[1]);
?>

<head>
  <title>Radius Servers</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="assets/js/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link href="assets/css/sb-admin-2.min.css?v=2.1" rel="stylesheet">
  <script src="assets/js/jquery.min.js"></script>
  <style>
    .card {
      border-radius: 5px;
      -webkit-box-shadow: 0 1px 20px 0 rgba(69, 90, 100, 0.08);
      box-shadow: 0 1px 20px 0 rgba(69, 90, 100, 0.08);
      border: none;
      margin-bottom: 30px
    }
  </style>

</head>

<body id="page-top">
  <div id="wrapper">

    <ul class="navbar-nav bg-gradient-purples sidebar sidebar-dark accordion" id="accordionSidebar">

      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <!-- <div class="sidebar-brand-icon">
          <i class="fa fa-cloud"></i>
        </div> -->
        <div class="sidebar-brand-text mx-3">MYRADIUS</div>
      </a>

      <hr class="sidebar-divider my-0">
      <li class="nav-item"> <a class="nav-link" href="/"> <i class="fas fa-fw fa-tachometer-alt"></i> <span>Dashboard</span></a> </li>
      <hr class="sidebar-divider">
      <div class="sidebar-heading">Layanan</div>

      <li class="nav-item <?php
                          if ('add_user.php' == $pages) {
                            echo 'active';
                          } elseif ('list_user.php' == $pages) {
                            echo 'active';
                          } elseif ('add_user_old.php' == $pages) {
                            echo 'active';
                          }
                          ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#userman" aria-expanded="true" aria-controls="collapsePages"> <i class="fas fa-fw fa-cloud"></i> <span>Userman</span> </a>
        <div id="userman" class="collapse <?php
                                          if ('add_user.php' == $pages) {
                                            echo 'show';
                                          } elseif ('list_user.php' == $pages) {
                                            echo 'show';
                                          }
                                          ?>" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">

            <a class="collapse-item <?php
                                    if ('add_user.php' == $pages) {
                                      echo 'active';
                                    }
                                    ?>" href="/add_user.php"><i class="fas fa-fw fa-plus fa-sm"></i> Add Users</a>
            <a class="collapse-item <?php
                                    if ('list_user.php' == $pages) {
                                      echo 'active';
                                    }
                                    ?>" href="/list_user.php"><i class="fas fa-fw fa-list fa-sm"></i> List Users</a>

          </div>
        </div>
      </li>




      <hr class="sidebar-divider d-none d-md-block">
      <div class="text-center d-none d-md-inline"> <button class="rounded-circle border-0" id="sidebarToggle"></button> </div>
    </ul>

    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">

        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3"> <i class="fa fa-bars"></i>
          </button>
          <ul class="navbar-nav ml-auto">
            <div class="topbar-divider d-none d-sm-block"></div>
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span class="mr-2 d-none d-lg-inline text-gray-600 small">Niammuddin MZ</span>
                <img class="img-profile rounded-circle" src="https://avatars.dicebear.com/v2/avataaars/1493488117.svg?options[mood][]=happy">
              </a>
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#"> <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i> Account Settings</a>
                <div class="dropdown-divider"></div>
                <!-- <a class="dropdown-item" href="" data-toggle="modal" data-target="#logoutModal"> <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Logout</a> -->
                <a class="dropdown-item" href="/auth/logout.php"> <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i> Logout</a>
              </div>
            </li>
          </ul>
        </nav>