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
				switch($_GET['ChoixPlateau']){
					case "Europeen" :
						$_SESSION['Tablier'] = TablierSolitaire::initTablierEuropeen();
						break;
					case "Anglais" :
						$_SESSION['Tablier'] = TablierSolitaire::initTablierAnglais();
						break;
					case "Asymetrique" :
						$_SESSION['Tablier'] = TablierSolitaire::initTablierAsymetrique();
						break;
					case "Gagnant" :
						$_SESSION['Tablier'] = TablierSolitaire::initTablierGagnant();
						break;
					case "Perdant" :
						$_SESSION['Tablier'] = TablierSolitaire::initTablierPerdant();
						break;
				}

				break;
			}

			case "personnaliserTablier": {
				$str .= "?action=CreationTablier";
				break;
			}
		}
	}

	header($str);
?>