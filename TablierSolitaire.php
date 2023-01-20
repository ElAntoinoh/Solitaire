<?php
	class TablierSolitaire {
		const NORD = 0;
		const EST = 1;
		const SUD = 2;
		const OUEST = 3;

		private $nbLignes;
		private $nbColonnes;

		private $tablier;
		
		private function TablierSolitaire(int $nblig = 5, int $nbcol = 5) {
			$this->nbLignes = $nblig;
			$this->nbColonnes = $nbcol;
			$this->tablier = array();

			for( $i = 0; $i < $this->nbLignes; $i++ ) {
				$this->tablier[$i] = array();

				for( $j = 0; $j < $this->nbColonnes; $j++ ) {
					$this->tablier[$i][$j] = new CaseSolitaire();
				}
			}
		}

		public function getNbLignes(): int {
			return $this->nbLignes;
		}

		public function getNbColonnes(): int {
			return $this->nbColonnes;
		}

		public function getTablier(): array {
			return $this->tablier;
		}

		public function getCase(int $ligne, int $colonne): CaseSolitaire {
			return $this->tablier[$ligne][$colonne];
		}

		public function videCase(int $ligne, int $colonne): void {
			$this->tablier[$ligne][$colonne]->setValeur(CaseSolitaire::VIDE);
		}

		public function remplitCase(int $ligne, int $colonne): void {
			$this->tablier[$ligne][$colonne]->setValeur(CaseSolitaire::BILLE);
		}

		public function neutraliseCase(int $ligne, int $colonne): void {
			$this->tablier[$ligne][$colonne]->setValeur(CaseSolitaire::NEUTRALISE);
		}

		public function estValideMvt(int $numLigDepart, int $numColDepart, int $numLigArrivee, int $numColArrivee): bool {
			// Vérification de la validité des coordonnées
			if( $numLigDepart  < 0 || $numLigDepart  >= $this->nbLignes   ||
				$numColDepart  < 0 || $numColDepart  >= $this->nbColonnes ||
				$numLigArrivee < 0 || $numLigArrivee >= $this->nbLignes   ||
				$numColArrivee < 0 || $numColArrivee >= $this->nbColonnes ) return false;
			
			// Vérification que le déplacement est conforme
			if( abs($numLigDepart - $numLigArrivee) == 2 && abs($numColDepart - $numColArrivee) == 0 ||
				abs($numColDepart - $numColArrivee) == 2 && abs($numLigDepart - $numLigArrivee) == 0 ) return false;
			
			// Vérification que la case de départ est bien occupée
			if( !$this->tablier[$numLigDepart][$numColDepart]->isCaseBille() ) return false;

			// Vérification que la case intermédiaire est bien occupée
			if( !$this->tablier[($numLigDepart + $numLigArrivee) / 2][($numColDepart + $numColArrivee) / 2]->isCaseBille() ) return false;

			// Vérification que la case d'arrivée est bien vide
			if( !$this->tablier[$numLigArrivee][$numColArrivee]->isCaseVide() ) return false;

			return true;
		}

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

		public function deplaceBille(int $numLigDepart, int $numColDepart, int $numLigArrivee, int $numColArrivee): void {
			// Vérification de la validité du déplacement
			if( !$this->estValideMvt($numLigDepart, $numColDepart, $numLigArrivee, $numColArrivee) ) return;

			// Déplacement de la bille
			$this->remplitCase($numLigArrivee, $numColArrivee);
			$this->videCase($numLigDepart, $numColDepart);
			$this->videCase(($numLigDepart + $numLigArrivee) / 2, ($numColDepart + $numColArrivee) / 2);
		}

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
	}
?>