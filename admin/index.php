
<?php

require "user.php";
session_start();

if (!isset($_SESSION["user"])){
    $url = "..";
    die('<script type="text/javascript"> window.location=\''.$url.'\' </script>');
} elseif (strcmp($_SESSION["user"]->getDesignation(), "HR Manager") != 0){
    $url = "..";
    die('<script type="text/javascript"> window.location=\''.$url.'\' </script>');
}

if(isset($_GET['logout']))
{
    session_unset();
    session_destroy();
    die('<script type="text/javascript"> window.location=\''.$url.'\' </script>');
}

$servername = "localhost";
$username = "root";
$dbpassword = "root";
$dbname = "AttendanceSystem";

// Create connection
$conn = new mysqli($servername, $username, $dbpassword, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error . "<br>");
}


function getAttendances(){
    global $conn;
    $sql = "SELECT a.*, u.uid, u.name FROM (SELECT * FROM attendance WHERE date = CURRENT_DATE) AS a RIGHT JOIN users AS u ON a.uid = u.uid ORDER BY u.name";
    $result = $conn->query($sql);
    return $result;
}

function getTotalEmpCount(){
    global $conn;
    $sql = "SELECT COUNT(*) AS count FROM users";
    $result = $conn->query($sql);
    $count = 0;
    if ($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $count = $row["count"];
    }
    return $count;
}

function getTotalPresent(){
    global $conn;
    $sql = "SELECT COUNT(*) AS count FROM (SELECT * FROM attendance WHERE timeIn IS NOT NULL AND date = CURRENT_DATE) a JOIN users u ON u.uid = a.uid";
    $result = $conn->query($sql);
    $count = 0;
    if ($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $count = $row["count"];
    }
    return $count;
}

function getTotalLate(){
    global $conn;
    $sql = "SELECT COUNT(*) AS count FROM (SELECT * FROM attendance WHERE timeIn IS NOT NULL AND timeIn > '11:00' AND date = CURRENT_DATE) a JOIN users u ON u.uid = a.uid";
    $result = $conn->query($sql);
    $count = 0;
    if ($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $count = $row["count"];
    }
    return $count;
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
                                        echo getTotalEmpCount();
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
                                        echo getTotalEmpCount() - getTotalPresent();
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
                                        echo getTotalPresent();
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
                                        echo getTotalLate();
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
                                                $result = getAttendances();
                                                if ($result->num_rows > 0) {
                                                    $i = 1;
                                                    while($row = $result->fetch_assoc()){
                                                        echo "<tr><th scope=\"row\">$i</th>";
                                                        echo "<td><a href='empEdit.php?id=".$row["uid"]."' >".$row["name"]."</a></td>";
                                                        $timeIn = $row["timeIn"];
                                                        if ($timeIn == null)
                                                            $timeIn = "-";
                                                        $timeOut = $row["timeOut"];
                                                        if($timeOut == null)
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