<?php
ini_set('display_errors', 1);
require_once('../utils/database.php');
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <?php include '../utils/head.php'; ?>
    <title>Gestion des membres</title>
</head>

<body class="d-flex flex-column h-100">

    <?php include '../utils/header.php'; ?>
    <div class="container">
        <h1 style="text-align: center;">Gestion des membres</h1>
        <div class="row">
            <div class="col">
                <?php
                $bdd = getDatabaseConnection();
                $q = 'SELECT * FROM members';
                $req = $bdd->prepare($q);
                $req->execute();
                $results = $req->fetchAll();
                ?>
                <h2 style="text-align: center;">Liste des membres :</h2>
                <a href="/AeroClub/trainer_space.php" class="btn btn-primary" style="background-color: #B8CCCF; border-color:#B8CCCF;">&lt;</a>

                <ul>
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Nom</th>
                                <th scope="col">Prénom</th>
                                <th scope="col">Adresse mail</th>
                                <th scope="col">Niveau de formation</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <?php foreach ($results as $key => $members) { ?>
                            <tbody>
                                <tr>
                                    <td><?= $members['lastname']; ?></td>
                                    <td><?= $members['firstname']; ?> </td>
                                    <td><?= $members['mail']; ?> </td>
                                    <td><?= $members['level']; ?> </td>
                                    <td>
                                        <a href="seeDetails.php?id_member=<?php echo $members['id'] ?>" class="btn btn-primary buttonColor"><i class="far fa-eye" style="text-align: center"></i></a>
                                        <a data-bs-toggle="modal" data-bs-target="#deleteMemberModal" data-bs-url="deleteMember.php?id_member=<?= $members['id'] ?>" class="btn btn-danger"><i class="fas fa-trash" style="text-align: center"></i></a>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                    </table>
                </ul>
            </div>
        </div>
    </div>

    <!-- Modal suppression d'un membre -->
    <div class="modal fade" id="deleteMemberModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Suppression d'un membre</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="message-text" class="col-form-label">Êtes-vous sûr de supprimer ce membre ?</label>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <a type="button" id="send" class="btn btn-primary text-muted" style="background-color: #B8CCCF;border-color:#B8CCCF;">Valider</a>
                </div>
            </div>
        </div>
    </div>

    <?php include("../utils/footer.php"); ?>
</body>
</html>

<script>
    // Script permettant de récupérer le lien
    var deleteMemberModal = document.getElementById('deleteMemberModal')
    deleteMemberModal.addEventListener('show.bs.modal', function(event) {
        // Le bouton qui a déclenché la modal
        var button = event.relatedTarget
        var recipient = button.getAttribute('data-bs-url')
        var a = deleteMemberModal.querySelector('.modal-footer a')
        a.href = recipient
    });
</script>