<?php
namespace app\models;
class Role{

    private $id;
    private $role;
    private $permission;

    public function __construct($id,$role,$permission)
    {
        $this->id = $id;
        $this->role = $role;
        $this->permission = $permission;
    }
    public function getId() {
        return $this->id;
    }
    public function getRole() {
        return $this->role;
    }
    public function getPermission() {
        return $this->permission;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }
    public function setRole($role) {
        $this->role = $role;
        return $this;
    }
    public function setPermission($permission) {
        $this->permission = $permission;
        return $this;
    }
}



?>