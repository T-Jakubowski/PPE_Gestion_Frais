<?php

namespace app\models;

use PDO;
use app\models\User;
use app\utils\SingletonDBMaria;

class DAOUser {

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

    /*
      Renvoie un user par rapport a son identifaint
      @param string $Identifiant
      @return User $user
     */

    public function findByidentifiant($Identifiant): User
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

    /*
      Enregistre un user dans la bdd
      @param User $u
      @return void
     */

    public function save(User $u): void
    {
        $sql = "INSERT INTO user(Identifiant, Nom, Prenom, password, IdRole)
                Values (:Identifiant, :Nom, :Prenom, :password, :IdRole);";
        $Identifiant = $u->getIdentifiant();
        $Nom = $u->getNom();
        $Prenom = $u->getPrenom();
        $password = $u->getpassword();
        $IdRole = $u->getidRole();

        $prepared_Statement = $this->cnx->prepare($sql);
        $prepared_Statement->bindParam("Identifiant", $Identifiant);
        $prepared_Statement->bindParam("Nom", $Nom);
        $prepared_Statement->bindParam("Prenom", $Prenom);
        $prepared_Statement->bindParam("password", $password);
        $prepared_Statement->bindParam("IdRole", $IdRole);

        $prepared_Statement->execute();
    }

    /*
      Met a jour un user existant
      @param User $u
      @return void
     */

    public function edit(User $u): void
    {

        $sql = 'UPDATE user
                SET Nom=:Nom, Prenom=:Prenom, password=:password, IdRole=:IdRole
                Where Identifiant=:Identifiant';

        $Identifiant = $u->getIdentifiant();
        $Nom = $u->getNom();
        $Prenom = $u->getPrenom();
        $password = $u->getpassword();
        $IdRole = $u->getidRole();

        $prepared_Statement = $this->cnx->prepare($sql);
        $prepared_Statement->bindParam("Identifiant", $Identifiant);
        $prepared_Statement->bindParam("Prenom", $Prenom);
        $prepared_Statement->bindParam("Nom", $Nom);
        $prepared_Statement->bindParam("password", $password);
        $prepared_Statement->bindParam("IdRole", $IdRole);
        $prepared_Statement->execute();
    }

    /*
      Supprime un user
      @param int $Id
      @return void
     */

    public function remove($Identifiant): void
    {
        $sql = 'delete from user WHERE Identifiant=:Identifiant;';
        $prepared_Statement = $this->cnx->prepare($sql);
        $prepared_Statement->bindParam("Identifiant", $Identifiant);
        $prepared_Statement->execute();
    }

    /*
      Renvoie Tout les user
      @param int $offset
      @param int $limit
      @return array<User>
     */
    public function findAll($offset = 0, $limit = 10) : array
    {

        $sql = 'SELECT * FROM user LIMIT :limit OFFSET :offset';
        $prepared_Statement = $this->cnx->prepare($sql);
        $prepared_Statement->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $prepared_Statement->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $prepared_Statement->execute();

        $desUser = array();
        while ($row = $prepared_Statement->fetch(\PDO::FETCH_ASSOC)) {
            $desUser[] = new User($row['Identifiant'], $row['Nom'], $row['Prenom'], $row['password'], $row['IdRole']);
        }
        return $desUser;
    }

    /*
      Renvoie Tout les user qui contienne value
      @param string $value
      @param int $offset
      @param int $limit
      @return array<User>
     */

    public function findAllWhereIdentifiant($value, $offset = 0, $limit = 10): Array {

        $sql = 'SELECT Identifiant, Nom, Prenom, password, IdRole FROM user WHERE Identifiant LIKE :Identifiant LIMIT :limit OFFSET :offset';
        $prepared_Statement = $this->cnx->prepare($sql);
        $value = "%$value%";
        $prepared_Statement->bindValue(':Identifiant', $value, \PDO::PARAM_STR);
        $prepared_Statement->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $prepared_Statement->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $prepared_Statement->execute();
        $desUser = [];
        while ($row = $prepared_Statement->fetch(\PDO::FETCH_ASSOC)) {
            $desUser[] = new User($row['Identifiant'], $row['Nom'], $row['Prenom'], $row['password'], $row['IdRole']);
        }
        return $desUser;
    }

    /*
      Renvoie le nombre de user
      @return int
     */

    public function count(): int {
        $sql = 'SELECT COUNT(*) as nbUser from user u ;';
        $statement = $this->cnx->query($sql);
        $nbUser = $statement->fetch(\PDO::FETCH_ASSOC);
        $nbUser = $nbUser['nbUser'];
        return $nbUser;
    }

    /*
      Renvoie le nombre de user qui contienne value
      @param string $value
      @return int
     */

    public function countWhere($value): int {
        $sql = 'SELECT COUNT(*) as nbUser from user where identifiant LIKE :Identifiant;';
        $prepared_Statement = $this->cnx->prepare($sql);
        $value = "%$value%";
        $prepared_Statement->bindValue(':Identifiant', $value, \PDO::PARAM_STR);
        $prepared_Statement->execute();
        $nbUser = $prepared_Statement->fetch(\PDO::FETCH_ASSOC);
        $nbUser = $nbUser['nbUser'];
        return $nbUser;
    }

    /*
      Renvoie Si le role en entré existe
      @param int $idRole
      @return bool
     */

    public function findIfRoleExist($idRole) {
        $SQL = 'SELECT * FROM role
        WHERE Id=:Id;';
        $cnx = $this->cnx;
        $preparedStatement = $cnx->prepare($SQL);
        $preparedStatement->bindParam("Id", $idRole);
        $preparedStatement->execute();
        $isExist = false;
        while ($row = $preparedStatement->fetch(\PDO::FETCH_ASSOC)) {
            $isExist = true;
        }
        return $isExist;
    }

    /*
      Renvoie Si l'user' en entré existe
      @param string $Identifiant
      @return bool
     */

    public function findifUserExist($Identifiant) {
        $sql = 'SELECT * FROM user WHERE Identifiant=:Identifiant;';
        $prepared_Statement = $this->cnx->prepare($sql);
        $prepared_Statement->bindParam("Identifiant", $Identifiant);
        $prepared_Statement->execute();
        $isExist = false;
        while ($row = $prepared_Statement->fetch(\PDO::FETCH_ASSOC)) {
            $isExist = true;
        }
        return $isExist;
    }

    /*
      Renvoie Si l'user en entré existe
      @param string $Identifiant
      @return bool
     */

    public function findifUserIdentifiantExist($Identifiant) {
        $sql = 'SELECT * FROM user WHERE Identifiant=:Identifiant;';
        $prepared_Statement = $this->cnx->prepare($sql);
        $prepared_Statement->bindParam("Identifiant", $Identifiant);
        $prepared_Statement->execute();
        $isExist = false;
        while ($row = $prepared_Statement->fetch(\PDO::FETCH_ASSOC)) {
            $isExist = true;
        }
        return $isExist;
    }

    /*
      Renvoie null si l'utilisateur / mdp n'est pas valide ou son
      @param string $login
      @param mixed $password
      @return bool
     */

    public function CheckUser($login, $password) {
        $sql = 'SELECT Identifiant,Nom,Prenom FROM user WHERE Identifiant=:Identifiant AND password=:password;';
        $prepared_Statement = $this->cnx->prepare($sql);
        $prepared_Statement->bindParam("Identifiant", $login);
        $prepared_Statement->bindParam("password", $password);
        $prepared_Statement->execute();
        $isExist = false;
        while ($row = $prepared_Statement->fetch(\PDO::FETCH_ASSOC)) {
            $user = new user($row['Identifiant'], $row['Nom'], $row['Prenom'], $row['password'], $row['IdRole']);
            $isExist = true;
        }
        if ($isExist == false) {
            return null;
        } else {

            return $user;
        }
        return $isExist;
    }

    /*
      Renvoie si l'utilisateur a bien ce mdp chiffré ou non
      @param string $login
      @param mixed $password
      @return bool
     */

    public function CheckPassword($login, $password) {
        $sql = 'SELECT Identifiant FROM user WHERE Identifiant=:Identifiant AND password=:password;';
        $prepared_Statement = $this->cnx->prepare($sql);
        $prepared_Statement->bindParam("Identifiant", $login);
        $prepared_Statement->bindParam("password", $password);
        $prepared_Statement->execute();
        $isExist = false;
        while ($row = $prepared_Statement->fetch(\PDO::FETCH_ASSOC)) {
            $isExist = true;
        }
        return $isExist;
    }

}

?>