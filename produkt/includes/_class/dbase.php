<?php

class dbase
{
    private $hostname;
    private $brukernavn;
    private $passord;
    private $dbnavn;
    private $error;
    
    public function __construct()
    {
        $this->hostname = "193.107.29.49";
        $this->brukernavn = "xzindor_db1";
        $this->passord = "lol123";
        $this->dbnavn = "xzindor_db1";
    }
    
    public function connect()
    {
        $db = new mysqli($this->hostname, $this->brukernavn, $this->passord, $this->dbnavn);
        if($db->connect_error)
        {
            die("Feil ved henting av data. Kunne ikke koble til databasen." . $db->connect_error);
        }
        return $db;
    }
}

?>
