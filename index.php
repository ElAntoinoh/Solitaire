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
		<div class="container has-text-centered">
		
			<section class="section" >
				<?php
					if( isset($_GET['action']) && $_GET['action']=="CreationTablier" ){
						/* PARTIE PERSONNALISATION */
						if(!isset($_SESSION['TablierPerso'])){
						?>
						<form action="action.php" method="GET">
							<label class="has-text-white">Nombre de lignes : </label><input type="number" name="lignePerso" value="3" required min="3" max="8">
							<label class="has-text-white">Nombre de colonnes : </label><input type="number" name="colonnePerso" value="3" required min="3" max="8">
							<button name="action" value="CreerTablierPerso">Valider</button>
						</form>
						<?php
						}else{
							$UI = new TablierSolitaireUI($_SESSION['TablierPerso']);

							echo $UI->getFormulairePersonnalisation();
						}
					}
					elseif(isset($_SESSION['Tablier'])){
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
					}
				?>
			</section>
			<section class="section" >
				<form action="action.php" method="GET">
					<button name="action" value="nouvellePartie">
						Nouvelle Partie
					</button>

					<select name="ChoixPlateau">
						<option>Europeen</option>
						<option>Anglais</option>
						<option>Asymetrique</option>
						<option>Gagnant</option>
						<option>Perdant</option>
					</select>

					<button name="action" value="personnaliserTablier">
						Personnaliser
					</button>
				</form>
			</section>
		</div>
		
	</body>
</html>
