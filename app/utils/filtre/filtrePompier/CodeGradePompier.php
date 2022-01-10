<?php
namespace app\utils\filtre\filtrePompier;

class CodeGradePompier extends AbstractPompier {

    public function checkPompier(string $data): bool {
        $isExist=$this->DAOPompier->iscodeGradePompierExist($data);
        if ($isExist==true) {
            return true;
        } else {
            return false;
        }
    }

}

?>


