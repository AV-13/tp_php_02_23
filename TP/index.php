<?php require_once 'include/init.php'; ?>
<?php

$req = $pdo->query("SELECT * FROM appartement");
$appartement = $req->fetchAll(PDO::FETCH_ASSOC);
?>

<!----- AFFICHAGE ----->
<?php require_once 'common/headerTP.php'; ?>
<div class="backgroundPhoto">
    <h1 class='titreIndex'> Bienvenue sur HAUSSMANN</h1>
</div>
<div class="affichageCard">

    <?php for ($i = 0; $i < 3; $i++) {
        $key = $i; ?>
        <?php if ($appartement[$key]['reservation_message'] === null) { ?>
            <div class="card">
                <div class="card-body">
                    <p class='title'><?= $appartement[$key]['title'] ?></p>
                    <p class='postalCode'><?= $appartement[$key]['postal_code'] ?></p>
                    <p class='city'><?= $appartement[$key]['city'] ?></p>
                    <p class='price'><?= format_price($appartement[$key]['price']) ?> €</p>
                    <img class='imgCard' src="<?= $appartement[$key]['photo'] ?>">
                    <a href="ficheAnnonce.php?id_appartement=<?= $appartement[$key]['id_appartement'] ?>" class="btn">Consulter cette annonce</a>
                </div>
            </div>
        <?php } else { ?>
            <div class="card">
                <div class="card-body">
                    <p class='title'><?= $appartement[$key]['title'] ?></p>
                    <p class='postalCode'><?= $appartement[$key]['postal_code'] ?></p>
                    <p class='city'><?= $appartement[$key]['city'] ?></p>
                    <p class='price'><?= format_price($appartement[$key]['price']) ?> €</p>
                    <img class='imgCard' src="<?= $appartement[$key]['photo'] ?>">
                    <a href="#" class="btnRes">Réservé</a>
                </div>
            </div>
        <?php } ?>
    <?php } ?>

    <?php require_once 'common/footerTP.php'; ?>