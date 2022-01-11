<?php

namespace app\controllers;

use app\models\DAOFicheFrais;
use app\models\FicheFrais;
use app\models\DAOLigneFrais;
use app\models\DAOUser;
use app\utils\SingletonDBMaria;
use app\utils\Renderer;
use app\models\DAOAuth;
use app\utils\Auth;
use app\utils\filtre\filtreFicheFrais\FiltreFicheFrais;


class FicheFraisController extends BaseController
{
    private DAOLigneFrais $DAOLigneFrais;
    private DAOFicheFrais $DAOFicheFrais;
    private DAOUser $DAOUser;

    public function __construct() {
        $cnx = SingletonDBMaria::getInstance()->getConnection();
        $DAOFicheFrais = new DAOFicheFrais($cnx);
        $this->DAOFicheFrais = $DAOFicheFrais;

        $DAOLigneFrais = new DAOLigneFrais($cnx);
        $this->DAOLigneFrais = $DAOLigneFrais;

        $DAOUser = new DAOUser($cnx);
        $this->DAOUser = $DAOUser;
    }

    public function show() : void {

        $auth = new Auth();
        $isactive = $auth->is_session_active();
        if ($isactive == true) {
            $permission_read = $auth->can('read');
            $permission_manage = $auth->can('manage');
            if ($permission_read) {
                $whoIsLogged = $_SESSION['identifiant'];
                $today = date("Y-m-01");
                $ficheFrais = $this->DAOFicheFrais->find('1999-08-30', 'adtdyganed');
                $desLigneFrais = $this->DAOLigneFrais->find('1999-08-30','adtdyganed');
                $desDates = $this->DAOFicheFrais->findDate('adtdyganed');
                $desUsers = $this->DAOUser->findAllNoLimit();
                $page = Renderer::render("view_fiche_frais.php", compact('ficheFrais', 'desLigneFrais', 'desDates', 'desUsers'));     
            } else {
                $page = Renderer::render("view_denyAccess.php");
            }
        } else {
            $page = Renderer::render("view_login.php");
        }
        echo $page;
    }

    public function insert(){
        
        
    }

    public function delete(){
        $this->DAOLigneFrais->remove($_SESSION("editidentifiant"));
    }

    public function edit(){

        $auth = new Auth();
        $isactive = $auth->is_session_active();
        if ($isactive == true) {
            $permission = $auth->can('update');
            if ($permission) {


                $Date = date("Y-m-01");
                $Identifiant = $_SESSION['identifiant'];
                $Etat = htmlspecialchars($_POST['editEtat']);
                $Km = htmlspecialchars($_POST['editKm']);
                $Repas = htmlspecialchars($_POST['editRepas']);
                $Nuite = htmlspecialchars($_POST['editNuite']);

                $data = array(
                    "date" => $Date,
                    "identifiant" => $Identifiant,
                    "etat" => $Etat,
                    "km" => $Km,
                    "repas" => $Repas,
                    "nuite" => $Nuite,
                );
                $f = new FiltreFicheFrais($data);
                $data = $f->Fich();
                $isSuccess = true;
                foreach ($data as $key => $value) {
                    if ($value == false) {
                        if ($key != "id") {
                            $isSuccess = false;
                            $valueError[] = $key;
                        }
                    }
                }
                
                if ($isSuccess == true) {
                    $ficheToUpdate = new FicheFrais($Date, $Identifiant, $Etat, $Repas, $Repas, $Nuite);
                    $this->DAOFicheFrais->save($ficheToUpdate);
                    $resultMessage = "la fiche a bien été modifier";
                    $page = Renderer::render("view_fiche_frais_edit.php", compact("resultMessage"));
                } else {
                    $page = Renderer::render("view_fiche_frais_edit.php", compact("valueError"));
                }
            } else {
                $page = Renderer::render("view_denyAccess.php");
            }
        } else {
            $page = Renderer::render("view_login.php");
        }
        echo $page;
    }
}
