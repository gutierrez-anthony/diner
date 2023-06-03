<?php
/*
 * 328/diner/model/validation.php
 * Contains functions to validate data in the
 * diner app
 */

class Validate
{
    static function validMeal($meal)
    {
//    if(!empty($meal) && in_array($meal, getMeals())){
//        return true;
//    } else {
//        return false;
//    }
        return (!empty($meal) && in_array($meal, DataLayer::getMeals()));
    }

    static function validFood($food)
    {
        $food = trim($food);
        return (strlen($food) >= 2 && !ctype_digit($food));
    }

    static function validCondiments($userCondiments)
    {
        $validCondiments = DataLayer::getCondiments();

        //Check each user condiment against array of valid condiments
        foreach ($userCondiments as $userCondiment) {
            if (!in_array($userCondiment, $validCondiments)) {
                return false;
            }
        }
        return true;
    }
}
