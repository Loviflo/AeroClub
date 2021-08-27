<!DOCTYPE html>
<html lang="fr">

<head>
    <?php include 'utils/head.php'; ?>
    <title>Nos avions</title>
    <link rel="stylesheet" href="CSS/calendar.css">
    <?php
    ini_set("display_errors", 1);
    ?>
</head>

<body class="d-flex flex-column h-100">
    <?php include 'utils/header.php'; ?>
    <div class="container mt-3">
        <h1 class="text-center">Nos avions</h1>
        <div class="row">
        <div class="col-lg-6">
            <div class="card mb-3">
                <img src="/AeroClub/Images/RobinDR400FGDES.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Robin DR 400 120cv F GDES</h5>
                    <p class="card-text">Voici notre avion pour les formations.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card mb-3">
                <img src="/AeroClub/Images/PIPERFGIDI.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">PIPER PA 28 180cv F GIDI</h5>
                    <p class="card-text">Voici notre avion pour les sauts en parachutes et les baptêmes de l'air.</p>
                </div>
            </div>
        </div>
        </div>
        <div class="row">
        <div class="col-lg-6">
            <div class="card mb-3">
                <img src="/AeroClub/Images/PIPISTRELVIRUSSW.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">PIPISTREL VIRUS SW</h5>
                    <p class="card-text">Notre premier ULM.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card mb-3">
                <img src="/AeroClub/Images/FLIGHTDESIGNCT2K.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Flight Design CT 2k</h5>
                    <p class="card-text">Notre deuxième ULM.</p>
                </div>
            </div>
        </div>
        </div>
    </div>
    

    <?php include 'utils/footer.php'; ?>
</body>

</html>