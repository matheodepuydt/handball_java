<?php
// Connexion à la base de données
$server = 'localhost';
$bd = 'phphandball';
$db_login = 'admin';
$db_password = '$iutinfo';

try {
    $linkpdo = new PDO("mysql:host=$server;dbname=$bd", $db_login, $db_password);
    $linkpdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

// Récupérer tous les utilisateurs
$req = $linkpdo->prepare('SELECT login, password FROM authentification');
$req->execute();
$users = $req->fetchAll(PDO::FETCH_ASSOC);

foreach ($users as $user) {
    $login = $user['login']; // Utilisation de login pour identifier l'utilisateur
    $plainPassword = $user['password']; // Le mot de passe actuel (non haché)

    // Hachage du mot de passe
    $hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

    // Mise à jour du mot de passe haché dans la base
    $update = $linkpdo->prepare('UPDATE authentification SET password = :hashedPassword WHERE login = :login');
    $update->bindParam(':hashedPassword', $hashedPassword, PDO::PARAM_STR);
    $update->bindParam(':login', $login, PDO::PARAM_STR); // On utilise `login` ici pour identifier l'utilisateur
    $update->execute();
}

echo "Tous les mots de passe ont été hachés avec succès.";
?>
