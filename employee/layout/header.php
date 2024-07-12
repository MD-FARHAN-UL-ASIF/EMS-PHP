<?php
// Retrieve the full name from the database
$query = "SELECT FullName FROM admin WHERE UserName = '" . $_SESSION['admin_login'] . "'";
$result = $dbh->query($query);
$row = $result->fetch(PDO::FETCH_ASSOC);
$full_name = $row['FullName'];
?>
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
                <?php include '../includes/admin-notification.php' ?>
            </ul>
        </div>
    </div>
</div>
<!-- page title area start -->
<div class="page-title-area">
    <div class="row align-items-center">
        <div class="col-sm-6">
            <div class="breadcrumbs-area clearfix">
                <h4 class="page-title pull-left"><?php echo htmlspecialchars($page_title); ?></h4>
                <ul class="breadcrumbs pull-left">
                    <li><a href="dashboard.php">Employee</a></li>
                    <li><span><?php echo htmlspecialchars($breadcrumb); ?></span></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-6 clearfix">
        <div class="user-profile pull-right">
         <img class="avatar user-thumb" src="../assets/images/no_image.jpg" alt="avatar">
        <h4 class="user-name dropdown-toggle" data-toggle="dropdown"><?php include 'logged.php' ?> <i class="fa fa-angle-down"></i></h4>
         <div class="dropdown-menu">
            <a class="dropdown-item" href="my-profile.php">View Profile</a>
            <a class="dropdown-item" href="change-password-employee.php">Password</a>
            <a class="dropdown-item" href="logout.php">Log Out</a>
     </div>
</div>
        </div>
    </div>
</div>
