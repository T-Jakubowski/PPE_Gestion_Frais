<?php
namespace app\utils\filtre\filtreFicheFrais;

class NuiteFicheFrais extends AbstractFicheFrais{
    
    public function checkFicheFrais(string $data): bool {
        $isNumber = preg_match('~^[0-9]{6}$~', $data);
        if ($data == $isNumber) {
            return true;
        } else {
            return false;
        }
    }
}
?>