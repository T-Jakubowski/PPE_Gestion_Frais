<?php
namespace app\utils\filtre\filtreCaserne;


/*
* @author Baptiste Coquelet <b.coquelet@eleve.leschartreux.net>
*/
class AdresseCaserne extends AbstractCaserne{

    public function checkCaserne(string $data) : bool {
        $isValid = false;

        $mot = preg_match('@\w@', $data);
        if($mot && strlen($data) > 4 && strlen($data) < 16)
        {
            $isValid = true;
        }
        else {
            $isValid = false;
        }

        return $isValid;
    }
}
?>