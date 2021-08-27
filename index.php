<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include 'utils/head.php'; ?>
    <title>Accueil</title>
    <link rel="stylesheet" href="CSS/calendar.css">
    <?php
    ini_set("display_errors", 1);
    ?>
</head>

<body class="d-flex flex-column h-100">
    <?php include 'utils/header.php'; ?>
    <div class="parallax">
    </div>
    <div class="container mt-3">
        <h1 class="text-center">Bienvenue dans notre AeroClub</h1>
        <div class="row">
        <div class="col-lg-6">
            <h4 class="text-center">Notre flotte</h4>
            <p>L'aéroclub vous propose une flotte moderne et performante de <a href="/AeroClub/planes.php">4 avions</a> dédiés à l'instruction et aux voyages.</p>
        </div>
        <div class="col-lg-6">
            <h4 class="text-center">L'équipe</h4>
            <p>Nos instructeurs sont à votre écoute et vous dispenseront une formation de qualité dans le respect de la réglementation et dans un souci permanent de sécurité et d'efficacité.</p>
        </div>
        </div>
        </div>
    </div>

    <?php include 'utils/footer.php'; ?>
</body>

</html>