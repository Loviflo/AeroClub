<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <?php include 'utils/head.php'; ?>
    <title>Inscription</title>
</head>

<body class="d-flex flex-column h-100"> <?php include 'utils/header.php'; ?>
    <?php
    echo isset($_GET['msg']) ? $_GET['msg'] : null; ?>
    <div class="container">
        <h1 class="mt-3">Inscription</h1>
        <form action="actions/sign_in_process.php" method="post">
            <div class="row">
                <div class="form-group mb-3 col-lg-4">
                    <label for="firstname">Prénom</label>
                    <input type="text" class="form-control" id="firstname" placeholder="Votre prénom..." name="firstname" required>
                </div>
                <div class="form-group mb-3 col-lg-4">
                    <label for="lastname">Nom</label>
                    <input type="text" class="form-control" id="lastname" placeholder="Votre nom..." name="lastname" required>
                </div>
                <div class="form-group mb-3 col-lg-4">
                    <label for="">Votre date de naissance</label>
                    <input onfocusout="age(this.value)" type="date" class="form-control" name="birthDate" id="birthDate" placeholder="Votre date de naissance..." required>
                </div>
            </div>
            <div class="form-group mb-3">
                <label for="email">Mail</label>
                <input type="email" class="form-control" id="email" placeholder="Votre mail..." name="email" required>
            </div>
            <div class="form-group mb-3">
                <label for="level">Niveau de formation</label></br>
                <select class="form-control" name="level" id="level">
                    <option value="Aucun Brevet" selected>Aucun Brevet</option>
                    <option value="Brevet de Base">Brevet de Base</option>
                    <option value="Licence Pilote d'Avion Léger">Licence Pilote d'Avion Léger</option>
                    <option value="Brevet de Pilote Privé">Brevet de Pilote Privé</option>
                </select>
            </div>
            <div class="form-group mb-3">
                <label for="password">Mot de passe</label>
                <input type="password" class="form-control" id="password" placeholder="Votre mot de passe..." name="password" required>
                <small id="passwordHelpBlock" class="form-text text-muted">
                    Votre mot de passe doit faire entre 8 et 20 caractères
                </small>
            </div>
            <div class="form-group mb-3">
                <label for="conf_password">Confirmer votre mot de passe</label>
                <input type="password" class="form-control" id="conf_password" placeholder="Confirmer votre mot de passe..." name="conf_password" required>
            </div>
            <div class="form-group mb-3" role="group">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="FFAPrice" id="inlineRadio1" value="74">
                    <label class="form-check-label" for="inlineRadio1">Licence + assurance : 74€</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="FFAPrice" id="inlineRadio2" value="114">
                    <label class="form-check-label" for="inlineRadio2" data-toggle="tooltip" data-placement="bottom" title="Recevez vos infos pilotes chaque mois !">Licence + assurance + revue mensuelle "info pilote" : 114€</label>
                </div>
            </div>
            <div class="form-group form-check mb-3" id="cost" style="visibility: hidden;">
                <input type="checkbox" class="form-check-input" name="" id="" value="checkedValue" required>
                <label id="costLabel" class="form-check-label" for="">
                    Veuillez indiquez votre âge.
                </label>
            </div>
            <button type="submit" class="btn btn-primary buttonColor">Valider</button>
        </form>
    </div>
    <?php include("utils/footer.php"); ?>
</body>
<script>
    function age(dateAge) {
        var date = new Date(dateAge);
        var diff = Date.now() - date.getTime();
        var age = new Date(diff);
        var ageNumber = Math.abs(age.getUTCFullYear() - 1970);
        var cost = ageNumber < 21 ? 178 : 218;
        var text = 'Veuillez accepter de payer la somme de ' + cost + '€ pour la cotisation';
        document.getElementById('costLabel').textContent = text;
        document.getElementById('cost').style.visibility = "visible";
    }
</script>

</html>