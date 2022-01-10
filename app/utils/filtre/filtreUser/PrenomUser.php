<?php
namespace app\utils\filtre\filtreUser;

class PrenomUser extends AbstractUser{
    public function checkUser(string $data): bool {
        $prenomUser = preg_match('~[A-Za-z]~', $data);
        if ($prenomUser && strlen($data) < 21) {
            return true;
        } else {
            return false;
        }
    }

}
