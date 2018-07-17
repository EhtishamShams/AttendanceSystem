<?php
/**
 * Created by PhpStorm.
 * User: Ehtisham
 * Date: 17/07/2018
 * Time: 13:09
 */

require_once "../User.php";
require_once "../Input.php";
require_once "../Models/AuthModel.php";

session_start();

class AuthController
{
    static function authenticate(){
        if (!isset($_SESSION["user"])) {
            $url = "index.php";
            die('<script type="text/javascript"> window.location=\'' . $url . '\' </script>');
        }
    }

    static function authenticateAdmin(){
        self::authenticate();
        if (strcmp($_SESSION["user"]->getDesignation(), "HR Manager") != 0){
            $url = "index.php";
            die('<script type="text/javascript"> window.location=\''.$url.'\' </script>');
        }
    }

    static function checkLogin(){
        if (isset($_SESSION["user"])){
            if (strcmp($_SESSION["user"]->getDesignation(), "HR Manager") == 0)
                $url = "admin.php";
            else
                $url = "emp.php";
            die('<script type="text/javascript"> window.location=\''.$url.'\' </script>');
        }
    }

    static function getLoggedInUser(){
        return $_SESSION["user"];
    }

    static function logOut(){
        session_unset();
        session_destroy();
        die('<script type="text/javascript"> window.location ="index.php" </script>');
    }

    static function logIn($postEmail, $postPass){
        $email = $pass = "";
        $error = false;
        if (empty($postEmail)) {
            $error = true;
        } else {
            $email = Input::test_input($postEmail);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = true;
            }
        }

        if (empty($postPass)) {
            $error = true;
        } else {
            $pass = Input::test_input($postPass);
        }

        if (!$error) {

            $error = AuthModel::logIn($email,$pass);
        }

        return $error;
    }


}

if (isset($_GET['logout'])) {
    AuthController::logOut();
}