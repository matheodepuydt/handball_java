<?php
require '../Controleurs/redirectionControleur.php';

class Commentaire {
    private string $description;
    private string $date_commentaire;

    public function __construct(string $description, string $date_commentaire) {
        $this->description = $description;
        $this->date_commentaire = $date_commentaire;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getDate(): string {
        return $this->date_commentaire;
    }
}
?>