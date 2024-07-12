<?php
session_start();
error_reporting(0);
include('../includes/db_connection.php');

if (empty($_SESSION['admin_login'])) {
    header('location: login.php');
    exit(); // Add exit to stop further execution
}
$page_title = "Manage Employee";
$breadcrumb = "Manage Employee";

//Inactive  Employee    
if (isset($_GET['inid'])) {
    $id = $_GET['inid'];
    $status = 0;
    $sql = "UPDATE employees set Status=:status  WHERE id=:id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':id', $id, PDO::PARAM_STR);
    $query->bindParam(':status', $status, PDO::PARAM_STR);
    $query->execute();
    header('location:employee.php');
}

//Activated Employee
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $status = 1;
    $sql = "UPDATE employees set Status=:status  WHERE id=:id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':id', $id, PDO::PARAM_STR);
    $query->bindParam(':status', $status, PDO::PARAM_STR);
    $query->execute();
    header('location:employee.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Management System</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/themify-icons.css">
    <link rel="stylesheet" href="../assets/css/metisMenu.css">
    <link rel="stylesheet" href="../assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="../assets/css/slicknav.min.css">
    <!-- amchart css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <!-- Start datatable css -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
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
                    $page = 'employee';
                    include '../admin/layout/sidebar.php';
                    ?>
                </div>
            </div>
        </div>


        <div class="main-content">
            <?php include '../admin/layout/header.php' ?>

            <div class="row">
                <div class="col-12 mt-5">
                    <div class="card">
                        <?php if ($error) { ?><div class="alert alert-danger alert-dismissible fade show"><strong>Info: </strong><?php echo htmlentities($error); ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>

                            </div><?php } else if ($msg) { ?><div class="alert alert-success alert-dismissible fade show"><strong>Info: </strong><?php echo htmlentities($msg); ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div><?php } ?>
                        <div class="card-body">
                            <div class="data-tables datatable-dark">
                                <center><a href="create_employee.php" class="btn btn-sm btn-info">Add Employee</a></center>
                                <table id="dataTable3" class="table table-hover table-striped text-center">
                                    <thead class="text-capitalize">
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Employe ID</th>
                                            <th>Email</th>
                                            <th>Department</th>
                                            <th>Joined On</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        $sql = "SELECT EmpId,FirstName,LastName,Email,Department,Status,RegDate,id from  employees";
                                        $query = $dbh->prepare($sql);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        $cnt = 1;
                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $result) {               ?>
                                                <tr>
                                                    <td> <?php echo htmlentities($cnt); ?></td>

                                                    <td><?php echo htmlentities($result->FirstName); ?>&nbsp;<?php echo htmlentities($result->LastName); ?></td>

                                                    <td><?php echo htmlentities($result->EmpId); ?></td>

                                                    <td><?php echo htmlentities($result->Email); ?></td>

                                                    <td><?php echo htmlentities($result->Department); ?></td>

                                                    <td><?php echo htmlentities($result->RegDate); ?></td>

                                                    <td><?php $stats = $result->Status;
                                                        if ($stats) {
                                                        ?>
                                                            <span class="badge badge-pill badge-success">Active</span>
                                                        <?php } else { ?>
                                                            <span class="badge badge-pill badge-danger">Inactive</span>
                                                        <?php } ?>


                                                    </td>
                                                    <td><a href="update-employee.php?empid=<?php echo htmlentities($result->id); ?>"><i class="fa fa-edit" style="color:green"></i></a>
                                                        <?php if ($result->Status == 1) { ?>
                                                            <a href="employees.php?inid=<?php echo htmlentities($result->id); ?>" onclick="return confirm('Are you sure you want to inactive this employee?');"" > <i class=" fa fa-times-circle" style="color:red" title="Inactive"></i>
                                                            <?php } else { ?>

                                                                <a href="employees.php?id=<?php echo htmlentities($result->id); ?>" onclick="return confirm('Are you sure you want to active this employee?');""><i class=" fa fa-check" style="color:green" title="Active"></i>
                                                                <?php } ?>
                                                    </td>
                                                </tr>
                                        <?php $cnt++;
                                            }
                                        } ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include '../admin/layout/footer.php' ?>
        </div>
    </div>
    <!-- jquery latest version -->
    <script src="../assets/js/vendor/jquery-2.2.4.min.js"></script>
    <!-- bootstrap 4 js -->
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/owl.carousel.min.js"></script>
    <script src="../assets/js/metisMenu.min.js"></script>
    <script src="../assets/js/jquery.slimscroll.min.js"></script>
    <script src="../assets/js/jquery.slicknav.min.js"></script>

    <!-- start chart js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
    <!-- start highcharts js -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <!-- start zingchart js -->
    <script src="https://cdn.zingchart.com/zingchart.min.js"></script>
    <script>
        zingchart.MODULESDIR = "https://cdn.zingchart.com/modules/";
        ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9", "ee6b7db5b51705a13dc2339db3edaf6d"];
    </script>
    <!-- all line chart activation -->
    <script src="assets/js/line-chart.js"></script>
    <!-- all pie chart -->
    <script src="assets/js/pie-chart.js"></script>

    <!-- Start datatable js -->
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>

    <!-- others plugins -->
    <script src="../assets/js/plugins.js"></script>
    <script src="../assets/js/scripts.js"></script>
</body>

</html>