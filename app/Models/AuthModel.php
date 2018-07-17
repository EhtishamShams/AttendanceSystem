<?php
/**
 * Created by PhpStorm.
 * User: Ehtisham
 * Date: 17/07/2018
 * Time: 13:09
 */


require_once "../Connection.php";
require_once "../User.php";
require_once "../Input.php";

session_start();

class AuthModel
{
    static function logIn($email, $pass){
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = Connection::getDB()->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hash = $row["password"];
            if (password_verify($pass, $hash)) {
                $user = new User($row["uid"], $row["email"], $row["name"], $row["picUrl"], $row["designation"], $row["boss"], $row["dept"], $row["salary"]);
                $_SESSION["user"] = $user;
                if (strcmp($row["designation"], "HR Manager") == 0)
                    $url = "admin.php";
                else
                    $url = "emp.php";
                die('<script type="text/javascript"> window.location=\'' . $url . '\' </script>');
            } else {
                $error = true;
            }

        } else {
            $error = true;
        }
        return $error;
    }
}