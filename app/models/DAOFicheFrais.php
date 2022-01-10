<?php

namespace app\models;

use PDO;
use app\models\User;
use app\utils\SingletonDBMaria;

class DAOFicheFrais {

    private $cnx;

    public function __construct($cnx) {
        $this->cnx = $cnx;
    }

    /*
      Renvoie un user par rapport a son id
      
      @param int $Identifiant
      
      @return User $user
     */
    public function find($Identifiant): User 
    {
        $sql = 'SELECT * FROM user WHERE Identifiant=:Identifiant;';
        $prepared_Statement = $this->cnx->prepare($sql);
        $prepared_Statement->bindParam("Identifiant", $Identifiant);
        $prepared_Statement->execute();
        while ($row = $prepared_Statement->fetch(\PDO::FETCH_ASSOC)) {
            $user = new User($row['Identifiant'], $row['Nom'], $row['Prenom'], $row['password'], $row['IdRole']);
        }
        return $user;
    }

}

?>