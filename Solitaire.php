<?php 
include "TablierSolitaire.php" 

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
			    				<figure class="image is-96x96">
									<?php if($tablier->getCase($i, $j)->getValeur() == 1): ?>
								  		<img src="ressources/CaseBille.png">
							  		<?php elseif($tablier->getCase($i, $j)->getValeur() == 0): ?>
							  			<img src="ressources/CaseVide.png">
							  		<?php endif; ?>
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