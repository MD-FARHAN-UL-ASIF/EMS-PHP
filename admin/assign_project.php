<?php
session_start();
error_reporting(0);
include('../includes/db_connection.php');

if (empty($_SESSION['admin_login'])) {
    header('location: login.php');
    exit(); // Add exit to stop further execution
}

$page_title = "Assign Project";
$breadcrumb = "Project Management";

if (isset($_POST['add_project'])) {
    // Handle file upload
    $target_dir = "../assets/project_file/";
    $target_file = $target_dir . basename($_FILES["documents"]["name"]);
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
 
    // Check if file is a actual document or fake
    if (isset($_POST["submit"])) {
        $check = filesize($_FILES["documents"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }
    }
 
    // Check file size
    if ($_FILES["documents"]["size"] > 5000000) {
        $uploadOk = 0;
    }
 
    // Allow certain file formats
    if ($fileType != "pdf" && $fileType != "doc" && $fileType != "docx" && $fileType != "xls" && $fileType != "xlsx") {
        $uploadOk = 0;
    }
 
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $_SESSION['error'] = "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["documents"]["tmp_name"], $target_file)) {
            // Prepare and bind
            $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
            $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_SPECIAL_CHARS);
            $starting_date = filter_input(INPUT_POST, 'starting_date', FILTER_SANITIZE_SPECIAL_CHARS);
            $closing_date = filter_input(INPUT_POST, 'closing_date', FILTER_SANITIZE_SPECIAL_CHARS);
            $empId = filter_input(INPUT_POST, 'empId', FILTER_SANITIZE_NUMBER_INT);
            $status = 0;
            $documents = $target_file;
 
            $sql = "INSERT INTO project (title, description, starting_date, closing_date, submission_date, documents,submitted_documents, empId, status)
                    VALUES (:title, :description, :starting_date, :closing_date, NULL, :documents, Null, :empId, :status)";
            $query = $dbh->prepare($sql);
            $query->bindParam(':title', $title, PDO::PARAM_STR);
            $query->bindParam(':description', $description, PDO::PARAM_STR);
            $query->bindParam(':starting_date', $starting_date, PDO::PARAM_STR);
            $query->bindParam(':closing_date', $closing_date, PDO::PARAM_STR);
            $query->bindParam(':documents', $documents, PDO::PARAM_STR);
            $query->bindParam(':empId', $empId, PDO::PARAM_INT);
            $query->bindParam(':status', $status, PDO::PARAM_INT);
 
            if ($query->execute()) {
                $_SESSION['msg'] = "Project has been added successfully";
                header('location: project.php');
                exit();
            } else {
                $_SESSION['error'] = "ERROR: Could not add project. Please try again.";
                header('location: create_project.php');
                exit();
            }
        } else {
            $_SESSION['error'] = "Sorry, there was an error uploading your file.";
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
                    $page = 'assign_project';
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
                                    <form name="addproject" method="POST" enctype="multipart/form-data">
                                        <div class="card-body">
                                            <p class="text-muted font-14 mb-4">Please fill up the form in order to add a project</p>
 
                                            <div class="form-group">
                                                <label for="title" class="col-form-label">Project Title</label>
                                                <input class="form-control" name="title" type="text" required id="title">
                                            </div>
 
                                            <div class="form-group">
                                                <label for="description" class="col-form-label">Description</label>
                                                <textarea class="form-control" name="description" required id="description"></textarea>
                                            </div>
 
                                            <div class="form-group">
                                                <label for="starting_date" class="col-form-label">Starting Date</label>
                                                <input class="form-control" name="starting_date" type="date" required id="starting_date">
                                            </div>
 
                                            <div class="form-group">
                                                <label for="closing_date" class="col-form-label">Closing Date</label>
                                                <input class="form-control" name="closing_date" type="date" required id="closing_date">
                                            </div>
 
                                            <div class="form-group">
                                                <label for="documents" class="col-form-label">Upload Document</label>
                                                <input class="form-control" name="documents" type="file" required id="documents">
                                            </div>
 
                                            <div class="form-group">
                                                <label for="empId" class="col-form-label">Assign to Employee</label>
                                                <select class="custom-select" name="empId" required id="empId">
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
 
                                            <button class="btn btn-sm btn-info" name="add_project" type="submit">ADD</button>
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
