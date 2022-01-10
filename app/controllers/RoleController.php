<?php

namespace app\controllers;

use app\models\DAORole;
use app\utils\SingletonDBMaria;
use app\utils\Renderer;
use app\models\Role;
use app\utils\filtre\filtreRole\FiltreRole;
use app\utils\Auth;

class RoleController extends BaseController {

    private DAORole $DAORole;

    public function __construct() {
        $cnx = SingletonDBMaria::getInstance()->getConnection();
        $DAORole = new DAORole($cnx);
        $this->DAORole = $DAORole;
    }

    /*
        Affiche la page role
        @return void
    */
    public function show() : void{

        $auth = new Auth();
        $isactive = $auth->is_session_active();
        if ($isactive == true) {
            $permission_read = $auth->can('read');
            $permission_manage = $auth->can('manage');
            if ($permission_manage) {
                if (isset($_GET["page"])) {
                    $Offset = (htmlspecialchars($_GET["page"]) * 10) - 10;
                } else {
                    $Offset = 0;
                }
                if (isset($_GET["search"])) {
                    $NumR = (htmlspecialchars($_GET["search"]));
                    $LstRole = $this->DAORole->findAllWhereName($NumR, 0, 10);
                    $CountRole = $this->DAORole->countWhere($NumR);
                } else {
                    $LstRole = $this->DAORole->findAll($Offset, 10);
                    $CountRole = $this->DAORole->count();
                }
                $page = Renderer::render("view_role.php", compact("LstRole", "CountRole", "permission_manage", "permission_read"));
            } else {
                $page = Renderer::render("view_denyAccess.php");
            }
        } else {
            $page = Renderer::render("view_login.php");
        }
        echo $page;
    }

    /*
        Creer un role
        @return void
    */
    public function insert() : void{

        $auth = new Auth();
        $isactive = $auth->is_session_active();
        if ($isactive == true) {
            $permission = $auth->can('manage');
            if ($permission) {
                $id = htmlspecialchars($_POST['addid']);
                $role = htmlspecialchars($_POST['addrole']);
                $permission = htmlspecialchars($_POST['addpermission']);
                $data = array(
                    "id" => $id,
                    "role" => $role,
                    "permission" => $permission,
                );
                $f = new FiltreRole($data);
                $data = $f->rol();
                $isSuccess = true;
                foreach ($data as $key => $value) {
                    if ($value == false) {
                        $isSuccess = false;
                        $valueError[] = $key;
                    }
                }
                if ($isSuccess == true) {
                    $roleToAdd = new Role(htmlspecialchars($_POST['addid']), htmlspecialchars($_POST['addrole']), htmlspecialchars($_POST['addpermission']));
                    $this->DAORole->save($roleToAdd);
                    $resultMessage = "le role numéro a bien été ajouter";
                    $page = Renderer::render("view_role_add.php", compact("resultMessage"));
                } else {
                    $page = Renderer::render("view_role_add.php", compact("valueError"));
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
        Modifie un role
        @return void
    */
    public function update(): void {

        $auth = new Auth();
        $isactive = $auth->is_session_active();
        if ($isactive == true) {
            $permission = $auth->can('manage');
            if ($permission) {
                $id = htmlspecialchars($_POST['editid']);
                $isExist = $this->DAORole->findIfRoleIdExist($id);
                $isSuccess = false;
                if ($isExist == true) {
                    $role = htmlspecialchars($_POST['editrole']);
                    $permission = htmlspecialchars($_POST['editpermission']);
                    $data = array(
                        "id" => $id,
                        "role" => $role,
                        "permission" => $permission,
                    );
                    $f = new FiltreRole($data);
                    $data = $f->rol();
                    $isSuccess = true;
                    foreach ($data as $key => $value) {
                        if ($value == false) {
                            if ($key != "id") {
                                $isSuccess = false;
                                $valueError[] = $key;
                            }
                        }
                    }
                }
                if ($isSuccess == true) {
                    $roleToUpdate = new Role(htmlspecialchars($_POST['editid']), htmlspecialchars($_POST['editrole']), htmlspecialchars($_POST['editpermission']));
                    $this->DAORole->edit($roleToUpdate);
                    $resultMessage = "le role numéro '" . $id . "' a bien été modifier";
                    $page = Renderer::render("view_role_edit.php", compact("resultMessage"));
                } else {
                    $page = Renderer::render("view_role_edit.php", compact("valueError"));
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
        Supprime un role
        @return void
    */
    public function delete(): void {

        $auth = new Auth();
        $isactive = $auth->is_session_active();
        if ($isactive == true) {
            $permission = $auth->can('manage');
            if ($permission) {
                $id = htmlspecialchars($_POST['idRoleToDelete']);
                $isExist = $this->DAORole->findIfRoleIdExist($id);
                if ($isExist == true) {
                    $UserOnRole = $this->DAORole->findUserFromRole($id);
                    if ($UserOnRole == false) {
                        $resultMessage = "le role numéro '" . $id . "' a bien été Supprimer";
                        $this->DAORole->remove($id);
                        $page = Renderer::render("view_role_delete.php", compact("resultMessage"));
                    } else {
                        $valueError = "Le role numéro " . $id . " possede des users et ne peut donc pas etre supprimer";
                        $page = Renderer::render("view_role_delete.php", compact("valueError"));
                    }
                } else {
                    $valueError = "Vous ne pouvez pas supprimer le role " . $id . " pour l'instant";
                    $page = Renderer::render("view_role_delete.php", compact("valueError"));
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