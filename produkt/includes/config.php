<?php
/*
	CONFIG FILE
	Include in all pages!
*/

//Kataloger
$C['DIR']['ROOT'] = "../";
$C['DIR']['CLASS'] = "includes/";
$C['DIR']['SIDER'] = "pages/" 

//Brukerconfig
$C['BRUKER']['REGEX'] = "/[^a-zA-Z0-9]/";
$C['BRUKER']['MIN'] = 3;
$C['BRUKER']['MAX'] = 30;
$C['BRUKER']['NAVN_MIN'] = 2;
$C['BRUKER']['NAVN_MAX'] = 30;
$C['BRUKER']['NAVN_UGYLDIG_REGEX'] = "/[^a-zA-Z0-9זרוֶ״ֵ\s]/u";
$C['BRUKER']['PASSORD_MIN'] = 6;

	function sjekkFelt($input)
	{
		return mysql_real_escape_string($input);
	}

?>