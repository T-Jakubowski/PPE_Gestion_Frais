<?php
namespace app\utils\filtre\filtreLigneFrais;

class IsNumber extends AbstractLigneFrais{
    public function checkLigneFrais(string $data): bool {
        $isNumber = preg_match('~^[0-9]{0,6}$~', $data);
        if ($isNumber) {
            return true;
        } else {
            return false;
        }
    }
}
?>