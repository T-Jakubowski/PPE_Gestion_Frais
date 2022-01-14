<?php
namespace app\utils\filtre\filtreLigneFrais;

class FiltreLigneFrais{
    private $formData=[];
    private $results=[];

    public function __construct($formData){
        $this->formData=$formData;
    }
    public function acceptLigneFrais(string $key,AbstractLigneFrais $ligne){
        $data=$this->formData;
        foreach($data as $keys=>$value){
            if ($keys==$key){
                $datas=$ligne->checkLigneFrais($value);
            }
        }
        return $datas;
    }

    public function lign() : array {
        $data=$this->formData;
        $datas=array();
        foreach($data as $key=>$value){
            switch ($key) {
                case "num":
                    $datas[$key]=$this->acceptLigneFrais("num",new IsNumber());
                    break;
                case "libelle":
                    $datas[$key]=$this->acceptLigneFrais("libelle",new LibelleLigneFrais());
                    break;
                case "prix":
                    $datas[$key]=$this->acceptLigneFrais("prix",new IsNumber());
                    break;
                case "date":
                    $datas[$key]=$this->acceptLigneFrais("date",new DateLigneFrais());
                    break;
                case "identifiant":
                    $datas[$key]=$this->acceptLigneFrais("identifiant",new IdentifiantLigneFrais());
                    break;
                default:
                    break;
            }
        }
        return $datas;
    }
    public function getStatus(string $key){
        $datas=$this->lign();
        $value=$datas[$key];
        return $value;
    }
}

