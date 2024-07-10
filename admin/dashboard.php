<?php
session_start();
error_reporting(0);
include('../includes/db_connection.php');

// Redirect if admin_login session is not set
if (empty($_SESSION['admin_login'])) {
    header('location: index.php');
    exit(); // Add exit to stop further execution
}

// Retrieve the full name from the database
$query = "SELECT FullName FROM admin WHERE UserName = '" . $_SESSION['admin_login'] . "'";
$result = $dbh->query($query);
$row = $result->fetch(PDO::FETCH_ASSOC);
$full_name = $row['FullName'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>ADMIN DASHBOARD - EMS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="../assets/images/icon/favicon.ico">
    <!-- CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/themify-icons.css">
    <link rel="stylesheet" href="../assets/css/metisMenu.css">
    <link rel="stylesheet" href="../assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="../assets/css/slicknav.min.css">
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all">
    <link rel="stylesheet" href="../assets/css/typography.css">
    <link rel="stylesheet" href="../assets/css/default-css.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/responsive.css">
    <!-- Modernizr JS -->
    <script src="../assets/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body>
    <div id="preloader">
        <div class="loader"></div>
    </div>

    <div class="page-container">
        <div class="sidebar-menu">
            <div class="sidebar-header">
                <div class="logo">
                    <a href="dashboard.php"><img src="../assets/images/icon/ems_logo.jpeg" alt="logo"></a>
                </div>
            </div>
            <div class="main-menu">
                <div class="menu-inner">
                    <?php
                    $page = 'dashboard';
                    include '../admin/layout/sidebar.php';
                    ?>
                </div>
            </div>
        </div>

        <div class="main-content">
            <div class="header-area">
                <div class="row align-items-center">
                    <div class="col-md-6 col-sm-8 clearfix">
                        <div class="nav-btn pull-left">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-4 clearfix">
                        <ul class="notification-area pull-right">
                            <li id="full-view"><i class="ti-fullscreen"></i></li>
                            <li id="full-view-exit"><i class="ti-zoom-out"></i></li>
                            <?php include '../includes/admin-notification.php' ?>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- page title area start -->
            <div class="page-title-area">
  <div class="row align-items-center">
    <div class="col-sm-6">
      <div class="breadcrumbs-area clearfix">
        <h4 class="page-title pull-left">Dashboard</h4>
        <ul class="breadcrumbs pull-left">
          <li><a href="dashboard.php">Home</a></li>
          <li><span>Admin's Dashboard</span></li>
        </ul>
      </div>
    </div>
    <div class="col-sm-6 clearfix">
      <div class="user-profile pull-right">
        <img class="avatar user-thumb" src="../assets/images/admin.png" alt="avatar">
        <h4 class="user-name dropdown-toggle" data-toggle="dropdown">
          <?php echo htmlspecialchars($full_name); ?> <i class="fa fa-angle-down"></i>
        </h4>
        <div class="dropdown-menu">
          <a class="dropdown-item" href="logout.php">Log Out</a>
        </div>
      </div>
    </div>
  </div>
</div>

            <div class="main-content-inner">
                <div class="sales-report-area mt-5 mb-5">

                </div>
            </div>
            <?php include '../admin/layout/footer.php' ?>
        </div>

        <!-- JavaScript -->
        <script src="../assets/js/vendor/jquery-2.2.4.min.js"></script>
        <script src="../assets/js/popper.min.js"></script>
        <script src="../assets/js/bootstrap.min.js"></script>
        <script src="../assets/js/owl.carousel.min.js"></script>
        <script src="../assets/js/metisMenu.min.js"></script>
        <script src="../assets/js/jquery.slimscroll.min.js"></script>
        <script src="../assets/js/jquery.slicknav.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://cdn.zingchart.com/zingchart.min.js"></script>
        <script>
            zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
            ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9", "ee6b7db5b51705a13dc2339db3edaf6d"];
        </script>
        <script src="../assets/js/line-chart.js"></script>
        <script src="../assets/js/pie-chart.js"></script>
        <script src="../assets/js/plugins.js"></script>
        <script src="../assets/js/scripts.js"></script>
</body>

</html>