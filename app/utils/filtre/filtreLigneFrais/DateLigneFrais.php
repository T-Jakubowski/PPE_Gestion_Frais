<?php
namespace app\utils\filtre\filtreLigneFrais;

class DateLigneFrais extends AbstractLigneFrais{

    function isValid($date, $format = 'Y-m-d') {
        $dt = \DateTime::createFromFormat($format, $date);
        return $dt && $dt->format($format) === $date;
    }
    
    public function checkLigneFrais(string $data): bool {
        $p = new DateLigneFrais;
        if ($p->isValid($data)) {
            return true;
        } else {
            return false;
        }
    }
}
?>