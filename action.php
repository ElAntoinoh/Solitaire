<?php
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


header("HTTP/1.1 303 See Other");
header("Location: index.php");
exit;
?>