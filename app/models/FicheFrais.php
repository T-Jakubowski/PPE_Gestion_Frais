<?php
namespace app\models;
class FicheFrais{

    private $date;
    private $identifiant;
    private $etat;
    private $km;
    private $repas;
    private $nuite;


    public function __construct($date, $identifiant, $etat, $km, $repas, $nuite)
    {
        $this->date = $date;
        $this->identifiant = $identifiant;
        $this->etat = $etat;
        $this->km = $km;
        $this->repas = $repas;
        $this->nuite = $nuite;
    }

    public function getDate() {
        return $this->date;
    }
    public function getIdentifiant() {
        return $this->identifiant;
    }
    public function getEtat() {
        return $this->etat;
    }
    public function getKm() {
        return $this->km;
    }
    public function getRepas() {
        return $this->repas;
    }
    public function getNuite() {
        return $this->nuite;
    }

    public function setDate($date) {
        $this->date = $date;
        return $this;
    }
    public function setIdentifiant($identifiant) {
        $this->identifiant = $identifiant;
        return $this;
    }
    public function setEtat($etat) {
        $this->etat = $etat;
        return $this;
    }
    public function setKm($km) {
        $this->km = $km;
        return $this;
    }
    public function setRepas($repas) {
        $this->repas = $repas;
        return $this;
    }
    public function setNuite($nuite) {
        $this->nuite = $nuite;
        return $this;
    }
}



?>