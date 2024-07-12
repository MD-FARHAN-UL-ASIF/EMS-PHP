<nav>
    <ul class="metismenu" id="menu">
        <li class="<?php if($page == 'dashboard') { echo 'active'; } ?>">
            <a href="dashboard.php"><i class="ti-dashboard"></i> <span>Dashboard</span></a>
        </li>
        
        <li class="has-submenu <?php if($page == 'leave' || $page == 'apply_leave') { echo 'active'; } ?>">
            <a href="javascript:void(0)" aria-expanded="true"><i class="ti-id-badge"></i> <span>My Leave</span></a>
            <ul class="submenu <?php if($page == 'leave') { echo 'in'; } ?>">
                <li class="<?php if($page == 'leave' ) { echo 'active'; } ?>"><a href="leave.php">Leave History</a></li>
                <li class="<?php if($page == 'apply_leave') { echo 'active'; } ?>"><a href="apply_leave.php">Apply Leave</a></li>
            </ul>
        </li>
    </ul>
</nav>
