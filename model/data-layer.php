<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/../pdo-config.php');
class DataLayer
{
    private $_dbh;

    function __construct()
    {
        try {
            $this->_dbh =new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            //echo 'Connected to the database!';
        }
        catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    function saveOrder($order)
    {
        //1. Define the query (test first!)
        $sql = "INSERT INTO orders (food, meal, condiments)
                    VALUES (:food, :meal, :condiments)";

        //2. Prepare the statement
        $statement = $this->_dbh->prepare($sql);

        //3. Bind the parameters
        $food = $order->getFood();
        $meal = $order->getMeal();
        $conds = $order->getCondiments();
        $statement->bindParam(':food', $food);
        $statement->bindParam(':meal', $meal);
        $statement->bindParam(':condiments', $conds);

        //4. Execute
        $statement->execute();

        //5. Return the primary key
        $id = $this->_dbh->lastInsertId();
        return $id;
    }
    // Get the meals for the order form
    static function getMeals()
    {
        $meals = array("breakfast", "lunch", "dinner");
        return $meals;
    }

// Get the condiments for the order 2 form
    static function getConds()
    {
        $condiments = array("ketchup", "mustard", "mayo", "sriracha");
        return $condiments;
    }
}
