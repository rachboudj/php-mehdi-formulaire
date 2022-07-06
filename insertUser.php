<?php

require('includes/pdo.php');
require('includes/function.php');

if(!empty($_POST['submitted'])) {
    // Faille XSS


    $title = cleanXss('title');
    $content = trim(strip_tags($_POST['content']));
    $mail = trim(strip_tags($_POST['mail']));
    // Validation
    $errors = validText($errors,$title,'title',3,100);
    $errors = validText($errors,$content,'content',10,1000);
    $errors = validEmail($errors, $mail, 'mail');

    if(count($errors) === 0) {
        // insertion en BDD si aucune error
        $sql = "INSERT INTO beer (title,content,email,created_at) VALUES (:title,:content,:mail,NOW())";
        $query = $pdo->prepare($sql);
        // ATTENTION INJECTION SQL
        $query->bindValue(':title',$title, PDO::PARAM_STR);
        $query->bindValue(':content',$content, PDO::PARAM_STR);
        $query->bindValue(':mail',$mail, PDO::PARAM_STR);
        $query->execute();
        $last_id = $pdo->lastInsertId();
        header('Location: detail-beer.php?id=' . $last_id);
        // $success = true;
    }
}
?>



<h1>Ajouter un utilisateur</h1>
    <form action="" method="post" novalidate class="wrap2">
        <label for="nom">Nom</label>
        <input type="text" name="nom" id="nom" value="<?php if(!empty($_POST['nom'])) { echo $_POST['nom']; } ?>">
        <span class="error"><?php if(!empty($errors['title'])) { echo $errors['title']; } ?></span>

        <label for="prenom">Prénom</label>
        <textarea name="prenom" id="prenom" cols="30" rows="10"><?php if(!empty($_POST['prenom'])) { echo $_POST['prenom']; } ?></textarea>
        <span class="error"><?php if(!empty($errors['content'])) { echo $errors['content']; } ?></span>

        <label for="email">E-mail</label>
        <input type="email" name="email" id="email" value="<?php if(!empty($_POST['email'])) { echo $_POST['email']; } ?>">
        <span class="error"><?php if(!empty($errors['mail'])) { echo $errors['mail']; } ?></span>

        <input type="submit" name="submitted" value="Ajouter un utilisateur">
    </form>
