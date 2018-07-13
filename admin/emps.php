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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["deleteUid"])) {
    $sql = "DELETE FROM users WHERE uid = " .$_POST["deleteUid"];
    if ($conn->query($sql)){
        echo '<script type="text/javascript">alert("Employee Deleted Successfully!")</script>';
        die('<script type="text/javascript"> window.location.reload() </script>');
    } else {
        echo '<script type="text/javascript">alert("Error deleting employee: ' . $conn->error . '")</script>';
        die('<script type="text/javascript"> window.location.reload() </script>');
    }
}
elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = test_input($_POST["addEmail"]);
    $name = test_input($_POST["addName"]);
    $password = password_hash(test_input($_POST["addPassword"]), PASSWORD_DEFAULT);
    $dept = test_input($_POST["addDept"]);
    $salary = test_input($_POST["addSalary"]);
    $boss = test_input($_POST["addBoss"]);
    $designation = test_input($_POST["addDesign"]);


    if ($boss == -1)
        $boss = "NULL";

    require "upload.php";

    if (basename($_FILES["fileInput"]["name"]) == null || !$uploadOk)
        $sql = "INSERT INTO users (name, email, dept, salary, boss, designation, password) VALUES ('$name', '$email', '$dept', $salary, $boss, '$designation', '$password')";
    else
        $sql = "INSERT INTO users (name, email, dept, salary, boss, designation, picUrl, password) VALUES ('$name', '$email', '$dept', $salary, $boss, '$designation', '$upload_path', '$password')";
    if ($conn->query($sql)){
        echo '<script type="text/javascript">alert("Added Successfully!")</script>';
        die('<script type="text/javascript"> window.location.reload() </script>');
    } else {
        echo '<script type="text/javascript">alert("Error adding employee: ' . $conn->error . '")</script>';
        die('<script type="text/javascript"> window.location.reload() </script>');
    }
}


function getEmployees()
{
    global $conn;
    $sql = "SELECT u.*, uu.name AS bossName FROM users u LEFT JOIN users uu ON u.boss = uu.uid ORDER BY u.name";
    $result = $conn->query($sql);
    return $result;
}

function getAllManagers(){
    global $conn;
    $sql = "SELECT * FROM users WHERE designation = 'Manager'";
    $result = $conn->query($sql);
    return $result;
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
                    <h2 class="no-margin-bottom">Employees</h2>
                </div>
            </header>
            <!-- Breadcrumb-->
            <div class="breadcrumb-holder container-fluid">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li class="breadcrumb-item active">Employees</li>
                </ul>
            </div>
            <br>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <button type="button" data-toggle="modal" data-target="#addModal" class="btn btn-primary"
                                style="float: right">Add Employee
                        </button>
                    </div>
                </div>
            </div>
            <br>
            <section class="tables no-padding-top">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">

                                <div class="card-header d-flex align-items-center">
                                    <h3 class="h4">Employees</h3>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Profile Pic</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Department</th>
                                                <th>Salary</th>
                                                <th>Boss</th>
                                                <th>Designation</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>

                                            <?php
                                            $result = getEmployees();
                                            if ($result->num_rows > 0) {
                                                $i = 1;
                                                while ($row = $result->fetch_assoc()) {

                                                    echo "<tr><th scope=\"row\">$i</th>";
                                                    if ($row["picUrl"] != null)
                                                        echo "<td><img src='../".$row["picUrl"]."' class='img-fluid rounded-circle' style='max-height: 50px; width: auto;'></td>";
                                                    else
                                                        echo "<td><img src='../images/sample-user.png' class='img-fluid rounded-circle' style='max-height: 50px; width: auto;'></td>";
                                                    echo "<td>" . $row["name"] . "</td>";
                                                    echo "<td>" . $row["email"] . "</td>";
                                                    echo "<td>" . $row["dept"] . "</td>";
                                                    echo "<td>" . $row["salary"] . "</td>";
                                                    $boss = $row["bossName"];
                                                    if ($boss == null)
                                                        $boss = "-";
                                                    echo "<td>$boss</td>";
                                                    echo "<td>" . $row["designation"] . "</td>";
                                                    if ($_SESSION["user"]->getUid() != $row["uid"]) {
                                                        echo "<td><a href='empEdit.php?id=" . $row["uid"] . "' class='btn btn-primary'>Edit</a></td>";
                                                        echo "<td><form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' ><input type='hidden' name='deleteUid' value='" . $row["uid"] . "'><input type=\"submit\" value=\"Delete\" class=\"btn btn-danger\"></form></td></tr>";
                                                    } else {
                                                        echo "<td></td><td></td></tr>";
                                                    }
                                                    $i++;
                                                }
                                            }
                                            ?>

                                            </tbody>


                                            <!-- Modal-->
                                            <div id="addModal" tabindex="-1" role="dialog"
                                                 aria-labelledby="addModalLabel" aria-hidden="true"
                                                 class="modal fade text-left">
                                                <div role="document" class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 id="exampleModalLabel" class="modal-title">Add Employee</h4>
                                                            <button type="button" data-dismiss="modal"
                                                                    aria-label="Close" class="close"><span
                                                                        aria-hidden="true">×</span></button>
                                                        </div>
                                                        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">
                                                            <div class="modal-body">
                                                                <p>Add New Employee.</p>
                                                                <div class="form-group">
                                                                    <label>Name*</label>
                                                                    <input type="text" placeholder="Full Name" name="addName"
                                                                           class="form-control" id="addName" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Email*</label>
                                                                    <input type="email" placeholder="e.g. ex@example.com" name="addEmail"
                                                                           class="form-control" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Password*</label>
                                                                    <input type="password" placeholder="Password" name="addPassword"
                                                                           class="form-control" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Department*</label>
                                                                    <input type="text" placeholder="e.g. HR, IT" name="addDept"
                                                                           class="form-control" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label>Salary*</label>
                                                                    <input type="number" placeholder="e.g. 500000" name="addSalary"
                                                                           class="form-control" min="0" required>
                                                                </div>
                                                                <div class="form-group select">
                                                                    <label>Boss*</label>
                                                                    <select name="addBoss" class="form-control">
                                                                        <option value="-1">None</option>
                                                                        <?php
                                                                            $result = getAllManagers();
                                                                            if ($result->num_rows > 0) {
                                                                                while ($row = $result->fetch_assoc()) {
                                                                                    echo "<option value='" . $row["uid"] . "'>" . $row["name"] . "</option>";
                                                                                }
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group select">
                                                                    <label>Designation*</label>
                                                                    <select name="addDesign" class="form-control">
                                                                        <option value="Developer">Developer</option>
                                                                        <option value="Manager">Manager</option>
                                                                        <option value="HR Manager">HR Manager</option>
                                                                        <option value="CEO">CEO</option>

                                                                    </select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label>Profile Pic</label>
                                                                    <input id="fileInput" name="fileInput" type="file" class="form-control-file">
                                                                </div>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" data-dismiss="modal"
                                                                        class="btn btn-secondary">Close
                                                                </button>
                                                                <input type="submit" value="Add"
                                                                       class="btn btn-primary">
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
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