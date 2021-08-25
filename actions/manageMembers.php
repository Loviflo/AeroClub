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
                                        <a href="seeDetails.php?id_member=<?php echo $members['id'] ?>" class="btn btn-primary"><i class="far fa-eye" style="text-align: center"></i></a>
                                        <a onClick="javascript: return confirm('Veuillez comfirmer la suppression');" href="deleteMember.php?id_member=<?php echo $members['id'] ?>" class="btn btn-danger"><i class="fas fa-trash" style="text-align: center"></i></a>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                    </table>
                </ul>
            </div>
        </div>
    </div>
    <?php include("../utils/footer.php"); ?>
</body>