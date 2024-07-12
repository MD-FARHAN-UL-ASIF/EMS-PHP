<?php
session_start();
error_reporting(0);
include('../includes/db_connection.php');

if (empty($_SESSION['admin_login'])) {
    header('location: login.php');
    exit(); // Add exit to stop further execution
}

$page_title = "Leave Details";
$breadcrumb = "Manage Leave";

$isread = 1;
$did = intval($_GET['leaveid']);  
date_default_timezone_set('Asia/Dhaka');
$admremarkdate = date('Y-m-d G:i:s ', strtotime("now"));

$sql = "UPDATE leaves SET IsRead = :isread WHERE id = :did";
$query = $dbh->prepare($sql);
$query->bindParam(':isread', $isread, PDO::PARAM_STR);
$query->bindParam(':did', $did, PDO::PARAM_STR);
$query->execute();

// Code for action taken on leave
if (isset($_POST['update'])) { 
    $description = $_POST['description'];
    $status = $_POST['status'];   
    $admremarkdate = date('Y-m-d G:i:s ', strtotime("now"));

    $sql = "UPDATE leaves SET AdminRemark = :description, Status = :status, AdminRemarkDate = :admremarkdate WHERE id = :did";
    $query = $dbh->prepare($sql);
    $query->bindParam(':description', $description, PDO::PARAM_STR);
    $query->bindParam(':status', $status, PDO::PARAM_STR);
    $query->bindParam(':admremarkdate', $admremarkdate, PDO::PARAM_STR);
    $query->bindParam(':did', $did, PDO::PARAM_STR);
    $query->execute();
    $msg = "Leave Status updated Successfully";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMS</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/themify-icons.css">
    <link rel="stylesheet" href="../assets/css/metisMenu.css">
    <link rel="stylesheet" href="../assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="../assets/css/slicknav.min.css">
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <link rel="stylesheet" href="../assets/css/typography.css">
    <link rel="stylesheet" href="../assets/css/default-css.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/responsive.css">
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
                    $page = 'department';
                    include '../admin/layout/sidebar.php';
                    ?>
                </div>
            </div>
        </div>

        <div class="main-content">
            <?php include '../admin/layout/header.php'; ?>

            <div class="main-content-inner">
                <div class="row">
                    <div class="col-lg-12 mt-5">
                        <?php if (isset($error)) { ?>
                            <div class="alert alert-danger alert-dismissible fade show">
                                <strong>Info: </strong><?php echo htmlentities($error); ?>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php } elseif (isset($msg)) { ?>
                            <div class="alert alert-success alert-dismissible fade show">
                                <strong>Info: </strong><?php echo htmlentities($msg); ?> 
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php } ?>
                        <div class="card">
                            <div class="card-body">
                                <div class="single-table">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover text-center">
                                            <tbody>
                                                <?php 
                                                $lid = intval($_GET['leaveid']);
                                                $sql = "SELECT leaves.id as lid, employees.FirstName, employees.LastName, employees.EmpId, employees.id, employees.Gender, employees.Phone, employees.Email, leaves.LeaveType, leaves.ToDate, leaves.FromDate, leaves.Description, leaves.PostingDate, leaves.Status, leaves.AdminRemark, leaves.AdminRemarkDate 
                                                        FROM leaves 
                                                        JOIN employees ON leaves.empid = employees.id 
                                                        WHERE leaves.id = :lid";
                                                $query = $dbh->prepare($sql);
                                                $query->bindParam(':lid', $lid, PDO::PARAM_STR);
                                                $query->execute();
                                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                $cnt = 1;
                                                if ($query->rowCount() > 0) {
                                                    foreach ($results as $result) {
                                                ?>
                                                <tr>
                                                    <td><b>Employee ID:</b></td>
                                                    <td colspan="1"><?php echo htmlentities($result->EmpId); ?></td>
                                                    <td><b>Employee Name:</b></td>
                                                    <td colspan="1">
                                                        <a href="update_employee.php?empid=<?php echo htmlentities($result->id); ?>" target="_blank">
                                                            <?php echo htmlentities($result->FirstName . " " . $result->LastName); ?>
                                                        </a>
                                                    </td>
                                                    <td><b>Gender :</b></td>
                                                    <td colspan="1"><?php echo htmlentities($result->Gender); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Employee Email:</b></td>
                                                    <td colspan="1"><?php echo htmlentities($result->Email); ?></td>
                                                    <td><b>Employee Contact:</b></td>
                                                    <td colspan="1"><?php echo htmlentities($result->Phone); ?></td>
                                                    <td><b>Leave Type:</b></td>
                                                    <td colspan="1"><?php echo htmlentities($result->LeaveType); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Leave From:</b></td>
                                                    <td colspan="1"><?php echo htmlentities($result->FromDate); ?></td>
                                                    <td><b>Leave Upto:</b></td>
                                                    <td colspan="1"><?php echo htmlentities($result->ToDate); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Leave Applied:</b></td>
                                                    <td><?php echo htmlentities($result->PostingDate); ?></td>
                                                    <td><b>Status:</b></td>
                                                    <td>
                                                        <?php 
                                                        $stats = $result->Status;
                                                        if ($stats == 1) {
                                                            echo '<span style="color: green">Approved</span>';
                                                        } elseif ($stats == 2) {
                                                            echo '<span style="color: red">Declined</span>';
                                                        } else {
                                                            echo '<span style="color: blue">Pending</span>';
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>Leave Conditions:</b></td>
                                                    <td colspan="5"><?php echo htmlentities($result->Description); ?></td>
                                                </tr>
                                                <tr>
                                                    <td><b>Admin Remark:</b></td>
                                                    <td colspan="12">
                                                        <?php 
                                                        if ($result->AdminRemark == "") {
                                                            echo "Waiting for Action";  
                                                        } else {
                                                            echo htmlentities($result->AdminRemark);
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><b>Admin Action On:</b></td>
                                                    <td>
                                                        <?php 
                                                        if ($result->AdminRemarkDate == "") {
                                                            echo "NA";  
                                                        } else {
                                                            echo htmlentities($result->AdminRemarkDate);
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                                <?php 
                                                if ($stats == 0) {
                                                ?>
                                                <tr>
                                                    <td colspan="12">
                                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">SET ACTION</button>
                                                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">SET ACTION</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <form method="POST" name="adminaction">
                                                                        <div class="modal-body">
                                                                            <select class="custom-select" name="status" required>
                                                                                <option value="">Choose...</option>
                                                                                <option value="1">Approve</option>
                                                                                <option value="2">Decline</option>
                                                                            </select>
                                                                            <br>
                                                                            <p><textarea id="textarea1" name="description" class="form-control" placeholder="Description" rows="5" maxlength="500" required></textarea></p>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                                            <button type="submit" class="btn btn-success" name="update">Apply</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                                <?php $cnt++; } } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include '../admin/layout/footer.php'; ?>
        </div>
    </div>
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
    <script src="assets/js/line-chart.js"></script>
    <script src="assets/js/pie-chart.js"></script>
    <script src="../assets/js/plugins.js"></script>
    <script src="../assets/js/scripts.js"></script>
</body>

</html>
