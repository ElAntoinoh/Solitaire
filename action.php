<?php
	include "TablierSolitaire.php";
	session_start();

	header("HTTP/1.1 303 See Other");

	$name = preg_split("(\.php)", $_SERVER["HTTP_REFERER"])[0];

	$str = "Location: ". $name .".php";

	if( isset($_GET['action']) ) {
		switch( $_GET['action'] ) {
			case "selectionner": {
				$str .= "?action=poser&coord=".$_GET['coord'];
				break;
			}

			case "poser": {
				// Déplacement de la bille
				$_SESSION['Tablier'] -> deplaceBille(
					intval(explode("_", $_GET['coord_depart'])[0]),
					intval(explode("_", $_GET['coord_depart'])[1]),
					intval(explode("_", $_GET['coord']       )[0]),
					intval(explode("_", $_GET['coord']       )[1])
				);	

				// Si la partie n'est pas finie, on redirige vers la page de sélection
				if( !$_SESSION['Tablier'] -> isFinDePartie() ) {
					$str .= "?action=selectionner";
					break;
				}

				// Sinon, on affiche la victoire/défaite
				$str .= "?finDePartie=".($_SESSION['Tablier'] -> isVictoire() ? "Victoire" : "Defaite");
				
				break;
			}

			case "nouvellePartie": {
				switch($_GET['ChoixPlateau']) {
					case "Europeen" :
						$_SESSION['Tablier'] = TablierSolitaire::initTablierEuropeen();
						$_SESSION['tablierActuel'] = "Europeen";
						break;
					case "Allemand" :
						$_SESSION['Tablier'] = TablierSolitaire::initTablierAllemand();
						$_SESSION['tablierActuel'] = "Allemand";
						break;
					case "Diamant" :
						$_SESSION['Tablier'] = TablierSolitaire::initTablierDiamant();
						$_SESSION['tablierActuel'] = "Diamant";
						break;
					case "Anglais" :
						$_SESSION['Tablier'] = TablierSolitaire::initTablierAnglais();
						$_SESSION['tablierActuel'] = "Anglais";
						break;
					case "Asymetrique" :
						$_SESSION['Tablier'] = TablierSolitaire::initTablierAsymetrique();
						$_SESSION['tablierActuel'] = "Asymetrique";
						break;
					case "Gagnant" :
						$_SESSION['Tablier'] = TablierSolitaire::initTablierGagnant();
						$_SESSION['tablierActuel'] = "Gagnant";
						break;
					case "Perdant" :
						$_SESSION['Tablier'] = TablierSolitaire::initTablierPerdant();
						$_SESSION['tablierActuel'] = "Perdant";
						break;
					case "Personnaliser" :
						for( $i = 0; $i < $_SESSION['TablierPerso']->getNbLignes(); $i++ ) {
							for( $j = 0; $j < $_SESSION['TablierPerso']->getNbColonnes(); $j++ ) {
								$tab[$i][$j] = $_SESSION['TablierPerso']->getCase($i, $j)->getValeur();
							}
						}
						
						$_SESSION['Tablier'] = TablierSolitaire::initTablierPersonalise($tab);
						$_SESSION['tablierActuel'] = "Personnaliser";
						break;
				}

				break;
			}

			case "personnaliserTablier": {
				$str .= "?action=CreationTablier";
				break;
			}

			case "CreerTablierPerso": {
				for( $i = 0; $i < $_GET['lignePerso']; $i++ ) {
					for( $j = 0; $j < $_GET['colonnePerso']; $j++ ) {
						$tab[$i][$j] = 1;
					}
				}

				$_SESSION['TablierPerso'] = TablierSolitaire::initTablierPersonalise($tab);

				$str .= "?action=CreationTablier";
				break;
			}

			case "changeCasePerso": {
				$ligne   = intval(explode("_", $_GET['coord'])[0]);
				$colonne = intval(explode("_", $_GET['coord'])[1]);

				$valeurCase = $_SESSION['TablierPerso'] -> getCase($ligne, $colonne)->getValeur();

				switch($valeurCase) {
					case -1 : {	$_SESSION['TablierPerso'] -> remplitCase   ($ligne, $colonne); break; }
					case  0 : {	$_SESSION['TablierPerso'] -> neutraliseCase($ligne, $colonne); break; }
					case  1 : {	$_SESSION['TablierPerso'] -> videCase      ($ligne, $colonne); break; }
				}

				$str .= "?action=CreationTablier";
				break;
			}
		}
	}

	header($str);
?>