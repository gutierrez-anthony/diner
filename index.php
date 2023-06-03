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

// Connect to Database
$dataLayer = new DataLayer();

// Create an F3 (Fat-Free Framework) object
$f3 = Base::instance();
$con = new Controller($f3);
// Base $f3 = new Base();

// Define a default route
$f3->route('GET /', function() {
    $GLOBALS['con']->home();
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
$f3->route('GET|POST /order1', function() {
    $GLOBALS['con']->order1();
});

// Create a route "/order2" -> orderForm2.html
$f3->route('GET|POST /order2', function() {

    $GLOBALS['con']->order2();
});

// Create a route "/summary" -> summary.html
$f3->route('GET /summary', function() {

    $GLOBALS['con']->summary();
});

// Run Fat-Free
$f3->run();