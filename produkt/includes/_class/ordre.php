<?php

class ordre
{
	public $kundeid;
	public $dato;
	public $betalt;
	public $total;
	
	function __construct()
	{
	}
	function addOrdreLinje($innAntall,$innID)
	{
		//komando for å skrive dette til sqlen
	}
	function sendOrdre($total)
	{
		//komando for å lagre ordreren
		$this->total = $total;
	}
}
