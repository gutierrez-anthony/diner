<?php
class Controller
{
    // F3 object
    private $_f3;

    function __construct($f3)
    {
        $this->_f3 = $f3;
    }

    function home()
    {
        //echo '<h1>Welcome to My Diner!</h1>';

        // Display a view page
        $view = new Template();
        echo $view->render('views/home.html');
    }

    function order1()
    {
        $food = "";
        $meal = "";

        // If the form has been posted
        // "Auto-global" arrays:  $_SERVER, $_GET, $_POST
        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            // Get the data
            // ["food"]=>"ramen" ["meal"]=>"lunch"
            //var_dump($_POST);
            if(isset($_POST['food'])) {
                $food = $_POST['food'];
            }

            if(isset($_POST['meal'])) {
                $meal = $_POST['meal'];
            }
            //echo ("Food: $food, Meal: $meal");

            $newOrder = new Order();

            // Validate the data
            if (Validate::validMeal($meal)) {
                $newOrder->setMeal($meal);
            }
            else {
                $this->_f3->set('errors["meal"]', 'Invalid meal selected');
            }

            if (Validate::validFood($food)) {
                $newOrder->setFood($food);
            }
            else {
                $this->_f3->set('errors["food"]', 'Invalid food entered');
            }

            // Store the data in the session array

            //$_SESSION['food'] = $food;

            // Redirect to order2 route
            if( empty($this->_f3->get('errors'))) {
                //Add order object to Session
                $this->_f3->set('SESSION.order', $newOrder);

                $this->_f3->reroute('order2');
            }
        }

        //Get the data from the model and add to the hive
        $this->_f3->set('meals', DataLayer::getMeals());

        // Add user data to the hive
        $this->_f3->set('userFood', $food);
        $this->_f3->set('userMeal', $meal);

        // Display a view page
        $view = new Template();
        echo $view->render('views/orderForm1.html');
    } // end of order1 function

    function order2()
    {
        //Initialize condiments array
        $selectedCondiments = array();

        // If the form has been posted
        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            if (!empty($_POST['conds'])) {
                $selectedCondiments = $_POST['conds'];

                if (Validate::validCondiments($selectedCondiments)) {
                    $conds = implode(", ", $selectedCondiments);

                    $this->_f3->get('SESSION.order')->setCondiments($conds);
                }
                else {
                    $this->_f3->set('errors["conds"]', "You do not have access");
                }
            }

            if (empty($this->_f3->get('errors'))) {
                //Redirect to the summary route
                $this->_f3->reroute('summary');
            }
        }

        //Get the data from the model and add to the hive
        $this->_f3->set("condiments", DataLayer::getConds());

        // Display a view page
        $view = new Template();
        echo $view->render('views/orderForm2.html');
    }// end of order2 function

    function summary()
    {
        // Save order to database
        $orderId = $GLOBALS['dataLayer']->saveOrder($this->_f3->get('SESSION.order'));
        $this->_f3->set('orderId', $orderId);

        // Display a view page
        $view = new Template();
        echo $view->render('views/summary.html');

        session_destroy();
    }

} // End of class