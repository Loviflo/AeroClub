<?php
ini_set('display_errors', 1);
require_once('utils/database.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <?php include 'utils/head.php'; ?>
    <title>Espace Formateur</title>
</head>
<body>
<?php include 'utils/header.php'; ?>
<?php
$bdd = getDatabaseConnection();
$q = 'SELECT TO_DO, TO_DO FROM TO_DO';
$req = $bdd->prepare($q);
$req->execute();
$results = $req->fetchAll();

$q2 = 'SELECT TO_DO, TO_DO FROM TO_DO';
$req2 = $bdd->prepare($q2);
$req2->execute();
$results2 = $req2->fetchAll();
?>
<div class="container">
    <h1 style="text-align: center;">Espace Membre</h1>
    <div class="row">
        <div class="col">
            <h2 style="text-align: center;">Mes formations : </h2>
            <?php foreach ($results as $key => $user) { ?>
            <tr>
                <td class="text-center">Heures BB :<?php echo $user['TO_DO']; ?></td>
                <td class="text-center">Heures LAPL :<?php echo $user['TO_DO']; ?></td>
                <td class="text-center">Heures PPL :<?php echo $user['TO_DO']; ?></td>
            </tr>
        </div>
        <?php }?>
        <div class="col">
            <h2 style="text-align: center;">Mes cours :</h2>
            <?php foreach ($results2 as $key => $user2) { ?>
            <tr>
                <td class="text-center"><?php echo $user2['TO_DO'];} ?></td>
                <td class="text-center">
                    <a href="/AeroClub/actions/cancel_class.php?id_client=<?php echo $user2['TO_DO']; ?>" class="btn btn-danger" onclick="deletehref(this)" data-bs-toggle="modal" data-bs-target="#deleteAccount" role="button" style="margin: 2px;"><i class="fas fa-trash"></i></a>
                </td>
            </tr>
        </div>
    </div>
</div>
<?php include("utils/footer.php"); ?>
</body>
<script>
    function deletehref(link) {
        let href = link.href;
        let idDeleteURL = document.getElementById('deleteURL');
        idDeleteURL.href = href;
    }
</script>
</html>
