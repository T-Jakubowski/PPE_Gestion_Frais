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
        
        $whoIsLogged = $_SESSION['identifiant'];

        $today = date("Y-m-01");
        var_dump($today);


        $ficheFrais = $this->DAOFicheFrais->find($today, $whoIsLogged);

        $desLigneFrais = $this->DAOLigneFrais->find('1999-08-30','adtdyganed');

        $desDates = $this->DAOFicheFrais->findDate('adtdyganed');

        $page = Renderer::render("view_fiche_frais.php", compact('ficheFrais', 'desLigneFrais', 'desDates'));
        echo $page;
        /*$desUsers = User::all('Identifiant');
        $desIdentifiant = [];
        foreach($desUsers as $user){
            array_push($desIdentifiant, $user->Identifiant);
        }*/
        


        /*return view('Fiche_Frais')
            ->with('ficheFrais', $ficheFrais)
            ->with('desLigneFrais', $desLigneFrais)
            ->with('desIdentifiant', $desIdentifiant)
            ->with('desFiches', $desFiches) ;*/
    }

    public function insert(){
        
        
    }

    public function delete(){
        
    }

    public function edit(){

        $auth = new Auth();
        $isactive = $auth->is_session_active();
        if ($isactive == true) {
            $permission = $auth->can('update');
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

        $Date = date("Y-m-01");
        $Identifiant = $_SESSION['identifiant'];
        $Etat = htmlspecialchars($_POST['editEtat']);
        $Km = htmlspecialchars($_POST['editKm']);
        $Repas = htmlspecialchars($_POST['editRepas']);
        $Nuite = htmlspecialchars($_POST['editNuite']);

        $ficheFrais = new FicheFrais ($Date, $Identifiant, $Etat, $Km, $Repas, $Nuite);

        $this->DAOFicheFrais->save($ficheFrais);

    }
}
