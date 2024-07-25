<?php
session_start();
include('includes/db_connection.php');

$msg = ''; // Initialize $msg

if (isset($_POST['signin'])) {
    $uname = $_POST['username'];
    $password = md5($_POST['password']);  

    try {
        $sql = "SELECT Email, Password, Status, id FROM employees WHERE Email = :uname AND Password = :password";
        $query = $dbh->prepare($sql);
        $query->bindParam(':uname', $uname, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_OBJ);

        if ($result) {
            if ($result->Status == 0) {
                $msg = "Your account is currently inactive. Please contact your administrator.";
            } else {
                $_SESSION['employee_login'] = $uname;
                $_SESSION['eid'] = $result->id;
                header("Location: employee/dashboard.php");
                exit;
            }
        } else {
            $msg = "Invalid email or password. Please try again.";
        }
    } catch (PDOException $e) {
        $msg = "A database error occurred: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMS</title>
    <link rel="shortcut icon" type="image/png" href="assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/themify-icons.css">
    <link rel="stylesheet" href="assets/css/metisMenu.css">
    <link rel="stylesheet" href="assets/css/slicknav.min.css">
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <link rel="stylesheet" href="assets/css/default-css.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="../assets/js/vendor/modernizr-2.8.3.min.js"></script>
    <link rel="stylesheet" href="assets/css/typography.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
</head>
<body>
    <div id="preloader">
        <div class="loader"></div>
    </div>

    <div class="login-area login-s2">
        <div class="container">
            <div class="login-box ptb--100">
                <form method="POST" name="signin">
                    <div class="login-form-head">
                        <h4>Employee Login</h4>
                        <p>EMS</p>
                    </div>
                    <div class="login-form-body">
                        <?php if ($msg) { ?>
                            <div class="alert alert-danger" role="alert">
                                <strong>Error:</strong> <?php echo htmlentities($msg); ?>
                            </div>
                        <?php } ?>
                        <div class="form-gp">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" id="username" name="username" autocomplete="off" required>
                            <i class="ti-email"></i>
                            <div class="text-danger"></div>
                        </div>
                        <div class="form-gp">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" id="password" name="password" autocomplete="off" required>
                            <i class="ti-lock"></i>
                            <div class="text-danger"></div>
                        </div>
                        <div class="row mb-4 rmber-area">
                            <div class="col-6">
                                <div class="custom-control custom-checkbox mr-sm-2">
                                    <input type="checkbox" class="custom-control-input" id="customControlAutosizing">
                                    <label class="custom-control-label" for="customControlAutosizing">Remember Me</label>
                                </div>
                            </div>
                            <!-- <div class="col-6 text-right">
                                <a href="password-recovery.php">Forgot Password?</a>
                            </div> -->
                        </div>
                        <div class="submit-btn-area">
                            <button id="form_submit" type="submit" name="signin">Login <i class="ti-arrow-right"></i></button>
                        </div>
                        <div class="form-footer text-center mt-5">
                            <p class="text-muted"><a href="admin/login.php">Go to Admin Panel</a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/vendor/jquery-2.2.4.min.js"></script>
    <script src="assets/js/metisMenu.min.js"></script>
    <script src="assets/js/jquery.slimscroll.min.js"></script>
    <script src="assets/js/jquery.slicknav.min.js"></script>
    <script src="assets/js/plugins.js"></script>
    <script src="assets/js/scripts.js"></script>
</body>
</html>
                            