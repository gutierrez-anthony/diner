<?php
/*
 * 328/diner/model/validation.php
 * Contains functions to validate data in the
 * diner app
 */

function validMeal($meal)
{
//    if(!empty($meal) && in_array($meal, getMeals())){
//        return true;
//    } else {
//        return false;
//    }
    return (!empty($meal) && in_array($meal, getMeals()));
}