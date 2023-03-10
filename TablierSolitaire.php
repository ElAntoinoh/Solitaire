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

		const TYPES_TABLIERS = array("Europeen", "Allemand", "Asymetrique", "Anglais", "Diamant", "Gagnant", "Perdant");

		private $nbLignes;
		private $nbColonnes;

		protected $tablier;

		/**
		 * Constructeur de la classe TablierSolitaire
		 * @param array $tab Tableau à deux dimensions contenant les valeurs des cases du tablier
		 */
		private function __construct(array $tab) {
			$this->nbLignes   = count($tab);
			$this->nbColonnes = count($tab[0]);

			$this->tablier = array();

			for( $i = 0; $i < $this->nbLignes; $i++ ) {
				$this->tablier[$i] = array();

				for( $j = 0; $j < $this->nbColonnes; $j++ ) {
					$this->tablier[$i][$j] = new CaseSolitaire($tab[$i][$j]);
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
			$coordonnees = $this->calculerCoordonneesArrivee($numLigDepart, $numColDepart, $dir);

			return $this->estValideMvt($numLigDepart, $numColDepart, $coordonnees[0], $coordonnees[1]);
		}

		/**
		 * Retourne si au moins une case est jouable pour la bille
		 * @param int $numLig Ligne de la case
		 * @param int $numCol Colonne de la case
		 * @return bool Vrai si au moins une case est jouable, faux sinon
		 */
		public function isBilleJouable(int $numLig, int $numCol): bool {
			// Vérification de la validité des coordonnées
			if( $numLig < 0 || $numLig >= $this->nbLignes ||
				$numCol < 0 || $numCol >= $this->nbColonnes ) return false;
			
			// Vérification que la case est bien occupée
			if( !$this->tablier[$numLig][$numCol]->isCaseBille() ) return false;

			// Vérification que la case est jouable
			if( $this->estValideMvtDir($numLig, $numCol, TablierSolitaire::NORD ) ||
				$this->estValideMvtDir($numLig, $numCol, TablierSolitaire::EST  ) ||
				$this->estValideMvtDir($numLig, $numCol, TablierSolitaire::SUD  ) ||
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
			$coordonnees = $this->calculerCoordonneesArrivee($numLigDepart, $numColDepart, $dir);

			$this->deplaceBille($numLigDepart, $numColDepart, $coordonnees[0], $coordonnees[1]);
		}

		/**
		 * Renvoie les coordonnées de la case d'arrivée en fonction de la direction et des coordonnées de départ
		 * @param int $numLigDepart Ligne de départ
		 * @param int $numColDepart Colonne de départ
		 * @param int $dir Direction du déplacement
		 * @return array Tableau contenant les coordonnées de la case d'arrivée ([0] = ligne, [1] = colonne)
		 */
		private function calculerCoordonneesArrivee(int $numLigDepart, int $numColDepart, int $dir): array {
			switch($dir) {
				case TablierSolitaire::NORD: {
					return array($numLigDepart - 2, $numColDepart);
					break;
				}

				case TablierSolitaire::EST: {
					return array($numLigDepart, $numColDepart + 2);
					break;
				}

				case TablierSolitaire::SUD: {
					return array($numLigDepart + 2, $numColDepart);
					break;
				}

				case TablierSolitaire::OUEST: {
					return array($numLigDepart, $numColDepart - 2);
					break;
				}
			}
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
					if( $this->isBilleJouable($i, $j) ) {
						return false;
					}
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
					if( $this->tablier[$i][$j]->isCaseBille() ) {
						$nbBilles++;
					}
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
						case 1: {
							$resul .= "●";
							break;
						}

						case 0: {
							$resul .= "○";
							break;
						}

						default: {
							$resul .= "   ";
							break;
						}
					}
				}
				
				$resul .= "</br>";
			}

			return $resul;
		}

		/**
		 * Initialise un tablier européen
		 * @return TablierSolitaire Tablier initialisé
		 */
		public static function initTablierEuropeen(): TablierSolitaire {
			return new TablierSolitaire(array(
				array(-1, -1,  1,  1,  1, -1, -1),
				array(-1,  1,  1,  1,  1,  1, -1),
				array( 1,  1,  1,  0,  1,  1,  1),
				array( 1,  1,  1,  1,  1,  1,  1),
				array( 1,  1,  1,  1,  1,  1,  1),
				array(-1,  1,  1,  1,  1,  1, -1),
				array(-1, -1,  1,  1,  1, -1, -1),
			));
		}

		/**
		 * Initialise un tablier allemand
		 * @return TablierSolitaire Tablier initialisé
		 */
		public static function initTablierAllemand(): TablierSolitaire {
			return new TablierSolitaire(array(
				array(-1, -1, -1,  1,  1,  1, -1, -1, -1),
				array(-1, -1, -1,  1,  1,  1, -1, -1, -1),
				array(-1, -1, -1,  1,  1,  1, -1, -1, -1),
				array( 1,  1,  1,  1,  1,  1,  1,  1,  1),
				array( 1,  1,  1,  1,  0,  1,  1,  1,  1),
				array( 1,  1,  1,  1,  1,  1,  1,  1,  1),
				array(-1, -1, -1,  1,  1,  1, -1, -1, -1),
				array(-1, -1, -1,  1,  1,  1, -1, -1, -1),
				array(-1, -1, -1,  1,  1,  1, -1, -1, -1),
			));
		}

		/**
		 * Initialise un tablier asymétrique
		 * @return TablierSolitaire Tablier initialisé
		 */
		public static function initTablierAsymetrique(): TablierSolitaire {
			return new TablierSolitaire(array(
				array(-1, -1,  1,  1,  1, -1, -1, -1),
				array(-1, -1,  1,  1,  1, -1, -1, -1),
				array(-1, -1,  1,  1,  1, -1, -1, -1),
				array( 1,  1,  1,  1,  1,  1,  1,  1),
				array( 1,  1,  1,  0,  1,  1,  1,  1),
				array( 1,  1,  1,  1,  1,  1,  1,  1),
				array(-1, -1,  1,  1,  1, -1, -1, -1),
				array(-1, -1,  1,  1,  1, -1, -1, -1),
			));
		}

		/**
		 * Initialise un tablier anglais
		 * @return TablierSolitaire Tablier initialisé
		 */
		public static function initTablierAnglais(): TablierSolitaire {
			return new TablierSolitaire(array(
				array(-1, -1,  1,  1,  1, -1, -1),
				array(-1, -1,  1,  1,  1, -1, -1),
				array( 1,  1,  1,  1,  1,  1,  1),
				array( 1,  1,  1,  0,  1,  1,  1),
				array( 1,  1,  1,  1,  1,  1,  1),
				array(-1, -1,  1,  1,  1, -1, -1,),
				array(-1, -1,  1,  1,  1, -1, -1,)
			));
		}

		/**
		 * Initialise un tablier diamant
		 * @return TablierSolitaire Tablier initialisé
		 */
		public static function initTablierDiamant(): TablierSolitaire {
			return new TablierSolitaire(array(
				array(-1, -1, -1, -1,  1, -1, -1, -1, -1),
				array(-1, -1, -1,  1,  1,  1, -1, -1, -1),
				array(-1, -1,  1,  1,  1,  1,  1, -1, -1),
				array(-1,  1,  1,  1,  1,  1,  1,  1, -1),
				array( 1,  1,  1,  1,  0,  1,  1,  1,  1),
				array(-1,  1,  1,  1,  1,  1,  1,  1, -1),
				array(-1, -1,  1,  1,  1,  1,  1, -1, -1),
				array(-1, -1, -1,  1,  1,  1, -1, -1, -1),
				array(-1, -1, -1, -1,  1, -1, -1, -1, -1),
			));
		}

		/**
		 * Initialise un tablier perdant
		 * @return TablierSolitaire Tablier initialisé
		 */
		public static function initTablierPerdant(): TablierSolitaire {
			return new TablierSolitaire(array(
				array(1, 0, 0),
				array(1, 0, 0),
				array(0, 1, 1)
			));
		}

		/**
		 * Initialise un tablier gagnant
		 * @return TablierSolitaire Tablier initialisé
		 */
		public static function initTablierGagnant(): TablierSolitaire {
			return new TablierSolitaire(array(
				array(0, 0, 0),
				array(0, 0, 0),
				array(0, 1, 1)
			));
		}

		/**
		 * Initialise un tablier personnalisé
		 * @param array $tab Tableau de valeurs
		 * @return TablierSolitaire Tablier initialisé
		 */
		public static function initTablierPersonalise(array $tab): TablierSolitaire {
			return new TablierSolitaire($tab);
		}
	}
?>