<?php

require_once "../Controllers/AuthController.php";
require_once "../Controllers/AttendanceController.php";

AuthController::authenticateAdmin();

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
                    <h2 class="no-margin-bottom">Dashboard</h2>
                </div>
            </header>
            <!-- Dashboard Counts Section-->
            <section class="dashboard-counts no-padding-bottom">
                <div class="container-fluid">
                    <div class="row bg-white has-shadow">
                        <!-- Item -->
                        <div class="col-xl-3 col-sm-6">
                            <div class="item d-flex align-items-center">
                                <div class="icon bg-violet"><i class="icon-user"></i></div>
                                <div class="title"><span>Total<br>Emps</span>
                                </div>
                                <div class="number"><strong>
                                        <?php
                                        echo AttendanceController::getTotalEmpCount();
                                        ?>
                                    </strong></div>
                            </div>
                        </div>
                        <!-- Item -->
                        <div class="col-xl-3 col-sm-6">
                            <div class="item d-flex align-items-center">
                                <div class="icon bg-red"><i class="icon-padnote"></i></div>
                                <div class="title"><span>Absent<br>Today</span>
                                </div>
                                <div class="number"><strong><?php
                                        echo (AttendanceController::getTotalAbsentToday());
                                        ?></strong></div>
                            </div>
                        </div>
                        <!-- Item -->
                        <div class="col-xl-3 col-sm-6">
                            <div class="item d-flex align-items-center">
                                <div class="icon bg-green"><i class="icon-bill"></i></div>
                                <div class="title"><span>Present<br>Today</span>

                                </div>
                                <div class="number"><strong><?php
                                        echo AttendanceController::getTotalPresentToday();
                                        ?></strong></div>
                            </div>
                        </div>
                        <!-- Item -->
                        <div class="col-xl-3 col-sm-6">
                            <div class="item d-flex align-items-center">
                                <div class="icon bg-orange"><i class="icon-check"></i></div>
                                <div class="title"><span>Late<br>Today</span>
                                </div>
                                <div class="number"><strong><?php
                                        echo AttendanceController::getTotalLateToday();
                                        ?></strong></div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="tables">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">

                                <div class="card-header d-flex align-items-center">
                                    <h3 class="h4">Today's Attendance</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Time In</th>
                                                <th>Time Out</th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            <?php
                                            $arr = AttendanceController::getAttendances();
                                            $i = 1;
                                            if ($arr != null) {
                                                foreach ($arr as $attend) {
                                                    echo "<tr><th scope=\"row\">$i</th>";
                                                    echo "<td><a href='empEdit.php?id=" . $attend->getUid() . "' >" . $attend->getName() . "</a></td>";
                                                    $timeIn = $attend->getTimeIn();
                                                    if ($timeIn == null)
                                                        $timeIn = "-";
                                                    $timeOut = $attend->getTimeOut();
                                                    if ($timeOut == null)
                                                        $timeOut = "-";
                                                    echo "<td>$timeIn</td>";
                                                    echo "<td>$timeOut</td></tr>";
                                                    $i++;
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
            </section>



            <?php require "footer.php"; ?>
        </div>
    </div>
</div>

<?php require "scriptFiles.html" ?>

</body>
</html>