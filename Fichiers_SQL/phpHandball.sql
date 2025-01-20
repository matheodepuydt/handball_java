set autocommit=0;
start transaction;

DROP TABLE IF EXISTS participer;
DROP TABLE IF EXISTS commentaire;
DROP TABLE IF EXISTS rencontre;
DROP TABLE IF EXISTS authentification;
DROP TABLE IF EXISTS joueur;


-- Table Joueur
CREATE TABLE joueur (
    num_licence CHAR(13) PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    date_de_naissance DATE NOT NULL,
    taille INT,
    poids DECIMAL(15, 2),
    statut VARCHAR(50)
);

-- Table Commentaire
CREATE TABLE commentaire (
    num_licence CHAR(13),
    date_commentaire DATETIME NOT NULL,
    description VARCHAR(200),
    PRIMARY KEY (num_licence, date_commentaire),
    FOREIGN KEY (num_licence) REFERENCES joueur(num_licence) ON DELETE CASCADE
);

-- Table Rencontre
CREATE TABLE rencontre (
    date_heure DATETIME PRIMARY KEY,
    nom_adversaire VARCHAR(50) NOT NULL,
    lieu VARCHAR(50),
    domicile VARCHAR(20) NOT NULL,
    resultat VARCHAR(50)
);

-- Table Authentification
CREATE TABLE authentification (
    login VARCHAR(50) PRIMARY KEY,
    password VARCHAR(100) NOT NULL
);

-- Table Participer
CREATE TABLE participer (
    num_licence CHAR(13),
    date_heure DATETIME,
    titulaire BOOLEAN NOT NULL,
    note TINYINT,
    poste VARCHAR(50),
    PRIMARY KEY (num_licence, date_heure),
    FOREIGN KEY (num_licence) REFERENCES joueur(num_licence) ON DELETE CASCADE,
    FOREIGN KEY (date_heure) REFERENCES rencontre(date_heure) ON DELETE CASCADE
);

COMMIT;