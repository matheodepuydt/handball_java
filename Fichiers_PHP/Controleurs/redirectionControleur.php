<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    // Si l'utilisateur n'est pas connecté et n'est pas sur la page de login, redirigez-le
    if (basename($_SERVER['PHP_SELF']) !== 'authentificationVue.php') {
        header('Location: authentificationVue.php');
        exit();
    }
}
?>
