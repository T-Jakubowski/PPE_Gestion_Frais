<?php
namespace app\utils\filtre\filtrePompier;

class DateNaissancePompier extends AbstractPompier {

    function isValid($date, $format = 'Y-m-d') {
        $dt = \DateTime::createFromFormat($format, $date);
        return $dt && $dt->format($format) === $date;
    }

    public function checkPompier(string $data): bool {
        $p = new DateNaissancePompier;
        if ($p->isValid($data)) {
            return true;
        } else {
            return false;
        }
    }

}
?>

