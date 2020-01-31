<?php

//this is our controller!

//start session
session_start();
//turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

//require the autoload file
require_once('vendor/autoload.php');
require_once ('model/validation-functions.php');

//create an instance of the base class
$f3 = Base::instance();

//debug level
$f3->set('DEBUG', 3);

$f3->set('colors', array('pink','green','blue'));

//define a default route
$f3->route('GET /', function () {
    $view = new Template();
    echo $view->render('views/home.html');
});

//route for form one
$f3->route('GET|POST /order', function ($f3) {
    $_SESSION = array();

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(isset($_POST['animal'])){
            $animal = $_POST['animal'];
            if(validString($animal)){
                $_SESSION['animal'] = $animal;
                $f3->reroute('/order2');
            }
            else{
                $f3->set("error['animal']","Please enter a animal");
            }
        }

    }
    $view = new Template();
    echo $view->render('views/form1.html');
});

//route for form 2
$f3->route('GET|POST /order2', function ($f3) {

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        if(isset($_POST['color'])){
            $color = $_POST['color'];
            if(validColor($color)){
                $_SESSION['color'] = $color;
                $f3->reroute('/results');
            }
            else{
                $f3->set("error['color']","Please enter a color");
            }
        }

    }
    $view = new Template();
    echo $view->render('views/form2.html');
});

//route for results page
$f3->route('GET|POST /results', function () {
    $view = new Template();
    echo $view->render('views/results.html');
});


$f3->route('GET /@item', function ($f3, $param) {
    $item = $param["item"];
    switch($item){
        case "chicken":
            echo "<p>Cluck</p>";
            break;
        case "dog":
            echo "<p>Woof</p>";
            break;
        case "pig":
            echo "<p>Oink</p>";
            break;
        case "horse":
            echo "<p>Neigh</p>";
            break;
        case "bird":
            echo "<p>Chirp</p>";
            break;
        default:
            $f3->error(404);
            break;
    }
});

//run fat free
$f3 -> run();