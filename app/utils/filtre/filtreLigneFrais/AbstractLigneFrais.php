<?php
namespace app\utils\filtre\filtreLigneFrais;
use app\models\DAOLigneFrais;
use app\utils\SingletonDBMaria;

abstract class AbstractLigneFrais {
    protected DAOLigneFrais $DAOLigneFrais;
    public function __construct(){
        $cnx=SingletonDBMaria::getInstance()->getConnection();
        $DAOLigneFrais=new DAOLigneFrais($cnx);
        $this->DAOLigneFrais = $DAOLigneFrais;
    }
    abstract public function checkLigneFrais(string $data) : bool;
}