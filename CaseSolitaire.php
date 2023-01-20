<?php
	class CaseSolitaire {
		public const BILLE      = 1;
		public const VIDE       = 0;
		public const NEUTRALISE = -1;
		
		protected $valeur; // Intervale -1, 0, 1 ?

		public function __construct($valeur = CaseSolitaire::BILLE) {
			$this->valeur = $valeur;
		}

		public function __toString() {
			return $this->valeur;
		}
		
		public function getValeur() {
			return $this->valeur;
		}
			
		public function setValeur($new_valeur) {
			$this->valeur = $new_valeur;
		}
		
		public function isCaseVide() {
			return $this->valeur == CaseSolitaire::VIDE;
		}
		
		public function isCaseBille() {
			return $this->valeur == CaseSolitaire::BILLE;
		}
		
		public function isCaseNeutralise() {
			return $this->valeur == CaseSolitaire::NEUTRALISE;
		}
	}

	$case = new CaseSolitaire();

	echo $case->__toString()
?>