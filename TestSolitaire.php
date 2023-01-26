<?php 
include "TablierSolitaire.php";
?>



<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Solitaire</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
  </head>
  <body>

  	<!-- PARTIE PERDANT -->
	  <section class="section is-align-center" >
	  	<!-- Initialisation du tablier perdant -->
	  	<?php $tablier = TablierSolitaire::initTablierPerdant();?>
	    <table >
	    	<tbody>
	    		<?php for($i=0; $i < $tablier->getNbLignes(); $i++): ?>
					<tr>
		    			<?php for($j=0; $j < $tablier->getNbColonnes(); $j++): ?>
		    				<td>
		    					<!-- Créer une figure en 96x96 -->
			    				<figure class="image is-96x96">
			    					<!-- Si la case est une bille -->
									<?php if($tablier->getCase($i, $j)->getValeur() == CaseSolitaire::BILLE): ?>
								  		<img src="ressources/CaseBille.png">
							  		<!-- Si la case est vide -->
							  		<?php elseif($tablier->getCase($i, $j)->getValeur() == CaseSolitaire::VIDE): ?>
							  			<img src="ressources/CaseVide.png">
							  		<?php endif; ?>
							  		<!-- Sinon ne mettre aucune image.-->
								</figure>
							</td>
		    			<?php endFor; ?>
	    			</tr>
				<?php endFor; ?>
	    	</tbody>
	    </table>

	    <!-- Verification état de la partie -->
	    <p>
	    	<strong>Statue de la partie : </strong>
	    	<?php
	    		if( $tablier->isFinDePartie() ){
	    			if($tablier->isVictoire()){
	    				echo "Victoire de la partie.";
	    			}
	    			else{
	    				echo "Echec de la partie.";
	    			}
	    		}
	    		else{
	    			echo "En cours de partie.";
	    		}

	    	?>
	    </p>
	  </section>

	  <!-- PARTIE GAGNANT -->
	  <section class="section is-align-center" >
	  	<!-- Initialisation du tablier gagnant -->
	  	<?php $tablier = TablierSolitaire::initTablierGagnant();?>
	    <table >
	    	<tbody>
	    		<?php for($i=0; $i < $tablier->getNbLignes(); $i++): ?>
					<tr>
		    			<?php for($j=0; $j < $tablier->getNbColonnes(); $j++): ?>
		    				<td>
		    					<!-- Créer une figure en 96x96 -->
			    				<figure class="image is-96x96">
			    					<!-- Si la case est une bille -->
									<?php if($tablier->getCase($i, $j)->getValeur() == CaseSolitaire::BILLE): ?>
								  		<img src="ressources/CaseBille.png">
							  		<!-- Si la case est vide -->
							  		<?php elseif($tablier->getCase($i, $j)->getValeur() == CaseSolitaire::VIDE): ?>
							  			<img src="ressources/CaseVide.png">
							  		<?php endif; ?>
							  		<!-- Sinon ne mettre aucune image.-->
								</figure>
							</td>
		    			<?php endFor; ?>
	    			</tr>
				<?php endFor; ?>
	    	</tbody>
	    </table>

		<!-- Verification état de la partie -->
	    <p>
	    	<strong>Statue de la partie : </strong>
	    	<?php
	    		if($tablier->isFinDePartie()){
	    			if($tablier->isVictoire()){
	    				echo "Victoire de la partie.";
	    			}
	    			else{
	    				echo "Echec de la partie.";
	    			}
	    		}
	    		else{
	    			echo "En cours de partie.";
	    		}

	    	?>
	    </p>
	  </section>

	  <!-- PARTIE EN COURS -->
	  <section class="section is-align-center" >
		<!-- Initialisation du tablier en cours -->
		<?php $tablier = TablierSolitaire::initTablierAnglais();?>
	    <table >
	    	<tbody>
	    		<?php for($i=0; $i < $tablier->getNbLignes(); $i++): ?>
					<tr>
		    			<?php for($j=0; $j < $tablier->getNbColonnes(); $j++): ?>
		    				<td>
		    					<!-- Créer une figure en 96x96 -->
			    				<figure class="image is-96x96">
			    					<!-- Si la case est une bille -->
									<?php if($tablier->getCase($i, $j)->getValeur() == CaseSolitaire::BILLE): ?>
								  		<img src="ressources/CaseBille.png">
							  		<!-- Si la case est vide -->
							  		<?php elseif($tablier->getCase($i, $j)->getValeur() == CaseSolitaire::VIDE): ?>
							  			<img src="ressources/CaseVide.png">
							  		<?php endif; ?>
							  		<!-- Sinon ne mettre aucune image.-->
								</figure>
							</td>
		    			<?php endFor; ?>
	    			</tr>
				<?php endFor; ?>
	    	</tbody>
	    </table>

	    <!-- Verification état de la partie -->
	    <p>
	    	<strong>Statue de la partie : </strong>
	    	<?php
	    		if($tablier->isFinDePartie()){
	    			if($tablier->isVictoire()){
	    				echo "Victoire de la partie.";
	    			}
	    			else{
	    				echo "Echec de la partie.";
	    			}
	    		}
	    		else{
	    			echo "En cours de partie.";
	    		}

	    	?>
	    </p>
		  <p> Mouvement d'une bille </p>
<?php $tablier->deplaceBilleDir(1,3, TablierSolitaire::SUD); ?>
		  <table >
	    	<tbody>
	    		<?php for($i=0; $i < $tablier->getNbLignes(); $i++): ?>
					<tr>
		    			<?php for($j=0; $j < $tablier->getNbColonnes(); $j++): ?>
		    				<td>
		    					<!-- Créer une figure en 96x96 -->
			    				<figure class="image is-96x96">
			    					<!-- Si la case est une bille -->
									<?php if($tablier->getCase($i, $j)->getValeur() == CaseSolitaire::BILLE): ?>
								  		<img src="ressources/CaseBille.png">
							  		<!-- Si la case est vide -->
							  		<?php elseif($tablier->getCase($i, $j)->getValeur() == CaseSolitaire::VIDE): ?>
							  			<img src="ressources/CaseVide.png">
							  		<?php endif; ?>
							  		<!-- Sinon ne mettre aucune image.-->
								</figure>
							</td>
		    			<?php endFor; ?>
	    			</tr>
				<?php endFor; ?>
	    	</tbody>
	    </table>
		  
	  </section>
  </body>
</html>
