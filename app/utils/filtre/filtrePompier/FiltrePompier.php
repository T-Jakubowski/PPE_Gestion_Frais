<?php
namespace app\utils\filtre\filtrePompier;

class FiltrePompier{
    private $formData=[];
    private $results=[];


    public function __construct($formData){
        $this->formData=$formData;
    }
    public function acceptPompier(string $key, AbstractPompier $pompier){
        $data=$this->formData;
        foreach($data as $keys=>$value){
            if ($keys==$key){
                $datas=$pompier->checkPompier($value);
            }
        }
        return $datas;
    }

    public function pompie() : array {
        $data=$this->formData;
        $datas=array();
        foreach($data as $key=>$value){
            switch ($key) {
                case "matricule":
                    $datas[$key]=$this->acceptPompier("matricule",new MatriculePompier());
                    break; 
                case "nom":
                    $datas[$key]=$this->acceptPompier("nom",new NomPompier());
                    break;
                case "prenom":
                    $datas[$key]=$this->acceptPompier("prenom",new PrenomPompier());
                    break; 
                case "chefAgret":
                    $datas[$key]=$this->acceptPompier("chefAgret",new ChefAgretPompier());
                    break;
                case "dateNaissance":
                    $datas[$key]=$this->acceptPompier("dateNaissance",new DateNaissancePompier());
                    break;
                case "numCaserne":
                    $datas[$key]=$this->acceptPompier("numCaserne",new NumCasernePompier());
                    break; 
                case "codeGrade":
                    $datas[$key]=$this->acceptPompier("codeGrade",new CodeGradePompier());
                    break;
                case "matriculeRespo":
                    $datas[$key]=$this->acceptPompier("matriculeRespo",new MatriculeRespoPompier());
                    break;        
            }
        }
        return $datas;
    }
    public function getStatus(string $key){
        $datas=$this->pompie();
        $value=$datas[$key];
        return $value;
    }
}
