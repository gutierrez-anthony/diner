<?php


// Get the meals for the order form

function getMeals()
{
    $meals = array("breakfast", "lunch", "dinner");
    return $meals;
}

function getConds()
{
    $conds = array("ketchup", "mustard", "mayo", "sriracha");
    return $conds;
}