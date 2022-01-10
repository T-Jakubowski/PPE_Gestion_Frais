<?php
namespace app\utils\filtre\filtreCaserne;

/*
* @author Baptiste Coquelet <b.coquelet@eleve.leschartreux.net>
*/
class FiltreCaserne{
    private $formData=[];
    private $results=[];


    public function __construct($formData){
        $this->formData=$formData;
    }
    public function acceptCaserne(string $key,AbstractCaserne $caserne){
        $data=$this->formData;
        foreach($data as $keys=>$value){
            if ($keys==$key){
                $datas=$caserne->checkCaserne($value);
            }
        }
        return $datas;
    }

    public function caser() : array {
        $data=$this->formData;
        $datas=array();
        foreach($data as $key=>$value){
            switch ($key) {
                case "num":
                    $datas[$key]=$this->acceptCaserne("num",new NumCaserne());
                    break;
                case "ville":
                    $datas[$key]=$this->acceptCaserne("ville",new VilleCaserne());
                    break;
                case "cp":
                    $datas[$key]=$this->acceptCaserne("cp",new CPCaserne());
                    break;
                case "codetypec":
                    $datas[$key]=$this->acceptCaserne("codetypec",new CodeTypeCCaserne());
                    break;
                case "addresse":
                    $datas[$key]=$this->acceptCaserne("addresse",new AdresseCaserne());
                    break;        
            }
        }
        return $datas;
    }
    public function getStatus(string $key){
        $datas=$this->caser();
        $value=$datas[$key];
        return $value;
    }
}

