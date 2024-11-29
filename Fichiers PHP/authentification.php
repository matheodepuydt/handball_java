<h1>Authentification</h1>
<form action="authentification.php" method="post">
    Nom d'utilisateur : <input type="text" name="login"><br/>
    Mot de passe  : <input type="password" name="password"><br/>
    <input type="submit" name="seConnecter" value="Se connecter"><br/><br/>
</form>
<?php
if (isset($_POST["login"]) && isset($_POST["password"]) && isset($_POST["valider"])){

    //récupération des valeurs des champs de saisie
    $login = $_POST["login"];
    $password = $_POST["password"];

    //Connection à la Base de donnée
    $server = 'localhost';
    $bd = 'phphandball';
    $login = 'root';
    $mdp = '$iutinfo';
    try {
        $linkpdo = new PDO("mysql:host=$server;dbname=$bd", $login, $mdp);
    }

    catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }

    //Création de la requête SQL pour vérifier l'existence de l'utilisateur
    $req = $linkpdo-> prepare('SELECT password from authentification WHERE login = :thelogin');

    //Assignation des paramètres
    $req->bindParam(':thelogin', $login, PDO::PARAM_STR);

    //Exécution de la requête
    $req->execute();

    //Récupération du résultat de la requête
    $result = $req->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        //Vérifer que le mot de passe est correct
        $hashedPassword = $result['password'];

        //
        
    }

}

?>