<?php
namespace app\utils\filtre\filtreCaserne;
/*
* @author Baptiste Coquelet <b.coquelet@eleve.leschartreux.net>
*/
class NumCaserne extends AbstractCaserne{
    public function checkCaserne(string $data) : bool {
        $isValid=false;
        $IsExistInDB=$this->DAOCaserne->findIfNumCaserneExist($data);
        if ($IsExistInDB==false){
            $chiffre = preg_match('@[0-9]@', $data);
            $noMajuscule = preg_match('@[A-Z]@', $data);
            $noMinuscule = preg_match('@[a-z]@', $data);
            $noSpecialChara = preg_match('#^[a-z0-9]+$#i', $data);
            if($chiffre && !$noMajuscule && !$noMinuscule && $noSpecialChara && strlen($data) > 0 && strlen($data) < 12)
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