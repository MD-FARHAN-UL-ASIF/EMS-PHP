<?php
session_start();
error_reporting(0);
include('../includes/db_connection.php');

if (empty($_SESSION['admin_login'])) {
    header('location: login.php');
    exit(); // Add exit to stop further execution
}
$page_title = "Assigned Projects";
$breadcrumb = "Project Management";
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
    <!-- others css -->
    <link rel="stylesheet" href="../assets/css/typography.css">
    <link rel="stylesheet" href="../assets/css/default-css.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/responsive.css">
    <!-- modernizr css -->
    <script src="../assets/js/vendor/modernizr-2.8.3.min.js"></script>
    <style>
        .status-not-submitted {
            color: red;
        }
        .status-submitted {
            color: green;
        }
    </style>
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
            <?php include '../admin/layout/header.php'; ?>

            <div class="main-content-inner">
                <!-- row area start -->
                <div class="row">
                    <!-- assigned projects area start -->
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <div class="single-table">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped table-bordered progress-table text-center">
                                            <thead class="text-uppercase">
                                                <tr>
                                                    <th>S.N</th>
                                                    <th>Assigned To</th>
                                                    <th>Project Title</th>
                                                    <th>Description</th>
                                                    <th>Starting Date</th>
                                                    <th>Closing Date</th>
                                                    <th>Documents</th>
                                                    <th>Status</th>
                                                    <th>Submission Date</th>
                                                    <th>Submitted Documents</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql = "SELECT project.id, project.title, project.description, project.starting_date, project.closing_date, project.documents,
                                                        project.status, project.submission_date, project.submitted_documents, employees.FirstName, employees.LastName 
                                                        FROM project 
                                                        JOIN employees ON project.empId = employees.id 
                                                        ORDER BY project.id DESC";
                                                $query = $dbh->prepare($sql);
                                                $query->execute();
                                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                $cnt = 1;
                                                if ($query->rowCount() > 0) {
                                                    foreach ($results as $result) {
                                                        ?>
                                                        <tr>
                                                            <td><b><?php echo htmlentities($cnt); ?></b></td>
                                                            <td><?php echo htmlentities($result->FirstName . " " . $result->LastName); ?></td>
                                                            <td><?php echo htmlentities($result->title); ?></td>
                                                            <td><?php echo htmlentities($result->description); ?></td>
                                                            <td><?php echo htmlentities($result->starting_date); ?></td>
                                                            <td><?php echo htmlentities($result->closing_date); ?></td>
                                                            <td>
    <?php  {
        $document_path = '../' . $result->documents; // Adjust path as needed
        echo '<a href="' . $document_path . '" target="_blank">View Document</a>';
    } ?>
</td>

                                                            <td class="<?php echo ($result->status == 0) ? 'status-not-submitted' : 'status-submitted'; ?>">
                                                                <?php echo ($result->status == 0) ? 'Not Submitted' : 'Submitted'; ?>
                                                            </td>
                                                            <td>
    <?php echo $result->submission_date !== null ? htmlentities($result->submission_date) : 'Not submitted'; ?>
</td>

<td>
    <?php
    if ($result->status == 1 && $result->submitted_documents !== null) {
        $submitted_document_path = '../' . $result->submitted_documents; // Adjust path as needed
        echo '<a href="' . $submitted_document_path . '" target="_blank">View Submitted Document</a>';
    } else{
        echo 'Document Not Submitted';
    }
    ?>
</td>

                                                        </tr>
                                                <?php
                                                        $cnt++;
                                                    }
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- assigned projects area end -->
                </div>
                <!-- row area end -->
            </div>
            <?php include '../admin/layout/footer.php'; ?>
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
    <script src="../assets/js/line-chart.js"></script>
    <!-- all pie chart -->
    <script src="../assets/js/pie-chart.js"></script>

    <!-- Start datatable js -->
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>

    <!-- others plugins -->
    <script src="../assets/js/plugins.js"></script>
    <script src="../assets/js/scripts.js"></script>
</body>

</html>
