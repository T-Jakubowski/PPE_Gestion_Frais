<?php
namespace app\utils\filtre\filtreRole;

/*
* @author Baptiste Coquelet <b.coquelet@eleve.leschartreux.net>
*/
class IdRole extends AbstractRole{
    public function checkRole(string $data) : bool {
        $isValide=false;
        $chiffre = preg_match('@[0-9]@', $data);
        if($chiffre && strlen($data) > 0 && strlen($data) < 6)
        {
            $IsExistInDB = $this->DAORole->findifRoleIdExist($data);
            if($IsExistInDB==false){
                $isValide=true;
            }
        }
        else {
            
        }
        return $isValide;
    }
}
?>