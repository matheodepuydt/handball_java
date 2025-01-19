<?php
require '../Controleurs/redirectionControleur.php';

// Connexion à la base de données
$server = 'localhost';
$bd = 'phphandball';
$db_login = 'admin';
$db_password = '$iutinfo';

try {
    $linkpdo = new PDO("mysql:host=$server;dbname=$bd", $db_login, $db_password);
    $linkpdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $req = $linkpdo->prepare('SELECT login, password FROM authentification');
    $req->execute();
    $users = $req->fetchAll(PDO::FETCH_ASSOC);

    foreach ($users as $user) {
        // Vérifie si le mot de passe n'est pas déjà haché
        if (!password_get_info($user['password'])['algo']) {
            $hashedPassword = password_hash($user['password'], PASSWORD_DEFAULT);
            
            // Mettre à jour le mot de passe dans la base
            $update = $linkpdo->prepare('UPDATE authentification SET password = :hashedPassword WHERE login = :login');
            $update->bindParam(':hashedPassword', $hashedPassword, PDO::PARAM_STR);
            $update->bindParam(':login', $user['login'], PDO::PARAM_STR);
            $update->execute();
        }
    }

    echo "Tous les mots de passe ont été hachés avec succès.";
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
?>