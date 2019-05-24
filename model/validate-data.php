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
    global $f3;

    //retrieve the post data
    $user = $f3->get('user');
    $pass = $f3->get('pass');

    //retrieve the database data
    $admin = $f3->get('admin');

    //compare data, still need to work on password
    if(!empty(user) && ($user == $admin['user'])){
        return true;
    }
    $f3->set("errors['login']", "The password, username combination do not match");
    return false;
}
