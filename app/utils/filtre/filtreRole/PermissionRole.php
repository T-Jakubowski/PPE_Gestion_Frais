<?php
namespace app\utils\filtre\filtreRole;

/*
* @author Baptiste Coquelet <b.coquelet@eleve.leschartreux.net>
*/
class PermissionRole extends AbstractRole{
    public function checkRole(string $data) : bool {
        $chiffre = preg_match('@[0-1]@', $data);
        if($chiffre && strlen($data) == 8)
        {
            $isValide=true;
        }
        else {
            $isValide=false;
            
        }
        return $isValide;
    }
}
?>