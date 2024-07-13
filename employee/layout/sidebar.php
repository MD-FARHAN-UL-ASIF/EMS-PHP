<nav>
    <ul class="metismenu" id="menu">
        <li class="<?php if($page == 'dashboard') { echo 'active'; } ?>">
            <a href="dashboard.php"><i class="ti-dashboard"></i> <span>Dashboard</span></a>
        </li>
        
        <li class="has-submenu <?php if($page == 'leave' || $page == 'apply_leave' || $page == 'leave_history') { echo 'active'; } ?>">
            <a href="javascript:void(0)" aria-expanded="true"><i class="ti-id-badge"></i> <span>My Leave</span></a>
            <ul class="submenu <?php if($page == 'leave' || $page == 'apply_leave') { echo 'in'; } ?>">
                <li class="<?php if($page == 'leave') { echo 'active'; } ?>"><a href="leave.php">Leave History</a></li>
                <li class="<?php if($page == 'apply_leave') { echo 'active'; } ?>"><a href="apply_leave.php">Apply Leave</a></li>
            </ul>
        </li>

        <li class="has-submenu <?php if($page == 'pending_project' || $page == 'submitted_project' || $page == 'all_project') { echo 'active'; } ?>">
            <a href="javascript:void(0)" aria-expanded="true"><i class="ti-id-badge"></i> <span>My Project</span></a>
            <ul class="submenu <?php if($page == 'pending_project' || $page == 'submitted_project' || $page == 'all_project') { echo 'in'; } ?>">
                <li class="<?php if($page == 'pending_project') { echo 'active'; } ?>"><a href="pending_project.php"><i class="fa fa-spinner"></i> Pending Project</a></li>
                <li class="<?php if($page == 'submitted_project') { echo 'active'; } ?>"><a href="submitted_project.php"><i class="fa fa-check"></i> Submitted Project</a></li>
                <li class="<?php if($page == 'all_project') { echo 'active'; } ?>"><a href="all_project.php">Project History</a></li>
            </ul>
        </li>
    </ul>
</nav>
