<?php
namespace app\utils\filtre\filtreCaserne;
/*
* @author Baptiste Coquelet <b.coquelet@eleve.leschartreux.net>
*/
class CPCaserne extends AbstractCaserne{
    public function checkCaserne(string $data) : bool {
        $chiffre = preg_match('@[0-9]{5}@', $data);
        if($chiffre && strlen($data) == 5)
        {
            return true;
        }
        else {
            return false;
        }
    }
}
?>