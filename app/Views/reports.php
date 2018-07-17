<?php

require_once "../Controllers/AuthController.php";
require_once "../Controllers/AttendanceController.php";

AuthController::authenticateAdmin();

date_default_timezone_set("Asia/Karachi");

$months = array("January", "February", "March", "April", "May", "June", "July",
    "August", "September", "October", "November", "December");

$wrongInput = false;
$dataFound = true;
$report;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["month"] != -1 && $_POST["year"] != -1){
        $report = AttendanceController::getMonthlyReport($_POST["month"],$_POST["year"]);
        if ($report == null){
            $dataFound = false;
        }
    }
    else {
        $wrongInput = true;
    }
}


?>


<!DOCTYPE html>
<html>
<head>
    <?php require "headFiles.html"?>
</head>

<body>
<div class="page">
    <?php require "header.php"; ?>

    <div class="page-content d-flex align-items-stretch">

        <?php require "sidebar.php"; ?>

        <div class="content-inner">
            <!-- Page Header-->
            <header class="page-header">
                <div class="container-fluid">
                    <h2 class="no-margin-bottom">Reports</h2>
                </div>
            </header>
            <!-- Breadcrumb-->
            <div class="breadcrumb-holder container-fluid">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">Reports</li>
                </ul>
            </div>
            <section>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <div class="form-group row">
                                        <label class="col col-form-label text-sm-right">Select Month: </label>
                                    <div class="col">
                                        <select name="month" class="form-control">
                                            <option value="-1">Month</option>
                                            <?php

                                            for ($i = 0; $i < sizeof($months); $i++){
                                                echo "<option value='". ($i+1) ."'>".$months[$i]."</option>";
                                            }

                                            ?>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <select name="year" class="form-control">
                                            <option value="-1">Year</option>
                                            <?php
                                            $yr = date("Y");
                                            while ($yr >= 1900) {
                                                echo "<option value='$yr'>$yr</option>";
                                                $yr--;
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <input type="submit" value="Go" class="btn btn-primary">
                                    </div>
                                </div>
                            </form>
                            <?php
                            if ($wrongInput) {
                                echo "<div class='text-center p-t-12'>
                                    <span class='txt2 alert alert-danger'>
                                    Please select both month and year!
                                    </span>
                                    </div>";
                            }
                            elseif (!$dataFound){
                                echo "<div class='text-center p-t-12'>
                                    <span class='txt2 alert alert-danger'>
                                    No results for the given month!
                                    </span>
                                    </div>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </section>

            <?php
            if (!$wrongInput && $_SERVER["REQUEST_METHOD"] == "POST" && $dataFound)
                require "monthlyAttend.php";
            ?>


            <?php require "footer.php"; ?>
        </div>
    </div>
</div>

<?php require "scriptFiles.html" ?>

</body>
</html>