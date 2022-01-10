<?php
namespace app\utils;
use app\utils\SingletonDBMaria;
use app\models\User;
use app\models\DAOAuth;

class Auth{
    
    private static DAOAuth $DAOAuth;

    public function __construct() {
        $cnx = SingletonDBMaria::getInstance()->getConnection();
        $DAOAuth = new DAOAuth($cnx);
        self::$DAOAuth = $DAOAuth;
    }
    
    /*
        Crée des session contenant les données d'un User
        @param User $user
        @return void
    */
    public static function login(User $user) : void{
        self::start_session();

        $identifiant = $user->getIdentifiant();
        $nom = $user->getNom();
        $prenom = $user->getPrenom();
        $idRole = $user->getIdRole();
        
        $_SESSION['identifiant']=$identifiant;
        $_SESSION['nom']=$nom;
        $_SESSION['prenom']=$prenom;
        $_SESSION['idRole']=$idRole;

    }
    /*
    * detruit la session si un session est active
    * @return void
    */
    public static function logout() : void{
        if (self::is_logged() == true){ 
            session_destroy();   
        }
    }
    /*
    * Vérifie qu'il y ait bien une variable de session User
    * @return bool
    */
    public static function is_logged() : bool {
        if (session_status() == PHP_SESSION_ACTIVE) {
            return true;
        }
        return false;
    }
    
    /*
        Regarde si la session d'un user est active
        @return bool
    */
    public static function is_session_active() : bool{
        if (isset($_SESSION['identifiant'])){
            return true;    
        }
        else{
            return false;        
        }
    }
    
    /*
        active une session si aucune n'est lancée
        @return void
    */
    public static function start_session (): void{
        if (self::is_logged() == false) {
            session_start();
        }
    }
    /*
    * retourne si la personne logger à le role entré
    * @param string $role
    * @return bool
    */
    public static function has(string $role) : bool {
        self::start_session();
        $isrole = self::$DAOAuth->findRoleById($_SESSION['idRole']);
        if ($isrole == $role)
        {
            return true;
        }else{
            return false;
        }
    }
    
    /*
    * retourne si la personne logger a la permission entré
    * @param string $perm
    * @return bool
    */
    public function can(string $perm) : bool {
        self::start_session();
        $isperm = self::$DAOAuth->findPermissionById($_SESSION['idRole']);
        switch($perm){
            case 'read':
                if ($isperm[7] == '1'){
                    return true;
                }
                else{
                    return false;
                } 
                break;
            case 'write':
                if ($isperm[6] == '1'){
                    return true;
                }
                else{
                    return false;
                } 
                break;
            case 'update':
                if ($isperm[5] == '1'){
                    return true;
                }
                else{
                    return false;
                } 
                break;
            case 'delete':
                if ($isperm[4] == '1'){
                    return true;
                }
                else{
                    return false;
                } 
                break;
            case 'manage':
                if ($isperm[3] == '1'){
                    return true;
                }
                else{
                    return false;
                } 
                break;
                
        }
        

        
    }
}

?>