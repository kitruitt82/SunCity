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

//print_r($_SERVER);
//instantiate database object
$db = new Database();

//default route to home page
$f3->route('GET /', function()
{
    $template = new Template();
    echo $template->render('views/home.html');
});

//route when 'home' is clicked
$f3->route('GET /home', function(){

    $view = new Template();
    echo $view->render("views/home.html");

});

//route when 'reservations' is clicked
$f3->route('GET /reservations', function(){

    $view = new Template();
    echo $view->render("views/reservations.html");

});

$f3->route('GET|POST /administration', function($f3)
{
    global $db;

    //check if user made attempt to login
    if(!empty($_POST))
    {
        $user=$_POST['user'];
        $pass = $_POST['pass'];

        $admin=$db->getAdmin($user);

        //add to the hive
        $f3->set('admin', $admin);
        $f3->set('user',$user);
        $f3->set('pass', $pass);
    }

    $template = new Template();
    echo $template->render('views/pending-orders.html');
});

$f3->run();