<h1>Authentification</h1>
<form action="authentification.php" method="post">
    Nom d'utilisateur : <input type="text" name="login" required><br/>
    Mot de passe  : <input type="password" name="password" required><br/>
    <input type="submit" name="seConnecter" value="Se connecter"><br/><br/>
</form>

<?php

// Connexion à la base de données
$server = 'localhost';
$bd = 'phphandball';
$db_login = 'admin';
$db_password = '$iutinfo';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = trim($_POST['login']);
    $password = trim($_POST['password']);

    // Validation des champs
    if (empty($login) || empty($password)) {
        die("Nom d'utilisateur ou mot de passe incorrect");
    }

    try {
        $linkpdo = new PDO("mysql:host=$server;dbname=$bd", $db_login, $db_password);
        $linkpdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Préparation de la requête
        $stmt = $linkpdo->prepare('SELECT password FROM authentification WHERE login = :login');
        $stmt->bindParam(':login', $login, PDO::PARAM_STR);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $hashedPassword = $result['password'];
            // Affiche le mot de passe haché pour le débogage
            var_dump($hashedPassword); 
            var_dump($password); 
            // Teste la vérification du mot de passe
            var_dump(password_verify($password, $hashedPassword)); 
            if (password_verify($password, $hashedPassword)) {
                session_start();
                $_SESSION['user'] = $login;
                header('Location: matchs.php');
                exit();
            } else {
                echo "Le mot de passe est incorrect.";
            }
        } else {
            echo "Le nom d'utilisateur est introuvable.";
        }
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
}
?>