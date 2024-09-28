<?php
session_start();
error_reporting(0);
include('../includes/db_connection.php');

if (empty($_SESSION['admin_login'])) {
    header('location: login.php');
    exit();
}

$page_title = "Give Salary";
$breadcrumb = "Salary Management";

if (isset($_POST['give_salary'])) {
    $empId = filter_input(INPUT_POST, 'empId', FILTER_SANITIZE_NUMBER_INT);
    $month = filter_input(INPUT_POST, 'month', FILTER_SANITIZE_SPECIAL_CHARS);
    $salary_in = filter_input(INPUT_POST, 'salary_in', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

    // Fetch previous balance
    $sql = "SELECT balance FROM employee_salary WHERE empId = :empId ORDER BY payout_date DESC LIMIT 1";
    $query = $dbh->prepare($sql);
    $query->bindParam(':empId', $empId, PDO::PARAM_INT);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_OBJ);
    $previous_balance = $result ? $result->balance : 0;

    // Calculate new balance
    $balance = $previous_balance + $salary_in;
    $salary_out = 0; // Always 0
    $payout_date = date('Y-m-d H:i:s'); // Current datetime

    // Insert into employee_salary table
    $sql = "INSERT INTO employee_salary (empId, salary_in, salary_out, balance, month, payout_date)
            VALUES (:empId, :salary_in, :salary_out, :balance, :month, :payout_date)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':empId', $empId, PDO::PARAM_INT);
    $query->bindParam(':salary_in', $salary_in, PDO::PARAM_STR);
    $query->bindParam(':salary_out', $salary_out, PDO::PARAM_STR);
    $query->bindParam(':balance', $balance, PDO::PARAM_STR);
    $query->bindParam(':month', $month, PDO::PARAM_STR);
    $query->bindParam(':payout_date', $payout_date, PDO::PARAM_STR);

    if ($query->execute()) {
        $_SESSION['msg'] = "Salary has been given successfully";
        header('location: payout.php');
        exit();
    } else {
        $_SESSION['error'] = "ERROR: Could not give salary. Please try again.";
        header('location: create_employee_salary.php');
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
                    $page = 'payout';
                    include '../admin/layout/sidebar.php';
                    ?>
                </div>
            </div>
        </div>

        <div class="main-content">
            <?php include '../admin/layout/header.php' ?>
            <div class="main-content-inner">
                <div class="row justify-content-center align-items-center">
                    <div class="col-lg-6 col-ml-12">
                        <div class="row justify-content-center align-items-center">
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
                                    <form name="give_salary" method="POST">
                                        <div class="card-body">
                                            <p class="text-muted font-14 mb-4">Please fill up the form in order to give salary</p>

                                            <div class="form-group">
                                                <label for="empId" class="col-form-label">Employee</label>
                                                <select class="custom-select" name="empId" required id="empId" onchange="fetchSalary()">
                                                    <option value="">Choose..</option>
                                                    <?php
                                                    $sql = "SELECT id, FirstName, LastName FROM employees";
                                                    $query = $dbh->prepare($sql);
                                                    $query->execute();
                                                    $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                    foreach ($results as $result) {
                                                        echo "<option value='" . $result->id . "'>" . $result->FirstName . " " . $result->LastName . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="month" class="col-form-label">Month</label>
                                                <select class="custom-select" name="month" required id="month">
                                                    <option value="">Choose..</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="salary_in" class="col-form-label">Salary In</label>
                                                <input class="form-control" name="salary_in" type="text" required id="salary_in" readonly>
                                            </div>

                                            <div class="form-group">
                                                <label for="balance" class="col-form-label">Balance</label>
                                                <input class="form-control" name="balance" type="text" required id="balance" readonly>
                                            </div>

                                            <button class="btn btn-sm btn-info" name="give_salary" type="submit">Give Salary</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
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
        <script src="https://www.amcharts.com/lib/3/serial.js"></script>
        <script src="https://www.amcharts.com/lib/3/export.min.js"></script>
        <script src="https://www.amcharts.com/lib/3/light.js"></script>
        <script src="../assets/js/amcharts.js"></script>
        <script src="../assets/js/scripts.js"></script>
        <script>
            function fetchSalary() {
                var empId = $('#empId').val();
                if (empId) {
                    $.ajax({
                        type: 'POST',
                        url: 'fetch_salary.php',
                        data: {
                            empId: empId
                        },
                        success: function(data) {
                            var salaryData = JSON.parse(data);
                            $('#salary_in').val(salaryData.salary_in);
                            $('#balance').val(salaryData.balance);
                        }
                    });
                }
            }
        </script>
        <script>
            // Get the current month (0-11, where 0 is January)
            const currentMonthIndex = new Date().getMonth();

            // Array of month names
            const months = [
                "January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];

            // Get the 'month' select element
            const monthSelect = document.getElementById("month");

            // Populate the select options starting from the current month
            for (let i = 0; i <= currentMonthIndex; i++) {
        const option = document.createElement("option");
        option.value = months[i];
        option.textContent = months[i];
        monthSelect.appendChild(option);
    }
        </script>
</body>

</html>