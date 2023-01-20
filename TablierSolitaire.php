<?php
	class TablierSolitaire {
		const NORD = 0;
		const EST = 0;
		const SUD = 0;
		const OUEST = 0;

		private $nbLignes;
		private $nbColonnes;

		private $tablier;
		
		private function TablierSolitaire($nblig = 5, $nbcol = 5) {
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

		public function getNbLignes() {
			return $this->nbLignes;
		}

		public function getNbColonnes() {
			return $this->nbColonnes;
		}

		public function getTablier() {
			return $this->tablier;
		}

		public function getCase($ligne, $colonne) {
			return $this->tablier[$ligne][$colonne];
		}

		public function videCase($ligne, $colonne) {
			$this->tablier[$ligne][$colonne]->setValeur(CaseSolitaire::VIDE);
		}

		public function remplitCase($ligne, $colonne) {
			$this->tablier[$ligne][$colonne]->setValeur(CaseSolitaire::BILLE);
		}

		public function neutraliseCase($ligne, $colonne) {
			$this->tablier[$ligne][$colonne]->setValeur(CaseSolitaire::NEUTRALISE);
		}
	}
?>