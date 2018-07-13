<?php

date_default_timezone_set("Asia/Karachi");
$time = date("H:i:s");

if ($time > "12:00:00") {

    $servername = "localhost";
    $username = "root";
    $dbpassword = "root";
    $dbname = "AttendanceSystem";

    $conn = new mysqli($servername, $username, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error . "<br>");
    }

    $sql = "SELECT u.email FROM users u WHERE u.designation = 'HR Manager'";
    $sql2 = "SELECT u.name, u.email FROM users u LEFT JOIN (SELECT * FROM attendance aa WHERE aa.date = CURRENT_DATE) a ON u.uid = a.uid WHERE a.timein IS NULL";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        $to = "";
        while ($row = $result->fetch_assoc()) {
            $to = $row["email"];

            $result2 = $conn->query($sql2);

            if ($result2->num_rows > 0) {

                $subject = "Employee(s) Marked Absent";
                $message = "Dear HR Manager,\n\nThis is to inform you that the following employee(s) are marked absent today for not marking their attendance in the system.\n";

                while ($row2 = $result2->fetch_assoc()) {
                    $message .= $row2["name"] . ": " . $row2["email"] . "\n";
                }

                $message .= "\nRegards,\nCoeus Solutions";

                $headers = 'From: no-reply@coeus-solutions.de';
                echo $to . "<br>" . $message . "<br>" . $headers . "<br>";
                mail($to, $subject, $message, $headers);
            }
            else
                break;
        }
    }

}

?>