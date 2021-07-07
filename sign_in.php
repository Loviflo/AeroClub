<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <?php include 'utils/head.php'; ?>
        <title><?php echo $site->pagesClientSide->signInClient->pageTitle; ?></title>
    </head>
    <body>
        <?php include 'utils/header.php'; ?>
        <?php
        echo isset($_GET['msg'])?$_GET['msg']:null; ?>
        <div class="container">
        <h1 class="mt-3">Inscription</h1>
        <form action="actions/sign_in_process.php" method="post">
                <div class="form-group mb-3">
                    <label for="firstname">Prénom</label>
                    <input type="text" class="form-control" id="firstname" placeholder="Votre prénom..." name="firstname" required>
                </div>
                <div class="form-group mb-3">
                    <label for="lastname">Nom</label>
                    <input type="text" class="form-control" id="lastname" placeholder="Votre nom..." name="lastname" required>
                </div>
                <div class="form-group mb-3">
                    <label for="email">Mail</label>
                    <input type="email" class="form-control" id="email" placeholder="Votre mail..." name="email" required>
                </div>
                <div class="form-group mb-3">
                    <label for="password">Mot de passe</label>
                    <input type="password" class="form-control" id="password" placeholder="Votre mot de passe..." name="password" required>
                </div>
                <div class="form-group mb-3">
                    <label for="conf_password">Confirmer votre mot de passe</label>
                    <input type="password" class="form-control" id="conf_password" placeholder="Confirmer votre mot de passe..." name="conf_password" required>
                </div>
                <button type="submit" class="btn btn-primary">Valider</button>
            </form>
        </div>
        <?php include("utils/footer.php"); ?>
    </body>
</html>