<?php
namespace app\models;
class LigneFrais{

    private $num;
    private $libelle;
    private $prix;
    private $date;
    private $identifiant;


    public function __construct($num, $libelle, $prix, $date, $identifiant)
    {
        $this->num = $num;
        $this->libelle = $libelle;
        $this->prix = $prix;
        $this->date = $date;
        $this->identifiant = $identifiant;
    }

    public function getNum() {
        return $this->num;
    }
    public function getLibelle() {
        return $this->libelle;
    }
    public function getPrix() {
        return $this->prix;
    }
    public function getDate() {
        return $this->date;
    }
    public function getIdentifiant() {
        return $this->identifiant;
    }

    public function setNum($num) {
        $this->num = $num;
        return $this;
    }
    public function setLibelle($libelle) {
        $this->libelle = $libelle;
        return $this;
    }
    public function setPrix($prix) {
        $this->prix = $prix;
        return $this;
    }
    public function setDate($date) {
        $this->date = $date;
        return $this;
    }
    public function setIdentifiant($identifiant) {
        $this->identifiant = $identifiant;
        return $this;
    }
}



?>