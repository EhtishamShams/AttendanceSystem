<?php

date_default_timezone_set("Asia/Karachi");
$time = date("H:i:s");

if ($time > "11:00:00" && $time < "12:00:00") {

    $servername = "localhost";
    $username = "root";
    $dbpassword = "root";
    $dbname = "AttendanceSystem";

    $conn = new mysqli($servername, $username, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error . "<br>");
    }

    $sql = "SELECT u.email FROM users u LEFT JOIN (SELECT * FROM attendance aa WHERE aa.date = CURRENT_DATE) a ON u.uid = a.uid WHERE a.timein IS NULL";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $to = $row["email"];
            $subject = "Attendance Not Marked";
            $message = "Dear Employee,\n\nYou have not marked your attendance. Please mark your time in if you're in office. You'll be marked absent after 12:00.\n\nRegards,\nCoeus Solutions";
            $headers = 'From: no-reply@coeus-solutions.de';
            mail($to, $subject, $message, $headers);
        }
    }

}

?>
