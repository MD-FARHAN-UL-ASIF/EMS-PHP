<?php
session_start();
error_reporting(0);
include('../includes/db_connection.php');

if (empty($_SESSION['admin_login'])) {
    header('location: login.php');
    exit(); // Add exit to stop further execution
}

$page_title = "Add Employee";
$breadcrumb = "Add Employee";

if (isset($_POST['add_employee'])) {
    // Sanitize and validate input
    $empid = filter_input(INPUT_POST, 'empcode', FILTER_SANITIZE_SPECIAL_CHARS);
    $fname = filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_SPECIAL_CHARS);
    $lname = filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
    $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_SPECIAL_CHARS);
    $dob = filter_input(INPUT_POST, 'dob', FILTER_SANITIZE_SPECIAL_CHARS);
    $department = filter_input(INPUT_POST, 'department', FILTER_SANITIZE_SPECIAL_CHARS);
    $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_SPECIAL_CHARS);
    $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_SPECIAL_CHARS);
    $mobile = filter_input(INPUT_POST, 'mobile', FILTER_SANITIZE_SPECIAL_CHARS);
    $status = 1;
    $regdate = date('Y-m-d H:i:s'); // Current date and time for RegDate
    $salary = filter_input(INPUT_POST, 'salary', FILTER_SANITIZE_SPECIAL_CHARS);

    if (!preg_match('/^\d{11}$/', $mobile)) {
        $_SESSION['error'] = "Mobile number must be exactly 11 digits.";
        header('location: create_employee.php');
        exit();
    }
    // Hash the password
    $hashed_password = md5($password);

    // Insert data into database
    $sql = "INSERT INTO employees (EmpId, FirstName, LastName, Email, Password, Gender, Dob, Department, Address, City, Phone, Status, RegDate, Salary)
            VALUES (:empid, :fname, :lname, :email, :password, :gender, :dob, :department, :address, :city, :mobile, :status, :regdate, :salary)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':empid', $empid, PDO::PARAM_STR);
    $query->bindParam(':fname', $fname, PDO::PARAM_STR);
    $query->bindParam(':lname', $lname, PDO::PARAM_STR);
    $query->bindParam(':email', $email, PDO::PARAM_STR);
    $query->bindParam(':password', $hashed_password, PDO::PARAM_STR);
    $query->bindParam(':gender', $gender, PDO::PARAM_STR);
    $query->bindParam(':dob', $dob, PDO::PARAM_STR);
    $query->bindParam(':department', $department, PDO::PARAM_STR);
    $query->bindParam(':address', $address, PDO::PARAM_STR);
    $query->bindParam(':city', $city, PDO::PARAM_STR);
    $query->bindParam(':mobile', $mobile, PDO::PARAM_STR);
    $query->bindParam(':status', $status, PDO::PARAM_INT);
    $query->bindParam(':regdate', $regdate, PDO::PARAM_STR);
    $query->bindParam(':salary', $salary, PDO::PARAM_STR);

    if ($query->execute()) {
        $_SESSION['msg'] = "Employee has been added successfully";
        header('location: create_employee.php');
        exit();
    } else {
        $_SESSION['error'] = "ERROR: Could not add record. Please try again.";
        header('location: create_employee.php');
        exit();
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
    <!-- amchart css -->
    <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
    <!-- others css -->
    <link rel="stylesheet" href="../assets/css/typography.css">
    <link rel="stylesheet" href="../assets/css/default-css.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/responsive.css">
    <!-- modernizr css -->
    <script src="../assets/js/vendor/modernizr-2.8.3.min.js"></script>
    <script type="text/javascript">
        function valid() {
            if (document.addemp.password.value != document.addemp.confirmpassword.value) {
                alert("New Password and Confirm Password Field do not match!");
                document.addemp.confirmpassword.focus();
                return false;
            }
            return true;
        }
    </script>
    <script>
        function checkAvailabilityEmpid() {
            $("#loaderIcon").show();
            jQuery.ajax({
                url: "check_availability.php",
                data: 'empcode=' + $("#empcode").val(),
                type: "POST",
                success: function(data) {
                    $("#empid-availability").html(data);
                    $("#loaderIcon").hide();
                },
                error: function() {}
            });
        }
    </script>
    <script>
        function checkAvailabilityEmailid() {
            $("#loaderIcon").show();
            jQuery.ajax({
                url: "check_availability.php",
                data: 'emailid=' + $("#email").val(),
                type: "POST",
                success: function(data) {
                    $("#emailid-availability").html(data);
                    $("#loaderIcon").hide();
                },
                error: function() {}
            });
        }
    </script>
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
                                    <form name="addemp" method="POST">

                                        <div class="card-body">
                                            <p class="text-muted font-14 mb-4">Please fill up the form in order to add employee records</p>

                                            <div class="form-group">
                                                <label for="empcode" class="col-form-label">Employee ID</label>
                                                <input class="form-control" name="empcode" type="text" autocomplete="off" required id="empcode" onBlur="checkAvailabilityEmpid()">
                                            </div>

                                            <div class="form-group">
                                                <label for="firstName" class="col-form-label">First Name</label>
                                                <input class="form-control" name="firstName" type="text" required id="firstName">
                                            </div>

                                            <div class="form-group">
                                                <label for="lastName" class="col-form-label">Last Name</label>
                                                <input class="form-control" name="lastName" type="text" autocomplete="off" required id="lastName">
                                            </div>

                                            <div class="form-group">
                                                <label for="email" class="col-form-label">Email</label>
                                                <input class="form-control" name="email" type="email" autocomplete="off" required id="email" onBlur="checkAvailabilityEmailid()">
                                            </div>

                                            <div class="form-group">
                                                <label for="password" class="col-form-label">Password</label>
                                                <input class="form-control" name="password" type="password" autocomplete="off" required id="password">
                                            </div>

                                            <div class="form-group">
                                                <label for="confirmpassword" class="col-form-label">Confirm Password</label>
                                                <input class="form-control" name="confirmpassword" type="password" autocomplete="off" required id="confirmpassword">
                                            </div>

                                            <div class="form-group">
                                                <label class="col-form-label">Gender</label>
                                                <select class="custom-select" name="gender" autocomplete="off">
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-form-label">Date of Birth</label>
                                                <input class="form-control" name="dob" type="date" autocomplete="off" required>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-form-label">Preferred Department</label>
                                                <select class="custom-select" name="department" autocomplete="off">
                                                    <option value="">Choose..</option>
                                                    <?php
                                                    $sql = "SELECT Name from departments";
                                                    $query = $dbh->prepare($sql);
                                                    $query->execute();
                                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                    if ($query->rowCount() > 0) {
                                                        foreach ($results as $result) {
                                                    ?>
                                                            <option value="<?php echo htmlentities($result->Name); ?>"><?php echo htmlentities($result->Name); ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="address" class="col-form-label">Address</label>
                                                <input class="form-control" name="address" type="text" autocomplete="off" required id="address">
                                            </div>

                                            <div class="form-group">
                                                <label for="city" class="col-form-label">City/Town</label>
                                                <input class="form-control" name="city" type="text" autocomplete="off" required id="city">
                                            </div>

                                            <div class="form-group">
                                                <label for="mobile" class="col-form-label">Mobile Number</label>
                                                <input class="form-control" name="mobile" type="text" autocomplete="off" required id="mobile" maxlength="11" oninput="validateMobile(this)">
                                            </div>


                                            <div class="form-group">
                                                <label for="salary" class="col-form-label">Salary</label>
                                                <input class="form-control" name="salary" type="number" step="0.01" min="0" autocomplete="off" required id="salary">
                                            </div>

                                            <button class="btn btn-sm btn-info" name="add_employee" type="submit">ADD</button>
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