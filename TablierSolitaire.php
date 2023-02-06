<?php
require_once("CaseSolitaire.php");

/**
 * Classe TablierSolitaire
 */
class TablierSolitaire {
	const NORD  = 0;
	const EST   = 1;
	const SUD   = 2;
	const OUEST = 3;

	private $nbLignes;
	private $nbColonnes;

	protected $tablier;
	
	/**
	 * Constructeur de la classe TablierSolitaire
	 * @param int $nblig Nombre de lignes du tablier
	 * @param int $nbcol Nombre de colonnes du tablier
	 */
	private function __construct(int $nblig = 5, int $nbcol = 5) {
		$this->nbLignes = $nblig;
		$this->nbColonnes = $nbcol;
		$this->tablier = array();

		// Remplissage du tablier avec des billes
		for( $i = 0; $i < $this->nbLignes; $i++ ) {
			$this->tablier[$i] = array();

			for( $j = 0; $j < $this->nbColonnes; $j++ ) {
				$this->tablier[$i][$j] = new CaseSolitaire();
			}
		}
	}

	/**
	 * Retourne le nombre de lignes du tablier
	 * @return int Nombre de lignes du tablier
	 */
	public function getNbLignes(): int {
		return $this->nbLignes;
	}

	/**
	 * Retourne le nombre de colonnes du tablier
	 * @return int Nombre de colonnes du tablier
	 */
	public function getNbColonnes(): int {
		return $this->nbColonnes;
	}

	/**
	 * Retourne le tablier
	 * @return array Tablier
	 */
	public function getTablier(): array {
		return $this->tablier;
	}

	/**
	 * Retourne la case du tablier
	 * @param int $ligne Ligne de la case
	 * @param int $colonne Colonne de la case
	 * @return CaseSolitaire Case du tablier
	 */
	public function getCase(int $ligne, int $colonne): CaseSolitaire {
		return $this->tablier[$ligne][$colonne];
	}

	/**
	 * Vide la case du tablier
	 * @param int $ligne Ligne de la case
	 * @param int $colonne Colonne de la case
	 */
	public function videCase(int $ligne, int $colonne): void {
		$this->tablier[$ligne][$colonne]->setValeur(CaseSolitaire::VIDE);
	}

	/**
	 * Remplit la case du tablier
	 * @param int $ligne Ligne de la case
	 * @param int $colonne Colonne de la case
	 */
	public function remplitCase(int $ligne, int $colonne): void {
		$this->tablier[$ligne][$colonne]->setValeur(CaseSolitaire::BILLE);
	}

	/**
	 * Neutralise la case du tablier
	 * @param int $ligne Ligne de la case
	 * @param int $colonne Colonne de la case
	 */
	public function neutraliseCase(int $ligne, int $colonne): void {
		$this->tablier[$ligne][$colonne]->setValeur(CaseSolitaire::NEUTRALISE);
	}

	/**
	 * Retourne si le mouvement est valide
	 * @param int $numLigDepart Ligne de départ
	 * @param int $numColDepart Colonne de départ
	 * @param int $numLigArrivee Ligne d'arrivée
	 * @param int $numColArrivee Colonne d'arrivée
	 * @return bool Vrai si le mouvement est valide, faux sinon
	 */
	public function estValideMvt(int $numLigDepart, int $numColDepart, int $numLigArrivee, int $numColArrivee): bool {
		// Vérification de la validité des coordonnées
		if( $numLigDepart  < 0 || $numLigDepart  >= $this->nbLignes   ||
			$numColDepart  < 0 || $numColDepart  >= $this->nbColonnes ||
			$numLigArrivee < 0 || $numLigArrivee >= $this->nbLignes   ||
			$numColArrivee < 0 || $numColArrivee >= $this->nbColonnes ) return false;
		
		// Vérification que le déplacement est conforme
		if( !((abs($numLigDepart - $numLigArrivee) == 2 && $numColDepart == $numColArrivee) ||
			  (abs($numColDepart - $numColArrivee) == 2 && $numLigDepart == $numLigArrivee)    ) ) return false;
		
		// Vérification que la case de départ est bien occupée
		if( !$this->tablier[$numLigDepart][$numColDepart]->isCaseBille() ) return false;

		// Vérification que la case intermédiaire est bien occupée
		if( !$this->tablier[($numLigDepart + $numLigArrivee) / 2][($numColDepart + $numColArrivee) / 2]->isCaseBille() ) return false;

		// Vérification que la case d'arrivée est bien vide
		if( !$this->tablier[$numLigArrivee][$numColArrivee]->isCaseVide() ) return false;

		return true;
	}

	/**
	 * Retourne si le mouvement est valide
	 * @param int $numLigDepart Ligne de départ
	 * @param int $numColDepart Colonne de départ
	 * @param int $dir Direction du déplacement
	 * @return bool Vrai si le mouvement est valide, faux sinon
	 */
	public function estValideMvtDir(int $numLigDepart, int $numColDepart, int $dir): bool {
		$numLigArrivee = -1;
		$numColArrivee = -1;
		
		// Calcul de la position de la case d'arrivée en fonction de la direction
		switch($dir) {
			case TablierSolitaire::NORD:
				$numLigArrivee = $numLigDepart - 2;
				$numColArrivee = $numColDepart;
				break;
			case TablierSolitaire::EST:
				$numLigArrivee = $numLigDepart;
				$numColArrivee = $numColDepart + 2;
				break;
			case TablierSolitaire::SUD:
				$numLigArrivee = $numLigDepart + 2;
				$numColArrivee = $numColDepart;
				break;
			case TablierSolitaire::OUEST:
				$numLigArrivee = $numLigDepart;
				$numColArrivee = $numColDepart - 2;
				break;
		}

		return $this->estValideMvt($numLigDepart, $numColDepart, $numLigArrivee, $numColArrivee);
	}

	/**
	 * Retourne si au moins une case est jouable pour la bille
	 * @param int $numLig Ligne de la case
	 * @param int $numCol Colonne de la case
	 * @return bool Vrai si au moins une case est jouable, faux sinon
	 */
	public function isBilleJouable(int $numLig, int $numCol): bool {
		// Vérification de la validité des coordonnées
		if( $numLig < 0 || $numLig >= $this->nbLignes   ||
			$numCol < 0 || $numCol >= $this->nbColonnes ) return false;
		
		// Vérification que la case est bien occupée
		if( !$this->tablier[$numLig][$numCol]->isCaseBille() ) return false;

		// Vérification que la case est jouable
		if( $this->estValideMvtDir($numLig, $numCol, TablierSolitaire::NORD) ||
			$this->estValideMvtDir($numLig, $numCol, TablierSolitaire::EST)  ||
			$this->estValideMvtDir($numLig, $numCol, TablierSolitaire::SUD)  ||
			$this->estValideMvtDir($numLig, $numCol, TablierSolitaire::OUEST) ) return true;

		return false;
	}

	/**
	 * Deplace la bille
	 * @param int $numLigDepart Ligne de départ
	 * @param int $numColDepart Colonne de départ
	 * @param int $numLigArrivee Ligne d'arrivée
	 * @param int $numColArrivee Colonne d'arrivée
	 */
	public function deplaceBille(int $numLigDepart, int $numColDepart, int $numLigArrivee, int $numColArrivee): void {
		// Vérification de la validité du déplacement
		if( !$this->estValideMvt($numLigDepart, $numColDepart, $numLigArrivee, $numColArrivee) ) return;

		// Déplacement de la bille
		$this->remplitCase($numLigArrivee, $numColArrivee);
		$this->videCase($numLigDepart, $numColDepart);
		$this->videCase(($numLigDepart + $numLigArrivee) / 2, ($numColDepart + $numColArrivee) / 2);
	}

	/**
	 * Deplace la bille vers une direction
	 * @param int $numLigDepart Ligne de départ
	 * @param int $numColDepart Colonne de départ
	 * @param int $dir Direction du déplacement
	 */
	public function deplaceBilleDir(int $numLigDepart, int $numColDepart, int $dir): void {
		$numLigArrivee = -1;
		$numColArrivee = -1;
		
		// Calcul de la position de la case d'arrivée en fonction de la direction
		switch($dir) {
			case TablierSolitaire::NORD:
				$numLigArrivee = $numLigDepart - 2;
				$numColArrivee = $numColDepart;
				break;
			case TablierSolitaire::EST:
				$numLigArrivee = $numLigDepart;
				$numColArrivee = $numColDepart + 2;
				break;
			case TablierSolitaire::SUD:
				$numLigArrivee = $numLigDepart + 2;
				$numColArrivee = $numColDepart;
				break;
			case TablierSolitaire::OUEST:
				$numLigArrivee = $numLigDepart;
				$numColArrivee = $numColDepart - 2;
				break;
		}

		$this->deplaceBille($numLigDepart, $numColDepart, $numLigArrivee, $numColArrivee);
	}

	/**
	 * Retourne Vrai si le plateau n'est plus modifiable
	 * @return bool Vrai si la partie est terminée
	 */
	public function isFinDePartie(): bool {
		// Parcours des cases du tablier
		for( $i = 0; $i < $this->nbLignes; $i++ ) {
			for( $j = 0; $j < $this->nbColonnes; $j++ ) {
				// Si la case est jouable, la partie n'est pas terminée
				if( $this->isBilleJouable($i, $j) ) return false;
			}
		}

		// Si on arrive ici, c'est que toutes les billes sont bloquées
		return true;
	}

	/**
	 * Retourne Vrai si la partie est gagnante
	 * @return bool Vrai si la partie est gagnée
	 */
	public function isVictoire(): bool {
		$nbBilles = 0;

		// Parcours des cases du tablier
		for( $i = 0; $i < $this->nbLignes; $i++ ) {
			for( $j = 0; $j < $this->nbColonnes; $j++ ) {
				if( $this->tablier[$i][$j]->isCaseBille() ) $nbBilles++;
			}
		}

		// Si il ne reste qu'une bille, c'est une victoire
		return $nbBilles == 1;
	}

	/**
	 * toString de la classe TablierSolitaire
	 * @return string Chaine de caractères représentant le tablier
	 */
	public function __toString(): string{
		$resul = "";

		for( $i = 0; $i < $this->nbLignes; $i++ ) {
			for( $j = 0; $j < $this->nbColonnes; $j++ ) {
				switch( $this->tablier[$i][$j]->getValeur() ) {
					case 1:
						$resul .= "●";
						break;
					case 0:
						$resul .= "○";
						break;

					default:
						$resul .= "   ";
						break;
				}
			}
			
			$resul .=  "</br>";
		}

		return $resul;
	}

	/**
	 * Initialise un tablier européen
	 * @return TablierSolitaire Tablier initialisé
	 */
	public static function initTablierEuropeen(): TablierSolitaire{
		$tablier = new TablierSolitaire(7,7);

		$tablier->neutraliseCase(0,1);
		$tablier->neutraliseCase(1,0);
		$tablier->neutraliseCase(0,0);

		$tablier->neutraliseCase(0,6);
		$tablier->neutraliseCase(0,5);
		$tablier->neutraliseCase(1,6);

		$tablier->neutraliseCase(6,0);
		$tablier->neutraliseCase(5,0);
		$tablier->neutraliseCase(6,1);

		$tablier->neutraliseCase(6,6);
		$tablier->neutraliseCase(6,5);
		$tablier->neutraliseCase(5,6);

		$tablier->videCase(3,3);

		return $tablier;
	}

	/**
	 * Initialise un tablier anglais
	 * @return TablierSolitaire Tablier initialisé
	 */
	public static function initTablierAnglais(): TablierSolitaire{
		$tablier = new TablierSolitaire(7,7);

		$tablier->neutraliseCase(0,1);
		$tablier->neutraliseCase(1,0);
		$tablier->neutraliseCase(0,0);
		$tablier->neutraliseCase(1,1);

		$tablier->neutraliseCase(0,6);
		$tablier->neutraliseCase(0,5);
		$tablier->neutraliseCase(1,6);
		$tablier->neutraliseCase(1,5);

		$tablier->neutraliseCase(6,0);
		$tablier->neutraliseCase(5,0);
		$tablier->neutraliseCase(6,1);
		$tablier->neutraliseCase(5,1);

		$tablier->neutraliseCase(6,6);
		$tablier->neutraliseCase(6,5);
		$tablier->neutraliseCase(5,6);
		$tablier->neutraliseCase(5,5);

		$tablier->videCase(3,3);

		return $tablier;
	}

	/**
	 * Initialise un tablier asymétrique
	 * @return TablierSolitaire Tablier initialisé
	 */
	public static function initTablierAsymetrique(): TablierSolitaire{
		$tablier = new TablierSolitaire(8,8);

		$tablier->neutraliseCase(0,0);
		$tablier->neutraliseCase(0,1);
		$tablier->neutraliseCase(1,0);
		$tablier->neutraliseCase(1,1);
		$tablier->neutraliseCase(2,0);
		$tablier->neutraliseCase(2,1);

		$tablier->neutraliseCase(0,7);
		$tablier->neutraliseCase(0,6);
		$tablier->neutraliseCase(0,5);
		$tablier->neutraliseCase(1,7);
		$tablier->neutraliseCase(1,6);
		$tablier->neutraliseCase(1,5);
		$tablier->neutraliseCase(2,7);
		$tablier->neutraliseCase(2,6);
		$tablier->neutraliseCase(2,5);

		$tablier->neutraliseCase(7,0);
		$tablier->neutraliseCase(6,0);
		$tablier->neutraliseCase(7,1);
		$tablier->neutraliseCase(6,1);

		$tablier->neutraliseCase(7,7);
		$tablier->neutraliseCase(7,6);
		$tablier->neutraliseCase(7,5);
		$tablier->neutraliseCase(6,7);
		$tablier->neutraliseCase(6,6);
		$tablier->neutraliseCase(6,5);

		$tablier->videCase(4, 3);

		return $tablier;
	}

	/**
	 * Initialise un tablier perdant
	 * @return TablierSolitaire Tablier initialisé
	 */
	public static function initTablierPerdant(): TablierSolitaire {
		$tablier = new TablierSolitaire(3,3);

		
		$tablier->videCase(0,1);
		$tablier->videCase(0,2);
		$tablier->videCase(1,1);
		$tablier->videCase(1,2);
		$tablier->videCase(2,0);

		return $tablier;
	}

	/**
	 * Initialise un tablier gagnant
	 * @return TablierSolitaire Tablier initialisé
	 */
	public static function initTablierGagnant(): TablierSolitaire {
		$tablier = TablierSolitaire::initTablierPerdant();

		$tablier->videCase(2,0);
		$tablier->videCase(0,0);
		$tablier->videCase(1,0);

		return $tablier;
	}
}
?>
