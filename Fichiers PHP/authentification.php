<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentification</title>
    <style>
        /* Style global */
        body-authentification {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #444444, #777);
            color: #fff;
        }

        /* Conteneur principal */
        .auth-container {
            background-color: #2c2c2c;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
            width: 100%;
            max-width: 400px;
        }

        .auth-container h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #ffffff;
        }

        /* Style du formulaire */
        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"] {
            padding: 10px;
            margin-bottom: 15px;
            border: none;
            border-radius: 5px;
            background-color: #444;
            color: #fff;
        }

        input[type="submit"] {
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #777;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #999;
        }

        .error-message {
            color: #ff4d4d;
            margin-top: 10px;
            font-size: 14px;
        }
    </style>
</head>
<body name="body-authentification">
    <div class="auth-container">
        <h1>Authentification</h1>
        <form action="authentification.php" method="post">
            <label for="login">Nom d'utilisateur :</label>
            <input type="text" id="login" name="login" required>

            <label for="password">Mot de passe :</label>
            <input type="password" id="password" name="password" required>

            <input type="submit" name="seConnecter" value="Se connecter">

            <!-- Zone d'erreur, remplacez dynamiquement avec PHP si nécessaire -->
            <!-- <div class="error-message">Nom d'utilisateur ou mot de passe incorrect.</div> -->
        </form>
    </div>
</body>
</html>

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