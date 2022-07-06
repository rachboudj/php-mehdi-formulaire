<?php

require('includes/pdo.php');
require('includes/function.php');

$sucess = false;
$errors = [];
if(!empty($_POST['submitted'])) {
    // Faille XSS


    $nom = cleanXss('nom');
    $prenom = cleanXss('prenom');
    $email = cleanXss('email');
    // $prenom = trim(strip_tags($_POST['prenom']));
    // $email = trim(strip_tags($_POST['email']));
    // Validation
    $errors = validText($errors,$nom,'nom',2,100);
    $errors = validText($errors,$prenom,'prenom',2,100);
    $errors = validEmail($errors, $email, 'email');

    if(count($errors) === 0) {
        // insertion en BDD si aucune error
        $sql = "INSERT INTO users (nom,prenom,email,created_at) VALUES (:nom,:prenom,:email,NOW())";
        $query = $pdo->prepare($sql);
        // ATTENTION INJECTION SQL
        $query->bindValue(':nom',$nom, PDO::PARAM_STR);
        $query->bindValue(':prenom',$prenom, PDO::PARAM_STR);
        $query->bindValue(':email',$email, PDO::PARAM_STR);
        $query->execute();
        $last_id = $pdo->lastInsertId();
        // header('Location: detail-beer.php?id=' . $last_id);
        // $success = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Php mehdi formulaire</title>

    <link rel="stylesheet" href="./asset/style.css">
</head>
<body>
    <h1>Ajouter un utilisateur</h1>
    <form action="" method="post" novalidate class="wrap2">
        <label for="nom">Nom</label>
        <input type="text" name="nom" id="nom" value="<?php if(!empty($_POST['nom'])) { echo $_POST['nom']; } ?>">
        <span class="error"><?php if(!empty($errors['nom'])) { echo $errors['nom']; } ?></span>

        <label for="prenom">Prénom</label>
        <input type="text" name="prenom" id="prenom" value="<?php if(!empty($_POST['prenom'])) { echo $_POST['prenom']; } ?>">
        <span class="error"><?php if(!empty($errors['prenom'])) { echo $errors['prenom']; } ?></span>

        <label for="email">E-mail</label>
        <input type="email" name="email" id="email" value="<?php if(!empty($_POST['email'])) { echo $_POST['email']; } ?>">
        <span class="error"><?php if(!empty($errors['email'])) { echo $errors['email']; } ?></span>

        <input type="submit" name="submitted" value="Ajouter un utilisateur">
    </form>
</body>
</html>
