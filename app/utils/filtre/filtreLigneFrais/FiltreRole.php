<?php
namespace app\utils\filtre\filtreRole;

/*
* @author Baptiste Coquelet <b.coquelet@eleve.leschartreux.net>
*/
class FiltreRole{
    private $formData=[];
    private $results=[];

    public function __construct($formData){
        $this->formData=$formData;
    }
    public function acceptRole(string $key,AbstractRole $caserne){
        $data=$this->formData;
        foreach($data as $keys=>$value){
            if ($keys==$key){
                $datas=$caserne->checkRole($value);
            }
        }
        return $datas;
    }

    public function rol() : array {
        $data=$this->formData;
        $datas=array();
        foreach($data as $key=>$value){
            switch ($key) {
                case "role":
                    $datas[$key]=$this->acceptRole("role",new RoleRole());
                    break;
                case "permission":
                    $datas[$key]=$this->acceptRole("permission",new PermissionRole());
                    break;
                case "id":
                    $datas[$key]=$this->acceptRole("id",new IdRole());
                    break;
            }
        }
        return $datas;
    }
    public function getStatus(string $key){
        $datas=$this->rol();
        $value=$datas[$key];
        return $value;
    }
}

