<?php
namespace app\utils\filtre\filtrePompier;

class MatriculeRespoPompier extends AbstractPompier {

    public function checkPompier(string $data): bool {
        $IsExistInDB = $this->DAOPompier->findIfMatriculePompierExist($data);
        if ($data == ""){
            $IsExistInDB = true;
        }
        return $IsExistInDB;
    }

}

?>