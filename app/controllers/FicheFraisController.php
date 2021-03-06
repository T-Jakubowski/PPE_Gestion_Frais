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

    public function __construct()
    {

        $cnx = SingletonDBMaria::getInstance()->getConnection();
        $DAOFicheFrais = new DAOFicheFrais($cnx);
        $this->DAOFicheFrais = $DAOFicheFrais;

        $DAOLigneFrais = new DAOLigneFrais($cnx);
        $this->DAOLigneFrais = $DAOLigneFrais;

        $DAOUser = new DAOUser($cnx);
        $this->DAOUser = $DAOUser;
    }

    public function show(): void
    {

        $auth = new Auth();
        $isactive = $auth->is_session_active();

        if ($_SESSION['IdentifiantSelected']) {
            $user = $_SESSION['IdentifiantSelected'];
        } else {
            $user = $_SESSION['identifiant'];
        }

        if ($auth->can('manage') && $_POST['desUsers']) {
            $user = $_POST['desUsers'];
        }

        $date = date("Y-m-01");

        if ($_SESSION['date']) {
            $date = $_SESSION['date'];
        }

        if ($_POST['date']) {
            $date = $_POST['date'];
            $date = $date . "-01";
        }

        $_SESSION['date'] = $date;

        if ($isactive == true) {
            $permission_read = $auth->can('read');
            $permission_manage = $auth->can('manage');
            $permission_comptable = $auth->can('comptable');
            if ($permission_read) {
                $userSelected = false;

                if (isset($_POST['desUsers'])) {
                    $user = htmlspecialchars($_POST['desUsers']);
                    $_SESSION['IdentifiantSelected'] = $user;
                }

                $ficheExist = $this->DAOFicheFrais->findIfFicheExist($date, $user);
                if ($ficheExist) {
                    $ficheFrais = $this->DAOFicheFrais->find($date, $user);
                } else {
                    $ficheFraisToAdd = new FicheFrais($date, $user, 'En cours', 0, 0, 0);
                    $this->DAOFicheFrais->save($ficheFraisToAdd);
                    $ficheFrais = $this->DAOFicheFrais->find($date, $user);
                }
                $ligneExist = $this->DAOLigneFrais->findIfExist($date, $user);
                $desDates = $this->DAOFicheFrais->findDate($user);
                $desUsers = $this->DAOUser->findAllNoLimit();

                if ($ligneExist == true) {
                    $desLigneFrais = $this->DAOLigneFrais->find($date, $user);
                    $page = Renderer::render("view_fiche_frais.php", compact('ficheFrais', 'user', 'desLigneFrais', 'desDates', 'desUsers', 'ligneExist', 'permission_manage', 'userSelected', 'permission_comptable'));
                } else {
                    $page = Renderer::render("view_fiche_frais.php", compact('ficheFrais', 'user', 'ligneExist', 'desDates', 'desUsers', 'userSelected', 'permission_comptable'));
                }
            } else {
                $page = Renderer::render("view_denyAccess.php");
            }
        } else {
            $page = Renderer::render("view_login.php");
        }
        echo $page;
    }

    public function insert()
    {
        $auth = new Auth();
        $isactive = $auth->is_session_active();
        if ($isactive == true) {
            $permission = $auth->can('write');
            if ($permission) {
                if ($_SESSION['IdentifiantSelected']) {
                    $whoIsLogged = $_SESSION['IdentifiantSelected'];
                } else {
                    $whoIsLogged = $_SESSION['identifiant'];
                }
                $today = $_SESSION['date'];
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
                    $resultMessage = "la ligne a bien ??t?? ajouter";
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

    public function edit_line()
    {
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
                    $resultMessage = "la ligne a bien ??t?? modifier";
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

    public function deleteLigne()
    {
        $auth = new Auth();
        $isactive = $auth->is_session_active();
        if ($isactive == true) {
            $mangagePerm = $auth->can('delete');
            if ($mangagePerm == true) {
                $id = $_POST["idLigneToDelete"];
                $resultMessage = "la ligne a bien ??t?? Supprimer";
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

    public function edit_fiche()
    {

        $auth = new Auth();
        $isactive = $auth->is_session_active();
        if ($isactive == true) {
            $permission = $auth->can('update');
            if ($permission) {

                $Date = $_SESSION['date'];
                $Identifiant = $_SESSION['IdentifiantSelected'];
                if ($_POST['editEtat']) {
                    $Etat = htmlspecialchars($_POST['editEtat']);
                } else {
                    $ficheFrais = $this->DAOFicheFrais->find($Date, $Identifiant);
                    $Etat = $ficheFrais->getEtat();
                }
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
                    $resultMessage = "la fiche a bien ??t?? modifier";
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
