<?php
session_start();
error_reporting(0);
include('../includes/db_connection.php');

if (empty($_SESSION['admin_login'])) {
    header('location: login.php');
    exit(); // Add exit to stop further execution
}

$page_title = "Update Employee Details";
$breadcrumb = "Update Employee Details";

$eid = intval($_GET['empid']);
if (isset($_POST['update'])) {

    $fname = $_POST['firstName'];
    $lname = $_POST['lastName'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $department = $_POST['department'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $mobileno = $_POST['mobile'];
    $salary = $_POST['salary'];

    $sql = "UPDATE employees set FirstName=:fname,LastName=:lname,Gender=:gender,Dob=:dob,Department=:department,Address=:address,City=:city,Phone=:mobile, Salary=:salary where id=:eid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':fname', $fname, PDO::PARAM_STR);
    $query->bindParam(':lname', $lname, PDO::PARAM_STR);
    $query->bindParam(':gender', $gender, PDO::PARAM_STR);
    $query->bindParam(':dob', $dob, PDO::PARAM_STR);
    $query->bindParam(':department', $department, PDO::PARAM_STR);
    $query->bindParam(':address', $address, PDO::PARAM_STR);
    $query->bindParam(':city', $city, PDO::PARAM_STR);
    $query->bindParam(':mobile', $mobile, PDO::PARAM_STR);
    $query->bindParam(':eid', $eid, PDO::PARAM_STR);
    $query->bindparam(':salary', $salary, PDO::PARAM_STR);
    $query->execute();

    $msg = "Employee details updated Successfully";
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
                            <?php if ($error) { ?><div class="alert alert-danger alert-dismissible fade show"><strong>Info: </strong><?php echo htmlentities($error); ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>

                                </div><?php } else if ($msg) { ?><div class="alert alert-success alert-dismissible fade show"><strong>Info: </strong><?php echo htmlentities($msg); ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div><?php } ?>
                            <div class="card">
                                <form name="addemp" method="POST">

                                    <div class="card-body">


                                        <?php
                                        $eid = intval($_GET['empid']);
                                        $sql = "SELECT * from  employees where id=:eid";
                                        $query = $dbh->prepare($sql);
                                        $query->bindParam(':eid', $eid, PDO::PARAM_STR);
                                        $query->execute();
                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                        $cnt = 1;
                                        if ($query->rowCount() > 0) {
                                            foreach ($results as $result) {               ?>


                                                <div class="form-group">
                                                    <label for="example-text-input" class="col-form-label">First Name</label>
                                                    <input class="form-control" name="firstName" value="<?php echo htmlentities($result->FirstName); ?>" type="text" required id="example-text-input">
                                                </div>

                                                <div class="form-group">
                                                    <label for="example-text-input" class="col-form-label">Last Name</label>
                                                    <input class="form-control" name="lastName" value="<?php echo htmlentities($result->LastName); ?>" type="text" autocomplete="off" required id="example-text-input">
                                                </div>

                                                <div class="form-group">
                                                    <label for="example-email-input" class="col-form-label">Email</label>
                                                    <input class="form-control" name="email" type="email" value="<?php echo htmlentities($result->Email); ?>" readonly autocomplete="off" required id="example-email-input">
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-form-label">Gender</label>
                                                    <select class="custom-select" name="gender" autocomplete="off">
                                                        <option value="<?php echo htmlentities($result->Gender); ?>"><?php echo htmlentities($result->Gender); ?></option>
                                                        <option value="Male">Male</option>
                                                        <option value="Female">Female</option>
                                                        <option value="Other">Other</option>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="example-date-input" class="col-form-label">D.O.B</label>
                                                    <input class="form-control" type="date" name="dob" id="birthdate" value="<?php echo htmlentities($result->Dob); ?>">
                                                </div>

                                                <div class="form-group">
                                                    <label for="example-text-input" class="col-form-label">Contact Number</label>
                                                    <input class="form-control" name="mobile" type="text" value="<?php echo htmlentities($result->Phone); ?>" maxlength="10" autocomplete="off" required>
                                                </div>

                                                <div class="form-group">
                                                    <label for="example-text-input" class="col-form-label">Employee ID</label>
                                                    <input class="form-control" name="empcode" type="text" autocomplete="off" readonly required value="<?php echo htmlentities($result->EmpId); ?>" id="example-text-input">
                                                </div>

                                                <div class="form-group">
                                                    <label for="example-text-input" class="col-form-label">Address</label>
                                                    <input class="form-control" name="address" type="text" value="<?php echo htmlentities($result->Address); ?>" autocomplete="off" required>
                                                </div>

                                                <div class="form-group">
                                                    <label for="example-text-input" class="col-form-label">City</label>
                                                    <input class="form-control" name="city" type="text" value="<?php echo htmlentities($result->City); ?>" autocomplete="off" required>
                                                </div>

                                                <div class="form-group">
                                                    <label class="col-form-label">Department</label>
                                                    <select class="custom-select" name="department" autocomplete="off">
                                                        <option value="<?php echo htmlentities($result->Department); ?>"><?php echo htmlentities($result->Department); ?></option>

                                                        <?php $sql = "SELECT Name from departments";
                                                        $query = $dbh->prepare($sql);
                                                        $query->execute();
                                                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                        $cnt = 1;
                                                        if ($query->rowCount() > 0) {
                                                            foreach ($results as $resultt) {
                                                        ?>
                                                                <option value="<?php echo htmlentities($resultt->Name); ?>"><?php echo htmlentities($resultt->Name); ?></option>
                                                        <?php }
                                                        } ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="salary" class="col-form-label">Salary</label>
                                                    <input class="form-control" name="salary" type="number" value="<?php echo htmlentities($result->salary); ?>" step="0.01" min="0" autocomplete="off" required id="salary">
                                                </div>


                                        <?php }
                                        } ?>

                                        <button class="btn btn-primary" name="update" id="update" type="submit">MAKE CHANGES</button>

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

    <!-- others plugins -->
    <script src="../assets/js/plugins.js"></script>
    <script src="../assets/js/scripts.js"></script>
</body>

</html>