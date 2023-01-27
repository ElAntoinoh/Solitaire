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
        public function getFormulaireOrigine(): String {
            $str = "<form action=\"action.php\" method=\"GET\"><table><tbody>";

            for( $i = 0; $i < $this->ts->getNbLignes(); $i++ ) {
                $str .= "<tr>";

                for( $j = 0; $j < $this->ts->getNbColonnes(); $j++ ) {
                    $str .= "<td><button class='";
                    switch($this->ts->getCase($i, $j)->getValeur()) {
                        case -1: { $str .= "neutralise"; break; } 
                        case  0: { $str .= "vide";       break; }
                        case  1: { $str .= "bille";      break; }
                    }
                    
                    $str .= "' name='coord' value='" . $i . "_" . $j . "' " . ($this->ts->isBilleJouable($i, $j) ? "" : "disabled") . ">";

                    $str .= "<figure class=\"image is-96x96\">";
                    switch($this->ts->getCase($i, $j)->getValeur()) {
                        case  0: { $str .= "<img src=\"ressources/CaseVide.png\">";  break; }
                        case  1: { $str .= "<img src=\"ressources/CaseBille.png\">"; break; }
                    }

                    $str .= "</figure></button></td>";
                }

                $str .= "</tr>";
            }

            return $str;
        }

        /**
         * Retourne une chaîne de caractères intégrant le code HTML d'un formulaire permettant de
         * sélectionner une case vide accessible avec la bille précédemment sélectionnée et
         * contient un champ caché mémorisant les coordonnées de la bille en cours de déplacement.
         * Les coordonnées peuvent être représentés comme dans l'attribut value des boutons.
         * @param String $coord_depart Coordonnées de la case de départ
         * @return String Chaine de caractères intégrant le code HTML.
         */
        public function getFormulaireDestination(String $coord_depart): String {
            $lig = intval(explode("_", $coord_depart)[0]);
            $col = intval(explode("_", $coord_depart)[1]);

            $str = "<form action=\"action.php\" method=\"GET\">
            <table >
                <tbody>";

            for($i=0; $i < $tablier->getNbLignes(); $i++){
                $str += "<tr>";
                for($j=0; $j < $tablier->getNbColonnes(); $j++) {
                    $str += "<td>
                                    <button class='";
                    switch($tablier->getCase($i, $j)->getValeur()){
                        case 0: {return "vide'";break;}
                        case 1: {return "bille'";break;} 
                        default: {return "neutralise'";break;} 
                    }
                    $str += "name='coord' value='".$i."_".$j."'"; 

                    if(!$tablier->estValideMvt($lig,$col, $i, $j)) $str+= "disabled";

                    $str += "><figure class=\"image is-96x96\"><img src=\"ressources/";
                    if($tablier->getCase($i, $j)->getValeur() == CaseSolitaire::BILLE){
                        $str+= "CaseBille.png";
                    }elseif($tablier->getCase($i, $j)->getValeur() == CaseSolitaire::VIDE) {
                        $str+= "CaseVide.png";
                    }
                    $str = "</figure>
                                        </button>
                                    </td>";
                }
                $str+="</tr>";
            }
            $str +="</tbody>
            </table>
        </form>";
                


            return $str;
        }

        /**
         * Retourne une chaîne de caractères intégrant le code HTML représentant le plateau du jeu
         * lorsque la partie est terminée.
         * @return String Chaine de caractères intégrant le code HTML.
         */
        public function getTablierFinal(): String {}

        

        private function getBoutonCaseSolitaire(String $classe, int $ligne, int $colonne, bool $disabled) : String {}
    }
?>