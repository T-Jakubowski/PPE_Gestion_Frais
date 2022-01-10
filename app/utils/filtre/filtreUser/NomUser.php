<?php
namespace app\utils\filtre\filtreUser;

class NomUser extends AbstractUser{
        public function checkUser(string $data): bool {
        $nomUser = preg_match('~[A-Za-z]~', $data);
        if ($nomUser && strlen($data) < 21) {
            return true;
        } 
        else {
            return false;
        }
    }
}
