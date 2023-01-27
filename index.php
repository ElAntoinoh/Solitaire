<?php 
	include "TablierSolitaireUI.php";
	include "TablierSolitaire.php";

	session_start();

	$_SESSION['Tablier'] = new TablierSolitaireUI(TablierSolitaire::initTablierEuropeen());
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
			<?= $_SESSION['Tablier']->getFormulaireOrigine(); ?>
  	</section>
	</body>
</html>