<?php
/**
 * Created by PhpStorm.
 * User: Ehtisham
 * Date: 17/07/2018
 * Time: 15:28
 */

class AttenReport
{
    private $uid;
    private $name;
    private $presents;
    private $lates;
    private $leaves;

    /**
     * AttenReport constructor.
     * @param $uid
     * @param $name
     * @param $presents
     * @param $lates
     * @param $leaves
     */
    public function __construct($uid, $name, $presents, $lates, $leaves)
    {
        $this->uid = $uid;
        $this->name = $name;
        $this->presents = $presents;
        $this->lates = $lates;
        $this->leaves = $leaves;
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
    public function getPresents()
    {
        return $this->presents;
    }

    /**
     * @param mixed $presents
     */
    public function setPresents($presents)
    {
        $this->presents = $presents;
    }

    /**
     * @return mixed
     */
    public function getLates()
    {
        return $this->lates;
    }

    /**
     * @param mixed $lates
     */
    public function setLates($lates)
    {
        $this->lates = $lates;
    }

    /**
     * @return mixed
     */
    public function getLeaves()
    {
        return $this->leaves;
    }

    /**
     * @param mixed $leaves
     */
    public function setLeaves($leaves)
    {
        $this->leaves = $leaves;
    }



}