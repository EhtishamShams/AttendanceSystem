<!DOCTYPE html>
<html lang="en">

<?php

    require "admin/user.php";
    session_start();

    if (isset($_SESSION["user"])){
        if (strcmp($_SESSION["user"]->getDesignation(), "HR Manager") == 0)
            $url = "admin";
        else
            $url = "emp.php";
        die('<script type="text/javascript"> window.location=\''.$url.'\' </script>');
    }

    $servername = "localhost";
    $username = "root";
    $dbpassword = "root";
    $dbname = "AttendanceSystem";

    $conn = new mysqli($servername, $username, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error . "<br>");
    }


    $emailErr = $passErr = "";
    $mismatchErr = false;
    $email = $pass = "";
    $error = false;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (empty($_POST["email"])) {
            $emailErr = "Email is required";
            $error = true;
        } else {
            $email = test_input($_POST["email"]);
            // check if e-mail address is well-formed
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format";
                $error = true;
            }
        }

        if (empty($_POST["pass"])) {
            $passErr = "Password is required";
            $error = true;
        } else {
            $pass = test_input($_POST["pass"]);
        }

    }

    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }



    if (!$error && $_SERVER["REQUEST_METHOD"] == "POST") {

        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hash = $row["password"];
            if (password_verify($pass, $hash)) {
                $user = new User($row["uid"], $row["email"], $row["name"], $row["picUrl"], $row["designation"]);
                $_SESSION["uid"] = $row['uid'];
                $_SESSION["user"] = $user;
                if (strcmp($row["designation"], "HR Manager") == 0)
                    $url = "admin";
                else
                    $url = "emp.php";
                die('<script type="text/javascript"> window.location=\'' . $url . '\' </script>');
            } else {
                $mismatchErr = true;
            }

        } else {
            $mismatchErr = true;
        }
    }

    $conn->close();

?>

<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!--===============================================================================================-->
</head>
<body>

<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100">
            <div class="login100-pic js-tilt" data-tilt>
                <img src="images/img-01.png" alt="IMG">
            </div>

            <form class="login100-form validate-form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					<span class="login100-form-title">
						Member Login
					</span>

                <div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
                    <input class="input100" type="text" name="email" placeholder="Email">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
                </div>

                <div class="wrap-input100 validate-input" data-validate = "Password is required">
                    <input class="input100" type="password" name="pass" placeholder="Password">
                    <span class="focus-input100"></span>
                    <span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
                </div>


                <?php
                    if ($mismatchErr) {
                        echo "<div class='text-center p-t-12'>
                            <span class='txt2 alert alert-danger'>
                                Email/Password Incorrect!
                            </span>
                            </div>";
                    }
                ?>

                <div class="container-login100-form-btn">
                    <button class="login100-form-btn">
                        Login
                    </button>
                </div>

                <div class="text-center p-t-136">

                </div>
            </form>
        </div>
    </div>
</div>




<!--===============================================================================================-->
<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/bootstrap/js/popper.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
<script src="vendor/tilt/tilt.jquery.min.js"></script>
<script >
    $('.js-tilt').tilt({
        scale: 1.1
    })
</script>
<!--===============================================================================================-->
<script src="js/main.js"></script>

</body>
</html>