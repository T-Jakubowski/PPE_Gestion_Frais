<?php
namespace app\utils\filtre\filtreUser;
/*
* @author Baptiste Coquelet <b.coquelet@eleve.leschartreux.net>
*/
class FiltreUser{
    private $formData=[];
    private $results=[];

    public function __construct($formData){
        $this->formData=$formData;
    }
    public function acceptUser(string $key,AbstractUser $user){
        $data=$this->formData;
        foreach($data as $keys=>$value){
            if ($keys==$key){
                
                $datas=$user->checkUser($value);
            }
        }
        return $datas;
    }

    public function use() : array {
        $data=$this->formData;
        $datas=array();
        foreach($data as $key=>$value){
            switch ($key) {
                case "identifiant":
                    $datas[$key]=$this->acceptUser("identifiant",new IdentifiantUser());
                    break;
                case "nom":
                    $datas[$key]=$this->acceptUser("nom",new NomUser());
                    break;
                case "prenom":
                    $datas[$key]=$this->acceptUser("prenom",new PrenomUser());
                    break;
                case "password":
                    $datas[$key]=$this->acceptUser("password",new PasswordUser());
                    break;
                case "idRole":
                    $datas[$key]=$this->acceptUser("idRole",new IdRoleUser());
                    break;  
            }
        }
        return $datas;
    }
    public function getStatus(string $key){
        $datas=$this->use();
        $value=$datas[$key];
        return $value;
    }
}

