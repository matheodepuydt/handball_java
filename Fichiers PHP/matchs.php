

<?php
include('header.php'); 
session_start();
if (isset($_SESSION['user'])) {
    echo "Salut, " . $_SESSION['user'];
} else {
    echo "Vous n'êtes pas connecté.";
}

?>