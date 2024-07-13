<?php
session_start();
error_reporting(0);
include('../includes/db_connection.php');

if (empty($_SESSION['admin_login'])) {
    header('location: login.php');
    exit();
}

$page_title = "Project Details";
$breadcrumb = "Manage Projects";

$did = intval($_GET['projectid']);

// Code for action taken on project
if (isset($_POST['update'])) {
    $admin_feedback = $_POST['admin_feedback'];
    $admin_remarks = intval($_POST['admin_remarks']);

    $sql = "UPDATE project SET admin_feedback = :admin_feedback, admin_remarks = :admin_remarks WHERE id = :did";
    $query = $dbh->prepare($sql);
    $query->bindParam(':admin_feedback', $admin_feedback, PDO::PARAM_STR);
    $query->bindParam(':admin_remarks', $admin_remarks, PDO::PARAM_INT);
    $query->bindParam(':did', $did, PDO::PARAM_INT);
    $query->execute();
    $msg = "Project Feedback updated Successfully";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>EMS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                    $page = 'project';
                    include '../admin/layout/sidebar.php';
                    ?>
                </div>
            </div>
        </div>

        <div class="main-content">
            <?php include '../admin/layout/header.php' ?>

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
                                                $pid = intval($_GET['projectid']);
                                                $sql = "SELECT * FROM project WHERE id = :pid";
                                                $query = $dbh->prepare($sql);
                                                $query->bindParam(':pid', $pid, PDO::PARAM_INT);
                                                $query->execute();
                                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                $cnt = 1;
                                                if ($query->rowCount() > 0) {
                                                    foreach ($results as $result) {
                                                ?>
                                                        <tr>
                                                            <td><b>Project ID:</b></td>
                                                            <td colspan="1"><?php echo htmlentities($result->id); ?></td>
                                                            <td><b>Title:</b></td>
                                                            <td colspan="1"><?php echo htmlentities($result->title); ?></td>
                                                            <td><b>Documents:</b></td>
                                                            <td colspan="5">
                                                                <?php
                                                                if ($result->documents) {
                                                                    echo '<a href="' . htmlentities($result->documents) . '" target="_blank">View Document</a>';
                                                                } else {
                                                                    echo "No documents given by admin";
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Starting Date:</b></td>
                                                            <td colspan="1"><?php echo htmlentities($result->starting_date); ?></td>
                                                            <td><b>Closing Date:</b></td>
                                                            <td colspan="1"><?php echo htmlentities($result->closing_date); ?></td>
                                                            <td><b>Status:</b></td>
                                                            <td colspan="1">
                                                                <?php
                                                                $stats = $result->status;
                                                                if ($stats == 1) {
                                                                    echo '<span style="color: green">Submitted</span>';
                                                                } else {
                                                                    echo '<span style="color: red">Not Submitted</span>';
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Description :</b></td>
                                                            <td colspan="5"><?php echo htmlentities($result->description); ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Admin Feedback :</b></td>
                                                            <td colspan="5">
                                                                <?php echo htmlentities($result->admin_feedback) ? htmlentities($result->admin_feedback) : 'Not Issued Yet by admin'; ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>Admin Marking(Scale of 10) :</b></td>
                                                            <td colspan="1">
                                                                <?php echo htmlentities($result->admin_remarks) ? htmlentities($result->admin_remarks) : 'Not Issued Yet by admin'; ?>
                                                            </td>
                                                            <td><b>Submitted Project File:</b></td>
                                                            <td colspan="5">
                                                                <?php
                                                                if ($result->submitted_documents) {
                                                                    echo '<a href="' . htmlentities($result->submitted_documents) . '" target="_blank">View Document</a>';
                                                                } else {
                                                                    echo "You have not submitted the project file yet";
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        if ($stats == 1) {
                                                        ?>
                                                            <tr>
                                                                <td colspan="12">
                                                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#feedbackModal">Give Feedback</button>
                                                                    <div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog" aria-labelledby="feedbackModalLabel" aria-hidden="true">
                                                                        <div class="modal-dialog" role="document">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 class="modal-title" id="feedbackModalLabel">Update Feedback</h5>
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                        <span aria-hidden="true">&times;</span>
                                                                                    </button>
                                                                                </div>
                                                                                <form method="POST" name="adminaction">
                                                                                    <div class="modal-body">
                                                                                        <div class="form-group">
                                                                                            <label for="admin_feedback">Admin Feedback</label>
                                                                                            <textarea name="admin_feedback" class="form-control" maxlength="255" required></textarea>
                                                                                        </div>
                                                                                        <div class="form-group">
                                                                                            <label for="admin_remarks">Admin Marking (Scale of 10)</label>
                                                                                            <select name="admin_remarks" class="form-control" required>
                                                                                                <option value="">Select</option>
                                                                                                <?php for ($i = 1; $i <= 10; $i++) {
                                                                                                    echo "<option value=\"$i\">$i</option>";
                                                                                                } ?>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                                                        <button type="submit" class="btn btn-success" name="update">Submit</button>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
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
                </div>
            </div>
            <?php include '../admin/layout/footer.php' ?>
        </div>

        <!-- JavaScript -->
        <!-- jquery latest version -->
        <script src="../assets/js/vendor/jquery-2.2.4.min.js"></script>
        <!-- bootstrap 4 js -->
        <script src="../assets/js/popper.min.js"></script>
        <script src="../assets/js/bootstrap.min.js"></script>
        <script src="../assets/js/owl.carousel.min.js"></script>
        <script src="../assets/js/metisMenu.min.js"></script>
        <script src="../assets/js/jquery.slimscroll.min.js"></script>
        <script src="../assets/js/jquery.slicknav.min.js"></script>

        <!-- Start datatable js -->
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
        <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>

        <!-- others plugins -->
        <script src="../assets/js/plugins.js"></script>
        <script src="../assets/js/scripts.js"></script>
    </div>
</body>

</html>
