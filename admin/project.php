<?php
session_start();
error_reporting(0);
include('../includes/db_connection.php');

// Check if the admin is logged in
if (empty($_SESSION['admin_login'])) {
    header('location: login.php');
    exit();
}

// Page details
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
    <link rel="stylesheet" href="../assets/css/typography.css">
    <link rel="stylesheet" href="../assets/css/default-css.css">
    <link rel="stylesheet" href="../assets/css/styles.css">
    <link rel="stylesheet" href="../assets/css/responsive.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
    <style>
        .status-not-submitted {
            color: red;
        }

        .status-submitted {
            color: green;
        }
    </style>
    <script src="../assets/js/vendor/modernizr-2.8.3.min.js"></script>
</head>

<body>
    <!-- Preloader -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    
    <!-- Page Container -->
    <div class="page-container">
        <!-- Sidebar Menu -->
        <div class="sidebar-menu">
            <div class="sidebar-header">
                <div class="logo">
                    <a href="dashboard.php"><img src="../assets/images/icon/ems_logo.jpeg" alt="logo"></a>
                </div>
            </div>
            <div class="main-menu">
                <div class="menu-inner">
                    <?php include '../admin/layout/sidebar.php'; ?>
                </div>
            </div>
        </div>
        
        <!-- Main Content Area -->
        <div class="main-content">
            <!-- Header -->
            <?php include '../admin/layout/header.php'; ?>
            
            <!-- Page Content -->
            <div class="main-content-inner">
                <div class="row">
                    <!-- Assigned Projects Area -->
                    <div class="col-12 mt-5">
                        <div class="card">
                            <div class="card-body">
                                <div class="single-table">
                                    <div class="table-responsive">
                                        <table class="table table-hover table-striped table-bordered progress-table text-center" id="assignedProjectsTable">
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
                                                    <th>Submitted Project File</th>
                                                    <th>Action</th>
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
                                                                <?php
                                                                if ($result->documents !== null) {
                                                                    echo '<a href="' . htmlentities($result->documents) . '" target="_blank">View Document</a>';
                                                                } else {
                                                                    echo 'Document Not Available';
                                                                }
                                                                ?>
                                                            </td>
                                                            <td class="<?php echo ($result->status == 0) ? 'status-not-submitted' : 'status-submitted'; ?>">
                                                                <?php echo ($result->status == 0) ? 'Not Submitted' : 'Submitted'; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo $result->submission_date !== null ? htmlentities($result->submission_date) : 'Not submitted'; ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                if ($result->submitted_documents !== null) {
                                                                    echo '<a href="' . htmlentities($result->submitted_documents) . '" target="_blank">View Document</a>';
                                                                } else {
                                                                    echo 'Project Not Submitted yet';
                                                                }
                                                                ?>
                                                            </td>
                                                            <td><a href="project_details.php?projectid=<?php echo htmlentities($result->id); ?>" class="btn btn-secondary btn-sm"> View Details</a></td>
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
                </div>
            </div>

            <!-- Footer -->
            <?php include '../admin/layout/footer.php'; ?>
        </div>
    </div>
    
    <!-- jQuery and Bootstrap Scripts -->
    <script src="../assets/js/vendor/jquery-2.2.4.min.js"></script>
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script src="../assets/js/owl.carousel.min.js"></script>
    <script src="../assets/js/metisMenu.min.js"></script>
    <script src="../assets/js/jquery.slimscroll.min.js"></script>
    <script src="../assets/js/jquery.slicknav.min.js"></script>

    <!-- DataTables JS and Buttons Extension -->
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
    
    <!-- Custom Scripts -->
    <script src="../assets/js/plugins.js"></script>
    <script src="../assets/js/scripts.js"></script>
    
    <!-- DataTable Initialization -->
    <script>
        $(document).ready(function() {
            $('#assignedProjectsTable').DataTable({
                dom: 'Bfrtip', // Add buttons UI
                buttons: [
                    {
                        extend: 'copyHtml5',
                        text: 'Copy',
                        exportOptions: {
                            columns: ':not(:last-child)' // Exclude action column
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        text: 'Excel',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        text: 'CSV',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: 'PDF',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'print',
                        text: 'Print',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    }
                ]
            });
        });
    </script>
</body>

</html>
