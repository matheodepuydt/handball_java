<?php
class Commentaire {

    private $description;
    private $date;

    public function Commentaire($description, $date){
        $this->description = $description;
        $this->date = $date;
    }

    public function getDescription(){
        return $this->description;
    }

    public function getDate(){
        return $this->date;
    }

}
?>