<?php 
include "TablierSolitaire.php";

$tablier = TablierSolitaire::initTablierEuropeen();?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Solitaire</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
  </head>
  <body background="ressources/fondBois.jpg">
	  <section class="section is-align-center" >
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