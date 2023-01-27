<?php
	/**
	 * Classe CaseSolitaire
	 */
	class CaseSolitaire {
		public const BILLE      = 1;
		public const VIDE       = 0;
		public const NEUTRALISE = -1;
		
		protected $valeur; // -1, 0 ou 1

		/**
		 * Constructeur de la classe CaseSolitaire
		 * @param int $valeur Valeur de la case
		 */
		public function __construct($valeur = CaseSolitaire::BILLE) {
			$this->valeur = $valeur;
		}

		/**
		 * Retourne le toString de la case
		 * @return string toString de la case
		 */
		public function __toString() {
			return $this->valeur;
		}
		
		/**
		 * Retourne la valeur de la case
		 * @return int Valeur de la case
		 * @see CaseSolitaire::getValeur()
		 */
		public function getValeur() {
			return $this->valeur;
		}
			
		/**
		 * Modifie la valeur de la case
		 * @param int $new_valeur Nouvelle valeur de la case
		 * @return void
		 */
		public function setValeur($new_valeur) {
			$this->valeur = $new_valeur;
		}
		
		/**
		 * Retourne vrai si la case est vide
		 * @return bool Vrai si la case est vide
		 */
		public function isCaseVide() {
			return $this->valeur == CaseSolitaire::VIDE;
		}
		
		/**
		 * Retourne vrai si la case est une bille
		 * @return bool Vrai si la case est une bille
		 */
		public function isCaseBille() {
			return $this->valeur == CaseSolitaire::BILLE;
		}
		
		/**
		 * Retourne vrai si la case est neutralisée
		 * @return bool Vrai si la case est neutralisée
		 */
		public function isCaseNeutralise() {
			return $this->valeur == CaseSolitaire::NEUTRALISE;
		}
	}
?>