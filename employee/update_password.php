<?php
session_start();
error_reporting(0);
include('../includes/db_connection.php');

if (empty($_SESSION['employee_login'])) {
    header('location: ../index.php');
    exit(); // Add exit to stop further execution
}

$page_title = "Update Password";
$breadcrumb = "Update Password";

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        $action = $_POST['action'];
        $eid = $_SESSION['eid'];  // Ensure this session variable is properly set

        if ($action == 'validate_password') {
            // Handle current password validation
            $currentPassword = $_POST['currentPassword'];  // Already hashed

            $sql = "SELECT Password FROM employees WHERE id = :eid";
            $query = $dbh->prepare($sql);
            $query->bindParam(':eid', $eid, PDO::PARAM_STR);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);

            if ($result && $currentPassword === $result['Password']) {
                echo json_encode(['status' => 'success', 'message' => 'Current password is correct.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Current password is incorrect.']);
            }
            exit();
        }

        if ($action == 'update_password') {
            // Handle password update
            $currentPassword = $_POST['currentPassword'];  // Already hashed
            $newPassword = $_POST['newPassword'];  // Already hashed
            $confirmPassword = $_POST['confirmPassword'];  // Already hashed

            if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
                $message = 'All fields are required.';
            } elseif ($newPassword !== $confirmPassword) {
                $message = 'New passwords and Confirm New Password does not match.';
            } else {
                $sql = "SELECT Password FROM employees WHERE id = :eid";
                $query = $dbh->prepare($sql);
                $query->bindParam(':eid', $eid, PDO::PARAM_STR);
                $query->execute();
                $result = $query->fetch(PDO::FETCH_ASSOC);

                if ($result && $currentPassword === $result['Password']) {
                    $sql = "UPDATE employees SET Password = :newPassword WHERE id = :eid";
                    $query = $dbh->prepare($sql);
                    $query->bindParam(':newPassword', $newPassword, PDO::PARAM_STR);
                    $query->bindParam(':eid', $eid, PDO::PARAM_STR);
                    $query->execute();

                    $message = 'Password updated successfully.';
                } else {
                    $message = 'Current password is incorrect.';
                }
            }
            echo $message;
            exit();
        }
    }
}
?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>EMS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
    <script src="../assets/js/vendor/jquery-2.2.4.min.js"></script>
    <script src="../assets/js/vendor/modernizr-2.8.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>
    <style>
        .text-success {
            color: green;
        }
        .text-danger {
            color: red;
        }
    </style>
    <script>
        $(document).ready(function() {
            $('#updatePasswordForm').on('submit', function(e) {
                e.preventDefault();
                var currentPassword = CryptoJS.MD5($('#currentPassword').val()).toString();
                var newPassword = CryptoJS.MD5($('#newPassword').val()).toString();
                var confirmPassword = CryptoJS.MD5($('#confirmPassword').val()).toString();

                $.ajax({
                    url: '',  // Since this is a single file, keep the URL empty
                    method: 'POST',
                    data: {
                        action: 'update_password',
                        currentPassword: currentPassword,
                        newPassword: newPassword,
                        confirmPassword: confirmPassword
                    },
                    success: function(response) {
                        $('#response').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error: ' + status + error);
                    }
                });
            });

            $('#currentPassword').on('blur', function() {
                var currentPassword = CryptoJS.MD5($(this).val()).toString();
                $.ajax({
                    url: '',  // Since this is a single file, keep the URL empty
                    method: 'POST',
                    data: {
                        currentPassword: currentPassword,
                        action: 'validate_password'
                    },
                    success: function(response) {
                        var result = JSON.parse(response);
                        if (result.status === 'success') {
                            $('#currentPasswordError').html(result.message).removeClass('text-danger').addClass('text-success');
                        } else {
                            $('#currentPasswordError').html(result.message).removeClass('text-success').addClass('text-danger');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error: ' + status + error);
                    }
                });
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
                    $page = 'payout';
                    include '../employee/layout/sidebar.php';
                    ?>
                </div>
            </div>
        </div>

        <div class="main-content">
            <?php include '../employee/layout/header.php' ?>
            <div class="main-content-inner">
                <div class="row justify-content-center align-items-center">
                    <div class="col-lg-6 col-ml-12">
                        <div class="row justify-content-center">
                            <div class="col-lg-6">
                                <h2>Update Password</h2>
                                <form id="updatePasswordForm">
                                    <div class="form-group">
                                        <label for="currentPassword">Current Password</label>
                                        <input type="password" class="form-control" id="currentPassword" name="currentPassword" required>
                                        <div id="currentPasswordError"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="newPassword">New Password</label>
                                        <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="confirmPassword">Confirm New Password</label>
                                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                                    </div>
                                    <div id="response" class="mt-3 text-danger"></div>
                                    <button type="submit" class="btn btn-primary">Update Password</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include '../admin/layout/footer.php' ?>
        </div>
        <script src="../assets/js/popper.min.js"></script>
        <script src="../assets/js/bootstrap.min.js"></script>
        <script src="../assets/js/owl.carousel.min.js"></script>
        <script src="../assets/js/metisMenu.min.js"></script>
        <script src="../assets/js/jquery.slimscroll.min.js"></script>
        <script src="../assets/js/jquery.slicknav.min.js"></script>
        <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
        <script src="https://www.amcharts.com/lib/3/serial.js"></script>
        <script src="https://www.amcharts.com/lib/3/export.min.js"></script>
        <script src="https://www.amcharts.com/lib/3/light.js"></script>
        <script src="../assets/js/amcharts.js"></script>
        <script src="../assets/js/scripts.js"></script>
    </div>
</body>

</html>
