<?php
/**
 * Created by PhpStorm.
 * User: Ehtisham
 * Date: 09/07/2018
 * Time: 13:08
 */

class User {
    private $uid;
    private $email;
    private $name;
    private $picUrl;
    private $designation;

    /**
     * User constructor.
     * @param $uid
     * @param $email
     * @param $name
     * @param $picUrl
     * @param $designation
     */
    public function __construct($uid, $email, $name, $picUrl, $designation)
    {
        $this->uid = $uid;
        $this->email = $email;
        $this->name = $name;
        $this->picUrl = $picUrl;
        $this->designation = $designation;
    }


    /**
     * @return mixed
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * @param mixed $uid
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getPicUrl()
    {
        return $this->picUrl;
    }

    /**
     * @param mixed $picUrl
     */
    public function setPicUrl($picUrl)
    {
        $this->picUrl = $picUrl;
    }

    /**
     * @return mixed
     */
    public function getDesignation()
    {
        return $this->designation;
    }

    /**
     * @param mixed $designation
     */
    public function setDesignation($designation)
    {
        $this->designation = $designation;
    }


}

?>