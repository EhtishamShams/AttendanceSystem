<?php
/**
 * Created by PhpStorm.
 * User: Ehtisham
 * Date: 17/07/2018
 * Time: 15:46
 */

require_once "../Connection.php";
require_once "../User.php";
require_once "../Input.php";
require_once "../File.php";

class UserModel
{
    static function deleteEmp($uid){

        $sql = "DELETE FROM users WHERE uid = " .$uid;
        if (Connection::getDB()->query($sql)){
            return true;
        } else {
            return false;
        }
    }

    static function addEmp($email, $name, $password, $dept, $salary, $boss, $designation, $fileInput){

        $up = File::upload($fileInput, $email);

        if (basename($fileInput["name"]) == null || !$up[0])
            $sql = "INSERT INTO users (name, email, dept, salary, boss, designation, password) VALUES ('$name', '$email', '$dept', $salary, $boss, '$designation', '$password')";
        else
            $sql = "INSERT INTO users (name, email, dept, salary, boss, designation, picUrl, password) VALUES ('$name', '$email', '$dept', $salary, $boss, '$designation', '".$up[1]."', '$password')";
        if (Connection::getDB()->query($sql)){
            return true;
        } else {
            return false;
        }
    }

    static function updateEmp($uid, $email, $name, $dept, $salary, $boss, $designation, $fileInput){

        $up = File::upload($fileInput, $email);

        if (basename($fileInput["name"]) == null)
            $sql = "UPDATE users SET name='$name', email='$email', dept = '$dept', salary = $salary, boss = $boss, designation = '$designation' WHERE uid = $uid";
        elseif (!up[0])
            $sql = "UPDATE users SET name='$name', email='$email', dept = '$dept', salary = $salary, boss = $boss, designation = '$designation', picUrl = NULL WHERE uid = $uid";
        else
            $sql = "UPDATE users SET name='$name', email='$email', dept = '$dept', salary = $salary, boss = $boss, designation = '$designation', picUrl = '$up[1]' WHERE uid = $uid";
        if (Connection::getDB()->query($sql)){
            return true;
        } else {
            return false;
        }
    }

    static function getEmployees()
    {
        $sql = "SELECT u.*, uu.name AS bossName FROM users u LEFT JOIN users uu ON u.boss = uu.uid ORDER BY u.name";
        $result = Connection::getDB()->query($sql);
        if ($result->num_rows > 0){
            $arr= array();
            while($row = $result->fetch_assoc()){
                array_push($arr, new User($row["uid"],$row["email"],$row["name"],$row["picUrl"], $row["designation"],$row["bossName"],$row["dept"],$row["salary"]));
            }
            return $arr;

        } else {
            return null;
        }
    }

    static function getAllManagers(){
        $sql = "SELECT * FROM users WHERE designation = 'Manager'";
        $result = Connection::getDB()->query($sql);
        if ($result->num_rows > 0){
            $arr= array();
            while($row = $result->fetch_assoc()){
                array_push($arr, new User($row["uid"],$row["email"],$row["name"],$row["picUrl"], $row["designation"],$row["boss"],$row["dept"],$row["salary"]));
            }
            return $arr;
        } else {
            return null;
        }
    }

    static function getUserDetails($uid){
        $sql = "SELECT * FROM users WHERE uid = $uid";
        $result = Connection::getDB()->query($sql);
        if ($result->num_rows > 0){
            $row = $result->fetch_assoc();
            return new User($row["uid"],$row["email"],$row["name"],$row["picUrl"], $row["designation"],$row["boss"],$row["dept"],$row["salary"]);
        }
        else
            return null;
    }
}