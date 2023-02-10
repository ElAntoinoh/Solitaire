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
				if( $_GET['ChoixPlateau'] == "Personnaliser" ) {
					for( $i = 0; $i < $_SESSION['TablierPerso']->getNbLignes(); $i++ ) {
						for( $j = 0; $j < $_SESSION['TablierPerso']->getNbColonnes(); $j++ ) {
							$tab[$i][$j] = $_SESSION['TablierPerso']->getCase($i, $j)->getValeur();
						}
					}
					
					$_SESSION['Tablier'] = TablierSolitaire::initTablierPersonalise($tab);
				} else {
					$tab = array(
						"Europeen"    => TablierSolitaire::initTablierEuropeen(),
						"Allemand"    => TablierSolitaire::initTablierAllemand(),
						"Diamant"     => TablierSolitaire::initTablierDiamant(),
						"Anglais"     => TablierSolitaire::initTablierAnglais(),
						"Asymetrique" => TablierSolitaire::initTablierAsymetrique(),
						"Gagnant"     => TablierSolitaire::initTablierGagnant(),
						"Perdant"     => TablierSolitaire::initTablierPerdant(),
					);

					$_SESSION['Tablier'] = $tab[$_GET['ChoixPlateau']];
				}

				$_SESSION['tablierActuel'] = $_GET['ChoixPlateau'];

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