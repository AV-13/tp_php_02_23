<?php
require_once 'include/init.php';

if ($_POST) {
    foreach ($_POST as $key => $value) {
        $_POST[$key] = htmlspecialchars(addslashes(trim($value)));
    }
    if (strlen($_POST['title']) < 10 || strlen($_POST['title']) > 255) {
        $erreur .= '<div class="alert">Le title doit contenir entre 10 et 255 caractères</div>';
    }
    if (strlen($_POST['city']) < 3 || strlen($_POST['city']) > 100) {
        $erreur .= '<div class="alert">Le nom de la city doit contenir entre 3 et 100 caractères</div>';
    }
    if (strlen($_POST['description']) < 20) {
        $erreur .= '<div class="alert">La description doit au moins contenir 20 caractères</div>';
    }
    if (strlen($_POST['price']) < 3) {
        $erreur .= '<div class="alert">Le price de votre bien doit au moins dépasser 3 décimales pour pouvoir être posté sur le Bon Appart</div>';
    }
    if (strlen($_POST['postal_code']) != 5) {
        $erreur .= '<div class="alert alert-danger">Le code postal doit contenir 5 caractères</div>';
    }
    if (!empty($_FILES['photo'])) {
        var_dump($_FILES['photo']);
        $imgName = $_FILES['photo']['name'];
        $imgName = "Logement_" . time() . "_" . $imgName;
        $extension = pathinfo($imgName, PATHINFO_EXTENSION);
        $extension = strtolower($extension);
        $tabExt = ['jpg', 'jpeg', 'png', 'webp'];

        $imgBdd = URL . "public/images/$imgName";


        $imgServer = RACINE_SITE . "public/images/$imgName";

        if ($_FILES['photo']['size'] > 4000000 && !in_array($extension, $tabExt)) {
            $erreur .= '<div class="alert">Taille de l\'image trop grande</div>';
            $erreur .= '<div class="alert">Veuillez vérifier l\'exension</div>';
        }
    } else {
        $erreur .= '<div class="alert">Veuillez ajouter une photo à votre annonce</div>';
    }
    if (empty($erreur)) {
        $insertAnnonce = $pdo->prepare("INSERT INTO `appartement`(`title`, `city`, `postal_code`, `description`, `type`, `price`, `photo`) VALUES (:title, :city, :postal_code, :description, :type, :price, :photo)");
        $insertAnnonce->bindValue(':title', $_POST['title'], PDO::PARAM_STR);
        $insertAnnonce->bindValue(':city', $_POST['city'], PDO::PARAM_STR);
        $insertAnnonce->bindValue(':postal_code', $_POST['postal_code'], PDO::PARAM_STR);
        $insertAnnonce->bindValue(':description', $_POST['description'], PDO::PARAM_STR);
        $insertAnnonce->bindValue(':type', $_POST['type'], PDO::PARAM_STR);
        $insertAnnonce->bindValue(':price', $_POST['price'], PDO::PARAM_STR);
        $insertAnnonce->bindValue(':photo', $imgBdd, PDO::PARAM_STR);

        if ($insertAnnonce->execute()) {
            copy($_FILES['photo']['tmp_name'], $imgServer);
            $validation .= '<div class="alert">Vous avez ajouter votre annonce.</div>';
        } else {
            $validation .= '<div class="alert">Erreur lors de l\'ajout.</div>';
        }
    }

    $validation .= $erreur;
}


?>

<?php require_once 'common/headerTP.php'; ?>
<?php echo $validation; ?>
<div class="formulaire" title="Formulaire d'inscription">
    <form action='' method="post" enctype="multipart/form-data">
        <div>
            <label for="title">Titre:</label>
            <input type="text" id="title" name="title" placeholder="Appartement 3 pièces à la Butte aux Cailles">
        </div>
        <div>
            <label for="city">Ville :</label>
            <input type="text" id="city" name="city" placeholder="Paris">
        </div>
        <div>
            <label for="postal_code">Code postal :</label>
            <input type="text" id="postal_code" name="postal_code" placeholder="75013">
        </div>
        <div>
            <label for="description">Description :</label>
            <textarea id="description" name="description" placeholder="Décrivez votre bien immobilier en quelques mots"></textarea>
        </div>
        <label for='type'>Type de bien:</label>

        <select name="type" id="type">
            <option value="location">Location</option>
            <option value="vente">Vente</option>
        </select>
        <div>
            <label for="price">Prix : </label>
            <input type="text" id="price" name="price" placeholder="300 000 €">
        </div>
        <div>
            <div>
                <input type="file" placeholder="Photo du bien" name="photo">
            </div>
            <input type="submit" class='submitButton' value="Poster une annonce">
        </div>
    </form>
</div>
<?php require_once 'common/footerTP.php'; ?>