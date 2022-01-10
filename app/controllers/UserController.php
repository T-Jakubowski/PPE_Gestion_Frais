<?php

namespace app\controllers;

use app\models\DAOUser;
use app\utils\SingletonDBMaria;
use app\utils\Renderer;
use app\models\User;
use app\utils\Auth;
use app\utils\filtre\filtreUser\FiltreUser;

class UserController extends BaseController {

    private DAOUser $DAOUser;

    public function __construct() {
        $cnx = SingletonDBMaria::getInstance()->getConnection();
        $DAOUser = new DAOUser($cnx);
        $this->DAOUser = $DAOUser;
    }

    /*
        Affiche la page user
        @return void
    */
    public function show() : void{
        
        $auth = new Auth();
          $isactive = $auth->is_session_active();
          if ($isactive == true) {
          $managePerm = $auth->can('manage');
          if ($managePerm == true) {
        if (isset($_GET["page"])) {
            $Offset = ($_GET["page"] * 10) - 10;
        } else {
            $Offset = 0;
        }
        if (isset($_GET["search"])) {
            $NumU = ($_GET["search"]);
            $LstUser = $this->DAOUser->findAllWhereIdentifiant($NumU, 0, 10);
            $CountUser = $this->DAOUser->countWhere($NumU);
        } else {
            $LstUser = $this->DAOUser->findAll($Offset, 10);
            $CountUser = $this->DAOUser->count();
        }
        $readPerm = $auth->can('manage');
        $readPerm = true;
        $page = Renderer::render("view_user.php", compact("LstUser", "CountUser"));
        } else {
          $page = Renderer::render("view_denyAccess.php");
          }
          } else {
          $page = Renderer::render("view_login.php");
          }
        echo $page;
    }

    /*
        Ajoute un user
        @return void
    */
    public function insert() : void {
        $auth = new Auth();
        $isactive = $auth->is_session_active();
        if ($isactive == true) {
            $managePerm = $auth->can('manage');
            if ($managePerm == true) {
                $identifiant = htmlspecialchars($_POST['addidentifiant']);
                $nom = htmlspecialchars($_POST['addnom']);
                $prenom = htmlspecialchars($_POST['addprenom']);
                $password = htmlspecialchars($_POST['addpassword']);
                $role = htmlspecialchars($_POST['addidrole']);
                $data = array(
                    "identifiant" => $identifiant,
                    "nom" => $nom,
                    "prenom" => $prenom,
                    "password" => $password,
                    "idRole" => $role,
                );
                $f = new FiltreUser($data);
                $data = $f->use();
                $isSuccess = true;
                foreach ($data as $key => $value) {
                    if ($value == false) {
                        $isSuccess = false;
                        $valueError[] = $key;
                    }
                }
                if ($isSuccess == true) {
                    $password = hash('sha256', $password);
                    $userToAdd = new User($identifiant, $nom, $prenom, $password, $role);
                    $this->DAOUser->save($userToAdd);
                    $resultMessage = "le user numéro a bien été ajouter";
                    $page = Renderer::render("view_user_add.php", compact("resultMessage"));
                } else {
                    $page = Renderer::render("view_user_add.php", compact("valueError"));
                }
            } else {
                $page = Renderer::render("view_denyAccess.php");
            }
        } else {
            $page = Renderer::render("view_login.php");
        }
        echo $page;
    }

    /*
        modifie un user
        @return void
    */
    public function update(): void {
        $auth = new Auth();
        $isactive = $auth->is_session_active();
        if ($isactive == true) {
            $managePerm = $auth->can('manage');
            if ($managePerm == true) {
                $identifiant = htmlspecialchars($_POST['editidentifiant']);
                $isExist = $this->DAOUser->findIfUserIdentifiantExist($identifiant);
                $isSuccess = false;
                if ($isExist == true) {
                    $nom = htmlspecialchars($_POST['editnom']);
                    $prenom = htmlspecialchars($_POST['editprenom']);
                    $password = htmlspecialchars($_POST['editpassword']);
                    $role = htmlspecialchars($_POST['editidrole']);
                    $data = array(
                        "identifiant" => $identifiant,
                        "nom" => $nom,
                        "prenom" => $prenom,
                        "password" => $password,
                        "idRole" => $role,
                    );
                    $f = new FiltreUser($data);
                    $data = $f->use();
                    $isSuccess = true;
                    foreach ($data as $key => $value) {
                        if ($value == false) {
                            if ($key != "identifiant") {
                                $isSuccess = false;
                                $valueError[] = $key;
                            }
                        }
                    }
                }
                if ($isSuccess == true) {
                    $password = hash('sha256', $password);
                    $userToUpdate = new User($identifiant, $nom, $prenom, $password, $role);
                    $this->DAOUser->edit($userToUpdate);
                    $resultMessage = "le user numéro '" . $identifiant . "' a bien été modifier";
                    $page = Renderer::render("view_user_edit.php", compact("resultMessage"));
                } else {
                    $page = Renderer::render("view_user_edit.php", compact("valueError"));
                }
            } else {
                $page = Renderer::render("view_denyAccess.php");
            }
        } else {
            $page = Renderer::render("view_login.php");
        }
        echo $page;
    }

    /*
        supprime un user
        @return void
    */
    public function delete(): void {
        $auth = new Auth();
        $isactive = $auth->is_session_active();
        if ($isactive == true) {
            $mangagePerm = $auth->can('manage');
            if ($mangagePerm == true) {
                $identifiant = htmlspecialchars($_POST['idUserToDelete']);
                $identifiant_session = $_SESSION['identifiant'];
                if ($identifiant != $identifiant_session) {
                    $isExist = $this->DAOUser->findifUserIdentifiantExist($identifiant);
                    if ($isExist == true) {
                        $resultMessage = "le user numéro '" . $identifiant . "' a bien été Supprimer";
                        $this->DAOUser->remove($identifiant);
                        $page = Renderer::render("view_user_delete.php", compact("resultMessage"));
                    } else {
                        $valueError = "Vous ne pouvez pas supprimer le user " . $identifiant . " pour l'instant";
                        $page = Renderer::render("view_user_delete.php", compact("valueError"));
                    }
                } else {
                    $valueError = "Vous ne pouvez pas vous supprimer vous même";
                    $page = Renderer::render("view_user_delete.php", compact("valueError"));
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

?>