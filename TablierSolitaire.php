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
	}
?>