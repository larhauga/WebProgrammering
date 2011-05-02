<?php
/*
	CONFIG FILE
	Include in all pages!
*/

//Kataloger
$C['DIR']['ROOT'] = "../";
$C['DIR']['CLASS'] = "includes/";
$C['DIR']['SIDER'] = "pages/";
$C['DIR']['ADMIN'] = "admin/";

//Brukerconfig
$C['BRUKER']['REGEX'] = "/[^a-zA-Z0-9]/";
$C['BRUKER']['MIN'] = 3;
$C['BRUKER']['MAX'] = 30;
$C['BRUKER']['NAVN_MIN'] = 2;
$C['BRUKER']['NAVN_MAX'] = 30;
$C['BRUKER']['NAVN_UGYLDIG_REGEX'] = "/[^a-zA-Z0-9������\s]/u";
$C['BRUKER']['PASSORD_MIN'] = 6;

?>