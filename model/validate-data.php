<?php

/**
 * 05/23/2019
 * This file validates the data for the entered userInformation in admin page
 *
 * @authors Maria Gallardo <mgallardo3@mail.greenriver.edu>,Kat Truitt <ktruitt@mail.greenriver.edu>
 * @copyright 2019
 */

function validUser()
{
//    global $f3;
//
//    //retrieve the post data
//    $user = $f3->get('user');
//    $pass = $f3->get('pass');
//
//    //retrieve the database data
//    $admin = $f3->get('admin');
//
//    //compare data, still need to work on password
//    if(!empty(user) && ($user == $admin['user'])){
//        return true;
//    }
//    $f3->set("errors['login']", "The password, username combination do not match");
//    return false;

    global $f3;

    //retrieve the post data
    $user = $f3->get('user');
    $pass = $f3->get('pass');

    //compare data, still need to work on password
    if($user =='user123' && $pass == "Friendly123"){
        return true;
    }
    $f3->set("errors['login']", "The password, username combination do not match");
    return false;
}

/**
 * Function checks if reservation form is filled out correctly, if not adds error message to errors[]
 * @return bool returns true if validation is a success
 */
function validRequest()
{
    global $f3;
    $isValid = true;

    if (!validFName($f3->get('fname'))) {

        $isValid = false;
        $f3->set("errors['fname']", "Please enter your first name.");

    }

    if (!validLName($f3->get('lname'))) {
        $isValid = false;
        $f3->set("errors['lname']", "Please enter your last name.");
    }

    if (!validPhone($f3->get('phone'))) {
        $isValid = false;
        $f3->set("errors['phone']", "Please enter a valid phone number. Only numbers(0-9), no dashes and
        include area code ");
    }

    if(!validEmail($f3->get('email')))
    {
        $isValid = false;
        $f3->set("errors['email']", "Please enter a valid email.");
    }

    if (!validDate($f3->get('tour_date'))) {
        $isValid = false;
        $f3->set("errors['tour_date']", "Please select a date.");
    }

    if (!validStartTime($f3->get('start_time'))) {
        $isValid = false;
        $f3->set("errors['start_time']", "Please select a time.");
    }
    return $isValid;

}

/**
 * Function that checks if user inputs a valid first name
 * @param $fname $fname being passed to function
 * @return bool returns true if first name is not empty and contains letters only
 */
function validFName($fname)
{
    return !empty($fname) && ctype_alpha($fname);
}

/**
 * Function that checks if user inputs a valid first name
 * @param $lname $lname being passed to function
 * @return bool returns true if last name is not empty and contains letters only
 */
function validLName($lname)
{
    return !empty($lname) && ctype_alpha($lname);
}

/**
 * Function that checks if email is valid
 * @param $email $email that is being passed to function
 * @return mixed returns the filtered data if validation is a success and false if validation fails
 */
function validEmail($email)
{
    return !empty($email) && filter_var($email,FILTER_VALIDATE_EMAIL);
}

/**
 * Function that checks if phone number is valid
 * @param $phone $phone that is being passed to function
 * @return bool returns true if phone number is numeric and length is equal to 10 numbers
 */
function validPhone($phone)
{
    return !empty($phone) && is_numeric($phone) && strlen($phone)==10 ;
}

/**
 * @param $tour_date $tour_date input
 * @return bool returns true if date is not empty
 */
function validDate($tour_date)
{
    return !empty($tour_date);
}

/**
 * @param $start_time $start_time input
 * @return bool return true if not empty
 */
function validStartTime($start_time)
{
    return !empty($start_time);
}
