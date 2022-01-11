<?php
namespace app\utils\filtre\filtreFicheFrais;

class IsNumber extends AbstractFicheFrais{
    
    public function checkFicheFrais(string $data): bool {
        $isNumber = preg_match('~^[0-9]{0,6}$~', $data);
        if ($isNumber) {
            return true;
        } else {
            return false;
        }
    }
}
?>