<?php

namespace app\views;
use App\Controllers\FicheFraisController;
?>
<html>
<?php $ActivePageName = 'fiche_frais'; 
require ('Head.php');
?>

<body>

    <script>
        function ConfirmDelete(id) {
            var x = document.getElementById("idLigneToDelete");
            var y = document.getElementById("wantToDelete");
            x.value = id;
            y.innerHTML = id;
        }
        function Edit(id) {
            var x = document.getElementById("editid");
            x.value = id;
            x.innerHTML = id;

            var nom = document.getElementById(id+":Nom").innerHTML;
            var prenom = document.getElementById(id+":Prenom").innerHTML;
            var password = document.getElementById(id+":Password").innerHTML;
            var role = document.getElementById(id+":IdRole").innerHTML;
            document.getElementById("editnom").value = nom;
            document.getElementById("editprenom").value = prenom;
            document.getElementById("editpassword").value = password;
            document.getElementById("editidrole").value = role;
        }
    </script>

<?php  require ('view_NavBarre.php'); ?>
<br>
    <div class="container">
        <div class="row justify-content-end">
            <div class="col-1">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createLigneModal">+</button>
            </div>
        </div>
    </div>
<br>

<form id="selectUser" method="post" action="/fiche_frais/affiche">
    
    <?php if ($permission_manage == true){  ?>
    <select id="desUsers" name="desUsers" <?php if($userSelected == true){ echo 'disabled';} ?> >
        <option value="<?php echo $user; ?>"> <?php echo $user; ?></option>
        <?php foreach($desUsers as $u){ ?>
        <option value="<?php echo $u->getIdentifiant(); ?>"> <?php echo $u->getIdentifiant(); ?></option>
            <?php } ?>
    </select>
    <?php } ?>
    <input id="date" type="month" name="date">
    <button class="btn btn-success" type="submit">Valider</button>
<form>

<div><h3>Fiche </h3></div>
<div><h3>Frais forfait</h3></div>

<table id="tableFiche" class="table table-striped table-hover table-Secondary .table-responsive" >
    <thead>
    <tr>
        <th>Km</th>
        <th>Repas</th>
        <th>Nuite</th>
        <th>Etat</th>
        <th>Edit</th>
    </tr>
    </thead>
    <tbody>
        <tr>
            <tr>
                <td><?php echo $ficheFrais->getKm(); ?></td>
                <td><?php echo $ficheFrais->getRepas();?></td>
                <td><?php echo $ficheFrais->getNuite();?></td>
                <td><?php echo $ficheFrais->getEtat();?></td>
                <td><button  type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#editFicheModal"><img class="fit-picture" src="/img/edit_black_24dp.svg" alt="edit"></button>
            </tr>
    </tbody>
</table>

<?php if($ligneExist == true){ ?>
<div><h3>Frais hors-forfait</h3></div>

<table id="tableLigne" class="table table-striped table-hover table-Secondary .table-responsive" >
    <thead>
    <tr>
        <th>Num</th>
        <th>Libelle</th>
        <th>Prix</th>
        <th>Edit/Delete</th>
    </tr>
    </thead>
    <tbody>
        <tr>
            <?php 
            $i = 0;
            foreach ($desLigneFrais as $uneLigne){ 
            $i += 1;    
            $id = $uneLigne->getNum();?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $uneLigne->getLibelle();?></td>
                <td><?php echo $uneLigne->getPrix();?></td>
                <td><button  id ="<?php $id; ?>" onclick="Edit('<?php echo $id; ?>')" type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#editLigneModal"><img class="fit-picture" src="/img/edit_black_24dp.svg" alt="edit"></button>
                    <button  id ="<?php $id; ?>" onclick="ConfirmDelete('<?php echo $id; ?>')" type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteLigneModal"><img class="fit-picture" src="/img/delete_black_24dp.svg" alt="delete"></button></td>
                </tr>
                <?php
            }?>
    </tbody>
</table>
<?php } ?>




<!-- Modal edit Fiche-->
<div class="modal fade" id="editFicheModal" tabindex="-1" aria-labelledby="editFicheModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createFicheModalLabel">Edit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="UpdateFiche" method="post" action="/fiche_frais/edit">
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <input id="editKm" name="editKm" type="text" class="form-control" placeholder="15" aria-label="Recipient's username" aria-describedby="basic-addon2">
                        <span class="input-group-text" id="basic-addon2">Km</span>
                    </div>
                    <div class="input-group mb-3">
                        <input id="editRepas" name="editRepas" type="text" class="form-control" placeholder="9" aria-label="Recipient's username" aria-describedby="basic-addon2">
                        <span class="input-group-text" id="basic-addon2">Repas</span>
                    </div>
                    <div class="input-group mb-3">
                        <input id="editNuite" name="editNuite" type="text" class="form-control" placeholder="9" aria-label="Recipient's username" aria-describedby="basic-addon2">
                        <span class="input-group-text" id="basic-addon2">Nuite</span>
                    </div>
                    <div class="input-group mb-3">
                        <input id="editEtat" name="editEtat" type="text" class="form-control" placeholder="Remboursée" aria-label="Recipient's username" aria-describedby="basic-addon2">
                        <span class="input-group-text" id="basic-addon2">Etat</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="save">
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal insert Ligne-->
<div class="modal fade" id="createLigneModal" tabindex="-1" aria-labelledby="createLigneModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createLigneModalLabel">Create Ligne</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="InsertLigne" method="post" action="/fiche_frais/ligne_add">
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <input id="addLibelle" name="addLibelle" type="text" class="form-control" placeholder="Telephone" aria-label="Recipient's username" aria-describedby="basic-addon2">
                        <span class="input-group-text" id="basic-addon2">Libelle</span>
                    </div>
                    <div class="input-group mb-3">
                        <input id="addPrix" name="addPrix" type="text" class="form-control" placeholder="15" aria-label="Recipient's username" aria-describedby="basic-addon2">
                        <span class="input-group-text" id="basic-addon2">Prix</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="save">
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal edit Ligne-->
<div class="modal fade" id="editLigneModal" tabindex="-1" aria-labelledby="editLigneModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createLigneModalLabel">Edit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="UpdateLigne" method="post" action="/fiche_frais/edit_ligne">
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <input id="editid" name="editid" value="" type="text" class="form-control" placeholder="Value" readonly>
                        <span class="input-group-text">Id</span>
                    </div>
                    <div class="input-group mb-3">
                        <input id="editLibelle" name="editLibelle" type="text" class="form-control" placeholder="Telephone" aria-label="Recipient's username" aria-describedby="basic-addon2">
                        <span class="input-group-text" id="basic-addon2">Libelle</span>
                    </div>
                    <div class="input-group mb-3">
                        <input id="editPrix" name="editPrix" type="text" class="form-control" placeholder="15" aria-label="Recipient's username" aria-describedby="basic-addon2">
                        <span class="input-group-text" id="basic-addon2">Prix</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="save">
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal confirmDelete Ligne-->
<div class="modal fade" id="confirmDeleteLigneModal" tabindex="-1" aria-labelledby="confirmDeleteLigneModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteLigneModalLabel">Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h3>Etes-vous sur de vouloir supprimé la ligne ?</h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">NON</button>
                <form id="DeleteLigne" method="post" action="/fiche_frais/delete_ligne">
                    <input id="idLigneToDelete" name="idLigneToDelete" value="none" hidden>
                    <button type="submit" class="btn btn-success">OUI</button>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>
