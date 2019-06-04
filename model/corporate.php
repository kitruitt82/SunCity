<?php
/**
 * 06/01/2019
 * This file contains the class event Corporate that inherits functionality from the class events
 *
 * @authors Maria Gallardo <mgallardo3@mail.greenriver.edu>,Kat Truitt <ktruitt@mail.greenriver.edu>
 * @copyright 2019
 */
class Corporate extends Events
{
    public function __construct($group_size, $price, $_start_time, $name = "Coorporate")
    {
        parent::__construct($group_size, $price, $_start_time, $name);
    }
}