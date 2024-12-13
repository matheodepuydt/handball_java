<?php
public class Rencontre {

    private $date;
    private $heure;
    private $nom_adversaire;
    private $lieu;
    private $domicile;
    private $resultat;

    public function Rencontre($date,$heure,$nom_adversaire,$lieu,$domicile,$resultat){
        $this->date=$date;
        $this->heure=$heure;
        $this->nom_adversaire=$nom_adversaire;
        $this->lieu=$lieu;
        $this->domicile=$domicile;
        $this->resultat=$resultat;
    }

    public function getDate(){
        return $this->date;
    }

    public function getHeure(){
        return $this->heure;
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

}
?>