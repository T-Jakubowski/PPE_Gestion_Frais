<?php
namespace app\utils\filtre\filtreLigneFrais;

class IdentifiantLigneFrais extends AbstractLigneFrais{
    
    public function checkLigneFrais(string $data): bool {
        $isValid=false;
        $IsExistInDB=$this->DAOLigneFrais->findIfIdentifiantExist($data);
        if ($IsExistInDB == true and strlen($data) < 20){
            $isValid = true;
        }
        else {
            $isValid = false;
        }
        
        return $isValid;
    }
}
?>