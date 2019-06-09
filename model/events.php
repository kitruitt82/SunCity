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
    private $_description;
    private $_transportation;


    /**
     * Events constructor.
     * @param $name, the name of the event
     * @param $description, the size of people in the event
     * @param $transportation, the price of the event
     */
    public function __construct($description="",$name,$transportation)
    {
        $this->_name = $name;
        $this->_description = $description;
        $this->_transportation = $transportation;
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
    public function getDescription()
    {
        return $this->_description;
    }

    /**
     * This method takes a num parameter to set the group size for the event
     * @param integer $description, sets the group size
     */
    public function setDescription($description)
    {
        $this->_description = $description;
    }

    /**
     * This method returns the price of the event
     * @return float
     */
    public function getTransportation()
    {
        return $this->_transportation;
    }

    /**
     *
     * This method takes a float parameter to set the price of the event
     * @param float $transportation, sets the price of the event
     */
    public function setTransportation($transportation)
    {
        $this->_transportation = $transportation;
    }

}