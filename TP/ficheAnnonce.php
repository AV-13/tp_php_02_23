<?php
require_once 'include/init.php';
if ($_POST) {
    if (strlen($_POST['reservation_message']) < 50) {
        $erreur .= '<div class="alert">Votre message au propriétaire doit contenir au moins 50 caractères.</div>';
    }
    if (empty($erreur)) {
        $updateReservation = $pdo->prepare("UPDATE appartement SET reservation_message = :reservation_message WHERE id_appartement = :id_appartement");
        $updateReservation->bindValue(':reservation_message', $_POST['reservation_message'], PDO::PARAM_STR);
        $updateReservation->bindValue(':id_appartement', $_GET['id_appartement'], PDO::PARAM_INT);
        if ($updateReservation->execute()) {
            $validation .= '<div class="alert">Vous avez envoyé votre demande au propriétaire, il vous répondra dans moins de 48h.</div>';
        } else {
            $validation .= '<div class="alert">Erreur lors de la réservation</div>';
        }
    }

    $validation .= $erreur;
}

if (!isset($_GET['id_appartement'])) {
    header('location:consulterAnnonce.php');
    exit();
}

if (isset($_GET['id_appartement'])) {
    $reqFiche = $pdo->prepare("SELECT * FROM appartement WHERE id_appartement = :id_appartement");
    $reqFiche->bindValue(':id_appartement', $_GET['id_appartement'], PDO::PARAM_INT);
    $reqFiche->execute();
    $appartement = $reqFiche->fetch(PDO::FETCH_ASSOC);
}
?>
<?php require_once 'common/headerTP.php'; ?>
<?php if ($appartement['reservation_message'] === null) { ?>
    <div class="ficheContainer">
        <img class='imgFiche' src="<?= $appartement['photo'] ?>" alt="...">
        <div class="ficheBody">
            <h2><?= $appartement['title'] ?></h2>
            <p class='ficheCP'><span class="styleDesc">Code postal : </span><?= $appartement['postal_code'] ?></p>
            <p class='ficheVille'><span class="styleDesc">Ville : </span><?= $appartement['city'] ?></p>
            <p class='ficheType'><span class="styleDesc">Type de logement : </span><?= $appartement['type'] ?></p>
            <p class='ficheDesc'><span class="styleDesc">Description : </span><?= $appartement['description'] ?></p>
            <p class='fichePrice'><span class="styleDesc">Prix : </span><?= format_price($appartement['price']) ?> €</p>
            <div class="formulaire" title="Formulaire d'inscription">
                <form action='' method="post" enctype="multipart/form-data">
                    <div>
                        <label for="description">Message de réservation :</label>
                    </div>
                    <div>
                        <textarea class='resMessage' name="reservation_message" placeholder="Présentez vous et faites votre demande au propriétaire"></textarea>
                    </div>
                    <div>
                        <input type="submit" class='submitButton' value="Réserver">
                    </div>
                </form>
                <?php echo $validation ?>
            </div>
        </div>
    </div>
<?php } else { ?>
    <div class="ficheContainer">
        <img class='imgFiche' src="<?= $appartement['photo'] ?>" alt="...">
        <div class="ficheBody">
            <h2><?= $appartement['title'] ?></h2>
            <p class='ficheCP'><span class="styleDesc">Code postal : </span><?= $appartement['postal_code'] ?></p>
            <p class='ficheVille'><span class="styleDesc">Ville : </span><?= $appartement['city'] ?></p>
            <p class='ficheType'><span class="styleDesc">Type de logement : </span><?= $appartement['type'] ?></p>
            <p class='ficheDesc'><span class="styleDesc">Description : </span><?= $appartement['description'] ?></p>
            <p class='fichePrice'><span class="styleDesc">Prix : </span><?= format_price($appartement['price']) ?> €</p>
            <p class='ficheReservation'><span class="styleDesc">Message de réservation : </span><?= $appartement['reservation_message'] ?></p>
        </div>
    </div>
<?php } ?>
<?php require_once 'common/footerTP.php'; ?>