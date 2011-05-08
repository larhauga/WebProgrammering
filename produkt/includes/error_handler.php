<?php
/* Error handler */
/* Variable filnavn m.m */


$visFeil = 0;           //0: Viser ikke feil på side, E_ALL,E_WARNING
$logfil = "";           //Må være ABSOLUTTPATH!!!
$loglevel = "E_ALL";    //E_ALL, E_ERROR, E_WARNING, E_USER_ERROR
$evtRedir = "";         //Ved fatalfeil så redirect.
$epost = "lars@larshaugan.net"; // Sender epost hvis filen ikke eksisterer eller det er en feil.


error_reporting($visFeil);
set_error_handler(errorlogger, $loglevel);
register_shutdown_function(fatalFeil); 


function errorlogger($errno, $errstr,$errfile,$errline)
{
	$dato = date("d-m-Y H:i");
	$feil = $dato." ".$errfile." ".$errline." ".$errno." ".$errstr."\r\n";
	
        if(file_exists($logfil))
            error_log($feil, 3, $logfil);
        else
        {
            error_log("Logfilen er korrupt eller eksisterer ikke.
            Feilen som skjedde var: \n".$feil.".", 1,$epost);
        }
}

function fatalFeil()
{
	$error = error_get_last();
	$melding = $error["melding"]."\n";
        if(file_exists($logfil))
            error_log($melding,3,$logfil);
        else
        {
            error_log("Logfilen er korrupt eller eksisterer ikke.
            Feilen som skjedde var: ".$melding.".", 1,$epost);
        }
        if($evtRedir != "")
            header('Location:"'.$evtRedir.'"');
}
?>