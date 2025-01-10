<?php

    class controleurJoueurs{

        public function getAllJoueurs(){
            $joueurs = [
                ["Durand", "Michel", 26, 181, 76, "Actif", "1852647852312"],
                ["Martin", "Claire", 30, 165, 60, "Inactif", "6789012345"],
            ];
            return $joueurs;
        }

    }

?>