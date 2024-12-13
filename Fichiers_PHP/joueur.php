<?php
class Joueur {

    private $nom;
    private $prenom;
    private $date_de_naissance;
    private $taille;
    private $poids;
    private $num_licence;
    private $statut;

    public function Joueur($nom,$prenom,$date_de_naissance,$taille,$poids,$num_licence,$statut) {
        $this->nom = $nom;
        $this->prenom = $prenom;
        $this->date_de_naissance = $date_de_naissance;
        $this->taille = $taille;
        $this->poids = $poids;
        $this->num_licence = $num_licence;
        $this->statut = $statut;
    }

    public function getNom(){
        return $this->nom;
    }

    public function getPrenom(){
        return $this->prenom;
    }

    public function getdDate_de_naissance(){
        return $this->date_de_naissance;
    }

    public function getTaille(){
        return $this->taille;
    }

    public function getPoids(){
        return $this->poids;
    }

    public function getNum_licence(){
        return $this->num_licence;
    }

    public function getStatut(){
        return $this->statut;
    }

}
?>