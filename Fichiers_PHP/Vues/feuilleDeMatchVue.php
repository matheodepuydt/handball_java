<?php
require '../Controleurs/joueursControleur.php';
require '../classes/joueur.php';

session_start();

$controleur = new controleurJoueurs();

// Initialiser la liste des titulaires et des remplaçants si elles ne sont pas déjà définies dans la session
if (!isset($_SESSION['titulaires'])) {
    $_SESSION['titulaires'] = [];
}
if (!isset($_SESSION['remplacants'])) {
    $_SESSION['remplacants'] = [];
}

if (isset($_GET['date_heure'])) {
    $_SESSION['date_heure'] = htmlspecialchars($_GET['date_heure']);
}

if (isset($_GET['retirerTitulaire'])) {
    $licenceRetirerTitulaire = htmlspecialchars($_GET['retirerTitulaire']);
    
    // Rechercher et retirer le joueur de la liste des titulaires
    foreach ($_SESSION['titulaires'] as $key => $joueur) {
        if ($joueur->getNum_licence() == $licenceRetirerTitulaire) {
            unset($_SESSION['titulaires'][$key]); // Retirer le joueur
            $_SESSION['titulaires'] = array_values($_SESSION['titulaires']); // Réindexer le tableau
            break;
        }
    }
}

if (isset($_GET['retirerRemplacant'])) {
    $licenceRetirerRemplacant = htmlspecialchars($_GET['retirerRemplacant']);
    
    // Rechercher et retirer le joueur de la liste des remplaçants
    foreach ($_SESSION['remplacants'] as $key => $joueur) {
        if ($joueur->getNum_licence() == $licenceRetirerRemplacant) {
            unset($_SESSION['remplacants'][$key]); // Retirer le joueur
            $_SESSION['remplacants'] = array_values($_SESSION['remplacants']); // Réindexer le tableau
            break;
        }
    }
}

if (isset($_GET['licence'])) {
    $licence = htmlspecialchars($_GET['licence']);
    
    // Vérifier si le joueur est déjà dans la session des titulaires ou des remplaçants
    $joueurDejaDansListeTitulaire = false;
    foreach ($_SESSION['titulaires'] as $joueur) {
        if ($joueur->getNum_licence() == $licence) {
            $joueurDejaDansListeTitulaire = true;
            break;
        }
    }

    $joueurDejaDansListeRemplacant = false;
    foreach ($_SESSION['remplacants'] as $joueur) {
        if ($joueur->getNum_licence() == $licence) {
            $joueurDejaDansListeRemplacant = true;
            break;
        }
    }
    
    // Ajouter le joueur aux titulaires ou remplaçants en fonction de la catégorie
    if (!$joueurDejaDansListeTitulaire && $_GET['feuille'] == 'titulaire') {
        $joueur = $controleur->getJoueur($licence);
        $_SESSION['titulaires'][] = serialize($joueur);
    } elseif (!$joueurDejaDansListeRemplacant && $_GET['feuille'] == 'remplacant') {
        $joueur = $controleur->getJoueur($licence);
        $_SESSION['remplacants'][] = serialize($joueur);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feuille de match</title>
    <link rel="stylesheet" href="../static/style.css">
</head>
<body>

    <?php
    include('../static/header.html');
    ?>
    
    <div class="players-page-container">
        <h1>Feuille de match</h1>
        
        <!-- Titulaires -->
        <label for="joueurs">Titulaires :</label>

        <table class="players-table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Poste</th>
                    <th></th>
                    <th>Note</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (!is_array($_SESSION['titulaires'])) {
                    $_SESSION['titulaires'] = [];
                }

                // Récupérer les titulaires depuis la session
                foreach ($_SESSION['titulaires'] as &$joueur) {
                    if (is_string($joueur)) { // Vérifie si l'élément est une chaîne et donc sérialisé
                        $joueur = unserialize($joueur);
                    }
                    echo "<tr>
                            <td>{$joueur->getNom()}</td>
                            <td>{$joueur->getPrenom()}</td>
                            <td>
                                <select class='select-ajouter-joueur' name='poste'>
                                    <option value='Gardien'>Gardien</option>
                                    <option value='Ailier gauche'>Ailier gauche</option>
                                    <option value='Arrière gauche'>Arrière gauche</option>
                                    <option value='Centre'>Centre</option>
                                    <option value='Arrière droit'>Arrière droit</option>
                                    <option value='Ailier droit'>Ailier droit</option>
                                    <option value='Pivot'>Pivot</option>
                                </select>
                            </td>
                            <td>
                                <a href='feuilleDeMatchVue.php?retirerTitulaire={$joueur->getNum_licence()}'>
                                    <button type='button'>Retirer</button>
                                </a>
                            </td>
                            <td>
                                <select class='select-ajouter-joueur' name='note'>
                                    <option value='1'>1</option>
                                    <option value='2'>2</option>
                                    <option value='3'>3</option>
                                    <option value='4'>4</option>
                                    <option value='5'>5</option>
                                </select>
                            </td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>
        <div class="add-player-section">
            <a href="selectionVue.php?feuille=titulaire">
                <input type="button" value="Ajouter"/>
            </a>
        </div>
        
        <br><br>

        <!-- Remplaçants -->
        <label for="joueurs">Remplaçants :</label>

        <table class="players-table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Poste</th>
                    <th></th>
                    <th>Note</th>
                </tr>
            </thead>
            <tbody>
                <?php

                if (!is_array($_SESSION['remplacants'])) {
                    $_SESSION['remplacants'] = [];
                }

                // Récupérer les remplaçants depuis la session
                foreach ($_SESSION['remplacants'] as &$joueur) {
                    if (is_string($joueur)) { // Vérifie si l'élément est une chaîne et donc sérialisé
                        $joueur = unserialize($joueur);
                    }
                    echo "<tr>
                            <td>{$joueur->getNom()}</td>
                            <td>{$joueur->getPrenom()}</td>
                            <td>
                                <select class='select-ajouter-joueur' name='poste'>
                                    <option value='Gardien'>Gardien</option>
                                    <option value='Ailier gauche'>Ailier gauche</option>
                                    <option value='Arrière gauche'>Arrière gauche</option>
                                    <option value='Centre'>Centre</option>
                                    <option value='Arrière droit'>Arrière droit</option>
                                    <option value='Ailier droit'>Ailier droit</option>
                                    <option value='Pivot'>Pivot</option>
                                </select>
                            </td>
                            <td>
                                <a href='feuilleDeMatchVue.php?retirerRemplacant={$joueur->getNum_licence()}'>
                                    <button type='button'>Retirer</button>
                                </a>
                            </td>
                            <td>
                                <select class='select-ajouter-joueur' name='note'>
                                    <option value='1'>1</option>
                                    <option value='2'>2</option>
                                    <option value='3'>3</option>
                                    <option value='4'>4</option>
                                    <option value='5'>5</option>
                                </select>
                            </td>
                          </tr>";
                }                
                ?>
            </tbody>
        </table>
        <div class="add-player-section">
            <a href="selectionVue.php?feuille=remplacant">
                <input type="button" value="Ajouter"/>
            </a>
        </div>
    </div>
</body>
</html>
