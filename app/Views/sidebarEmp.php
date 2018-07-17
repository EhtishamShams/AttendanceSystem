<!-- Side Navbar -->
<nav class="side-navbar">
    <!-- Sidebar Header-->
    <div class="sidebar-header d-flex align-items-center">
        <div class="avatar">
            <?php
            if (AuthController::getLoggedInUser()->getPicUrl() == null){
                echo '<img src="../../public/images/sample-user.png" alt="..." class="img-fluid rounded-circle">';
            } else {
                echo '<img src="../'.AuthController::getLoggedInUser()->getPicUrl().'" alt="..." class="img-fluid rounded-circle">';
            }
            ?>
        </div>
        <div class="title">
            <h1 class="h4"><?php echo AuthController::getLoggedInUser()->getName();?></h1>
            <p><?php echo AuthController::getLoggedInUser()->getDesignation();?></p>
        </div>
    </div>
    <!-- Sidebar Navidation Menus--><span class="heading">Main</span>
    <ul class="list-unstyled">
        <li <?php if (basename($_SERVER['PHP_SELF']) =="emp.php")
            echo "class = 'active'";?>><a href="emp.php"> <i class="icon-padnote"></i>Mark Attendance</a></li>
    </ul>
</nav>