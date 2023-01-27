<?php



include "TablierSolitaire.php";
session_start();

/**
* Décode les chaînes associées aux coordonnées des cases de départ et de destination du
* mouvement et l'effectue sur la tablier. À l'issue du déplacement, elle vérifie si la
* partie est terminée et affiche si nécessaire un message de victoire ou de defaite.
* @param String $coord_depart Coordonnées de la case de départ
* @param String $coord_arrivee Coordonnées de la case de destination
*/
function realiserMouvement(String $coord_depart, String $coord_arrivee): void {
	

	// Vérification de la fin de partie
	if( !$_SESSION['Tablier']->isFinDePartie() ) return;

	// Veirification victoire/défaite
	echo $_SESSION['Tablier']->isVictoire() ? "<p>Victoire !</p>" : "<p>Défaite !</p>";
}

if( isset($_GET['action']) ){
	switch($_GET['action']){
		case "selectionner" :
			header("HTTP/1.1 303 See Other");
			header("Location: index.php?action=poser&coord=".$_GET['coord']);
			exit;
			break;
		case "poser":	
			// Déplacement de la bille
			$_SESSION['Tablier']->deplaceBille(
			    intval(explode("_", $_GET['coord_depart'])[0]),
			    intval(explode("_", $_GET['coord_depart'])[1]),
			    intval(explode("_", $_GET['coord'])[0]),
			    intval(explode("_", $_GET['coord'])[1])
			);						
			header("HTTP/1.1 303 See Other");
			header("Location: index.php?action=selectionner");
			exit;

			break;
	}
}



?>