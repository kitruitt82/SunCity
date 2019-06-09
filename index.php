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

    global $db;

    //get data from form
    if(!empty($_POST)){
        $first_name = $_POST['fname'];
        $last_name= $_POST['lname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $event_type = $_POST['event_type'];
        $groupSize = $_POST['groupSize'];
        $tour = $_POST['tour_date'];
        $start_time= $_POST['start_time'];
        $customize = $_POST['customize'];
//        $event_name= $_POST['event_name'];
//        $description = $_POST['description'];
//        $transportation=$_POST['transportation'];

        //add data to hive
        $f3->set('fname',$first_name);
        $f3->set('lname',$last_name);
        $f3->set('email',$email);
        $f3->set('phone',$phone);
        $f3->set('event_type',$event_type);
        $f3->set('groupSize', $groupSize);
        $f3->set('tour_date',$tour);
        $f3->set('start_time',$start_time);
        $f3->set('customize',$customize);

        //Validate form
        if(validRequest()) {
            $_SESSION['fname'] = $first_name;
            $_SESSION['lname'] = $last_name;
            $_SESSION['email'] = $email;
            $_SESSION['phone'] = $phone;
            $_SESSION['event_type'] = $event_type;
            $_SESSION['groupSize']= $groupSize;
            $_SESSION['tour_date'] = $tour;
            $_SESSION['start_time'] = $start_time;
            $_SESSION['customize']=$customize;
            if(empty($customize))
            {
                $event_name= $_POST['event_name'];
                $description = $_POST['description'];
                $transportation = $_POST['transportation'];
                $event= new $event_type($description,$event_name,$transportation);
                $_SESSION['event']=$event;

                $event->setDescription($description);
                $event->setName($event_name);
                $event->setTransportation($transportation);
                $_SESSION['event']=$event;
                $db->insertRequest();
                $db->insertCustomizedOrder();
                //reroute
            }
            else
            {
                $event_name= $_POST['event_name'];
                $description = $_POST['description'];
                $transportation = $_POST['transportation'];

                //crete the event object
                $event= new $event_type($description,$event_name,$transportation);
                $_SESSION['event']=$event;
                //send object to the hive
                $f3->set('event' ,$event);
                $db->insertRequest();
                $db->insertCustomizedOrder();

            }


            //reroute
            $f3->reroute('/summary');
        }
    }
    $view = new Template();
    echo $view->render("views/reservations2.html");
});

$f3->route('GET|POST /summary',function($f3){

    if(!empty($_POST)){
        $event_name= $_POST['event_name'];
        $description = $_POST['description'];
        $event_type = $_SESSION['event_type'];

        //crete the event object
        $event= new $event_type($description,$event_name);

        //send object to the hive
        $f3->set('event' ,$event);
        echo $event->getName();
    }
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