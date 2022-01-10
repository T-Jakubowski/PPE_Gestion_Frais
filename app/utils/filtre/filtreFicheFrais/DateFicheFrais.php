<?php
namespace app\utils\filtre\filtreFicheFrais;

class DateFicheFrais extends AbstractFicheFrais{

    function isValid($date, $format = 'Y-m-d') {
        $dt = \DateTime::createFromFormat($format, $date);
        return $dt && $dt->format($format) === $date;
    }
    
    public function checkFicheFrais(string $data): bool {
        $p = new DateFicheFrais;
        if ($p->isValid($data)) {
            return true;
        } else {
            return false;
        }
    }
}
?>