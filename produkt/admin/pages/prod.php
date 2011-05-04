<?php  
/* Produktoppdateringsside */
if(isset($_POST['slett']) && isset($_POST['produkt']))
    {
        $array = $_POST['produkt'];
        foreach($array as $teller=>$idSlett)
        {
            $Admin->slettProd($idSlett);
        }
        unset($_POST['slett']);
        unset($_POST['produkt']);
    }
	echo '
			<h1><img src="images/Cardboard-Box.png" alt="Brukere" width="30" height="30" />Produkter</h1>
			<div id="formVenstre">
			<h2>Legg til produkt</h2>
				<form action="?id=4" name="vare" method="post">
				<table width="100%">
					<tr>
						<td>Kategori: </td>
						<td>
			 					<select name="kategori" id="kategori">';
                                                                    $Admin->listValgKat();
                                                                    echo '
			 					</select>
						</td>
					</tr>
					<tr>
						<td>Navn: </td>
						<td><input type="text" id="navn" name="navn" /></td>
					</tr>
					<tr>
						<td>Bilde: </td>
						<td>
                                                    <form action="upload.php" method="post" enctype="multipart/form-data" target="upload_target" />
                                                            <input type="file" size="10" name="filstreng" />
                                                            <input type="submit" name="knapp" value="Last opp"/>
                                                    </form>
						</td>
					</tr>
					<tr>
						<td>Tekst: </td>
						<td>
							<textarea rows="12" cols="55" name="text" id="text" style="max-width:350px; max-height:400px;">
							</textarea>
						</td>
					</tr>
					<tr>
						<td>Pris: </td>
						<td><input type="text" id="pris" name="pris" /></td>
					</tr>
					<tr class="submit">
						<td></td>
						<td><input type="submit" name="regVare" id="regVare" /></td>
					</tr>
				</table>
				</form>
			</div>
			<div id="formHoyre">
			<h2>Produkter</h2>';
				if(isset($feilSlett))
                                    echo $feilSlett;
		echo'		<table width="100%">
					<tr>
						<td><input type="text" id="sok" name="sok" /></td>
					</tr>
                                        <script type="text/javascript">
                                            $("#sok").keyup(function() {
                                              $("#resultat").load("ajax/produkt.php?sok=" + document.getElementById("sok").value);
                                            });
                                       </script>
				</table>
                                <form action="" name="slett" method="POST">
                                <div id="resultat">
				<table width="100%">
					<tr>
						<td></td>
						<td>Kategori</td>
						<td>Navn</td>
						<td>Bilde</td>
						<td>Pris</td>
					</tr>';
                                             $Admin->visProdukter(0,10,"");
                               echo '
				</table>
                                </div>                                
                                <table width="100%">
                                    <tr class="submit">
                                        <td width="80%"></td>
                                        <td><input type="submit" id="slett" name="slett" value="Slett" /></td>
                                    </tr>
                               </table>
                                
				</form>
			</div>
			<div style="clear:both;">
			</div>
';
?>