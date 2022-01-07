<?php

require_once '../autoloader.php';

use app\controllers\BaseController;
use app\controllers\CaserneController;
use app\controllers\PompierController;
use app\controllers\UserController;
use app\controllers\RoleController;
use app\controllers\LoginController;
use app\controllers\DefaultController;
use app\controllers\HomeController;

session_start();
//https://www.youtube.com/watch?v=tbYa0rJQyoM
//https://www.youtube.com/watch?v=-iW6lo6wq1Y
//https://openclassrooms.com/fr/courses/2078536-developpez-votre-site-web-avec-le-framework-symfony2-ancienne-version/2079345-le-routeur-de-symfony2
//echo "<pre>" . print_r($_SERVER, true) . "<pre>";

if (isset($_SERVER["PATH_INFO"])) {
    $path = trim($_SERVER["PATH_INFO"], "/");
} else {
    $path = "";
}


$fragments = explode("/", $path); //cree tableau de caractére
//var_dump($fragment);

$control = array_shift($fragments);
//echo "control : $control <hr>";
switch ($control) {
    case '' :   // si juste la racine du site
        { //l'url est /
            defaultRoutes_get($fragments);
            break;
        }
    case "pompier" :    //Si page pompier
        {
            //echo "Gestion des routes pour pompier <hr>";
            //calling function to prevend all hard code here
            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                pompierRoutes_get($fragments);
            }
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                pompierRoutes_post($fragments);
            }
            break;
        }
    case "caserne" :    //Si page caserne
        {
            //echo "Gestion des routes pour caserne<hr>";
            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                caserneRoutes_get($fragments);
            }
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                caserneRoutes_post($fragments);
            }
            break;
        }
    case "user" :    //Si page user
        {
            //echo "Gestion des routes pour user<hr>";
            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                userRoutes_get($fragments);
            }
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                userRoutes_post($fragments);
            }
            break;
        }
    case "role" :    //Si page user
        {
            //echo "Gestion des routes pour user<hr>";
            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                roleRoutes_get($fragments);
            }
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                roleRoutes_post($fragments);
            }
            break;
        }
    case "login" :    //Si page login
        {
            //echo "Gestion des routes pour login<hr>";
            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                loginRoutes_get($fragments);
            }
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                loginRoutes_post($fragments);
            }
            break;
        }
    case "logout" :    //Si page logout
        {
            //echo "Gestion des routes pour logout<hr>";
            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                logoutRoutes_get($fragments);
            }
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                logoutRoutes_post($fragments);
            }
            break;
        }
    case "home" :    //Si page home
        {
            //echo "Gestion des routes pour login<hr>";
            if ($_SERVER["REQUEST_METHOD"] == "GET") {
                homeRoutes_get($fragments);
            }
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                homeRoutes_post($fragments);
            }
            break;
        }
}

    
function defaultRoutes_get($fragments)
{
    call_user_func_array([new DefaultController(), "index"], $fragments);
}

function homeRoutes_get($fragments)
{
    call_user_func_array([new HomeController(), "index"], $fragments);
}

function homeRoutes_post($fragments)
{
    call_user_func_array([new HomeController(), "index"], $fragments);
}

function pompierRoutes_get($fragments) {

    //var_dump($fragment);

    $action = array_shift($fragments); //action c'est ce que je veut faire sur les pompier
    //var_dump($action);

    switch ($action) {
        case "affiche" : {
                //echo "Calling pompierController->show <hr>";
                call_user_func_array([new PompierController(), "show"], $fragments); //nomController , methode du controler ,fragment a passer
                break;
            }
        case "delete" : {
                //echo "Calling pompierController->del <hr>";
                //Access permission can be checked here too
                call_user_func_array([new PompierController(), "delete"], $fragments);
                break;
            }
        case "edit" : {
                //echo "Calling pompierController->del <hr>";
                call_user_func_array([new PompierController(), "update"], $fragments); // \app\controllers\PompierController
                break;
            }
        case "add" : {
                //echo "Calling pompierController->show <hr>";
                call_user_func_array([new PompierController(), "insert"], $fragments); //nomController , methode du controler ,fragment a passer
                break;
            }
        default : {
                echo "Action '$action' non defini <hr>";
                //Gestion du probleme
            }
    }
}

function pompierRoutes_post($fragments) {
    $action = array_shift($fragments);
    switch ($action) {
        case "delete":
            //Access permission can be checked here too
            call_user_func_array([new PompierController(), "delete"], $fragments); // \app\controllers\PompierController
            break;
        case "add" :
            //echo "Action '$action' ready <hr>";
            //Access permission can be checked here too
            call_user_func_array([new PompierController(), "insert"], $fragments);
            break;
        case "edit" : {
                //echo "Calling pompierController->del <hr>";
                call_user_func_array([new PompierController(), "update"], $fragments); // \app\controllers\PompierController
                break;
            }

        default:
            echo "Action '$action' non defini <hr>";
            break;
    }
}

function caserneRoutes_get($fragments) {
    $action = array_shift($fragments);
    switch ($action) {
        case "affiche":
            //Access permission can be checked here too
            call_user_func_array([new CaserneController(), "show"], $fragments);
            break;
        case "detail" :
            call_user_func_array([new CaserneController(), "showDetails"], $fragments);
            break;
        case "add" :
            call_user_func_array([new CaserneController(), "insert"], $fragments);
            break;
        case "delete" :
            call_user_func_array([new CaserneController(), "delete"], $fragments);
            break;
        case "update" :
            call_user_func_array([new CaserneController(), "update"], $fragments);
            break;

        default:
            echo "Action '$action' non defini <hr>";
            break;
    }
}

function caserneRoutes_post($fragments) {
    $action = array_shift($fragments);
    switch ($action) {
        case "delete" :
            call_user_func_array([new CaserneController(), "delete"], $fragments);
            break;
        case "add" :
            call_user_func_array([new CaserneController(), "insert"], $fragments);
            break;
        case "update" :
            call_user_func_array([new CaserneController(), "update"], $fragments);
            break;
        default:
            break;
    }
}

function userRoutes_get($fragments) {
    $action = array_shift($fragments);
    switch ($action) {
        case "affiche":
            call_user_func_array([new UserController(), "show"], $fragments);
            break;
        case "detail" :
            call_user_func_array([new UserController(), "showDetails"], $fragments);
            break;
        case "add" :
            call_user_func_array([new UserController(), "insert"], $fragments);
            break;
        case "delete" :
            call_user_func_array([new UserController(), "delete"], $fragments);
            break;

        default:
            echo "Action '$action' non defini <hr>";
            break;
    }
}

function userRoutes_post($fragments) {
    $action = array_shift($fragments);
    switch ($action) {
        case "delete" :
            call_user_func_array([new userController(), "delete"], $fragments);
            break;
        case "add" :
            call_user_func_array([new userController(), "insert"], $fragments);
            break;
        case "edit" :
            call_user_func_array([new userController(), "update"], $fragments);
            break;
        default:
            break;
    }
}

function roleRoutes_get($fragments) {
    $action = array_shift($fragments);
    switch ($action) {
        case "affiche":
            call_user_func_array([new RoleController(), "show"], $fragments);
            break;
        case "detail" :
            call_user_func_array([new RoleController(), "showDetails"], $fragments);
            break;
        case "add" :
            call_user_func_array([new RoleController(), "insert"], $fragments);
            break;
        case "delete" :
            call_user_func_array([new RoleController(), "delete"], $fragments);
            break;

        default:
            echo "Action '$action' non defini <hr>";
            break;
    }
}

function roleRoutes_post($fragments) {
    $action = array_shift($fragments);
    switch ($action) {
        case "delete" :
            call_user_func_array([new RoleController(), "delete"], $fragments);
            break;
        case "add" :
            call_user_func_array([new RoleController(), "insert"], $fragments);
            break;
        case "edit" :
            call_user_func_array([new RoleController(), "update"], $fragments);
            break;
        default:
            break;
    }
}


function loginRoutes_get($fragments) {
    $action = array_shift($fragments);
    switch ($action) {
        case "affiche":
            call_user_func_array([new LoginController(), "show"], $fragments);
            break;
        case "login" :
            call_user_func_array([new LoginController(), "login"], $fragments);
            break;
        default:
            echo "Action '$action' non defini <hr>";
            break;
    }
}

function loginRoutes_post($fragments) {
    $action = array_shift($fragments);
    switch ($action) {
        case "affiche":
            call_user_func_array([new LoginController(), "show"], $fragments);
            break;
        case "login" :
            call_user_func_array([new LoginController(), "login"], $fragments);
            break;
        default:
            echo "Action '$action' non defini <hr>";
            break;
    }
}

function logoutRoutes_post($fragments) {
    call_user_func_array([new LoginController(), "logout"], $fragments);
}
function logoutRoutes_get($fragments) {
    call_user_func_array([new LoginController(), "logout"], $fragments);
}
?>