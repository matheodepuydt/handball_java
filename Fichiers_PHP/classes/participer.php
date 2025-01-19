<?php
class Participer {

    private $num_licence;
    private $date_heure;
    private $titulaire;
    private $note;
    private $poste;

    public function __construct($num_licence,$date_heure,$titulaire,$note,$poste){
        $this->num_licence=$num_licence;
        $this->date_heure=$date_heure;
        $this->titulaire=$titulaire;
        $this->note=$note;
        $this->poste=$poste;
    }

    public function getNum_licence(){
        return $this->num_licence;
    }

    public function getDate(){
        return $this->date_heure;
    }

    public function getTitulaire(){
        return $this->titulaire;
    }

    public function getNote(){
        return $this->note;
    }

    public function getPoste(){
        return $this->poste;
    }

    public function setNote(String $note){
        $this->note = $note;
    }

}
?>