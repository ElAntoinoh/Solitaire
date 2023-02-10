<?php
    abstract class TablierSolitaireUI {
        /**
         * Retourne une chaîne de caractères intégrant le code HTML d'un formulaire permettant de
         * sélectionner une bille jouable
         * @param String Chaine de caractères intégrant le code HTML.
         */
        public static function getFormulaireOrigine(TablierSolitaire $ts): String {
            $str = "<form action=\"action.php\" method=\"GET\"><table ><tbody>";

            for( $i = 0; $i < $ts->getNbLignes(); $i++ ) {
                $str .= "<tr>";

                for( $j = 0; $j < $ts->getNbColonnes(); $j++ ) {
                    $str .= "<td>";

                    switch($ts->getCase($i, $j)->getValeur()) {
                        case -1: { $classe = "\" hidden "; break; }
                        case  0: { $classe = "vide\" ";    break; }
                        case  1: { $classe = "bille\" ";   break; }
                    }

                    $str .= TablierSolitaireUI::getBoutonCaseSolitaire($classe, $i, $j, $ts->isBilleJouable($i, $j));

                    $str .= TablierSolitaireUI::getFigureCase($ts->getCase($i, $j)->getValeur());
                }

                $str .= "</tr>";
            }
            $str .= "<input type='hidden' name='action' value='selectionner'/>";

            return $str .= "</tbody></table></form>";
        }

        /**
         * Retourne une chaîne de caractères intégrant le code HTML d'un formulaire permettant de
         * sélectionner une case vide accessible avec la bille précédemment sélectionnée et
         * contient un champ caché mémorisant les coordonnées de la bille en cours de déplacement.
         * Les coordonnées peuvent être représentés comme dans l'attribut value des boutons.
         * @param String $coord_depart Coordonnées de la case de départ
         * @return String Chaine de caractères intégrant le code HTML.
         */
        public static function getFormulaireDestination(TablierSolitaire $ts, String $coord_depart): String {
            $lig = intval(explode("_", $coord_depart)[0]);
            $col = intval(explode("_", $coord_depart)[1]);

            $str = "<form action=\"action.php\" method=\"GET\"><table ><tbody>";

            for( $i = 0; $i < $ts->getNbLignes(); $i++ ) {
                $str .= "<tr>";

                for( $j = 0; $j < $ts->getNbColonnes(); $j++ ) {
                    $str .= "<td>";

                    switch( $ts->getCase($i, $j)->getValeur() ) {
                        case -1: { $classe = "\" hidden "; break; }
                        case  0: { $classe = "vide\" ";    break; }
                        case  1: { $classe = "bille \" ";  break; }
                    }

                    if( $i == $lig && $j == $col ) {
                        $str .= "<button class=\"".$classe."\">";
                    } else {
                        $str .= TablierSolitaireUI::getBoutonCaseSolitaire($classe, $i, $j, $ts->estValideMvt($lig,$col, $i, $j));
                    }
                    

                    $str .= TablierSolitaireUI::getFigureCase($ts->getCase($i, $j)->getValeur());
                }

                $str.="</tr>";
            }

            $str .= "<input type='hidden' name='coord_depart' value='".$coord_depart."'/>";
            $str .= "<input type='hidden' name='action' value='poser'/>";

            return $str .="</tbody></table></form>";
        }

        /**
         * Retourne une chaîne de caractères intégrant le code HTML représentant le plateau du jeu
         * lorsque la partie est terminée.
         * @return String Chaine de caractères intégrant le code HTML.
         */
        public static function getTablierFinal(TablierSolitaire $ts): String {
            $str = "<table><tbody>";

            for( $i = 0; $i < $ts->getNbLignes(); $i++ ) {
                $str .= "<tr>";

                for( $j = 0; $j < $ts->getNbColonnes(); $j++ ) {
                    $str .= "<td><figure class=\"image is-96x96\">";

                    switch($ts->getCase($i, $j)->getValeur()) {
                        case 0: { $str .= "<img src=\"ressources/CaseVide.png\">";  break; }
                        case 1: { $str .= "<img src=\"ressources/CaseBille.png\">"; break; }
                    }

                    $str .= "</figure></td>";
                }

                $str .= "</tr>";
            }

            return $str;
        }

		public static function getFormulairePersonnalisation(TablierSolitaire $ts) {
			$str = "<form action=\"action.php\" method=\"GET\"><table ><tbody>";

            for( $i = 0; $i < $ts->getNbLignes(); $i++ ) {
                $str .= "<tr>";

                for( $j = 0; $j < $ts->getNbColonnes(); $j++ ) {
                    $str .= "<td>";

                    switch($ts->getCase($i, $j)->getValeur()) {
                        case -1: { $classe = "neutralise \"  "; break; }
                        case  0: { $classe = "vide\" ";    break; }
                        case  1: { $classe = "bille\" ";   break; }
                    }

                    $str .= TablierSolitaireUI::getBoutonCaseSolitaire($classe, $i, $j, true);

                    $str .= TablierSolitaireUI::getFigureCase($ts->getCase($i, $j)->getValeur());
                }

                $str .= "</tr>";
            }
            $str .= "<input type='hidden' name='action' value='changeCasePerso'/>";

            return $str .= "</tbody></table></form>";
		}

        private static function getBoutonCaseSolitaire(String $classe, int $ligne, int $colonne, bool $disabled) : String {
            return "<button " ."class=\"".$classe." name=\"coord\" value=\"" . $ligne . "_" . $colonne . "\" " . ($disabled ? "" : "disabled") . ">";
        }

		private static function getFigureCase(int $valeur) {
			$str = "<figure class=\"image  is-32x32-mobile is-48x48-tablet is-64x64-desktop is-64x64-widescreen is-64x64-fullhd\">";

			switch($valeur) {
				case  0: { $str .= "<img src=\"ressources/CaseVide.png\">";       break; }
				case  1: { $str .= "<img src=\"ressources/CaseBille.png\">";      break; }
                case -1: { $str .= "<img src=\"ressources/CaseNeutralise.png\">"; break; }
			}

			$str .= "</figure></button></td>";

			return $str;
		}
    }
?>