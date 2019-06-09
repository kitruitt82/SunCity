<?php
/**
 * 06/01/2019
 * This file contains the class event Party that inherits functionality from the class events
 *
 * @authors Maria Gallardo <mgallardo3@mail.greenriver.edu>,Kat Truitt <ktruitt@mail.greenriver.edu>
 * @copyright 2019
 */
class Party extends Events
{
    public function __construct($description,  $name = "Party",$transportation="white shuttle van")
    {
        parent::__construct($description, $name,$transportation);
    }

}