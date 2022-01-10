<?php
namespace app\utils\filtre\filtreRole;
use app\models\DAORole;
use app\utils\SingletonDBMaria;
/*
* @author Baptiste Coquelet <b.coquelet@eleve.leschartreux.net>
*/
abstract class AbstractRole {
    protected DAORole $DAORole;
    public function __construct(){
        $cnx=SingletonDBMaria::getInstance()->getConnection();
        $DAORole=new DAORole($cnx);
        $this->DAORole = $DAORole;
    }
    abstract public function checkRole(string $data) : bool;
}