<?php
session_start();
error_reporting(0);
include('../includes/db_connection.php');

if (empty($_SESSION['admin_login'])) {
    header('location: login.php');
    exit();
}

$page_title = "Add Department";
$breadcrumb = "Add Department";

if (isset($_POST['add_department'])) {
    $deptname = $_POST['name'];
    $deptshortname = $_POST['shortname'];
    $deptcode = $_POST['code'];

    $sql = "INSERT INTO departments(Name, Code, ShortName) VALUES (:name, :code, :shortname)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':name', $deptname, PDO::PARAM_STR);
    $query->bindParam(':code', $deptcode, PDO::PARAM_STR);
    $query->bindParam(':shortname', $deptshortname, PDO::PARAM_STR);

    if ($query->execute()) {
        $_SESSION['msg'] = "Department Added Successfully";
    } else {
        $_SESSION['error'] = "Something went wrong. Please try again";
    }

    header('location: create_department.php');
    exit();
}
?>
<!doctype html>
<html class="no-js" lang="en">
<head>
<meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Admin Dashboard - EMS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="../assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/themify-icons.css">
    <link rel="stylesheet" href="../assets/css/metisMenu.css">
    <link rel="stylesheet" href="../assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="../assets/css/slicknav.min.css">
    <!-- amchart css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <!-- others css -->
    <link rel="stylesheet" href="../assets/css/typography.css">
    <link rel="stylesheet" href="../assets/css/default-css.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/responsive.css">
    <!-- modernizr css -->
    <script src="../assets/js/vendor/modernizr-2.8.3.min.js"></script>
</head>
<body>
    <!-- preloader area start -->
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
                    $page = 'department';
                    include '../admin/layout/sidebar.php';
                    ?>
                </div>
            </div>
        </div>

        <div class="main-content">
            <?php include '../admin/layout/header.php' ?>
            <div class="main-content-inner">
                <!-- row area start -->
                <div class="row justify-content-center align-items-center">
                    <div class="col-lg-6 col-ml-12">
                        <div class="row justify-content-center align-items-center">
                            <!-- Input form start -->
                            <div class="col-12 mt-5">
                                <?php if (isset($_SESSION['error'])) { ?>
                                    <div class="alert alert-danger alert-dismissible fade show">
                                        <strong>Info: </strong><?php echo htmlentities($_SESSION['error']); ?>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <?php unset($_SESSION['error']); ?>
                                <?php } else if (isset($_SESSION['msg'])) { ?>
                                    <div class="alert alert-success alert-dismissible fade show">
                                        <strong>Info: </strong><?php echo htmlentities($_SESSION['msg']); ?>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <?php unset($_SESSION['msg']); ?>
                                <?php } ?>
                                <div class="card">
                                    <form method="POST">
                                        <div class="card-body">
                                            <p class="text-muted font-14 mb-4">Fill up the form to add new department</p>

                                            <div class="form-group">
                                                <label for="example-text-input" class="col-form-label">Department Name</label>
                                                <input class="form-control" name="name" type="text" required id="example-text-input">
                                            </div>

                                            <div class="form-group">
                                                <label for="example-text-input" class="col-form-label">Shortform</label>
                                                <input class="form-control" name="shortname" type="text" autocomplete="off" required id="example-text-input">
                                            </div>

                                            <div class="form-group">
                                                <label for="example-email-input" class="col-form-label">Code</label>
                                                <input class="form-control" name="code" type="text" autocomplete="off" required id="example-email-input">
                                            </div>

                                            <button class="btn btn-primary" name="add_department" id="add_department" type="submit">ADD</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- Input form end -->
                        </div>
                    </div>
                </div>
                <!-- row area end -->
            </div>
        </div>
        <!-- footer area start-->
        <?php include '../admin/layout/footer.php' ?>
        <!-- footer area end-->
    </div>
    <script src="../assets/js/vendor/jquery-2.2.4.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/owl.carousel.min.js"></script>
    <script src="../assets/js/metisMenu.min.js"></script>
    <script src="../assets/js/jquery.slimscroll.min.js"></script>
    <script src="../assets/js/jquery.slicknav.min.js"></script>
    <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
    <script src="https://www.amcharts.com/lib/3/ammap.js"></script>
    <script src="https://www.amcharts.com/lib/3/maps/js/worldLow.js"></script>
    <script src="https://www.amcharts.com/lib/3/serial.js"></script>
    <script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
    <script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
    <script src="../assets/js/line-chart.js"></script>
    <script src="../assets/js/pie-chart.js"></script>
    <script src="../assets/js/plugins.js"></script>
    <script src="../assets/js/scripts.js"></script>
</body>
</html>
