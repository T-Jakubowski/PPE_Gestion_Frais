<?php
namespace app\utils\filtre\filtreUser;
use app\models\DAOUser;
use app\utils\SingletonDBMaria;
/*
* @author Baptiste Coquelet <b.coquelet@eleve.leschartreux.net>
*/
abstract class AbstractUser {
    protected DAOUser $daouser;
    public function __construct(){
        $cnx=SingletonDBMaria::getInstance()->getConnection();
        $DAOUser=new DAOUser($cnx);
        $this->DAOUser = $DAOUser;
    }
    abstract public function checkUser(string $data) : bool;
}