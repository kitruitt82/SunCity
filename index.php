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
session_start();
require_once('model/validate-data.php');


//Create an instance of the Base class
$f3 = Base::instance();

//Turn on Fat-Free error reporting
$f3->set('DEBUG', 3);

//print_r($_SERVER);
//instantiate database object
$db = new Database();

$f3->set('events', array("Bachelorette","Corporate","Party"));
$f3->set('size', array("1-6 / $600 ","7-12 / $700","Over 12 /$900 "));

$f3->route('GET /', function()
{
    session_destroy();
    $view = new Template();
    echo $view->render("views/home.html");
    //$party = new Bachelorette(5,"","");
    //echo $party->getName();
});

//route when 'home' is clicked
$f3->route('GET /home', function(){


    $view = new Template();
    echo $view->render("views/home.html");

});

//route to list of wineries in Yakima
$f3->route('GET /wineries',function(){

    $view = new Template();
    echo $view->render("views/wineries.html");

});

//route to reservations form
$f3->route('GET|POST /reservations', function($f3){

    //get data from form
    if(!empty($_POST)){
        $first_name = $_POST['fname'];
        $last_name= $_POST['lname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $event_type = $_POST['event_type'];
        $groupSize = $_POST['groupSize'];
        $start_time= $_POST['start_time'];

        //add data to hive
        $f3->set('fname',$first_name);
        $f3->set('lname',$last_name);
        $f3->set('email',$email);
        $f3->set('phone',$phone);
        $f3->set('event_type',$event_type);
        $f3->set('groupSize', $groupSize);
        $f3->set('start_time',$start_time);

        if(validRequest()) {
            $_SESSION['fname'] = $first_name;
            $_SESSION['lname'] = $last_name;
            $_SESSION['email'] = $email;
            $_SESSION['phone'] = $phone;
            $_SESSION['event_type'] = $event_type;
            $_SESSION['groupSize']= $groupSize;
            $_SESSION['start_time'] = $start_time;

//            if($_POST['request']=="Bachelorette"){
//                $event = new Bachelorette($description, $transportation, $name);
//            }
//            elseif(!empty($request) && $_POST['request']=="Corporate"){
//                $event = new Corporate($description, $transportation, $name);
//            }
//            else{
//                $event = new Party($description, $transportation, $name);
//            }
//            global $db;
//            $db->insertRequest();
//            $_SESSION['event'] = $event;
            //$db->insertEvent();

            //reroute
             $f3->reroute('/summary');
        }
    }
    $view = new Template();
    echo $view->render("views/reservations2.html");
});

$f3->route('GET /summary',function(){

    $view = new Template();
    echo $view->render("views/summary.html");

});

$f3->route('GET|POST /administration', function($f3) {

    //check if user made attempt to login
    if(!empty($_POST))
    {
        $user= $_POST['user'];
        $pass = $_POST['pass'];

        //add to the hive
        $f3->set('user',$user);
        $f3->set('pass', $pass);

        if(validUser())
        {
            $f3->reroute('/orders');
        }
    }

    $view = new Template();
    echo $view->render("views/admin.html");
});

$f3->route('GET|POST /orders', function($f3){
    global $db;

    //retrieve all the orders from the database
    $orders = $db->getPendingOrders();

    $f3->set('orders',$orders);


    $view = new Template();
    echo $view->render("views/pending-orders.html");

});

$f3->run();