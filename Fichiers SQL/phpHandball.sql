-- Table Joueur
CREATE TABLE Joueur (
    num_licence CHAR(13) PRIMARY KEY,
    nom VARCHAR(50) NOT NULL,
    prenom VARCHAR(50) NOT NULL,
    date_de_naissance DATE NOT NULL,
    taille INT,
    poids DECIMAL(15, 2),
    statut VARCHAR(50)
);

-- Table Commentaire
CREATE TABLE Commentaire (
    num_licence CHAR(13),
    date_commentaire DATETIME NOT NULL,
    description VARCHAR(50),
    PRIMARY KEY (num_licence, date_commentaire),
    FOREIGN KEY (num_licence) REFERENCES Joueur(num_licence) ON DELETE CASCADE
);

-- Table Rencontre
CREATE TABLE Rencontre (
    date_heure DATETIME PRIMARY KEY,
    nom_adversaire VARCHAR(50) NOT NULL,
    lieu VARCHAR(50),
    domicile BOOLEAN NOT NULL,
    resultat VARCHAR(50)
);

-- Table Authentification
CREATE TABLE Authentification (
    login VARCHAR(50) PRIMARY KEY,
    password VARCHAR(50) NOT NULL
);

-- Table Participer
CREATE TABLE Participer (
    num_licence CHAR(13),
    date_heure DATETIME,
    titulaire BOOLEAN NOT NULL,
    note TINYINT,
    poste VARCHAR(50),
    PRIMARY KEY (num_licence, date_heure),
    FOREIGN KEY (num_licence) REFERENCES Joueur(num_licence) ON DELETE CASCADE,
    FOREIGN KEY (date_heure) REFERENCES Rencontre(date_heure) ON DELETE CASCADE
);