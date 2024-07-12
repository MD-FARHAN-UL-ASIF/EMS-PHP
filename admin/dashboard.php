<?php
session_start();
error_reporting(0);
include('../includes/db_connection.php');

// Redirect if admin_login session is not set
if (empty($_SESSION['admin_login'])) {
    header('location: login.php');
    exit(); // Add exit to stop further execution
}
$page_title = "Admin's Dashboard";
$breadcrumb = "Dashboard";
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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const gradients = [
                "linear-gradient(135deg, #7dd5fa, #baf1e4)",
                "linear-gradient(135deg, #f093fb, #f5576c)",
                "linear-gradient(135deg, #5ee7df, #b490ca)",
                "linear-gradient(135deg, #f9d423, #ff4e50)",
                "linear-gradient(135deg, #1e3c72, #2a5298)"
            ];

            const cards = document.querySelectorAll('.single-report');

            cards.forEach(card => {
                const randomGradient = gradients[Math.floor(Math.random() * gradients.length)];
                card.style.background = randomGradient;
            });
        });
    </script>

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
            <?php include '../admin/layout/header.php' ?>

            <div class="main-content-inner">
                <div class="sales-report-area mt-5 mb-5">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="single-report">
                                <div class="s-report-inner">
                                    <div class="icon"><i class="fa fa-users"></i></div>
                                    <div class="s-report-title">
                                        <h4 class="header-title mb-0">Registered Employees</h4>
                                    </div>
                                    <div>
                                        <h1><?php include 'dashboard/employee_count.php'; ?></h1>
                                        <span>Active Employees</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="single-report">
                                <div class="s-report-inner">
                                    <div class="icon"><i class="fa fa-users"></i></div>
                                    <div class="s-report-title">
                                        <h4 class="header-title mb-0">Registered Employees</h4>
                                    </div>
                                    <div>
                                        <h1><?php include 'dashboard/employee_count.php'; ?></h1>
                                        <span>Active Employees</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

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