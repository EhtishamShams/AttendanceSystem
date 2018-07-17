<?php
/**
 * Created by PhpStorm.
 * User: Ehtisham
 * Date: 17/07/2018
 * Time: 15:46
 */

require_once "../Models/UserModel.php";

class UserController
{
    static function deleteEmp($uid){
        if (UserModel::deleteEmp($uid)){
            echo '<script type="text/javascript">alert("Employee Deleted Successfully!")</script>';
            die('<script type="text/javascript"> window.location.reload() </script>');
        } else {
            echo '<script type="text/javascript">alert("Error deleting employee!")</script>';
            die('<script type="text/javascript"> window.location.reload() </script>');
        }
    }

    static function addEmp($postEmail, $postName, $postPass, $postDept, $postSalary, $postBoss, $postDesign){
        $email = Input::test_input($postEmail);
        $name = Input::test_input($postName);
        $password = password_hash(Input::test_input($postPass), PASSWORD_DEFAULT);
        $dept = Input::test_input($postDept);
        $salary = Input::test_input($postSalary);
        $boss = Input::test_input($postBoss);
        $designation = Input::test_input($postDesign);

        if ($boss == -1)
            $boss = "NULL";

        if (UserModel::addEmp($email,$name,$password,$dept,$salary,$boss,$designation, $_FILES["fileInput"])){
            echo '<script type="text/javascript">alert("Added Successfully!")</script>';
            die('<script type="text/javascript"> window.location.reload() </script>');
        } else {
            echo '<script type="text/javascript">alert("Error adding employee!")</script>';
            die('<script type="text/javascript"> window.location.reload() </script>');
        }
    }

    static function updateEmp($postuid, $postEmail, $postName, $postDept, $postSalary, $postBoss, $postDesign){
        $uid = Input::test_input($postuid);
        $email = Input::test_input($postEmail);
        $name = Input::test_input($postName);
        $dept = Input::test_input($postDept);
        $salary = Input::test_input($postSalary);
        $boss = Input::test_input($postBoss);
        $designation = Input::test_input($postDesign);


        if ($boss == -1)
            $boss = "NULL";

        if (UserModel::updateEmp($uid,$email,$name,$dept,$salary,$boss,$designation,$_FILES["fileInput"])){
            echo '<script type="text/javascript">alert("Updated Successfully!")</script>';
        } else {
            echo '<script type="text/javascript">alert("Error updating record!")</script>';
        }
    }

    static function getEmployees()
    {
        return UserModel::getEmployees();
    }

    static function getAllManagers(){
        return UserModel::getAllManagers();
    }

    static function getUserDetails($uid){
        return UserModel::getUserDetails($uid);
    }
}