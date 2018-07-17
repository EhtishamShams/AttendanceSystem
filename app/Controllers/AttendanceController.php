<?php
/**
 * Created by PhpStorm.
 * User: Ehtisham
 * Date: 17/07/2018
 * Time: 13:24
 */

require_once "../Attend.php";
require_once "../Models/AttendanceModel.php";

class AttendanceController
{
    static function checkMarkedIn(){
        return AttendanceModel::checkMarkedIn();
    }

    static function checkMarkedOut(){
        return AttendanceModel::checkMarkedOut();
    }

    static function markIn(){
        if (AttendanceModel::markIn()){
            echo '<script type="text/javascript">alert("Attendance Marked!")</script>';
            die('<script type="text/javascript"> window.location.reload() </script>');
        } else {
            echo '<script type="text/javascript">alert("Error Marking attendance!")</script>';
            die('<script type="text/javascript"> window.location.reload() </script>');
        }
    }

    static function markOut(){
        if (AttendanceModel::markOut()){
            echo '<script type="text/javascript">alert("Attendance Marked!")</script>';
            die('<script type="text/javascript"> window.location.reload() </script>');
        } else {
            echo '<script type="text/javascript">alert("Error Marking attendance!")</script>';
            die('<script type="text/javascript"> window.location.reload() </script>');
        }
    }

    static function getAttendances(){
        return AttendanceModel::getAttendances();
    }

    static function getTotalEmpCount(){
        return AttendanceModel::getTotalEmpCount();
    }

    static function getTotalPresentToday(){
        return AttendanceModel::getTotalPresentToday();
    }

    static function getTotalAbsentToday(){
        return AttendanceModel::getTotalEmpCount() - AttendanceModel::getTotalPresentToday();
    }

    static function getTotalLateToday(){
        return AttendanceModel::getTotalLateToday();
    }

    static function getMonthlyReport($month, $year){
        return AttendanceModel::getMonthlyReport($month, $year);
    }
}