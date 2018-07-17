<?php
/**
 * Created by PhpStorm.
 * User: Ehtisham
 * Date: 17/07/2018
 * Time: 13:24
 */

require_once "../Connection.php";
require_once "../Attend.php";
require_once "../User.php";
require_once "../AttenReport.php";

date_default_timezone_set("Asia/Karachi");

class AttendanceModel
{
    static function checkMarkedIn(){
        $conn = Connection::getDB();
        $date = date("Y-m-d");
        $sql = "SELECT * FROM attendance WHERE uid = " .$_SESSION["user"]->getUid(). " AND date = '$date' AND timeIn IS NOT NULL";
        $result = $conn->query($sql);
        if ($result->num_rows > 0)
            return true;
        else
            return false;
    }

    static function checkMarkedOut(){
        $conn = Connection::getDB();
        $date = date("Y-m-d");
        $sql = "SELECT * FROM attendance WHERE uid = " .$_SESSION["user"]->getUid(). " AND date = '$date' AND timeOut IS NOT NULL";
        $result = $conn->query($sql);
        if ($result->num_rows > 0)
            return true;
        else
            return false;
    }

    static function markIn(){
        $conn = Connection::getDB();
        $time = date("H:i:s");
        $date = date("Y-m-d");

        $sql = "INSERT INTO attendance(uid,date,timeIn) VALUES (".$_SESSION["user"]->getUid().", '$date', '$time')";
        if ($conn->query($sql)){
            return true;
        } else {
            return false;
        }
    }

    static function markOut(){
        $conn = Connection::getDB();

        $time = date("H:i:s");
        $date = date("Y-m-d");
        $sql = "UPDATE attendance SET timeOut = '$time' WHERE uid = ".$_SESSION["user"]->getUid()." AND date = '$date'";
        if ($conn->query($sql)){
            return true;
        } else {
            return false;
        }
    }

    static function getAttendances(){
        $sql = "SELECT a.*, u.uid, u.name FROM (SELECT * FROM attendance WHERE date = CURRENT_DATE) AS a RIGHT JOIN users AS u ON a.uid = u.uid ORDER BY u.name";
        $result = Connection::getDB()->query($sql);
        if ($result->num_rows > 0){
            $attenArr = array();
            while ($row = $result->fetch_assoc()){
                array_push($attenArr, new Attend($row["uid"], $row["name"], $row["timeIn"],$row["timeOut"]));
            }
            return $attenArr;
        }
        else
            return null;
    }

    static function getTotalEmpCount(){
        $sql = "SELECT COUNT(*) AS count FROM users";
        $result = Connection::getDB()->query($sql);
        $count = 0;
        if ($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $count = $row["count"];
        }
        return $count;
    }

    static function getTotalPresentToday(){
        $sql = "SELECT COUNT(*) AS count FROM (SELECT * FROM attendance WHERE timeIn IS NOT NULL AND date = CURRENT_DATE) a JOIN users u ON u.uid = a.uid";
        $result = Connection::getDB()->query($sql);
        $count = 0;
        if ($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $count = $row["count"];
        }
        return $count;
    }

    static function getTotalLateToday(){
        $sql = "SELECT COUNT(*) AS count FROM (SELECT * FROM attendance WHERE timeIn IS NOT NULL AND timeIn > '11:00' AND date = CURRENT_DATE) a JOIN users u ON u.uid = a.uid";
        $result = Connection::getDB()->query($sql);
        $count = 0;
        if ($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $count = $row["count"];
        }
        return $count;
    }

    static function getMonthlyReport($month, $year){
        $sql = "SELECT u.uid, u.name, COUNT(a.date) presents, COUNT(aa.date) lates FROM users u LEFT JOIN (SELECT * FROM attendance WHERE MONTH(date) = ".$month." AND YEAR(date) = ".$year.") a on u.uid = a.uid LEFT JOIN (SELECT * FROM attendance WHERE timeIn IS NOT NULL AND timeIn > '11:00') aa ON u.uid = aa.uid AND a.date = aa.date GROUP BY u.uid";
        $result = Connection::getDB()->query($sql);
        $totalDays = self::countWorkingDays($year, $month, array(0,6));

        if ($result->num_rows > 0){
            $arr = array();
            while ($row = $result->fetch_assoc()){
                array_push($arr, new AttenReport($row["uid"], $row["name"], $row["presents"], $row["lates"], $totalDays - $row["presents"]));
            }
            return $arr;
        }
        else
            return null;
    }

    private static function countWorkingDays($year, $month, $ignore) {
        $count = 0;
        $counter = mktime(0, 0, 0, $month, 1, $year);
        while (date("n", $counter) == $month) {
            if (in_array(date("w", $counter), $ignore) == false) {
                $count++;
            }
            $counter = strtotime("+1 day", $counter);
        }
        return $count;
    }
}