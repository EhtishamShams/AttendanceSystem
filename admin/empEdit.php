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


function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uid = test_input($_POST["uid"]);
    $email = test_input($_POST["email"]);
    $name = test_input($_POST["name"]);
    $dept = test_input($_POST["dept"]);
    $salary = test_input($_POST["salary"]);
    $boss = test_input($_POST["boss"]);
    $designation = test_input($_POST["designation"]);


    if ($boss == -1)
        $boss = "NULL";

    require "upload.php";

    if (basename($_FILES["fileInput"]["name"]) == null)
        $sql = "UPDATE users SET name='$name', email='$email', dept = '$dept', salary = $salary, boss = $boss, designation = '$designation' WHERE uid = $uid";
    elseif (!$uploadOk)
        $sql = "UPDATE users SET name='$name', email='$email', dept = '$dept', salary = $salary, boss = $boss, designation = '$designation', picUrl = NULL WHERE uid = $uid";
    else
        $sql = "UPDATE users SET name='$name', email='$email', dept = '$dept', salary = $salary, boss = $boss, designation = '$designation', picUrl = '$upload_path' WHERE uid = $uid";
    if ($conn->query($sql)){
        echo '<script type="text/javascript">alert("Updated Successfully!")</script>';
    } else {
        echo '<script type="text/javascript">alert("Error updating record: ' . $conn->error . '")</script>';
    }
}

if (!isset($_GET['id'])) {
    $url = "emps.php";
    die('<script type="text/javascript"> window.location=\'' . $url . '\' </script>');
}

function getEmpDetails()
{
    global $conn;
    $sql = "SELECT * FROM users WHERE uid = " . $_GET["id"];
    $result = $conn->query($sql);
    return $result;
}

function getAllManagers(){
    global $conn;
    $sql = "SELECT * FROM users WHERE designation = 'Manager'";
    $result = $conn->query($sql);
    return $result;
}

$r = getEmpDetails();
if ($r->num_rows <= 0){
    die('<script type="text/javascript"> window.location=\'emps.php\' </script>');
}
$emp = $r->fetch_assoc();


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
                    <h2 class="no-margin-bottom">Edit Employee Details</h2>
                </div>
            </header>
            <!-- Breadcrumb-->
            <div class="breadcrumb-holder container-fluid">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item"><a href="emps.php">Employees</a></li>
                    <li class="breadcrumb-item active">Edit Employee</li>
                </ul>
            </div>

            <section class="forms">
                <div class="container-fluid">
                    <div class="row">

                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header d-flex align-items-center">
                                    <h3 class="h4">Employee Details</h3>
                                </div>
                                <div class="card-body">
                                    <p>Edit the employee information below.</p>

                                    <form class="form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
                                        <input name="uid" type="hidden" value="<?php echo $emp["uid"]?>">
                                        <div class="form-group row">
                                            <label class="col-sm-3 form-control-label">Profile Pic</label>
                                            <div class="col-sm-9">
                                                <?php

                                                if ($emp["picUrl"] == null)
                                                    echo "<img src=\"../images/sample-user.png\" class=\"img-fluid img-thumbnail rounded-circle\" style=\"max-width: 200px; height: auto;\" alt=\"Profile Pic\" >";
                                                else
                                                    echo "<img src=\"../".$emp["picUrl"]."\" class=\"img-fluid img-thumbnail rounded-circle\" style=\"max-width: 200px; height: auto;\" alt=\"Profile Pic\" >";
                                                ?>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-3 form-control-label">Name*</label>
                                            <div class="col-sm-9">
                                                <input name="name" type="text" required
                                                       placeholder="Full Name" value="<?php echo $emp["name"]?>"
                                                       class="form-control form-control-success">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 form-control-label">Email*</label>
                                            <div class="col-sm-9">
                                                <input name="email" type="email" required
                                                       placeholder="ex@example.com" value="<?php echo $emp["email"]?>"
                                                       class="form-control form-control-success">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 form-control-label">Department*</label>
                                            <div class="col-sm-9">
                                                <input name="dept" type="text" required
                                                       placeholder="e.g. HR, IT" value="<?php echo $emp["dept"]?>"
                                                       class="form-control form-control-success">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 form-control-label">Salary*</label>
                                            <div class="col-sm-9">
                                                <input name="salary" type="number" min="0" required
                                                       placeholder="e.g. 500000" value="<?php echo $emp["salary"]?>"
                                                       class="form-control form-control-success">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-3 form-control-label">Boss*</label>
                                            <div class="col-sm-9">
                                                <select name="boss" class="form-control btn btn-outline-secondary">
                                                    <option value="-1">None</option>
                                                    <?php
                                                    if ($emp["designation"] == "Developer") {
                                                        $result = getAllManagers();
                                                        if ($result->num_rows > 0) {
                                                            while ($row = $result->fetch_assoc()) {
                                                                if ($emp["boss"] == $row["uid"])
                                                                    echo "<option value='" . $row["uid"] . "' selected>" . $row["name"] . "</option>";
                                                                else
                                                                    echo "<option value='" . $row["uid"] . "'>" . $row["name"] . "</option>";
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 form-control-label">Designation*</label>
                                            <div class="col-sm-9">
                                                <select name="designation" class="form-control btn btn-outline-secondary">
                                                    <option value="Developer"
                                                        <?php if ($emp["designation"] == "Developer") echo "selected"?>>Developer</option>
                                                    <option value="Manager" class="dropdown-item"
                                                        <?php if ($emp["designation"] == "Manager") echo "selected"?>>Manager</option>
                                                    <option value="HR Manager" class="dropdown-item"
                                                        <?php if ($emp["designation"] == "HR Manager") echo "selected"?>>HR Manager</option>
                                                    <option value="CEO" class="dropdown-item"
                                                        <?php if ($emp["designation"] == "CEO") echo "selected"?>>CEO</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="fileInput" class="col-sm-3 form-control-label">Profile Pic</label>
                                            <div class="col-sm-9">
                                                <input id="fileInput" name="fileInput" type="file" class="form-control-file">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-9 offset-sm-3">
                                                <input type="submit" value="Update" class="btn btn-primary">
                                            </div>
                                        </div>
                                    </form>
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