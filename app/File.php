<?php
/**
 * Created by PhpStorm.
 * User: Ehtisham
 * Date: 16/07/2018
 * Time: 17:00
 */

class File
{
    static function upload($fileInput, $email){
        $target_dir = "uploads/";
        $target_file_actual = $target_dir . basename($fileInput["name"]);

        $uploadOk = true;
        $imageFileType = strtolower(pathinfo($target_file_actual,PATHINFO_EXTENSION));
        $upload_path = $target_dir . $email . "." . $imageFileType;
        $target_file = "../" . $upload_path;
        if (isset($_POST["submit"])){
            $check = getimagesize($fileInput["tmp_name"]);
            if($check !== false) {
                $uploadOk = true;
            } else {
                $uploadOk = false;
            }
        }

        // Check file size
        if ($fileInput["size"] > 500000) {
            $uploadOk = false;
        }

        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif" && $imageFileType != "ico" ) {
            $uploadOk = false;
        }

        if ($uploadOk) {
            if (move_uploaded_file($fileInput["tmp_name"], $target_file)) {
            } else {
                $uploadOk = false;
            }
        }

        return array($uploadOk, $upload_path);
    }
}