<?php
namespace app\utils\filtre\filtreCaserne;
use app\models\DAOCaserne;
use app\utils\SingletonDBMaria;
/*
* @author Baptiste Coquelet <b.coquelet@eleve.leschartreux.net>
*/
abstract class AbstractCaserne{
    protected DAOCaserne $daocaserne;
    public function __construct(){
        $cnx=SingletonDBMaria::getInstance()->getConnection();
        $DAOCaserne=new DAOCaserne($cnx);
        $this->DAOCaserne = $DAOCaserne;
    }
    abstract public function checkCaserne(string $data) : bool;
}
