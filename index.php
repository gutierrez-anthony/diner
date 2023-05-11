<?php

/*
 * Anthony Gutierrez
 * 4/18/2023
 * 328/diner/index.php
 * Controller for diner project
 */

// Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Require the autoload file
require_once('vendor/autoload.php');
require_once ('model/data-layer.php');

// Create an F3 (Fat-Free Framework) object
$f3 = Base::instance();
// Base $f3 = new Base();

// Define a default route
$f3->route('GET /', function() {

    //echo '<h1>Welcome to My Diner!</h1>';

    // Display a view page
    $view = new Template();
    echo $view->render('views/home.html');
});

// Define a breakfast route
$f3->route('GET /breakfast', function() {

    //echo '<h1>Breakfast Menu</h1>';

    // Display a view page
    $view = new Template();
    echo $view->render('views/menus/bfast.html');
});

// Define a breakfast route
$f3->route('GET /happy-hour', function() {

    //echo '<h1>Breakfast Menu</h1>';

    // Display a view page
    $view = new Template();
    echo $view->render('views/menus/happyHour.html');
});

// Create a route "/order1" -> orderForm1.html
$f3->route('GET|POST /order1', function($f3) {

    // If the form has been posted
    // "Auto-global" arrays:  $_SERVER, $_GET, $_POST
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        // Get the data
        // ["food"]=>"ramen" ["meal"]=>"lunch"
        //var_dump($_POST);
        $food = $_POST['food'];
        $meal = $_POST['meal'];
        //echo ("Food: $food, Meal: $meal");

        // Validate the data

        // Store the data in the session array
        $f3->set('SESSION.food', $food);
        $f3->set('SESSION.meal', $meal);
        //$_SESSION['food'] = $food;

        // Redirect to order2 route
        $f3->reroute('order2');
    }

    //Get the data from the model and add to the hive
    $f3->set('meals', getMeals());

    // Display a view page
    $view = new Template();
    echo $view->render('views/orderForm1.html');
});

// Create a route "/order2" -> orderForm2.html
$f3->route('GET|POST /order2', function($f3) {

    //echo '<h1>Breakfast Menu</h1>';

    // If the form has been posted
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        //Get the data
        //var_dump($_POST);
        //["conds"]=> array(2) { [0]=> string(7) "mustard" [1]=> string(4) "mayo" }
        $conds = implode(", ", $_POST['conds']);
        //echo $conds;

        //Validate the data

        //Store the data in the session array
        $f3->set('SESSION.condiments', $conds);

        //Redirect to the summary route
        $f3->reroute('summary');
    }
    $f3->set("conds", getConds());

    // Display a view page
    $view = new Template();
    echo $view->render('views/orderForm2.html');
});

// Create a route "/summary" -> summary.html
$f3->route('GET /summary', function() {

    //echo '<h1>Breakfast Menu</h1>';

    // Display a view page
    $view = new Template();
    echo $view->render('views/summary.html');

    session_destroy();
});

// Run Fat-Free
$f3->run();