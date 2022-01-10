<?php
namespace app\utils\filtre\filtrePompier;

class ChefAgretPompier extends AbstractPompier {

    public function checkPompier(string $data): bool {
        if ($data == 'O') {
            return true;
        } 
        elseif ($data == 'N') {
            return true;
        }
        else {
            return false;
        }
    }

}

?>