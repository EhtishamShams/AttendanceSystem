<?php


require_once "../Controllers/AuthController.php";
require_once "../Controllers/AttendanceController.php";

AuthController::authenticate();

date_default_timezone_set("Asia/Karachi");

$time = date("H:i:s");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["markTimeIn"])) {
    AttendanceController::markIn();
}
elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["markTimeOut"])) {
    AttendanceController::markOut();
}

?>


<!DOCTYPE html>
<html>
<head>
    <?php require_once "headFiles.html"; ?>
</head>

<body>
<div class="page">
    <?php require "header.php"; ?>

    <div class="page-content d-flex align-items-stretch">

        <?php require "sidebarEmp.php"; ?>

        <div class="content-inner">
            <!-- Page Header-->
            <header class="page-header">
                <div class="container-fluid">
                    <h2 class="no-margin-bottom">Mark Attendance</h2>
                </div>
            </header>
            <section>
                <div class="container-fluid">
                    <div class="row">

                        <div class="col-md-6 text-md-right">
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <input type="submit" name="markTimeIn" value="Mark Time In" class="btn btn-primary"
                                    <?php if (AttendanceController::checkMarkedIn() || $time > "12:00:00") echo "disabled";?>></form>
                        </div>
                        <br><br>
                        <div class="col-md-6">
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <input type="submit" name="markTimeOut" value="Mark Time Out" class="btn btn-primary" <?php if (!AttendanceController::checkMarkedIn() || AttendanceController::checkMarkedOut()) echo "disabled";?>></form>
                        </div>
                    </div>
                </div>
            </section>



            <?php require "footer.php"; ?>
        </div>
    </div>
</div>

<?php require_once "scriptFiles.html"; ?>

</body>
</html>