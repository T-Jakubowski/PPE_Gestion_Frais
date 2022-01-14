<?php

namespace app\controllers;

use app\models\DAOFicheFrais;
use app\models\FicheFrais;
use app\models\DAOLigneFrais;
use app\models\DAOUser;
use app\utils\SingletonDBMaria;
use app\utils\Renderer;
use app\models\DAOAuth;
use app\models\LigneFrais;
use app\utils\Auth;
use app\utils\filtre\filtreFicheFrais\FiltreFicheFrais;
use app\utils\filtre\filtreLigneFrais\FiltreLigneFrais;


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

        $user = $_SESSION['identifiant'];
        $date = date("Y-m-01");

        if(isset($_POST['selectFiche'])){
            echo "Select";
        }

        $auth = new Auth();
        $isactive = $auth->is_session_active();
        if ($isactive == true) {
            $permission_read = $auth->can('read');
            $permission_manage = $auth->can('manage');
            if ($permission_read) {
                $userSelected = false;

                if(isset($_POST['date']) and $permission_manage){
                    $date = htmlspecialchars($_POST['date']);
                    
                }
                if(isset($_POST['desUsers'])){
                    $user = htmlspecialchars($_POST['desUsers']);
                }  
                    
                $ficheExist = $this->DAOFicheFrais->findIfFicheExist($date, $user);
                if ($ficheExist) {
                    $ficheFrais = $this->DAOFicheFrais->find($date, $user);
                } else {
                    $ficheFraisToAdd = new FicheFrais($date, $user, 'En Cours',0,0,0);
                    $this->DAOFicheFrais->save($ficheFraisToAdd);
                    $ficheFrais = $this->DAOFicheFrais->find($date, $user);
                }
                $ligneExist = $this->DAOLigneFrais->findIfExist($date, $user);
                $desDates = $this->DAOFicheFrais->findDate($user);
                $desUsers = $this->DAOUser->findAllNoLimit();
                




                if ($ligneExist == true) {
                    $desLigneFrais = $this->DAOLigneFrais->find($date, $user);
                    $page = Renderer::render("view_fiche_frais.php", compact('ficheFrais', 'user','desLigneFrais', 'desDates', 'desUsers', 'ligneExist', 'permission_manage', 'userSelected'));    
                }
                else{
                    $page = Renderer::render("view_fiche_frais.php", compact('ficheFrais', 'user', 'ligneExist', 'desDates', 'desUsers','userSelected')); 
                }
            } else {
                $page = Renderer::render("view_denyAccess.php");
            }
        } else {
            $page = Renderer::render("view_login.php");
        }
        echo $page;
    }

    public function insert(){
        $auth = new Auth();
        $isactive = $auth->is_session_active();
        if ($isactive == true) {
            $permission = $auth->can('write');
            if ($permission) {
                $whoIsLogged = $_SESSION['identifiant'];
                $today = date("Y-m-01");
                $libelle = htmlspecialchars($_POST['addLibelle']);
                $prix = htmlspecialchars($_POST['addPrix']);
                $data = array(
                    "libelle" => $libelle,
                    "prix" => $prix,
                    "date" => $today,
                    "identifiant" => $whoIsLogged,
                );
                $f = new FiltreLigneFrais($data);
                $data = $f->lign();
                $isSuccess = true;
                foreach ($data as $key => $value) {
                    if ($value == false) {
                        $isSuccess = false;
                        $valueError[] = $key;
                    }
                }
                if ($isSuccess == true) {
                    $LigneFraisToAdd = new LigneFrais('', $libelle, $prix, $today, $whoIsLogged);
                    $this->DAOLigneFrais->save($LigneFraisToAdd);
                    $resultMessage = "la ligne a bien été ajouter";
                    $page = Renderer::render("view_fiche_frais_add.php", compact("resultMessage"));
                }
            } else {
                $page = Renderer::render("view_denyAccess.php");
            }
        } else {
            $page = Renderer::render("view_login.php");
        }
        echo $page;
    }

    public function edit_line(){
        $auth = new Auth();
        $isactive = $auth->is_session_active();
        if ($isactive == true) {
            $permission = $auth->can('update');
            if ($permission) {
                $num = htmlspecialchars($_POST['editid']);
                $isExist = $this->DAOLigneFrais->findIfLineExist($num);
                $isSuccess = false;
                if ($isExist == true) {
                    $libelle = htmlspecialchars($_POST['editLibelle']);
                    $prix = htmlspecialchars($_POST['editPrix']);
                    $data = array(
                        "num" => $num,
                        "libelle" => $libelle,
                        "prix" => $prix,
                    );
                    $f = new FiltreLigneFrais($data);
                    $data = $f->lign();
                    $isSuccess = true;
                    foreach ($data as $key => $value) {
                        if ($value == false) {
                            if ($key != "num") {
                                $isSuccess = false;
                                $valueError[] = $key;
                            }
                        }
                    }
                }
                if ($isSuccess == true) {
                    $ligneToUpdate = new LigneFrais($num, $libelle, $prix, '', '');
                    $this->DAOLigneFrais->edit($ligneToUpdate);
                    $resultMessage = "la ligne a bien été modifier";
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

    public function deleteLigne(){
        $auth = new Auth();
        $isactive = $auth->is_session_active();
        if ($isactive == true) {
            $mangagePerm = $auth->can('delete');
            if ($mangagePerm == true) {
                $id = $_POST["idLigneToDelete"];
                $resultMessage = "la ligne a bien été Supprimer";
                $this->DAOLigneFrais->remove($id);
                $page = Renderer::render("view_fiche_frais_delete.php", compact("resultMessage"));

            } else {
                $page = Renderer::render("view_denyAccess.php");
            }
        } else {
            $page = Renderer::render("view_login.php");
        }
        echo $page;
    }

    public function edit_fiche(){

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
                    $this->DAOFicheFrais->edit($ficheToUpdate);
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
