<?php
namespace app\utils\filtre\filtrePompier;

class PrenomPompier extends AbstractPompier {

    public function checkPompier(string $data): bool {
        $prenomPompier = preg_match('~[A-Za-z]~', $data);
        if ($prenomPompier && strlen($data) < 21) {
            return true;
        } 
        else {
            return false;
        }
    }

}

?>


