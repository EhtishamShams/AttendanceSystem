<?php

require "admin/user.php";
session_start();

if (!isset($_SESSION["user"])) {
    $url = "index.php";
    die('<script type="text/javascript"> window.location=\'' . $url . '\' </script>');
}

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    $url = "index.php";
    die('<script type="text/javascript"> window.location=\'' . $url . '\' </script>');
}

$servername = "localhost";
$username = "root";
$dbpassword = "root";
$dbname = "AttendanceSystem";

$conn = new mysqli($servername, $username, $dbpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error . "<br>");
}

date_default_timezone_set("Asia/Karachi");

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$time = date("H:i:s");
$date = date("Y-m-d");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["markTimeIn"])) {
    $sql = "INSERT INTO attendance(uid,date,timeIn) VALUES (".$_SESSION["user"]->getUid().", '$date', '$time')";
    if ($conn->query($sql)){
        echo '<script type="text/javascript">alert("Attendance Marked!")</script>';
        die('<script type="text/javascript"> window.location.reload() </script>');
    } else {
        echo '<script type="text/javascript">alert("Error Marking attendance: ' . $conn->error . '")</script>';
        die('<script type="text/javascript"> window.location.reload() </script>');
    }
}
elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["markTimeOut"])) {
    $sql = "UPDATE attendance SET timeOut = '$time' WHERE uid = ".$_SESSION["user"]->getUid()." AND date = '$date'";
    if ($conn->query($sql)){
        echo '<script type="text/javascript">alert("Attendance Marked!")</script>';
        die('<script type="text/javascript"> window.location.reload() </script>');
    } else {
        echo '<script type="text/javascript">alert("Error Marking attendance: ' . $conn->error . '")</script>';
        die('<script type="text/javascript"> window.location.reload() </script>');
    }
}

function checkMarkedIn(){
    global $date, $conn;
    $sql = "SELECT * FROM attendance WHERE uid = " .$_SESSION["user"]->getUid(). " AND date = '$date' AND timeIn IS NOT NULL";
    $result = $conn->query($sql);
    if ($result->num_rows > 0)
        return true;
    else
        return false;
}

function checkMarkedOut(){
    global $date, $conn;
    $sql = "SELECT * FROM attendance WHERE uid = " .$_SESSION["user"]->getUid(). " AND date = '$date' AND timeOut IS NOT NULL";
    $result = $conn->query($sql);
    if ($result->num_rows > 0)
        return true;
    else
        return false;
}

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Attendance System</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="all,follow">
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome CSS-->
    <link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css">
    <!-- Fontastic Custom icon font-->
    <link rel="stylesheet" href="css/fontastic.css">
    <!-- Google fonts - Poppins -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,700">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="css/style.default.css" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="css/custom.css">
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
</head>

<body>
<div class="page">
    <?php require "admin/header.php"; ?>

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
                                    <?php if (checkMarkedIn() || $time > "12:00:00") echo "disabled";?>></form>
                        </div>
                        <br><br>
                        <div class="col-md-6">
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <input type="submit" name="markTimeOut" value="Mark Time Out" class="btn btn-primary" <?php if (!checkMarkedIn() || checkMarkedOut()) echo "disabled";?>></form>
                        </div>
                    </div>
                </div>
            </section>



            <?php require "admin/footer.php"; ?>
        </div>
    </div>
</div>

<!-- JavaScript files-->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/popper.js/umd/popper.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="vendor/jquery.cookie/jquery.cookie.js"></script>
<script src="vendor/chart.js/Chart.min.js"></script>
<script src="vendor/jquery-validation/jquery.validate.min.js"></script>
<script src="js/charts-home.js"></script>
<!-- Main File-->
<script src="js/front.js"></script>

</body>
</html>