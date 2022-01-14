<?php

namespace app\models;

use PDO;
use app\models\FicheFrais;

class DAOFicheFrais {

    private $cnx;

    public function __construct($cnx) {
        $this->cnx = $cnx;
    }


    public function find($date, $identifiant): FicheFrais 
    {
        $sql = 'SELECT * FROM fiche_frais WHERE Identifiant=:identifiant and Date = :date;';
        $prepared_Statement = $this->cnx->prepare($sql);
        $prepared_Statement->bindParam("identifiant", $identifiant);
        $prepared_Statement->bindParam("date", $date);
        $prepared_Statement->execute();
        while ($row = $prepared_Statement->fetch(PDO::FETCH_ASSOC)) {
            $ficheFrais = new FicheFrais($row['Date'], $row['Identifiant'], $row['Etat'], $row['Km'], $row['Repas'], $row['Nuite']);
        }
        return $ficheFrais;
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

    public function findDate($identifiant): array 
    {
        $sql = 'SELECT * FROM fiche_frais WHERE Identifiant=:identifiant;';
        $prepared_Statement = $this->cnx->prepare($sql);
        $prepared_Statement->bindParam("identifiant", $identifiant);
        $prepared_Statement->execute();
        while ($row = $prepared_Statement->fetch(PDO::FETCH_ASSOC)) {
            $desDates[] = $row['Date'];
        }
        return $desDates;
    }

    public function save(FicheFrais $ff): void
    {
        $sql = "INSERT INTO fiche_frais(Date, Identifiant, Etat, Km, Repas, Nuite)
                Values (:Date, :Identifiant, :Etat, :Km, :Repas, :Nuite);";
        $Date = $ff->getDate();
        $Identifiant = $ff->getIdentifiant();
        $Etat = $ff->getEtat();
        $Km = $ff->getKm();
        $Repas = $ff->getRepas();
        $Nuite = $ff->getNuite();

        $prepared_Statement = $this->cnx->prepare($sql);
        $prepared_Statement->bindParam("Date", $Date);
        $prepared_Statement->bindParam("Identifiant", $Identifiant);
        $prepared_Statement->bindParam("Etat", $Etat);
        $prepared_Statement->bindParam("Km", $Km);
        $prepared_Statement->bindParam("Repas", $Repas);
        $prepared_Statement->bindParam("Nuite", $Nuite);
        $prepared_Statement->execute();
    }

    public function edit(FicheFrais $ff): void
    {
        $sql = 'UPDATE fiche_frais
                SET Etat=:etat, Repas=:repas, Nuite=:nuite, Km=:km
                Where Date=:date and Identifiant=:identifiant';

        $date = $ff->getDate();
        $identifiant = $ff->getIdentifiant();
        $etat = $ff->getEtat();
        $km = $ff->getKm();
        $repas = $ff->getRepas();
        $nuite = $ff->getNuite();

        $prepared_Statement = $this->cnx->prepare($sql);
        $prepared_Statement->bindParam("date", $date);
        $prepared_Statement->bindParam("identifiant", $identifiant);
        $prepared_Statement->bindParam("etat", $etat);
        $prepared_Statement->bindParam("km", $km);
        $prepared_Statement->bindParam("repas", $repas);
        $prepared_Statement->bindParam("nuite", $nuite);
        $prepared_Statement->execute();
    }

    public function findIfFicheExist($date, $identifiant ): bool
    {
        $sql = 'SELECT * FROM fiche_frais WHERE Date=:date and Identifiant=:identifiant;';
        $prepared_Statement = $this->cnx->prepare($sql);
        $prepared_Statement->bindParam("date", $date);
        $prepared_Statement->bindParam("identifiant", $identifiant);
        $prepared_Statement->execute();
        $verification = false;
        while ($row = $prepared_Statement->fetch(PDO::FETCH_ASSOC)) {
            $verification = true;
        }
        return $verification;
    }

}

?>