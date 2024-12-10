<?php
session_start();
if (isset($_SESSION['user'])) {
    echo "Bonjour, " . $_SESSION['user'];
} else {
    echo "Vous n'êtes pas connecté.";
}

?>