<?php
class Rencontre {

    private $date_heure;
    private $nom_adversaire;
    private $lieu;
    private $domicile;
    private $resultat;

    public function __construct($date_heure,$nom_adversaire,$lieu,$domicile,$resultat){
        $this->date_heure=$date_heure;
        $this->nom_adversaire=$nom_adversaire;
        $this->lieu=$lieu;
        $this->domicile=$domicile;
        $this->resultat=$resultat;
    }

    public function getDate(){
        return $this->date_heure;
    }

    public function getAdversaire(){
        return $this->nom_adversaire;
    }

    public function getLieu(){
        return $this->lieu;
    }

    public function getDomicile(){
        return $this->domicile;
    }

    public function getResultat(){
        return $this->resultat;
    }

    public function setResultat(String $resultat){
        $this->resultat = $resultat;
    }

}
?>