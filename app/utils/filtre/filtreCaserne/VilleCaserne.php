<?php
namespace app\utils\filtre\filtreCaserne;
/*
* @author Baptiste Coquelet <b.coquelet@eleve.leschartreux.net>
*/
class VilleCaserne extends AbstractCaserne{
    public function checkCaserne(string $data) : bool {
        $Lettre = preg_match('@[a-z]@i', $data);
        $noNumber = preg_match('@[0-9]@',$data);
        $noSpecialChara = preg_match('#^[a-z0-9]+$#i', $data);
        if($Lettre && !$noNumber && $noSpecialChara && strlen($data) > 0 && strlen($data) < 11)
        {
            return true;
        }
        else {
            return false;
        }
    }
}
?>