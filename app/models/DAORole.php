<?php

namespace app\models;

class DAORole {

    private $cnx;

    public function __construct($cnx) {
        $this->cnx = $cnx;
    }

    /*
      Renvoie un role par rapport a son id
      @param int $Id
      @return Role $Role
     */
    public function find($Id): Role {
        $sql = 'SELECT * FROM role WHERE Id=:Id;';
        $prepared_Statement = $this->cnx->prepare($sql);
        $prepared_Statement->bindParam("Id", $Id);
        $prepared_Statement->execute();
        while ($row = $prepared_Statement->fetch(\PDO::FETCH_ASSOC)) {
            $Role = new Role($row['Id'], $row['Role'], $row['Permission']);
        }
        return $Role;
    }

    /*
      Enregistre un role  dans la bdd
      @param Role $r
      @return void
     */

    public function save(Role $r): void {
        $sql = "INSERT INTO role(Id, Role, Permission)
                Values (:Id, :Role, :Permission);";
        $Id = $r->getId();
        $Role = $r->getRole();
        $Permission = $r->getPermission();

        $prepared_Statement = $this->cnx->prepare($sql);
        $prepared_Statement->bindParam("Id", $Id);
        $prepared_Statement->bindParam("Role", $Role);
        $prepared_Statement->bindParam("Permission", $Permission);

        $prepared_Statement->execute();
    }

    /*
      Met a jour un role existant
      @param Role $r
      @return void
     */

    public function edit(Role $r): void {
        $sql = 'UPDATE role
                SET Role=:Role, Permission=:Permission
                Where Id=:Id';
        $Id = $r->getid();
        $Role = $r->getRole();
        $Permission = $r->getPermission();
        $prepared_Statement = $this->cnx->prepare($sql);
        $prepared_Statement->bindParam("Id", $Id);
        $prepared_Statement->bindParam("Role", $Role);
        $prepared_Statement->bindParam("Permission", $Permission);
        $prepared_Statement->execute();
    }

    /*
      Supprime un role
      @param int $Id
      @return void
     */

    public function remove($Id): void {
        $sqldelete2 = 'DELETE from role WHERE Id=:Id;';
        $prepared_Statement = $this->cnx->prepare($sqldelete2);
        $prepared_Statement->bindParam("Id", $Id);
        $prepared_Statement->execute();
    }

    /*
      Renvoie Tout les roles
      @param int $offset
      @param int $limit
      @return array<Role>
     */

    public function findAll($offset = 0, $limit = 10): Array
    {

        $sql = 'SELECT * FROM role LIMIT :limit OFFSET :offset';
        $prepared_Statement = $this->cnx->prepare($sql);
        $prepared_Statement->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $prepared_Statement->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $prepared_Statement->execute();

        $desRoles = array();
        while ($row = $prepared_Statement->fetch(\PDO::FETCH_ASSOC)) {
            $desRoles[] = new Role($row['Id'], $row['Role'], $row['Permission']);
        }
        return $desRoles;
    }

    /*
      Renvoie Tout les roles qui contienne $value
      @param string $value
      @param int $offset
      @param int $limit
      @return array<Role>
     */
    public function findAllWhereName($value, $offset = 0, $limit = 10): Array {

        $sql = 'SELECT * FROM role WHERE Role LIKE :Role LIMIT :limit OFFSET :offset';
        $prepared_Statement = $this->cnx->prepare($sql);
        $value = "%$value%";
        $prepared_Statement->bindParam(':Role', $value, \PDO::PARAM_STR);
        $prepared_Statement->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $prepared_Statement->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $prepared_Statement->execute();

        $desRoles = array();
        while ($row = $prepared_Statement->fetch(\PDO::FETCH_ASSOC)) {
            $desRoles[] = new Role($row['Id'], $row['Role'], $row['Permission']);
        }
        return $desRoles;
    }

    /*
      Renvoie le nombre de role
      @return int $nbRole
     */
    public function count(): int {
        $sql = 'SELECT COUNT(*) as nbRoles from role p ;';
        $statement = $this->cnx->query($sql);
        $nbRoles = $statement->fetch(\PDO::FETCH_ASSOC);
        $nbRole = $nbRoles['nbRoles'];
        return $nbRole;
    }

    /*
        Renvoie un nombre de pompier en fonction d'un mot
        @param string $value
        @return int $nbRole
    */
    public function countWhere(string $value): int {
        $sql = 'SELECT COUNT(*) as nbRoles from role WHERE Role LIKE :Role  ;';
        $prepared_Statement = $this->cnx->prepare($sql);
        $value = "%$value%";
        $prepared_Statement->bindValue(':Role', $value, \PDO::PARAM_STR);
        $prepared_Statement->execute();
        $nbRole = $prepared_Statement->fetch(\PDO::FETCH_ASSOC);
        $nbRole = $nbRole['nbRoles'];
        return $nbRole;
    }

    /*
      Renvoie Si le nom du role en entré existe
      @param string $roleName
      @return bool
     */

    public function findifRoleExist(string $roleName) : bool{
        $sql = 'SELECT * FROM role WHERE Role=:roleName;';
        $prepared_Statement = $this->cnx->prepare($sql);
        $prepared_Statement->bindParam("roleName", $roleName);
        $prepared_Statement->execute();
        $isExist = false;
        while ($row = $prepared_Statement->fetch(\PDO::FETCH_ASSOC)) {
            $isExist = true;
        }
        return $isExist;
    }
    /*
      Renvoie Si le nom du role en entré existe
      @param int $Identifiant
      @return bool
     */
    public function findifRoleIdExist(int $Identifiant) : bool{
        $sql = 'SELECT * FROM role WHERE Id=:Id;';
        $prepared_Statement = $this->cnx->prepare($sql);
        $prepared_Statement->bindParam("Id", $Identifiant);
        $prepared_Statement->execute();
        $isExist = false;
        while ($row = $prepared_Statement->fetch(\PDO::FETCH_ASSOC)) {
            $isExist = true;
        }
        return $isExist;
    }
    
    /*
        Renvoie un user en fonction du role
        @param int $Identifiant
        @return bool $isExist
    */
    public function findUserFromRole(int $Identifiant) : bool{
        $sql = 'SELECT * FROM user WHERE IdRole=:Identifiant';
        $prepared_Statement = $this->cnx->prepare($sql);
        $prepared_Statement->bindParam("Identifiant", $Identifiant);
        $prepared_Statement->execute();
        $isExist = false;
        while($row = $prepared_Statement->fetch(\PDO::FETCH_ASSOC)){
            $isExist = true;
        }
        return $isExist;
    }
    
    
}

?>