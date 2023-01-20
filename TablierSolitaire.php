<?php


class TablierSolitaire
{

	const NORD = 0;
	const EST = 0;
	const SUD = 0;
	const OUEST = 0;

	private $nbLignes;
	private $nbColonnes;
	
	function __construct($nblig=5, $nbcol=5)
	{
		echo $nblig, $nbcol;
	}
}


$tablier = new TablierSolitaire();


?>