<?php
/**
 * 06/01/2019
 * This file contains the class event Bachelorette that inherits functionality from the class events
 *
 * @authors Maria Gallardo <mgallardo3@mail.greenriver.edu>,Kat Truitt <ktruitt@mail.greenriver.edu>
 * @copyright 2019
 */
class Bachelorette extends Events
{
    public function __construct($description, $transportation="pink limo", $name = "Bachelorette")
    {
        parent::__construct($description, $transportation, $name);
    }
}