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
require_once('model/validate-data.php');
session_start();

//Create an instance of the Base class
$f3 = Base::instance();

//Turn on Fat-Free error reporting
$f3->set('DEBUG', 3);

//Instantiate database object
$db = new Database();

//Arrays for drop-down select options
$f3->set('events', array("Bachelorette","Corporate","Party"));
$f3->set('size', array("1-6 / $600 ","7-12 / $700","Over 12 /$900 "));
$f3->set('times', array( '10:00:00', '11:00:00', '12:00:00'));
$f3->set('vehicles',array("White Shuttle Van","Pink Limo","Black Limo"));

$f3->route('GET /', function()
{
    session_destroy();
    $view = new Template();
    echo $view->render("views/home.html");
    //$party = new Bachelorette(5,"","");
    //echo $party->getName();
});

//The route when 'home' is clicked
$f3->route('GET /home', function(){

    session_destroy();

    $view = new Template();
    echo $view->render("views/home.html");

});

//route to list of wineries in Yakima
$f3->route('GET /wineries',function(){

    $view = new Template();
    echo $view->render("views/wineries.html");

});

//route to reservations form
$f3->route('GET|POST /reservations', function($f3) {

    //Connect to database
    global $db;

    //get data from form
    if (!empty($_POST)) {
        $first_name = $_POST['fname'];
        $last_name = $_POST['lname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $event_type = $_POST['event_type'];
        $groupSize = $_POST['groupSize'];
        $tour = $_POST['tour_date'];
        $start_time = $_POST['start_time'];
        $customize = $_POST['customize'];
        $event_name = $_POST['event_name'];
        $description = $_POST['description'];
        $transportation = $_POST['transportation'];

        //add data to hive
        $f3->set('fname', $first_name);
        $f3->set('lname', $last_name);
        $f3->set('email', $email);
        $f3->set('phone', $phone);
        $f3->set('event_type', $event_type);
        $f3->set('groupSize', $groupSize);
        $f3->set('tour_date', $tour);
        $f3->set('start_time', $start_time);
        $f3->set('customize', $customize);
        $f3->set('transportation', $transportation);
        $f3->set('event_name', $event_name);
        $f3->set('description', $description);

        //Validate form
        if (validRequest()) {
            $_SESSION['fname'] = $first_name;
            $_SESSION['lname'] = $last_name;
            $_SESSION['email'] = $email;
            $_SESSION['phone'] = $phone;
            $_SESSION['event_type'] = $event_type;
            $_SESSION['groupSize'] = $groupSize;
            $_SESSION['tour_date'] = $tour;
            $_SESSION['start_time'] = $start_time;
            $_SESSION['customize'] = $customize;

            //Insert data into database
            $db->insertRequest();
            //Check if input was customized
            if (!empty($customize)) {

                //create sessions to input data into event object
                $_SESSION['transportation'] = $transportation;
                $_SESSION['event_name'] = $event_name;
                $_SESSION['description'] = $description;

                //Create event object
                $event = new $event_type($description, $event_name, $transportation);

                //Create event object session
                $_SESSION['event'] = $event;

                //Set details to event object
                $event->setDescription($description);
                $event->setName($event_name);
                $event->setTransportation($transportation);

                //Set event object to the hive
                $f3->set('event', $event);

                //Insert customized order into database
                $db->insertCustomizedOrder();

            }
            else {

                //Event object details set with default object parameters
                $_SESSION['event_name'] = $event_type;
                $event_name = $event_type;
                $description = " ";
                $event = new $event_type($description, $event_name);
                $_SESSION['event'] = $event;
                $event->setName($event_name);
                $event->setDescription($description);
                $f3->set('event', $event);

                //$db->insertCustomizedOrder();
            }

            //If validation is successful, reroute to summary view
            $f3->reroute('/summary');

        }
    }

        //Display reservations page with validation errors
        $view = new Template();
        echo $view->render("views/reservations2.html");


});

$f3->route('GET /summary',function(){

    //Display summary.html for confirmation
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
    $orders = $db->getAllOrders();
    $p_order = $db->getPendingOrders();

    $f3->set('orders',$orders);
    $f3->set('p_order',$p_order);
    $view = new Template();
    echo $view->render("views/pending-orders.html");

});

$f3->route('GET /detail/@order', function($f3, $params)
{
    global $db;

    $order = $params['order'];
    $order_details = $db->getOrderDetails($order);
    $f3->set('order',$order_details);

    $template = new Template();
    echo $template->render('views/order_details.html');

});

$f3->run();