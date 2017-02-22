<html>
<body>
<h1 style="text-align:center;">Upload Verification</h1>

<?php


	session_start();

	$dataType = $_SESSION['dataType'];
	$dataSource = $_SESSION['dataSource'];			
	$facility = $_SESSION['facility'];	
	$phantom = $_SESSION['phantom'];
	$source = $_SESSION['source'];			
	$date = $_SESSION['date'];
	$phase = $_SESSION['phase'];
	$group = $_SESSION['group'];
	$user = $_SESSION['user'];		
	$step = $_SESSION['step'];
	$energy = $_SESSION['energy'];
	$region = $_SESSION['region'];
	$spot = $_SESSION['spot'];
	$beam = $_SESSION['beam'];
	$particle = $_SESSION['particle'];
	$permissions = $_SESSION['permissions'];
	$fileName = $_SESSION['fileName'];
	$fileLocation = $_SESSION['fileLocation'];


	//connect to the database
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

	echo "Sucessfully Connected to Database. Storing File Now.<br>";

	$insertFileMain = "INSERT INTO Main Values('$datasetID', '$date', '$source', '$facility', '$phantom', '$dataSource', '$step', '$energy', '$region', '$spot', '$beam', '$particle', '$phase');";

	$findExistingDataset = "SELECT datasetID FROM Main WHERE date = $date AND source = '$source' AND facilityID = $facility AND phantomID = $phantom AND dataSource = '$dataSource' AND stepSize = $step AND energy = $energy AND region = '$region' AND spot = $spot AND beam = '$beam' AND particle = '$particle' AND phase = $phase;";


	
	$existingData = mysqli_query($db, "$findGroupUser");
	// while($existing = $existingData->fetch_assoc())
	// {
	// 	$datasetID = $existing['datasetID'];
	// 	echo "$datasetID";
	// }	

	if($existingData == NULL)
	{
		$uploadMain = mysqli_query($db, "$insertFileMain");
		$datasetID = 0;
		$reconstructionID = 0;
		echo "Creating new dataset and uploading file.<br>";
	}

	switch($dataType)
	{
		case "Raw":
			$runNumber = $_SESSION['runNumber'];
			$runTags = $_SESSION['runTags'];
			$runAngle = $_SESSION['runAngle'];
			$insertFile = "INSERT INTO Raw VALUES('$datasetID', '$fileName', '$fileLocation', '$runNumber', '$runTags', '$runAngle', '$user', '$permissions');";
			echo "Uploading Raw file.<br>";
		break;

		case "Preprocessed":
			$processedDate = $_SESSION['processedDate'];
			$gt = $_SESSION['gt'];
			$code = $_SESSION['code'];
			$insertFile = "INSERT INTO Preprocessed VALUES('$datasetID','$fileName','$fileLocation', '$$processedDate', '$gt', '$code', '$user', '$permissions');";
			echo "Uploading Preprocessed file.<br>";
		break;

		case "Reconstruction":
			$processedDate = $_SESSION['processedDate'];
			$parameters = $_SESSION['parameters'];
			$code  = $_SESSION['code'];
			$notes = $_SESSION['notes'];
			$insertFile = "INSERT INTO Reconstruction VALUES('$datasetID', '$reconstructionID', '$fileName', '$fileLocation', '$code', '$processedDate', '$parameters', '$notes', '$user', '$permissions');";
			echo "Uploading Reconstruction file. <br>";
		break;

		case "Images":
			$processedDate = $_SESSION['processedDate'];
			$insertFile = "INSERT INTO Images VALUES('$reconstructionID', '$fileName', '$fileLocation', '$processedDate', '$user', '$permissions');";
			echo "Uploading Image.<br>";
		break;

		default:
			echo "There's been an error. Please try again.";
		break;
	}

	// echo "$insertFileMain";
	// echo "$insertFile";

	$uploadTable = mysqli_query($db, "$insertFile");

	echo "File has been uploaded.";


?>
<form method="POST" action='searchhome.php'>
<input type="submit" value="Return to Main Menu">
</form>

</body>
</html>
