<?php

namespace app\models;

use PDO;
use app\models\LigneFrais;

class DAOLigneFrais {

    private $cnx;

    public function __construct($cnx) {
        $this->cnx = $cnx;
    }


    public function find($date, $identifiant, $offset = 0, $limit = 10) : Array 
    {
        $sql = 'SELECT * FROM ligne_frais WHERE Identifiant=:identifiant and Date = :date LIMIT :limit OFFSET :offset;';
        $prepared_Statement = $this->cnx->prepare($sql);
        $prepared_Statement->bindParam("identifiant", $identifiant);
        $prepared_Statement->bindParam("date", $date);
        $prepared_Statement->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $prepared_Statement->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $prepared_Statement->execute();
        while ($row = $prepared_Statement->fetch(\PDO::FETCH_ASSOC)) {
            $desLigneFrais[] = new LigneFrais ($row['Num'], $row['Libelle'], $row['Prix'], $row['Date'], $row['Identifiant']);
        }
        return $desLigneFrais;
    }

    public function remove($Num): void
    {
        $sql = 'delete from ligne_frais WHERE Num=:Num;';
        $prepared_Statement = $this->cnx->prepare($sql);
        $prepared_Statement->bindParam("Num", $Num);
        $prepared_Statement->execute();
    }
}

?>