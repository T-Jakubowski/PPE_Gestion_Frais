<?php
namespace app\utils\filtre\filtreCaserne;

/*
* @author Baptiste Coquelet <b.coquelet@eleve.leschartreux.net>
*/
class CodeTypeCCaserne extends AbstractCaserne{
    public function checkCaserne(string $data) : bool {
        $IsExistInDB=$this->DAOCaserne->findIfTypeCaserneExist($data);
        return $IsExistInDB;
    }
}
?>