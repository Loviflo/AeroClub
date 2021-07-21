<header class="p-1 text-white" style="background: rgb(103,66,50);color: rgb(255,255,255);">
    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
    <div class="text-start">
        <a href="/QuickBaluchon/QuickBaluchon/index.php" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
            <img src="/QuickBaluchon/QuickBaluchon/img/Logo_SPS.png" style="width:20;height:16" alt="Logo"/>
        </a>
    </div>

        <div class="text-end">
            <?php if (isset($_SESSION['user'])) { ?>
                <div class="row">
                    <?php if ($_SESSION['user']['rank'] == 'staff') { ?>
                    <div class="col">
                        <a href="/QuickBaluchon/QuickBaluchon/backend/staff_account.php"><button type="button" class="btn btn-warning"><?php echo $site->headers->header->itemClientSpace->staff; ?></button></a>
                    </div>
                    <?php } else if($_SESSION['user']['rank'] == 'client') { ?>
                    <div class="col">
                        <a href="/QuickBaluchon/QuickBaluchon/client_space.php"><button type="button" class="btn btn-warning"><?php echo $site->headers->header->itemClientSpace->client; ?></button></a>
                    </div>
                    <?php } else if($_SESSION['user']['rank'] == 'deliveryman') { ?>
                    <div class="col">
                        <a href="/QuickBaluchon/QuickBaluchon/deliveryman_space.php"><button type="button" class="btn btn-warning"><?php echo $site->headers->header->itemClientSpace->deliveryman; ?></button></a>
                    </div>
                    <?php } ?>
                    <div class="col">
                        <a href="/QuickBaluchon/QuickBaluchon/actions/disconnect.php"><button type="button" class="btn btn-danger">Déconnexion</button></a>
                    </div>
                    
                </div>
            <?php } else { ?>
                <div class="row">
                    <div class="col">
                    <a href="/AeroClub/log_in.php"><button type="button" class="btn">Connexion</button></a>
                    </div>
                    <div class="col">
                    <a href="/AeroClub/sign_in.php"><button type="button" class="btn">Inscription</button></a>
                    </div>
                    <div class="col">
                    <a href="/AeroClub/log_in_trainers.php"><button type="button" class="btn">Connexion formateurs</button></a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</header>
<?php if(isset($_GET['msg'])) {
    echo "<p class='alert'>" . $_GET['msg'] . "</p>";
}
?>

