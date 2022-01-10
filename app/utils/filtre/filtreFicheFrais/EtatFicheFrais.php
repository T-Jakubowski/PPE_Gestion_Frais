<?php
namespace app\utils\filtre\filtreFicheFrais;

class EtatFicheFrais extends AbstractFicheFrais{
    
    public function checkFicheFrais(string $data): bool {
        if ($data == 'Remboursée' or $data == 'Validée' or $data == 'En cours') {
            return true;
        } else {
            return false;
        }
    }
}
?>