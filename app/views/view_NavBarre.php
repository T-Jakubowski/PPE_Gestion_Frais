<?php

namespace app\view;
use app\utils\Auth;
/*
 * @author Baptiste Coquelet <b.coquelet@eleve.leschartreux.net>
 * @param string $ActivePageName
 */
//FAKE VALUE TEST
$permEdit = true;

$IsActiveHome = "";
$IsActiveFicheFrais = "";
$IsActiveUser = "";
$IsActiveRole = "";
if (isset($ActivePageName)) {
    switch ($ActivePageName) {
        case "home":
            $IsActiveHome = "active";
            break;
        case "fiche_frais":
            $IsActiveFicheFrais = "active";
            break;
        case "user":
            $IsActiveUser = "active";
            break;
        case "role":
            $IsActiveRole = "active";
            break;
    }
} else {
    $ActivePageName = "Undefine";
}
?>


<header>
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #ff8787;">
        <div class="container-fluid">
            <a class="navbar-brand">Navigation</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <?php
                    $auth = new auth();
                    $permission_read = $auth->can('read');
                    $permission_manage = $auth->can('manage');
                    if ($permission_read) {
                        ?>
                        <a class="nav-link <?php echo $IsActiveHome; ?>" href="/home">Home</a>
                        <a class="nav-link <?php echo $IsActiveFicheFrais; ?>" href="/fiche_frais/affiche">fiche_frais</a>
                        <?php
                    }
                    ?>

                    <?php
                    if ($permission_manage) {
                        ?>
                        <a class="nav-link <?php echo $IsActiveUser; ?>" href="/user/affiche">User</a>
                        <a class="nav-link <?php echo $IsActiveRole; ?>" href="/role/affiche">Role</a>
                    <?php } ?>
                    <?php
                    if ($permission_read) {
                        ?>
                        <a class="nav-link disabled">Prochainement...</a>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <a class="btn btn-danger" href="/logout"><img src="/img/logout_black_24dp.svg" alt="Deconnexion"></a>
        </div>

        <?php if ($ActivePageName != "home") { ?>
            <form class="d-flex" target="/<?php echo $ActivePageName ?>/affiche" id="<?php echo $ActivePageName; ?>FormSearch">
                <input class="form-control me-2" id="<?php echo $ActivePageName; ?>InputSearch" name="search" type="search" placeholder="Search <?php echo $ActivePageName ?>" aria-label="Search">
                <button class="btn btn-success" type="submit">Search</button>
            </form>
        <?php } ?>
    </nav>
</header>