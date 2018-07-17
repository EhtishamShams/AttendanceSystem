<?php
/**
 * Created by PhpStorm.
 * User: Ehtisham
 * Date: 17/07/2018
 * Time: 13:25
 */

class Attend
{
    private $uid;
    private $name;
    private $timeIn;
    private $timeOut;

    /**
     * Attend constructor.
     * @param $uid
     * @param $name
     * @param $timeIn
     * @param $timeOut
     */
    public function __construct($uid, $name, $timeIn, $timeOut)
    {
        $this->uid = $uid;
        $this->name = $name;
        $this->timeIn = $timeIn;
        $this->timeOut = $timeOut;
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
    public function getTimeIn()
    {
        return $this->timeIn;
    }

    /**
     * @param mixed $timeIn
     */
    public function setTimeIn($timeIn)
    {
        $this->timeIn = $timeIn;
    }

    /**
     * @return mixed
     */
    public function getTimeOut()
    {
        return $this->timeOut;
    }

    /**
     * @param mixed $timeOut
     */
    public function setTimeOut($timeOut)
    {
        $this->timeOut = $timeOut;
    }

}