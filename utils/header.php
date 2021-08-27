<header>
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #B8CCCF;">
        <div class="container-fluid">
            <a class="navbar-brand" href="/Aeroclub/index.php"><img src="/Aeroclub/Images/Logo.png" style="width:125px;" alt="Logo" /></a>
            <button style="color: #003CA5;" class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php if (isset($_SESSION['user']) && $_SESSION['user']['rank'] == 'member') { ?>
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle text-muted" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Ajouter une réservation
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <li><a class="dropdown-item" href="/AeroClub/CalendarWeek.php?type=2">Formation</a></li>
                                    <li><a class="dropdown-item" href="/AeroClub/CalendarWeek.php?type=3">ULM</a></li>
                                    <li><a class="dropdown-item" href="/AeroClub/CalendarWeek.php?type=4">Saut en parachute</a></li>
                                    <li><a class="dropdown-item" href="/AeroClub/CalendarWeek.php?type=9">Baptême de l'air</a></li>
                                </ul>
                            </li>
                        </ul>
                    <?php } ?>
                </ul>
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <?php if (!isset($_SESSION['user'])) { ?>
                        <li class="nav-item dropdown d-flex">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Connexion
                            </a>
                            <div class="dropdown-menu dropdown-menu-lg-end">
                                <form class="px-3 py-3" action="/AeroClub/actions/log_in_process.php" method="post">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Mail</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Votre mail..." required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="password" class="form-label">Mot de passe</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Votre mot de passe..." required>
                                    </div>
                                    <button type="submit" class="btn" style="background-color: #B8CCCF; color:white;">Se connecter</button>
                                </form>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="/AeroClub/sign_in.php">Vous êtes nouveau ici ? Inscrivez-vous</a>
                            </div>
                        </li>
                        <?php } else { ?>
                            <li class="nav-item">
                                <a class="nav-link disabled" href="#">Bonjour <?= $_SESSION['user']['mail']; ?></a>
                            </li>
                        <?php
                        if ($_SESSION['user']['rank'] == 'trainer') { ?>
                            <li class="nav-item d-flex">
                                <a class="nav-link" href="/AeroClub/trainer_space.php">Mon espace</a>
                            </li>
                        <?php }
                        if ($_SESSION['user']['rank'] == 'member') { ?>
                            <li class="nav-item d-flex">
                                <a class="nav-link" href="/AeroClub/member_space.php">Mon espace</a>
                            </li>
                        <?php } ?>
                        <li class="nav-item d-flex">
                            <a class="nav-link text-danger" href="/AeroClub/actions/disconnect.php">Déconnexion</a>
                        </li>
                </ul>
            <?php } ?>
            </div>
        </div>
    </nav>
    <?php if (isset($_GET['msg'])) {
        echo "<p class='alert'>" . $_GET['msg'] . "</p>";
    }
    ?>
</header>