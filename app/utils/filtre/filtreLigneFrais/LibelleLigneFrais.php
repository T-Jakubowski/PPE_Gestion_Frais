<?php
namespace app\utils\filtre\filtreLigneFrais;

class LibelleLigneFrais extends AbstractLigneFrais{
    public function checkLigneFrais(string $data): bool {
        $isLibelle = preg_match('~[a-zA-Z]~', $data);
        if ($isLibelle and strlen($data) < 15) {
            return true;
        } else {
            return false;
        }
    }
}
?>