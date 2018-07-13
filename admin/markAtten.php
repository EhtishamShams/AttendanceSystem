<?php

require "user.php";
session_start();

if (!isset($_SESSION["user"])) {
//    echo "Session var not set<br>";
    $url = "..";
    die('<script type="text/javascript"> window.location=\'' . $url . '\' </script>');
} elseif (strcmp($_SESSION["user"]->getDesignation(), "HR Manager") != 0) {
    $url = "..";
    die('<script type="text/javascript"> window.location=\'' . $url . '\' </script>');
}

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    die('<script type="text/javascript"> window.location=\'' . $url . '\' </script>');
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
                    <h2 class="no-margin-bottom">Mark Attendance</h2>
                </div>
            </header>
            <!-- Breadcrumb-->
            <div class="breadcrumb-holder container-fluid">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">Mark Attendance</li>
                </ul>
            </div>
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



            <?php require "footer.php"; ?>
        </div>
    </div>
</div>

<?php require "scriptFiles.html" ?>

</body>
</html>