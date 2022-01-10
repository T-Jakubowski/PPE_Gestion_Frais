<?php

namespace app\views;
?>
<html>
    <?php require "Head.php"; ?>
    <script>
        function ConfirmDelete(id) {
            var x = document.getElementById("idRoleToDelete");
            var y = document.getElementById("wantToDelete");
            x.value = id;
            var role = document.getElementById(id+":Role").innerHTML;
            y.innerHTML = role;
        }
        function Edit(id) {
            var x = document.getElementById("editid");
            x.value = id;
            x.innerHTML = id;
            var role = document.getElementById(id+":Role").innerHTML;
            var permission = document.getElementById(id+":Permission").innerHTML;
            document.getElementById("editrole").value = role;
            document.getElementById("editpermission").value = permission;
            



        }
    </script>
    <body>
        <?php
        $ActivePageName = "role";
        require "view_NavBarre.php";
        ?>
        <br>

        <?php if ($permission_manage) {
            ?>
            <div class="container">
                <div class="row justify-content-end">
                    <div class="col-1">
                        <span data-bs-toggle="tooltip" data-bs-placement="top" title="Ajout de Role">
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#createRoleModal">+</button>
                        </span>
                    </div>
                </div>
            </div>
        <?php } ?>

        <br>
        <div><h3>Liste des Role:</h3></div>

        <?php
        if (isset($_GET["page"])) {
            $NumPage = $_GET["page"];
        } else {
            $NumPage = 1;
        }
        if (isset($_GET["search"])) {
            $NumLikes = "&search=" . intval($_GET["search"]);
        } else {
            $NumLikes = "";
        }
        ?>
        <table id="tableRole" class="table table-striped table-hover table-Secondary .table-responsive" >
            <thead>
                <tr>
                    <th data-bs-toggle="tooltip" data-bs-placement="top" title="Varchar(15)">Id</th>
                    <th data-bs-toggle="tooltip" data-bs-placement="top" title="Varchar(20)">Role</th>
                    <th data-bs-toggle="tooltip" data-bs-placement="top" title="Int (8)">Permission</th>
                    <?php
                    if ($permission_manage) {
                        ?>
                        <th>Edit/Delete</th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($LstRole as $Role) {
                    /* @var Role $Role */
                    ?>
                    <tr>
                        <td <?php $id = $Role->getId(); ?>id="<?php echo $id . ":Id"; ?>"><?php echo $id; ?></td>
                        <td id="<?php echo $id . ":Role"; ?>"><?php echo $Role->getRole(); ?></td>
                        <td id="<?php echo $id . ":Permission"; ?>"><?php echo $Role->getPermission(); ?></td>
                        <?php if ($permission_manage) { ?>
                            <td><button id="<?php echo $id . ":edit"; ?>" onclick="Edit(<?php echo $id; ?>)" type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#editRoleModal"><img class="fit-picture" src="/img/edit_black_24dp.svg" alt="edit"></button>
                                <button id="<?php echo $id . ":del"; ?>" onclick="ConfirmDelete(<?php echo $id; ?>)" type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteRoleModal"><img class="fit-picture" src="/img/delete_black_24dp.svg" alt="delete"></button></td>
                        </tr>
                    <?php }
                    ?>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>



        <!-- Modal create role-->
        <div class="modal fade" id="createroleModal" tabindex="-1" aria-labelledby="createUsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createroleModalLabel">Create Role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="InsertRole" method="post" action="/role/add">
                        <div class="modal-body">
                            <div class="input-group mb-3">
                                <input id="addid" name="addid" type="text" class="form-control" placeholder="ex: 1" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                <span class="input-group-text" id="basic-addon2">Id</span>
                            </div>
                            <div class="input-group mb-3">
                                <input id="addrole" name="addrole" type="text" class="form-control" placeholder="ex: admin" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                <span class="input-group-text" id="basic-addon2">Role</span>
                            </div>
                            <div class="input-group mb-3">
                                <input id="addpermission" name="addpermission" type="text" class="form-control" placeholder="ex: 0001111" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                <span class="input-group-text" id="basic-addon2">Permission</span>
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


        <!-- Modal edit Role-->
        <div class="modal fade" id="editRoleModal" tabindex="-1" aria-labelledby="editRoleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createRoleModalLabel">Edit</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="UpdateRole" method="post" action="/role/edit">
                        <div class="modal-body">
                            <div class="input-group mb-3">
                                <input id="editid" name="editid" value="" type="text" class="form-control" placeholder="Value" readonly>
                                <span class="input-group-text">Id</span>
                            </div>
                            <div class="input-group mb-3">
                                <input id="editrole" name="editrole" type="text" class="form-control" placeholder="ex: admin" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                <span class="input-group-text" id="basic-addon2">Role</span>
                            </div>
                            <div class="input-group mb-3">
                                <input id="editpermission" name="editpermission" type="text" class="form-control" placeholder="ex: 0001111" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                <span class="input-group-text" id="basic-addon2">Permission</span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <input type="submit" class="btn btn-primary" value="Save changes">
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- Modal confirmDelete Role-->
        <div class="modal fade" id="confirmDeleteRoleModal" tabindex="-1" aria-labelledby="confirmDeleteRoleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmDeleteRoleModalLabel">Delete</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h3>Etes-vous sur de vouloir supprimé le Role <span id="wantToDelete"></span> ?</h3>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">NON</button>
                        <form id="DeleteRole" method="post" action="/role/delete">
                            <input id="idRoleToDelete" name="idRoleToDelete" value="none" hidden>
                            <button type="submit" class="btn btn-success">OUI</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>













        <?php

        function round_up($number, $precision = 1) {
            $fig = (int) str_pad('1', $precision, '0');
            return (ceil($number * $fig) / $fig);
        }

        $nbPage = round_up($CountRole / 10);
        $index = 1;
        $classPreview = "";
        $classNext = "";
        if ($NumPage == 1) {
            $classPreview = "disabled";
        }
        if (strval($NumPage) == strval($nbPage)) {
            $classNext = "disabled";
        }
        ?>

        <footer>
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <li class="page-item <?php echo $classPreview; ?>">
                        <a class="page-link" href="?page=<?php echo $NumPage - 1, $NumLikes; ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <?php
                    $pageLimit = $index + 20;
                    while ($index <= $nbPage) {
                        $isactive = "";
                        if ($index == $NumPage) {
                            $isactive = "active";
                        }
                        ?>
                        <li class="page-item <?php echo $isactive ?>"><a class="page-link" href="?page=<?php echo $index, $NumLikes; ?>"><?php echo $index; ?></a></li>
                        <?php
                        $index += 1;
                    }
                    ?>

                    <li class="page-item <?php echo $classNext ?>">
                        <a class="page-link" href="?page=<?php echo $NumPage + 1, $NumLikes; ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </footer>

        <script>




            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        </script>
    </body>
</html>