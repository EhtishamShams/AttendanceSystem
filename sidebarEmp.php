<!-- Side Navbar -->
<nav class="side-navbar">
    <!-- Sidebar Header-->
    <div class="sidebar-header d-flex align-items-center">
        <div class="avatar">
            <?php
            if ($_SESSION["user"]->getPicUrl() == null){
                echo '<img src="images/sample-user.png" alt="..." class="img-fluid rounded-circle">';
            } else {
                echo '<img src="'.$_SESSION["user"]->getPicUrl().'" alt="..." class="img-fluid rounded-circle">';
            }
            ?>
        </div>
        <div class="title">
            <h1 class="h4"><?php echo $_SESSION["user"]->getName();?></h1>
            <p><?php echo $_SESSION["user"]->getDesignation();?></p>
        </div>
    </div>
    <!-- Sidebar Navidation Menus--><span class="heading">Main</span>
    <ul class="list-unstyled">
        <li <?php if (basename($_SERVER['PHP_SELF']) =="emp.php")
            echo "class = 'active'";?>><a href="emp.php"> <i class="icon-padnote"></i>Mark Attendance</a></li>
    </ul>
</nav>