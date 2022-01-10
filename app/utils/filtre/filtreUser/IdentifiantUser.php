<?php
namespace app\utils\filtre\filtreUser;
/*
* @author Baptiste Coquelet <b.coquelet@eleve.leschartreux.net>
*/
class IdentifiantUser extends AbstractUser{
    public function checkUser(string $data) : bool {
        $isValid = false;
        $isExist=false;

        $isExist=$this->DAOUser->findifUserExist($data);
        if ($isExist==false){
            $Lettre = preg_match('@[a-z]@i', $data);
            $noSpecialChara = preg_match('#^[a-z0-9]+$#i', $data);
            if($Lettre && $noSpecialChara && strlen($data) > 0 && strlen($data) < 21)
            {
                $isValid = true;
            }
            else {
                $isValid = false;
            }
        }
    return $isValid;
    }
}
?>