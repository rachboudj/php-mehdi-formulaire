<?php
require('./includes/pdo.php');
require('./includes/function.php');
include('./includes/header.php'); 

?>
<?php
if(!empty($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    $sql_edit_user = "SELECT * FROM users WHERE id = :id";
    $query = $pdo->prepare($sql_edit_user);
    $query->bindValue(':id',$id, PDO::PARAM_INT);
    $query->execute();
    $user = $query->fetch();
    // debug($user);
    // die;

$errors = [];
if(!empty($_POST['submitted'])) {

    $nom = cleanXss('nom');
    $prenom = cleanXss('prenom');
    $email = cleanXss('email');

    $errors = validText($errors,$nom,'nom',2,100);
    $errors = validText($errors,$prenom,'prenom',2,100);
    $errors = validEmail($errors, $email, 'email');

    if(count($errors) === 0) {
        $requete_update = "UPDATE users SET nom= :nom, prenom= :prenom, email = :email  WHERE id= :id";
        $query = $pdo->prepare($requete_update);
        $query->bindValue(':nom',$nom, PDO::PARAM_STR);
        $query->bindValue(':prenom',$prenom, PDO::PARAM_STR);
        $query->bindValue(':email',$email, PDO::PARAM_STR);
        $query->bindValue(':id',$id, PDO::PARAM_INT);
        $query->execute();
        header('Location: index.php');
    }
}
?>
<h1>Editer un utilisateur</h1>
    <form action="" method="post" novalidate>
        <label for="nom">
            <span>Nom :</span>
            <input type="text" name="nom" value="<?=$user['nom']?>">
            <span class="error"><?php if(!empty($errors['nom'])) { echo $errors['nom']; } ?></span>

        </label>
        <label for="prenom">
            <span>Prenom :</span>
            <input type="text" name="prenom" value="<?=$user['prenom']?>">
            <span class="error"><?php if(!empty($errors['prenom'])) { echo $errors['prenom']; } ?></span>
        </label>
        <label for="email">
            <span>Email :</span>
            <input type="text" name="email" value="<?=$user['email']?>">
            <span class="error"><?php if(!empty($errors['email'])) { echo $errors['email']; } ?></span>
        </label>
        <input type="submit" name="submitted" value="Editer utilisateur">
    </form>
<?php } ?>