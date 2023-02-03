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
		<link rel="stylesheet" href="style.css">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
	</head>

	<body background="ressources/fondBois.jpg">
		<section class="section is-align-center" >
			<form action="action.php" method="GET">
				<button name="action" value="nouvellePartie">
					Nouvelle Partie
				</button>
			</form>

			<?php
				if( !isset($_SESSION['Tablier']) ) {
					$_SESSION['Tablier'] = TablierSolitaire::initTablierEuropeen();
				}

				$UI = new TablierSolitaireUI($_SESSION['Tablier']);

				if( !isset($_GET['finDePartie']) ) {
					if( isset($_GET['action']) and $_GET['action'] == "poser" ) {
						echo $UI->getFormulaireDestination($_GET['coord']);
						exit();
					}
				} else {
					echo "<p class=\"has-text-white is-size-2\">".$_GET['finDePartie']."</p>";
				}

				echo $UI->getFormulaireOrigine();
			?>
  		</section>
	</body>
</html>
