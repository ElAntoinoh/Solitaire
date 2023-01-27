<?php
    class TablierSolitaireUI {
        private TablierSolitaire $ts;

        /**
         * Constructeur de la classe TablierSolitaireUI
         */
        public function __construct(TablierSolitaire $ts = null) {
            $this->ts = $ts != null ? $ts : new TablierSolitaire();
        }

        /**
         * Retourne une chaîne de caractères intégrant le code HTML d'un formulaire permettant de
         * sélectionner une bille jouable
         * @param String Chaine de caractères intégrant le code HTML.
         */
        public function getFormulaireOrigine(): String {}

        /**
         * Retourne une chaîne de caractères intégrant le code HTML d'un formulaire permettant de
         * sélectionner une case vide accessible avec la bille précédemment sélectionnée et
         * contient un champ caché mémorisant les coordonnées de la bille en cours de déplacement.
         * Les coordonnées peuvent être représentés comme dans l'attribut value des boutons.
         * @param String $coord_depart Coordonnées de la case de départ
         * @return String Chaine de caractères intégrant le code HTML.
         */
        public function getFormulaireDestination(String $coord_depart): String {}

        /**
         * Retourne une chaîne de caractères intégrant le code HTML représentant le plateau du jeu
         * lorsque la partie est terminée.
         * @return String Chaine de caractères intégrant le code HTML.
         */
        public function getTablierFinal(): String {}

        /**
         * Décode les chaînes associées aux coordonnées des cases de départ et de destination du
         * mouvement et l'effectue sur la tablier. À l'issue du déplacement, elle vérifie si la
         * partie est terminée et affiche si nécessaire un message de victoire ou de defaite.
         * @param String $coord_depart Coordonnées de la case de départ
         * @param String $coord_arrivee Coordonnées de la case de destination
         */
        public function realiserMouvement(String $coord_depart, String $coord_arrivee): void {
            // Déplacement de la bille
            $this->ts->deplaceBille(
                intval(explode("_", $coord_depart)[0]),
                intval(explode("_", $coord_depart)[1]),
                intval(explode("_", $coord_arrivee)[0]),
                intval(explode("_", $coord_arrivee)[1])
            );

            // Vérification de la fin de partie
            if( !$this->ts->isFinDePartie() ) return;

            // Veirification victoire/défaite
            echo $this->ts->isVictoire() ? "<p>Victoire !</p>" : "<p>Défaite !</p>";
        }

        private function getBoutonCaseSolitaire(int $ligne, int $colonne, bool $disabled, String $classe): String {}
    }
?>