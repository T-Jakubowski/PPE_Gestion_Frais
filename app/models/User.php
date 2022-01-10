<?php
namespace app\models;
class User{
    private $identifiant;
    private $nom;
    private $prenom;
    private $password;
    private $IdRole;

    public function __construct($identifiant,$nom, $prenom, $password,$IdRole)
    {
        $this->identifiant = $identifiant;
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->password = $password;
        $this->IdRole = $IdRole;
    }
    public function getIdentifiant() {
        return $this->identifiant;
    }
    public function getNom() {
        return $this->nom;
    }
    public function getPrenom() {
        return $this->prenom;
    }
    public function getPassword() {
        return $this->password;
    }
    public function getIdRole() {
        return $this->IdRole;
    }
    public function setIdentifiant($identifiant) {
        $this->identifiant = $identifiant;
        return $this;
    }
    public function setNom($nom) {
        $this->nom = $nom;
        return $this;
    }
    public function setPrenom($prenom) {
        $this->prenom = $prenom;
        return $this;
    }
    public function setPassword($password) {
        $this->password = $password;
        return $this;
    }
    public function setIdRoless($IdRole) {
        $this->IdRole = $IdRole;
        return $this;
    }
}



?>