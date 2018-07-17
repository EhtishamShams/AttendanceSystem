<?php

require_once "../Controllers/AuthController.php";
require_once "../Controllers/UserController.php";

AuthController::authenticateAdmin();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    UserController::updateEmp($_POST["uid"],$_POST["email"],$_POST["name"],$_POST["dept"],$_POST["salary"],$_POST["boss"],$_POST["designation"]);
}

if (!isset($_GET['id'])) {
    $url = "emps.php";
    die('<script type="text/javascript"> window.location=\'' . $url . '\' </script>');
}

$emp = UserController::getUserDetails($_GET["id"]);
if ($emp == null){
    die('<script type="text/javascript"> window.location=\'emps.php\' </script>');
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
                                        <input name="uid" type="hidden" value="<?php echo $emp->getUid()?>">
                                        <div class="form-group row">
                                            <label class="col-sm-3 form-control-label">Profile Pic</label>
                                            <div class="col-sm-9">
                                                <?php

                                                if ($emp->getPicUrl() == null)
                                                    echo "<img src=\"../../images/sample-user.png\" class=\"img-fluid img-thumbnail rounded-circle\" style=\"max-width: 200px; height: auto;\" alt=\"Profile Pic\" >";
                                                else
                                                    echo "<img src=\"../".$emp->getPicUrl()."\" class=\"img-fluid img-thumbnail rounded-circle\" style=\"max-width: 200px; height: auto;\" alt=\"Profile Pic\" >";
                                                ?>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-3 form-control-label">Name*</label>
                                            <div class="col-sm-9">
                                                <input name="name" type="text" required
                                                       placeholder="Full Name" value="<?php echo $emp->getName()?>"
                                                       class="form-control form-control-success">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 form-control-label">Email*</label>
                                            <div class="col-sm-9">
                                                <input name="email" type="email" required
                                                       placeholder="ex@example.com" value="<?php echo $emp->getEmail()?>"
                                                       class="form-control form-control-success">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 form-control-label">Department*</label>
                                            <div class="col-sm-9">
                                                <input name="dept" type="text" required
                                                       placeholder="e.g. HR, IT" value="<?php echo $emp->getDept()?>"
                                                       class="form-control form-control-success">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 form-control-label">Salary*</label>
                                            <div class="col-sm-9">
                                                <input name="salary" type="number" min="0" required
                                                       placeholder="e.g. 500000" value="<?php echo $emp->getSalary()?>"
                                                       class="form-control form-control-success">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-3 form-control-label">Boss*</label>
                                            <div class="col-sm-9">
                                                <select name="boss" class="form-control btn btn-outline-secondary">
                                                    <option value="-1">None</option>
                                                    <?php
                                                        $arr = UserController::getAllManagers();
                                                        if ($arr != null) {
                                                            foreach ($arr as $man) {
                                                                if ($emp->getBoss() == $man->getUid())
                                                                    echo "<option value='" . $man->getUid() . "' selected>" . $man->getName() . "</option>";
                                                                else
                                                                    echo "<option value='" . $man->getUid() . "'>" . $man->getName() . "</option>";
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
                                                        <?php if ($emp->getDesignation() == "Developer") echo "selected"?>>Developer</option>
                                                    <option value="Manager" class="dropdown-item"
                                                        <?php if ($emp->getDesignation() == "Manager") echo "selected"?>>Manager</option>
                                                    <option value="HR Manager" class="dropdown-item"
                                                        <?php if ($emp->getDesignation() == "HR Manager") echo "selected"?>>HR Manager</option>
                                                    <option value="CEO" class="dropdown-item"
                                                        <?php if ($emp->getDesignation() == "CEO") echo "selected"?>>CEO</option>
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