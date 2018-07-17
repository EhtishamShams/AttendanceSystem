<?php

require_once "../Controllers/AuthController.php";
require_once "../Controllers/UserController.php";

AuthController::authenticateAdmin();


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["deleteUid"])) {
    UserController::deleteEmp($_POST["deleteUid"]);
}
elseif ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addEmp"])) {
    UserController::addEmp($_POST["addEmail"],$_POST["addName"],$_POST["addPassword"],$_POST["addDept"],$_POST["addSalary"],$_POST["addBoss"],$_POST["addDesign"]);
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
                                            $emps = UserController::getEmployees();
                                            if ($emps != null) {
                                                $i = 1;
                                                foreach ($emps as $emp) {
                                                    echo "<tr><th scope=\"row\">$i</th>";
                                                    if ($emp->getPicUrl() != null)
                                                        echo "<td><img src='../".$emp->getPicUrl()."' class='img-fluid rounded-circle' style='max-height: 50px; width: auto;'></td>";
                                                    else
                                                        echo "<td><img src='../../public/images/sample-user.png' class='img-fluid rounded-circle' style='max-height: 50px; width: auto;'></td>";
                                                    echo "<td>" . $emp->getName() . "</td>";
                                                    echo "<td>" . $emp->getEmail() . "</td>";
                                                    echo "<td>" . $emp->getDept() . "</td>";
                                                    echo "<td>" . $emp->getSalary() . "</td>";
                                                    $boss = $emp->getBoss();
                                                    if ($boss == null)
                                                        $boss = "-";
                                                    echo "<td>$boss</td>";
                                                    echo "<td>" . $emp->getDesignation() . "</td>";
                                                    if (AuthController::getLoggedInUser()->getUid() != $emp->getUid()) {
                                                        echo "<td><a href='empEdit.php?id=" . $emp->getUid() . "' class='btn btn-primary'>Edit</a></td>";
                                                        echo "<td><form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' ><input type='hidden' name='deleteUid' value='" . $emp->getUid() . "'><input type=\"submit\" value=\"Delete\" class=\"btn btn-danger\"></form></td></tr>";
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
                                                                            $arr = UserController::getAllManagers();
                                                                            if ($arr != null) {
                                                                                foreach ($arr as $man) {
                                                                                    echo "<option value='" . $man->getUid() . "'>" . $man->getName() . "</option>";
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
                                                                <input type="submit" name="addEmp" value="Add"
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