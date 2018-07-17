<?php
/**
 * Created by PhpStorm.
 * User: Ehtisham
 * Date: 16/07/2018
 * Time: 15:31
 */

class Input
{
    static function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

}