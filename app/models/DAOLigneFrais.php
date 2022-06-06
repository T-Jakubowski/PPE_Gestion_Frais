<?php

namespace app\models;

use PDO;
use app\models\LigneFrais;

class DAOLigneFrais {

    private $cnx;

    public function __construct($cnx) {
        $this->cnx = $cnx;
    }


    public function find($date, $identifiant) : Array 
    {
        $sql = 'SELECT * FROM ligne_frais WHERE Identifiant=:identifiant and Date = :date;';
        $prepared_Statement = $this->cnx->prepare($sql);
        $prepared_Statement->bindParam("identifiant", $identifiant);
        $prepared_Statement->bindParam("date", $date);
        $prepared_Statement->execute();
        while ($row = $prepared_Statement->fetch(\PDO::FETCH_ASSOC)) {
            $desLigneFrais[] = new LigneFrais ($row['Num'], $row['Libelle'], $row['Prix'], $row['Date'], $row['Identifiant']);
        }
        return $desLigneFrais;
    }

    public function findIfExist($date, $identifiant) : bool
    {
        $sql = 'SELECT * FROM ligne_frais WHERE Identifiant=:identifiant and Date = :date;';
        $prepared_Statement = $this->cnx->prepare($sql);
        $prepared_Statement->bindParam("identifiant", $identifiant);
        $prepared_Statement->bindParam("date", $date);
        $prepared_Statement->execute();
        $verification = false;
        while ($row = $prepared_Statement->fetch(\PDO::FETCH_ASSOC)) {
            $verification = true;
        }
        return $verification;
    }

    public function remove($Num): void
    {
        $sql = 'delete from ligne_frais WHERE Num=:Num;';
        $prepared_Statement = $this->cnx->prepare($sql);
        $prepared_Statement->bindParam("Num", $Num);
        $prepared_Statement->execute();
    }

    public function findIfIdentifiantExist($identifiant): bool
    {
        $sql = 'SELECT * FROM fiche_frais WHERE Identifiant=:identifiant;';
        $prepared_Statement = $this->cnx->prepare($sql);
        $prepared_Statement->bindParam("identifiant", $identifiant);
        $prepared_Statement->execute();
        $verification = false;
        while ($row = $prepared_Statement->fetch(PDO::FETCH_ASSOC)) {
            $verification = true;
        }
        return $verification;
    }

    public function findIfLineExist($num): bool
    {
        $sql = 'SELECT * FROM ligne_frais WHERE Num=:num;';
        $prepared_Statement = $this->cnx->prepare($sql);
        $prepared_Statement->bindParam("num", $num);
        $prepared_Statement->execute();
        $verification = false;
        while ($row = $prepared_Statement->fetch(PDO::FETCH_ASSOC)) {
            $verification = true;
        }
        return $verification;
    }

    public function edit(LigneFrais $ln): void
    {

        $sql = 'UPDATE ligne_frais
                SET Libelle=:libelle, Prix=:prix
                Where Num=:num';

        $libelle = $ln->getLibelle();
        $prix = $ln->getPrix();
        $num = $ln->getNum();

        $prepared_Statement = $this->cnx->prepare($sql);
        $prepared_Statement->bindParam("libelle", $libelle);
        $prepared_Statement->bindParam("prix", $prix);
        $prepared_Statement->bindParam("num", $num);;
        $prepared_Statement->execute();
    }

    public function save(LigneFrais $ln): void
    {
        $sql = "INSERT INTO ligne_frais(Libelle, Prix, Date, Identifiant)
                Values (:libelle, :prix, :date, :identifiant);";
        $libelle = $ln->getLibelle();
        $prix = $ln->getPrix();
        $date = $ln->getDate();
        $identifiant = $ln->getIdentifiant();

        $prepared_Statement = $this->cnx->prepare($sql);
        $prepared_Statement->bindParam("libelle", $libelle);
        $prepared_Statement->bindParam("prix", $prix);
        $prepared_Statement->bindParam("date", $date);
        $prepared_Statement->bindParam("identifiant", $identifiant);

        $prepared_Statement->execute();
    }

}

?>