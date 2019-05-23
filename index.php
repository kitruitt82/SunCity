<?php
/**
 * @athor by Maria Gallardo, Katt Truitt
 * @version 1.0
 * File: index.php
 *
 * This file is the controller that routes the user to the home page, as well as managing
 * retrieving database connection results from the database.
 */

// Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Require the autoload file
require_once('vendor/autoload.php');

//Create an instance of the Base class
$f3 = Base::instance();

//Turn on Fat-Free error reporting
$f3->set('DEBUG', 3);


//instantiate database object
$db = new Database();

/*//default route
$f3->route('GET /', function()
{
    $template = new Template();
    echo $template->render('views/home.html');
});*/
//This route links to a survey
$f3->route('GET /', function($f3)
{
    global $db;
    $reservations=$db->getPendingOrders();

    //Test the Database function
    foreach ($reservations as $row) {
        echo "<p>" . $row['fname'] . ", " . $row['lname'] . ", "
            . $row['event_id'] . "</p>";
    }

//    $template = new Template();
//    echo $template->render('views/some-admin-page');
});

$f3->run();