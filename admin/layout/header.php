<?php
session_start();
include('db_connection.php'); // Ensure you have the correct DB connection file included

// Retrieve the full name from the database
$query = "SELECT FullName FROM admin WHERE UserName = :username";
$stmt = $dbh->prepare($query);
$stmt->bindParam(':username', $_SESSION['admin_login']);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$full_name = $row['FullName'];

// Handle password update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $username = $_SESSION['admin_login'];

    // Check if passwords match
    if ($new_password !== $confirm_password) {
        $message = "Passwords do not match!";
    } else {
        // Hash the new password using bcrypt
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

        // Update the password in the database
        $query = "UPDATE admin SET Password = :password WHERE UserName = :username";
        $stmt = $dbh->prepare($query);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':username', $username);

        if ($stmt->execute()) {
            $message = "Password updated successfully!";
        } else {
            $message = "Failed to update password!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Include necessary CSS and JS files (Bootstrap, FontAwesome, etc.) -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/font-awesome.min.css">
    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
</head>
<body>

<!-- Header Area -->
<div class="header-area">
    <div class="row align-items-center">
        <div class="col-md-6 col-sm-8 clearfix">
            <div class="nav-btn pull-left">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
        <div class="col-md-6 col-sm-4 clearfix">
            <ul class="notification-area pull-right">
                <li id="full-view"><i class="ti-fullscreen"></i></li>
                <li id="full-view-exit"><i class="ti-zoom-out"></i></li>
                <?php include '../dashboard/admin_notification.php' ?>
            </ul>
        </div>
    </div>
</div>

<!-- Page Title Area -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left"><?php echo htmlspecialchars($page_title); ?></h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="dashboard.php">Admin</a></li>
                    <li><span><?php echo htmlspecialchars($breadcrumb); ?></span></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-6 clearfix">
            <div class="user-profile pull-right">
                <img class="avatar user-thumb" src="../assets/images/admin.png" alt="avatar">
                <h4 class="user-name dropdown-toggle" data-toggle="dropdown">
                    <?php echo htmlspecialchars($full_name); ?> <i class="fa fa-angle-down"></i>
                </h4>
                <div class="dropdown-menu">
                    <a class="dropdown-item" href="logout.php">Log Out</a>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#updatePasswordModal">Update Password</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Password Update Modal -->
<div class="modal fade" id="updatePasswordModal" tabindex="-1" role="dialog" aria-labelledby="updatePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updatePasswordModalLabel">Update Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" action="">
                <div class="modal-body">
                    <?php if (isset($message)): ?>
                        <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label for="new-password">New Password</label>
                        <input type="password" class="form-control" id="new-password" name="new_password" required>
                    </div>
                    <div class="form-group">
                        <label for="confirm-password">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm-password" name="confirm_password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Password</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
