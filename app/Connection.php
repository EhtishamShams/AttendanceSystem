<?php
/**
 * Created by PhpStorm.
 * User: Ehtisham
 * Date: 16/07/2018
 * Time: 13:06
 */


class Connection
{
    private static $conn = null;

    static function getDB() {
        if (self::$conn == null){
            $servername = "localhost";
            $username = "root";
            $dbpassword = "root";
            $dbname = "AttendanceSystem";
            self::$conn = new mysqli($servername, $username, $dbpassword, $dbname);

            if (self::$conn->connect_error) {
                die("Connection failed: " . self::$conn->connect_error . "<br>");
            }
        }
        return self::$conn;

    }

    static function destroyConn(){
        self::$conn->close();
        self::$conn = null;
    }

}