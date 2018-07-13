<?php
/**
 * Created by PhpStorm.
 * User: Ehtisham
 * Date: 11/07/2018
 * Time: 12:13
 */


$target_dir = "uploads/";
$target_file_actual = $target_dir . basename($_FILES["fileInput"]["name"]);

$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file_actual,PATHINFO_EXTENSION));
$upload_path = $target_dir . $email . "." . $imageFileType;
$target_file = "../" . $upload_path;
if (isset($_POST["submit"])){
    $check = getimagesize($_FILES["fileInput"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
    }
}

// Check file size
if ($_FILES["fileInput"]["size"] > 500000) {
    $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" && $imageFileType != "ico" ) {
    $uploadOk = 0;
}

if ($uploadOk == 1) {
    if (move_uploaded_file($_FILES["fileInput"]["tmp_name"], $target_file)) {
    } else {
        $uploadOk = 0;
    }
}

?>