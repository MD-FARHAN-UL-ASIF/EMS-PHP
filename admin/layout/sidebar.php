<nav>
        <ul class="metismenu" id="menu">
        <li class="<?php if($page=='dashboard') {echo 'active';} ?>"><a href="dashboard.php"><i class="ti-dashboard"></i> <span>Dashboard</span></a></li>
                            
        <li class="<?php if($page=='employee') {echo 'active';} ?>"><a href="employee.php"><i class="ti-id-badge"></i> <span>Employee Section</span></a></li>
                        
        <li class="<?php if($page=='department') {echo 'active';} ?>"><a href="department.php"><i class="fa fa-th-large"></i> <span>Department Section</span></a></li>

        <li class="<?php if($page=='manage-leave') {echo 'active';} ?>">
            <a href="javascript:void(0)" aria-expanded="true"><i class="ti-briefcase"></i><span>Manage Leave</span></a>

            <ul class="collapse">
                <li ><a href="pending_leave.php"><i class="fa fa-spinner"></i> Pending</a></li>
                <li ><a href="approved_leave.php"><i class="fa fa-check"></i> Approved</a></li>
                <li ><a href="declined_leave.php"><i class="fa fa-times-circle"></i> Declined</a></li>
                <li ><a href="all_leave.php"><i class="fa fa-history"></i> Leave History</a></li>
            </ul>
            
        </li>

        <li class="<?php if($page=='manage-admin') {echo 'active';} ?>"><a href="manage-admin.php"><i class="fa fa-lock"></i> <span>Manage Admin</span></a></li>
                            
    </ul>
</nav>