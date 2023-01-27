<?php 

	include "TablierSolitaireUI.php";
	include "TablierSolitaire.php";
	session_start();
	?>

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
			<?php
			if( !isset($_SESSION['Tablier']) ) {
					$_SESSION['Tablier'] = TablierSolitaire::initTablierEuropeen();

					$UI = new TablierSolitaireUI($_SESSION['Tablier']);

					echo $UI->getFormulaireOrigine();
			}else{
				if( isset($_GET) && isset($_GET['action']) ){
					switch($_GET['action']){
						case "selectionner" :
							$UI = new TablierSolitaireUI($_SESSION['Tablier']);

							echo $UI->getFormulaireOrigine();
							break;
						case "poser":				
							$UI = new TablierSolitaireUI($_SESSION['Tablier']);

							echo $UI->getFormulaireDestination($_GET['coord']);

							break;
					}
				}
			}


			?>
  	</section>
	</body>
</html>
