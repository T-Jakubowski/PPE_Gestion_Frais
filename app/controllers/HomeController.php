<?php

namespace app\controllers;

use app\utils\Renderer;
use app\utils\Auth;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/*
 * Description of LoginController
 * @author student
 */

class HomeController extends BaseController {

    public function __construct() {
        
    }
/*
        Affiche la page home
        @return void
    */
    public function index() : void {
        $auth = new Auth();
        $isactive = $auth->is_session_active();
        if ($isactive == true) {
            $permission = $auth->can('read');
            $permission_manage = $auth->can('manage');
            if ($permission) {
                $page = Renderer::render("view_home.php", compact ("permission_manage"));
            }
            else{
                $page = Renderer::render("view_denyAccess.php");
            }
        } else {
            $page = Renderer::render("view_login.php");
        }
        echo $page;
    }

}
