<?php

/**
 * 06/01/2019
 * This file contains the class events
 *
 * @authors Maria Gallardo <mgallardo3@mail.greenriver.edu>,Kat Truitt <ktruitt@mail.greenriver.edu>
 * @copyright 2019
 */
class Events
{
    private $_name;
    private $_group_size;
    private $_price;
    private $_start_time;

    /**
     * Events constructor.
     * @param $name, the name of the event
     * @param $group_size, the size of people in the event
     * @param $price, the price of the event
     * @param $_start_time, the time the event starts
     */
    public function __construct($name,$group_size,$price,$_start_time)
    {
        $this->_name = $name;
        $this->_group_size = $group_size;
        $this->_price = $price;
        $this->_start_time = $_start_time;
    }

    /**
     * This method returns the event's name
     * @return String
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * This method takes a parameter to set the name of the event
     * @param String, $name is the name of the event
     * @return void
     */
    public function setName($name)
    {
        $this->_name = $name;
    }

    /**
     * This method returns the number of people reserving the event
     * @return integer
     */
    public function getGroupSize()
    {
        return $this->_group_size;
    }

    /**
     * This method takes a num parameter to set the group size for the event
     * @param integer $group_size, sets the group size
     */
    public function setGroupSize($group_size)
    {
        $this->_group_size = $group_size;
    }

    /**
     * This method returns the price of the event
     * @return float
     */
    public function getPrice()
    {
        return $this->_price;
    }

    /**
     *
     * This method takes a float parameter to set the price of the event
     * @param float $price, sets the price of the event
     */
    public function setPrice($price)
    {
        $this->_price = $price;
    }

    /**
     * This method returns the time the event starts
     * @return String
     */
    public function getStartTime()
    {
        return $this->_start_time;
    }

    /**
     * This method sets the time the event starts using a string parameter
     * @param String $start_time
     */
    public function setStartTime($start_time)
    {
        $this->_start_time = $start_time;
    }


}