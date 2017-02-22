<html>

<body>

<h1 style="text-align:center;">Search Criteria</h1>

<hr>


<?php

	session_start();
	$enteredUser = $_POST['enteredUser'];

	$servername = "localhost";
	$username = ; //username redacted
	$password = ; //Password redacted
	$defaultdb = "mccarty_pct_data";
	$db = mysqli_connect("$servername", "$username", "$password", "$defaultdb");
			
	if (mysqli_connect_errno() OR !$db)
	{
		echo "Failed to connect to MySQL : " . mysqli_connect_error();
	   			die("Connection failed. :*( <br>");
	}

	$validateUser = "SELECT grp FROM Users WHERE username = '$enteredUser';";

	$userData = mysqli_query($db, "$validateUser");
if($user = $userData->fetch_assoc())
{
	$_SESSION['currentGroup'] = $user['grp'];
	$_SESSION['currentUser'] = $enteredUser;

	$enteredUser = NULL;

	echo "Welcome " . $_SESSION['currentUser'] . " from " . $_SESSION['currentGroup'] . "<br>";
	
	$_SESSION['facilityOrig'] = NULL;
	$_SESSION['dataSourceOrig'] = NULL;
	$_SESSION['phaseOrig'] = NULL;
	$_SESSION['sourceOrig'] = NULL;
	$_SESSION['phantomOrig'] = NULL;
	$_SESSION['dateStart'] = NULL;
	$_SESSION['dateEnd'] = NULL;
	$_SESSION['particleOrig'] = NULL;
	$_SESSION['energyOrig'] = NULL;
	$_SESSION['keywordOrig'] = NULL;

	// echo "
	// <form method = 'get' action= 'readheliumfiles.php'>
	// <p align='center'>
	// <input type='submit' value = 'Top Secret'>
	// </p>
	// </form> ";


	echo "
	<form method = 'get' action= 'uploaddata.php'>
	<p align='right'>
	<input type='submit' value = 'Upload Data'>
	</p>
	</form> 

	<form method='get' action='datasearch2.php'>

	<p>
	<input type='submit' value = 'Submit'>
	<input type='reset'>
	</p>

	<p> 
	Facility:
	<select name = 'facility'>
		<option value = ' ' >All Facilities</option>
		<option value = '1' >Baylor</option>
		<option value = '2' >CPC</option>
		<option value = '3' >LLU</option>
		<option value = '4' >NIU</option>
		<option value = '5' >UCSC</option>
		<option value = '6' >UCSF</option>
	</select>
	</p> 

	<p> 
	Technology:
	<select name = 'dataSource'>
		<option value = ' ' >All Technologies</option>
		<option value = 'pCT' >pCT</option>
		<option value = 'pR' >pR</option>
		<option value = 'HeCT' >HeCT</option>
		<option value = 'HeR' >HeR</option>
		<option value = 'pIVI' >pIVI</option>
		<option value = 'HeIVI' >HeIVI</option>
	</select>
	</p>	
	
	<p> 
	Data Source:
	<select name='source'>
		<option value = ' ' >All Sources</option>
		<option value = 'E' >Experimental</option>
		<option value = 'S' >Simulated</option>
	</select>
	</p>

	<p> 
	Objects:
	<select name='phantom'>
		<option value = ' ' >All Objects</option>
		<option value = '1' >Empty Run NOS</option>
		<option value = '2' >Empty Run Cal</option>
		<option value = '3' >Calibration</option>	
		<option value = '4' >Alignment (Rod)</option>
		<option value = '5' >Water Phantom</option>
		<option value = '6' >CTP404 Sensitometry</option>
		<option value = '7' >CTP528 High Resolution Line Pair</option>
		<option value = '8' >CTP515 Low Contrast Module</option>
		<option value = '9' >CTP 554 Dose Phantom</option>
		<option value = '10' >HN715 CIRS Pediatric Head</option>
		<option value = '11' >HN715 CIRS Pediatric, Modified</option>
		<option value = '12' >LMU DECT</option>
		<option value = '13' >CIRS Custom Edge Spread Function</option>
		<option value = '14' >Birks</option>
	</select>
	</p>

	<p>
	Data Collection Date Between: 
	<input type='date' name='dateStart'> And 
	<input type='date' name='dateEnd'>
	</p>

	<hr>

	<p> 
	Particle:
	<select name='particle'>
		<option value = ' ' >All Particles</option>
		<option value = 'proton' >Protons</option>
		<option value = 'helium' >Helium</option>
	</select>
	</p>

	<p> 
	Energy:
	<select name='energy'>
		<option value = ' ' >All Energies</option>
		<option value = '175' >175 MeV</option>
		<option value = '200' >200 MeV</option>
		<option value = '220' >220 MeV</option>
	</select>
	</p>

	<p>
	Keywords:
	<input type='text' name='keyword'>
	(Keywords must be separated by semicolons ; and must contain no white space)
	</p>

	</form>		

	";

}
else
{
	echo "Invalid Username. Please try again.";
}


?>
</body>
</html>
