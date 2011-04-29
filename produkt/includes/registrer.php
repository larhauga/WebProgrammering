<body>
<form action="reg2.php" method="get" name="login">
<h2>Registering av ny kunde</h2>
<table width="248" summary="Kunde info">
<tr>
<td>Epost:</td><td><input name="epost" type="text"></td></tr>
<tr><td>Gjenta Epost:</td><td><input name="epost2" type="text"></td><tr>
<tr><td height="22">Passord:</td><td><input name="passord" type="text"></td><tr>
<tr><td>Gjenta Passord:</td><td><input name="passord2" type="text"></td><tr>
<tr><td>Fornavn:</td><td><input name="fornavn" type="text"></td><tr>
<tr><td>Etternavn:</td><td><input name="etternavn" type="text"></td><tr>
</table>
<br>
<table width="248" height="104" summary="adresse">
<tr>
<td width="66">Adresse:</td><td width="170"><input name="adresse" type="text"></td></tr>
<tr><td>Postnr:</td><td><input name="postnr" type="text"></td><tr>
<tr><td>Poststed</td><td><input name="poststed" type="text" readonly="readonly"></td><tr>
<tr><td>Tlf:</td><td><input name="tlf" type="text"></td><tr>
</table>
<input name="submit" type="submit" value="Register">
</form>
</body>
</html>