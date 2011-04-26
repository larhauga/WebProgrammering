<?php 
include "includes/head.php";
?>

<body>
	<div id="container">
		<div id="header">
		<div id="headervenstre">
			<h1>Nettbutikken</h1>
		</div>
		  <div id="headerkolonne">
		  	<div id="logginn">
			    <form name="login" method="post" action="login.php">
						<table>
						  <tr>
							<td>Epost: </td>
							<td><input type="text" name="epost" id="epost" /></td>
					      </tr>
					      <tr>
					        <td>Passord: </td>
					        <td><input type="password" name="passord" id="passord" /></td>
				    	  </tr>
				          <tr>
					         <td></td>
						 	 <td><input type="submit" name="login" id="login" value="Logg inn" />
					           Registrer <a href="includes/login/reg2.php">her</a></td>
					      </tr>
						</table>
					</form>
				</div>
				
			<div id="sok">
				<form name="sok" method="post" action="sok.php">
						<table>
							<tr>
								<td><input type="text" name="soktekst" id="soktekst" /></td>
								<td><input name="sok" type="submit" value="SØK" /></td>
							</tr>
						</table>
				</form>
			</div>
		 </div>

		</div>
		

		<div id="meny">
		<ul>
			<li><a href="#">Datautstyr</a></li>
			<li><a href="#">PC</a></li>
			<li><a href="#">Lyd og Bilde</a></li>
			<li><a href="#">Foto og Video</a></li>
			<li><a href="#">Telefoni og Gps</a></li>
			<li><a href="#">Spill</a></li>
			<li><a href="#">Hjem og Fritid</a></li>
		</ul>
		</div>
		
		<div id="main">
			<div id="path">
				<a href="#">Hjem</a> <strong id="hjerte">&hearts;</strong> <a href="#">Datautstyr</a>
			</div>

		</div>
		<div id="rightbar">
		  <div id="handlevogn">
		    <h1>Handlevogn</h1>
		  	<p>Vare 1</p>
		  	<p>Vare 2</p>
	  	  </div>
		</div><!--end of rightbar -->
        <?php
		include "includes/footer.php";
		?>
	</div>
</body>
</html>
