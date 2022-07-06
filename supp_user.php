<?php 
require('./includes/pdo.php');

// DELETE FROM users WHERE id=
if(!empty($_GET['id']) && is_numeric($_GET['id'])) 
{
    $id = $_GET['id'];
    $sql = "DELETE FROM users WHERE id = :id";
    $query = $pdo->prepare($sql);
    $query->bindValue(':id',$id, PDO::PARAM_INT);
    $query->execute();
    // $users = $query->fetch();
    header('Location: index.php');
} else {
    die("Aucun parametre n'est passé à la page de suppression");
}
