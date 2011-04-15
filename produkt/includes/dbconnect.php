<?php

$db = new MySQLi("localhost","xzindor_db1","lol123","xzindor_db1");
if($db->connect_error)
{
	die("Kunne ikke koble til databasen".$db->connect_error);
}
?>
 