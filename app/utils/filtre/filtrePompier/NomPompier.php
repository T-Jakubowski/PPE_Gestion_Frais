<?php
namespace app\utils\filtre\filtrePompier;

class NomPompier extends AbstractPompier {
    public function checkPompier(string $data): bool {
        $nomPompier = preg_match('~[A-Za-z]~', $data);
        if ($nomPompier && strlen($data) < 21) {
            return true;
        } 
        else {
            return false;
        }
    }

}

?>

