<?php

require_once '../autoloader.php';
use app\utils\SingletonDBMaria;
use app\controllers\PompierController;
$cnx = SingletonDBMaria::getInstance()->getConnection();


 
 $c = new PompierController();
 $c->Show();
 
 
 