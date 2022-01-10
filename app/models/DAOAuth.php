<?php

namespace app\models;

class DAOAuth {

    private $cnx;

    public function __construct($cnx) {
        $this->cnx = $cnx;
    }
    
    /*
        Renvoie un role en fonction de son id
        @param int $Id
        @return string role
    */
    public function findRoleById($Id) : string {
        $sql = 'SELECT * FROM role WHERE Id=:Id;';
        $prepared_Statement = $this->cnx->prepare($sql);
        $prepared_Statement->bindParam("Id", $Id);
        $prepared_Statement->execute();
        while ($row = $prepared_Statement->fetch(\PDO::FETCH_ASSOC)) {
            return $row['role'];
        }
    }
    
    /*
        Renvoie une permission en fonction de son id
        @param int $Id
        @return string Permission
    */
    public function findPermissionById(int $Id) : string {
        $sql = 'SELECT * FROM role WHERE Id=:Id;';
        $prepared_Statement = $this->cnx->prepare($sql);
        $prepared_Statement->bindParam("Id", $Id);
        $prepared_Statement->execute();
        while ($row = $prepared_Statement->fetch(\PDO::FETCH_ASSOC)) {
            return strval($row['Permission']);
        }
    }
    
    /*
        Renvoie true si l'identifiant et le password correspondent a un user
        @param string $identifiant, string $password
        @return bool $isloginValide
    */
    public function isLoginValide(string $identifiant, string $password) : bool {
        $password=hash('sha256', $password);
        $sql = 'SELECT * FROM user WHERE Identifiant=:Identifiant and password=:password;';
        $prepared_Statement = $this->cnx->prepare($sql);
        $prepared_Statement->bindParam("Identifiant", $identifiant);
        $prepared_Statement->bindParam("password", $password);
        $prepared_Statement->execute();
        $loginValide = false;
        while ($row = $prepared_Statement->fetch(\PDO::FETCH_ASSOC)) {
            $loginValide = true;
        }
        return $loginValide;
    }
    
    /*
        Renvoie un user correspondant à l'identifiant et le password
        @param string $identifiant, string $password
        @return User $user
    */
    public function findUserByLogin(string $identifiant, string $password) : User{
        $password=hash('sha256', $password);
        $sql = 'SELECT * FROM user WHERE Identifiant=:Identifiant and password=:password;';
        $prepared_Statement = $this->cnx->prepare($sql);
        $prepared_Statement->bindParam("Identifiant", $identifiant);
        $prepared_Statement->bindParam("password", $password);
        $prepared_Statement->execute();
        while ($row = $prepared_Statement->fetch(\PDO::FETCH_ASSOC)) {
            $user = new User ($row['Identifiant'], $row['Nom'], $row['Prenom'], $row['password'], $row['IdRole']);
        }
        return $user;
    }
}
