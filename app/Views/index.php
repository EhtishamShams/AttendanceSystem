<!DOCTYPE html>
<html lang="en">

<?php

    require_once "../Controllers/AuthController.php";
    AuthController::checkLogin();

    $mismatchErr = false;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $mismatchErr = AuthController::logIn($_POST["email"], $_POST["pass"]);
    }
?>

<head>
    <title>Login</title>

    <?php require_once "styleSheets2.html"; ?>

</head>
<body>

<div class="limiter">
    <div class="container-login100">
        <div class="wrap-login100">
            <div class="login100-pic js-tilt" data-tilt>
                <img src="../../public/images/img-01.png" alt="IMG">
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



<?php require_once "scripts2.html"; ?>


</body>
</html>