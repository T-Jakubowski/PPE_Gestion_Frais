<?php
namespace app\utils\filtre\FiltreFicheFrais;

class FiltreFicheFrais{
    private $formData=[];
    private $results=[];

    public function __construct($formData){
        $this->formData=$formData;
    }
    public function acceptRole(string $key,AbstractFicheFrais $ficheFrais){
        $data=$this->formData;
        foreach($data as $keys=>$value){
            if ($keys==$key){
                $datas=$ficheFrais->checkFicheFrais($value);
            }
        }
        return $datas;
    }

    public function Fich() : array {
        $data=$this->formData;
        $datas=array();
        foreach($data as $key=>$value){
            switch ($key) {
                case "date":
                    $datas[$key]=$this->acceptRole("date",new DateFicheFrais());
                    break;
                case "identifiant":
                    $datas[$key]=$this->acceptRole("identifiant",new IdentifiantFicheFrais());
                    break;
                case "etat":
                    $datas[$key]=$this->acceptRole("etat",new EtatFicheFrais());
                    break;
                case "km":
                    $datas[$key]=$this->acceptRole("km",new KmFicheFrais());
                    break;
                case "repas":
                    $datas[$key]=$this->acceptRole("repas",new RepasFicheFrais());
                    break;
                case "nuite":
                    $datas[$key]=$this->acceptRole("nuite",new NuiteFicheFrais());
                    break;
            }
        }
        return $datas;
    }
    public function getStatus(string $key){
        $datas=$this->Fich();
        $value=$datas[$key];
        return $value;
    }
}

