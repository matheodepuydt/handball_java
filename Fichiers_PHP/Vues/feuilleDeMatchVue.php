<?php
require_once '../classes/participer.php';
require '../Controleurs/joueursControleur.php';
require '../Controleurs/matchsControleur.php';
require '../classes/joueur.php';
require '../Controleurs/redirectionControleur.php';


//session_start();

$controleurJoueur = new controleurJoueurs();
$controleurMatch = new matchsControleur();

if (!isset($_SESSION['titulaires'])) {
    $_SESSION['titulaires'] = [];
}
if (!isset($_SESSION['remplacants'])) {
    $_SESSION['remplacants'] = [];
}
if (!isset($_GET['feuille'])) {
    $_GET['feuille'] = "";
}

// Vérifier si le formulaire a été soumis avec les nouvelles notes
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Mettre à jour la note de chaque titulaire
    foreach ($_SESSION['titulaires'] as &$participer) {
        // Vérifier si une note a été soumise pour ce joueur
        if (isset($_GET['note'])) {
            $nouvelleNote = htmlspecialchars($_GET['note']);
            $licenceCible = htmlspecialchars($_GET['num_licence']);

            foreach ($_SESSION['titulaires'] as &$participer) {
                if ($participer->getNum_licence() == $licenceCible) {
                    $participer->setNote($nouvelleNote);
                    break; // Une fois trouvé, on arrête la boucle
                }
            }

        } else if (isset($_GET['poste']) && isset($_GET['num_licence'])) {
            $nouveauPoste = htmlspecialchars($_GET['poste']);
            $licenceCible = htmlspecialchars($_GET['num_licence']);
            
            foreach ($_SESSION['titulaires'] as &$participer) {
                if ($participer->getNum_licence() == $licenceCible) {
                    $participer->setPoste($nouveauPoste);
                    break; // Une fois trouvé, on arrête la boucle
                }
            }
        }
    }
    
    // Mettre à jour la note de chaque remplaçant
    foreach ($_SESSION['remplacants'] as &$participer) {
        // Vérifier si une note a été soumise pour ce joueur
        if (isset($_GET['note'])) {
            $nouvelleNote = htmlspecialchars($_GET['note']);
            $licenceCible = htmlspecialchars($_GET['num_licence']);

            foreach ($_SESSION['remplacants'] as &$participer) {
                if ($participer->getNum_licence() == $licenceCible) {
                    $participer->setNote($nouvelleNote);
                    break; // Une fois trouvé, on arrête la boucle
                }
            }

        
        }else if (isset($_GET['poste']) && isset($_GET['num_licence'])) {
            $nouveauPoste = htmlspecialchars($_GET['poste']);
            $licenceCible = htmlspecialchars($_GET['num_licence']);
            
            foreach ($_SESSION['remplacants'] as &$participer) {
                if ($participer->getNum_licence() == $licenceCible) {
                    $participer->setPoste($nouveauPoste);
                    break; // Une fois trouvé, on arrête la boucle
                }
            }
        }
    }
}



if (isset($_GET['date_heure'])) {
    $_SESSION['date_heure'] = htmlspecialchars($_GET['date_heure']);
    $_SESSION['titulaires'] = $controleurMatch->getAllParticipationsTitulaires($_SESSION['date_heure']);
    $_SESSION['remplacants'] = $controleurMatch->getAllParticipationsRemplacants($_SESSION['date_heure']);
}

$dateActuelle = date('Y-m-d H:i'); // Date et heure actuelles
$estPasse = strtotime($_SESSION['date_heure']) < strtotime($dateActuelle); // Comparaison des dates
$matchDansLePasse = $estPasse ? "disabled" : ""; // Variable pour désactiver si le match est dans le passé

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
        // Vérifier si le nombre de titulaires est inférieur à 7
        if (count($_SESSION['titulaires']) < 7) {
            $participer = new Participer($licence,$_SESSION['date_heure'],1,null,null);
            $_SESSION['titulaires'][] = $participer;
        } else {
            echo "<p>Le nombre de titulaires ne peut pas dépasser 7.</p>";
        }
    } elseif (!$joueurDejaDansListeRemplacant && $_GET['feuille'] == 'remplacant') {
        // Vérifier si le nombre de remplaçants est inférieur à 7
        if (count($_SESSION['remplacants']) < 7) {
            $participer = new Participer($licence,$_SESSION['date_heure'],0,null,null);
            $_SESSION['remplacants'][] = $participer;
        } else {
            echo "<p>Le nombre de remplaçants ne peut pas dépasser 7.</p>";
        }
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

    if (isset($_GET['valider'])) { // Si le bouton valider est cliqué
        // Vérifier que le nombre de titulaires est bien égal à 7
        if (count($_SESSION['titulaires']) != 7) {
            echo "<p class='error-message'>Il doit y avoir exactement 7 titulaires pour valider la feuille de match.</p>";
        } else {
            $controleurMatch->updateParticipers($_SESSION['titulaires'], $_SESSION['remplacants'], $_SESSION['date_heure']);
            header('Location: matchsVue.php');
            exit();
        }
    }
    ?>
    
    <div class="players-page-container">
        <h1>Feuille de match</h1>
        <div class="players-page-container">
            <!-- Titulaires -->
            <label for="joueurs">Titulaires : <?php echo count($_SESSION['titulaires']); ?>/7</label>

            <table class="players-table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Poste</th>
                        <th></th>
                        <th>Note</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    // Récupérer les titulaires depuis la session
                    foreach ($_SESSION['titulaires'] as &$participer) {
                        if (is_string($participer)) { // Vérifie si l'élément est une chaîne et donc sérialisé
                            $participer = unserialize($participer);
                        }
                        $joueur = $controleurJoueur->getJoueur($participer->getNum_licence());
                        $num_licence = $participer->getNum_licence();
                        $date_heure = $participer->getDate();
                        echo "<form method='POST' action='feuilleDeMatchVue.php'>
                                <tr>
                                    <td>{$joueur->getNom()}</td>
                                    <td>{$joueur->getPrenom()}</td>
                                    <td>{$participer->getPoste()}</td>
                                    <td>
                                        <a href='changerDePosteVue.php?date_heure={$date_heure}&num_licence={$num_licence}'>
                                            <button type='button' " . ($matchDansLePasse ? "disabled" : "") . ">Changer de Poste</button>
                                        </a>
                                    </td>
                                    <td>{$participer->getNote()}</td>
                                    <td>
                                        <a href='changerNoteVue.php?date_heure={$date_heure}&num_licence={$num_licence}'>
                                            <button type='button' ". (!$matchDansLePasse ? "disabled" : "") . ">Évaluer</button>
                                        </a>
                                    </td>
                                    <td>
                                        <a href='feuilleDeMatchVue.php?retirerTitulaire={$joueur->getNum_licence()}'>
                                            <button type='button' $matchDansLePasse>Retirer</button>
                                        </a>
                                    </td>
                                </tr>
                            </form>
                            ";
                    }
                    ?>
                </tbody>
            </table>
            <div class="players-table">
                <?php
                if (count($_SESSION['titulaires']) < 7) {
                    echo "<a href='selectionVue.php?feuille=titulaire'>
                            <button type='button' $matchDansLePasse>Ajouter</button>
                        </a>";
                } else {
                    echo "<p>Le nombre maximum de titulaires est atteint. Vous ne pouvez pas ajouter d'autres joueurs.</p>";
                }
                ?>
            </div>

            <br><br>

            <!-- Remplaçants -->
            <label for="joueurs">Remplaçants : <?php echo count($_SESSION['remplacants']); ?>/7 (facultatif)</label>

            <table class="players-table">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Poste</th>
                        <th></th>
                        <th>Note</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    if (!is_array($_SESSION['remplacants'])) {
                        $_SESSION['remplacants'] = [];
                    }

                    // Récupérer les remplaçants depuis la session
                    foreach ($_SESSION['remplacants'] as &$participer) {
                        if (is_string($participer)) { // Vérifie si l'élément est une chaîne et donc sérialisé
                            $participer = unserialize($participer);
                        }
                        $joueur = $controleurJoueur->getJoueur($participer->getNum_licence());
                        $num_licence = $participer->getNum_licence();
                        $date_heure = $participer->getDate();
                        echo "<form method='POST' action='feuilleDeMatchVue.php'>
                                <tr>
                                    <td>{$joueur->getNom()}</td>
                                    <td>{$joueur->getPrenom()}</td>
                                    <td>{$participer->getPoste()}</td>
                                    <td>
                                        <a href='changerDePosteVue.php?date_heure={$date_heure}&num_licence={$num_licence}'>
                                            <button type='button' " . ($matchDansLePasse ? "disabled" : "") . ">Changer de Poste</button>
                                        </a>
                                    </td>
                                    <td>{$participer->getNote()}</td>
                                    <td>
                                        <a href='changerNoteVue.php?date_heure={$date_heure}&num_licence={$num_licence}'>
                                            <button type='button' ". (!$matchDansLePasse ? "disabled" : "") . ">Évaluer</button>
                                        </a>
                                    </td>
                                    <td>
                                        <a href='feuilleDeMatchVue.php?retirerRemplacant={$joueur->getNum_licence()}'>
                                            <button type='button' $matchDansLePasse>Retirer</button>
                                        </a>
                                    </td>
                                </tr>
                            </form>
                            ";
                    }                
                    ?>
                </tbody>
            </table>
            <div class="players-table">
                <?php
                if (count($_SESSION['remplacants']) < 7) {
                    echo "<a href='selectionVue.php?feuille=remplacant'>
                            <button type='button' $matchDansLePasse>Ajouter</button>
                        </a>";
                } else {
                    echo "<p>Le nombre maximum de remplaçants est atteint. Vous ne pouvez pas ajouter d'autres joueurs.</p>";
                }
                ?>
            </div>
        </div>
        <div class="add-player-section">
            <a href="feuilleDeMatchVue.php?valider=1">
                <input type="button" value="Valider"/>
            </a>
        </div>
    </div>
</body>
</html>
