<?php
namespace app\utils\filtre\filtreFicheFrais;

class IdentifiantFicheFrais extends AbstractFicheFrais{
    
    public function checkFicheFrais(string $data): bool {
        $isValid=false;
        $IsExistInDB=$this->DAOFicheFrais->findIfIdentifiantExist($data);
        if ($IsExistInDB==false){
            if(strlen($data) < 20)
            {
                $isValid = true;
            }
            else {
                $isValid = false;
            }
        }
        return $isValid;
    }
}
?>