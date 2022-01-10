<?php
namespace app\utils\filtre\filtrePompier;
use app\models\DAOPompier;
use app\utils\SingletonDBMaria;

abstract class AbstractPompier{
    protected DAOPompier $DAOPompier;
    public function __construct(){
        $cnx=SingletonDBMaria::getInstance()->getConnection();
        $DAOPompier=new DAOPompier($cnx);
        $this->DAOPompier = $DAOPompier;
    }
    abstract public function checkPompier(string $data) : bool;
}
