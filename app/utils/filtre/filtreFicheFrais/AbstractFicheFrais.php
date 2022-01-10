<?php
namespace app\utils\filtre\filtreFicheFrais;
use app\models\DAOFicheFrais;
use app\utils\SingletonDBMaria;


abstract class AbstractFicheFrais {
    protected DAOFicheFrais $DAOFicheFrais;
    public function __construct(){
        $cnx = SingletonDBMaria::getInstance()->getConnection();
        $DAOFicheFrais = new DAOFicheFrais($cnx);
        $this->DAOFicheFrais = $DAOFicheFrais;
    }
    abstract public function checkFicheFrais(string $data) : bool;
}