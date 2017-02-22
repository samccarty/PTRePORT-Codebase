<html>
<body>

<h1 style="text-align:center;">Run Results</h1>

<?php

function intFacility($facilityInfo)
{
	switch($facilityInfo)
	{
		case 1:
		$facility = "Baylor";
		break;

		case 2:
		$facility = "CPC";
		break;

		case 3:
   		$facility = "LLU";
   		break;
					
		case 4:
   		$facility = "NIU";
  		break;

   		case 5:
   		$facility = "UCSC";
   		break;

		case 6:
   		$facility = "UCSF";
   		break;

   		default:
   		$facility = NULL;
  		break;
		    	}
	return $facility;	    	
}		
function intSource($sourceInfo)
{
	switch($sourceInfo)
	{
		case E:
		$source = "Experimental";
		break;

		case S:
		$source = "Simulated";
		break;

	    default:
	    $source = NULL;
	    break;
	   			}
	return $source;   			
}

function intPhantom($phantomInfo)
{

   	switch($phantomInfo)
   	{
   		case 1:
   		$phantom = "Empty Run NOS";
   		break;

   		case 2:
   		$phantom = "Empty Run Cal";
   		break;

		case 3:
		$phantom = "Calibration Phantom";
		break;

		case 4:
		$phantom = "Alignment (Rod) Phantom";
		break;

		case 5:
		$phantom = "Water Phantom";
		break;

		case 6:
		$phantom = "CTP404 Sensitometry Phantom";
		break;

		case 7:
		$phantom = "CTP528 High Resolution Line Pair Phantom";
		break;

		case 8:
		$phantom = "CTP515 Low Contrast Module";
		break;

		case 9:
		$phantom = "CTP554 Dose Phantom";
		break;

		case 10:
		$phantom = "HN715 CIRS Pediatric Head Phantom, Original";
		break;

		case 11:
		$phantom = "HN715 CIRS Pediatric Head Phantom, Modified";
		break;

		case 12:
		$phantom = "LMU DECT Phantom";
		break;

		case 13:
		$phantom = "CIRS Custom Edge Spread Function Phantom";
		break;

		case 14:
		$phantom = "Birks Phantom";
		break;

		default:
		$phantom = NULL;
		break;
	}

	return $phantom;
}
function rawTableHeaders()
{
	echo "<table border='1'>
	<tr>
	<th>Data Type</th>
	<th>Date Created</th>
	<th>Data Source</th>
	<th>Sim vs Ex</th>
	<th>Phantom</th>
	<th>Facility</th>
	<th>File Name</th>
	<th>File Location</th>
	<th>Run Number</th>
	<th>Run Tags</th>
	<th>Run Angle</th>
	<th>Step Size</th>
	<th>Energy</th>
	<th>Region</th>
	<th>Spot Size</th>
	<th>Beam Type</th>
	<th>Particle Type</th>
	<th>Phase</th>
	<th>User</th>
	<th>Group</th>
	<th>File Permissions</th>
	</tr>";  
}

function preTableHeaders()
{
	echo "<table border='1'>
	<tr>
	<th>Data Type</th>
	<th>Date Created</th>
	<th>Data Source</th>
	<th>Sim vs Ex</th>
	<th>Phantom</th>
	<th>Facility</th>
	<th>File Name</th>
	<th>Preprocessed Date</th>
	<th>File Location</th>
	<th>GEANT4/TOPAS</th>
	<th>Code Version Used</th>
	<th>Step Size</th>
	<th>Energy</th>
	<th>Region</th>
	<th>Spot Size</th>
	<th>Beam Type</th>
	<th>Particle Type</th>
	<th>Phase</th>
	<th>User</th>
	<th>Group</th>
	<th>File Permissions</th>
	</tr>";  
}

function recTableHeaders()
{
	echo "<table border='1'>
	<tr>
	<th>Data Type</th>
	<th>Date Created</th>
	<th>Data Source</th>
	<th>Sim vs Ex</th>
	<th>Phantom</th>
	<th>Facility</th>
	<th>File Name</th>
	<th>Reconstruction Date</th>
	<th>File Location</th>
	<th>Parameters</th>
	<th>Code Version Used</th>
	<th>Notes</th>
	<th>Step Size</th>
	<th>Energy</th>
	<th>Region</th>
	<th>Spot Size</th>
	<th>Beam Type</th>
	<th>Particle Type</th>
	<th>Phase</th>
	<th>User</th>
	<th>Group</th>
	<th>File Permissions</th>
	</tr>";  
}

function imTableHeaders()
{
	echo "<table border='1'>
	<tr>
	<th>Data Type</th>
	<th>Date Created</th>
	<th>Data Source</th>
	<th>Phantom</th>
	<th>Facility</th>
	<th>File Name</th>
	<th>Reconstruction Date</th>
	<th>File Location</th>
	<th>Phase</th>
	<th>User</th>
	<th>Group</th>
	<th>File Permissions</th>
	</tr>";  
}
session_start();

//connect to the database
$servername = "localhost";
$username = ; //username redacted
$password = ; //password redacted
$defaultdb = "mccarty_pct_data";
$db = mysqli_connect("$servername", "$username", "$password", "$defaultdb");
	    		
if (mysqli_connect_errno() OR !$db)
{
	echo "Failed to connect to MySQL : " . mysqli_connect_error();
	die("Connection failed. :*( <br>");
}

$today = date(mdY);
// echo "<br> $today <br>";

$fileRaw = $_SESSION['fileRaw'];
$filePre = $_SESSION['filePre'];
$rawSize = sizeof($fileRaw);
$preSize = sizeof($filePre);
// echo "rawSize: $rawSize <br> preSize: $preSize <br> rawCount: $rawCount <br> preCount: $preCount <br>";

// echo "Raw Files: ";
// print_r($fileRaw);
// echo "<br>";
// echo "Pre Files: ";
// print_r($filePre);
// echo "<br>";

$userPer = $_GET['userPer'];
$groupPer = $_GET['groupPer'];
$publicPer = $_GET['publicPer'];
$permissions = "$userPer" . "$groupPer" . "$publicPer";

$currentUser = $_SESSION['currentUser'];
$currentGroup = $_SESSION['currentGroup'];

$preMethod = $_GET['preMethod'];
$preMode = $_GET['preMode'];



// echo "numTVcorr: $numTVcorr <br> numWcalib: $numWcalib<br>";
// echo "Wcalib: $Wcalib <br> TVcorr: $TVcorr<br>";

//For Version 2.0, add check to see if current user is authorized to process files. 
if($rawSize > 0)
{
	//Check Calibration Checkboxes
	$numWcalib = 0;
	$numTVcorr = 0;
	for($count = 0;$count < 8;$count++)
	{	
		$calibCheck = "calib$count";
		// echo "calibCheck: $calibCheck";
		if($_GET[$calibCheck] != ' ')
		{

			$calib = $_GET[$calibCheck];
			// echo "$calib<br>";
			if(strpos($calib, "W") !== false)
			{
				$Wcalib = $calib;
				$numWcalib = $numWcalib + 1;
			}
			elseif(strpos($calib, "TV") !== false)
			{
				$TVcorr = $calib;
				$numTVcorr = $numTVcorr + 1;
			}
		}
	}
	if(($numWcalib != 1) OR ($numTVcorr != 1))
	{
		echo "You must select only two Calibration files. One Wcalib and one TVcorr <br>";
	}

	for($count = 0;$count < $rawSize; $count++ )
	{
		// echo $fileRaw[$count];
		list($dash, $ion, $pct, $org, $phantom, $simEx, $date, $runtag, $input, $file) = explode('/', $fileRaw[$count]);
		$file = basename($fileRaw[$count]);
		$datpos = strpos($fileRaw[$count], '.dat');
		// echo "datpos: $datpos<br>";
		$fileLocation = substr($fileRaw[$count], 0, ($datpos + 4));
		// echo "FileLocation: $fileLocation<br>";
		// echo "FileRaw: $fileRaw[$count]<br>";

		// $outputLocation = "run40";



		if(strpos($file, '.dat') !== false)
		{
			echo "Currently preprocessing $file.<br>";
			if(strpos($file, 'He') !== false)
			{
				$outputLocation = "/ion/pCT_data/helium/Preprocessed/0042_inf/$today";
				// echo "$outputLocation<br>";
			}
			else
			{
				$outputLocation = "/$ion/$pct/$org/$phantom/$simEx/$date/$runtag/Output/$today";
				// echo "Output Location: $outputLocation<br>";
			}
			
			$command = "ssh ionsvc@kodiak.baylor.edu 'cd /ion/home/ionsvc/repos/Preprocessing; pwd; ./bin/pCT_Preprocessing -o $outputLocation -t 1 -W $Wcalib -T $TVcorr $fileLocation;'";
			// echo "$command<br><br>";
			$runScriptOut = shell_exec($command);
			// echo "runscript: $runScriptOut<br>";

			if(strpos($runScriptOut, 'all done'))
			{
				echo "<br>$file was preprocessed sucessfully.<br>";
			}
			else
			{
				echo "Error: There was an error encounterd while preprocessing $file. Please check your parameters and try again.<br>";
			}
		}
		else
		{
			echo "The file $file is of the wrong type to be preprocessed.<br>";
		}
	}
	
	$exFile = $fileRaw[0];
	// echo "exFile: $exFile.<br>";

	$datpos = strpos($exFile, '.dat');
	// echo "datpos: $datpos<br>";
	$exFile = substr($exFile, 0, ($datpos + 4));
	// echo "exFile: $exFile.<br>";
	$findExRaw = "SELECT * FROM Raw WHERE location LIKE '%$exFile%';";
	$resultRaw = mysqli_query($db, "$findExRaw");
	if(mysqli_num_rows($resultRaw) > 0)
	{	     		
		while ($row = $resultRaw->fetch_assoc()) 
		{
			// echo "Found exFile.<br>";
			$tagEx = $row['tag'];
			$dsIDEx = $row['datasetID'];
		}
	}

	// echo "Ex dsID: $dsIDEx<br>";

	$findExMain = "SELECT * FROM Main WHERE datasetID = $dsIDEx;";
	$resultMain = mysqli_query($db, "$findExMain");
	if(mysqli_num_rows($resultMain) > 0)
	{	     		
		while ($row = $resultMain->fetch_assoc()) 
		{
			$dateEx = $row['date'];
			$sourceEx = $row['source'];
			$sourceEx = intSource($sourceEx);
			$facilityEx = $row['facilityID'];
			$facilityEx = intFacility($facilityEx);
			$phantomEx = $row['phantomID'];
			$phantomEx = intPhantom($phantomEx);
			$dataSourceEx = $row['dataSource'];
			$stepEx = $row['stepSize'];
			$energyEx = $row['energy'];
			$regionEx = $row['region'];
			$spotEx = $row['spot'];
			$beamEx = $row['beam'];
			$particleEx = $row['particle'];
			$phaseEx = $row['phase'];												
		}
	}
	echo "<table>";
	preTableHeaders();
	echo "<tr>";
	echo "<td> Preprocessed </td>";
	echo "<td> $dateEx </td>";
	echo "<td> $dataSourceEx </td>";
	echo "<td> $sourceEx </td>";
	echo "<td> $phantomEx </td>";
	echo "<td> $facilityEx </td>";
	echo "<td> projection_000 </td>";
	echo "<td> $today </td>";
	echo "<td> $outputLocation/x_0_0.txt </td>";
	echo "<td> GEANT4 </td>"; //I think the current reconstruction always uses GEANT4....
	echo "<td>  </td>";
	echo "<td> $stepEx </td>";
	echo "<td> $energyEx </td>";
	echo "<td> $tagEx </td>";
	echo "<td> $spotEx </td>";
	echo "<td> $beamEx </td>";
	echo "<td> $particleEx </td>";
	echo "<td> $phaseEx </td>";
	echo "<td> $currentUser </td>";
	echo "<td> $currentGroup </td>";
	echo "<td> $permissions </td>";
	echo "</tr>";
	echo "</table>";
}
	
if($preSize > 0)
{

	//Load in Reconstruction Parameters
	$lambda = $_GET['lambda'];
	$rsync	= $_GET['rsync'];

	//Construct pct_param file to be used by Reconstruction.
	$params = "ssh ionsvc@kodiak.baylor.edu 'cd /ion/home/ionsvc/repos/Reconstruction/pct_params; echo '\''--lambda $lambda'\'' > pct_param.dat; echo '\''--using_rsync $rsync'\'' >> pct_param.dat;'";
	//Add ability to input other parameters here.
	$paramsOut =  shell_exec($params);
	// echo "Writing Parameter File: $paramsOut<br>";

	for($count = 0;$count < $preSize; $count++ )
	{
		echo $filePre[$count];
		list($dash, $ion, $pct, $org, $phantom, $simEx, $date, $runtag, $output, $procDate, $file) = explode('/', $filePre[$count]);
		$file = basename($filePre[$count]);
		// echo "$file.<br>";
		if((strpos($file, '.bin') !== false) OR (strpos($file, '.out') !== false))
		{
			echo "Currently reconstructing $file.<br>";
			$recDate = date('y-m-d');
			$outputLocation = "/$ion/$pct/$org/$phantom/$simEx/$date/$runtag/$output/$procDate/Reconstruction/$recDate/";
			// echo "$outputLocation<br>";

			//Run Reconstruction Script.
			$command = "ssh ionsvc@kodiak.baylor.edu 'cd /ion/home/ionsvc/repos/Reconstruction; ./batch_array.sh -m false -p $filePre[$count] -s false; pwd;'";
			$parameters = "ssh ionsvc@kodiak.baylor.edu '--lambda 0.001;'";
			echo "$command<br>";
			$runScriptOut = shell_exec($command);
			$runScriptOut2 = shell_exec($parameters);
			echo "runscript: $runScriptOut<br>";
			echo "$runScriptOut2<br>";

			//Add command to create output directory.
			//Figure out how to move and rename output file. 
		}
		else
		{
			echo "The file $file is of the wrong type to be preprocessed.<br>";
		}
	}

		// 	$runResult[1] = "Reconstruction";
		// $runResult[2] = $fileToRun[2];
		// $runResult[3] = $fileToRun[3];
		// $runResult[4] = $fileToRun[4];
		// $runResult[5] = $fileToRun[5];
		// $runResult[6] = $fileToRun[6];
		// $runResult[7] = "new file name";
		// $runResult[8] = date("Ymd");
		// $runResult[9] = "new file location";
		// $runResult[10] = "Parameters";
		// $runResult[11] = "Code";
		// $runResult[12] = "Notes";
		// $runResult[13] = $fileToRun[12];
		// $runResult[14] = $fileToRun[13];
		// $runResult[15] = $fileToRun[14];
		// $runResult[16] = $fileToRun[15];
		// $runResult[17] = $fileToRun[16];
		// $runResult[18] = $fileToRun[17];
		// $runResult[19] = $fileToRun[18];
		// $runResult[20] = $_SESSION['currentUser'];
		// $runResult[21] = $_SESSION['currentGroup'];
		// $runResult[22] = "$permissions";

// 		recTableHeaders();
// 		echo "<tr>";
// 		for ($count = 1; $count <=22; $count++)
// 		{	
// 			echo "<td>" . $runResult[$count] . "</td>";
// 		}
// 		echo "</tr>";
// 	break;

// 	case 'im':

// 		$runResult[1] = "Image";
// 		$runResult[2] = date('Ymd');
// 		$runResult[3] = $fileToRun[2];
// 		$runResult[4] = $fileToRun[3];
// 		$runResult[5] = $fileToRun[4];
// 		$runResult[6] = "New File Name";
// 		$runResult[7] = $fileToRun[8];
// 		$runResult[8] = "New File Location";
// 		$runResult[9] = $fileToRun[19];
// 		$runResult[10] = $_SESSION['currentUser'];
// 		$runResult[11] = $_SESSION['currentGroup'];
// 		$runResult[12] = "$permissions";

// 		imTableHeaders();
// 		echo "<tr>";
// 		echo "<td> </td>";
// 		for ($count = 1; $count <=13; $count++)
// 		{	
// 			echo "<td>" . $runResult[$count] . "</td>";
// 		}
// 		echo "</tr>";
}
	

//Run Script based on previous selections

// echo "
// <br>
// <form method = 'get' action='searchhome.php'>
// <input type = 'submit' value = 'Upload to database'>
// </form>
// ";

// 	//connect to the database
// 	$servername = "localhost";
// 	$username = ; //username redacted
// 	$password = ; //password redacted
// 	$defaultdb = "mccarty_pct_data";
// 	$db = mysqli_connect("$servername", "$username", "$password", "$defaultdb");
	    		
// 	if (mysqli_connect_errno() OR !$db)
// 	{
// 		echo "Failed to connect to MySQL : " . mysqli_connect_error();
// 		die("Connection failed. :*( <br>");
// 	}

// 	echo "Sucessfully Connected to Database. Storing File Now.<br>";

// 	$insertFileMain = "INSERT INTO Main Values('$datasetID', '$date', '$source', '$facility', '$phantom', '$dataSource', '$step', '$energy', '$region', '$spot', '$beam', '$particle', '$phase');";

// 	$findExistingDataset = "SELECT datasetID FROM Main WHERE date = $date AND source = '$source' AND facilityID = $facility AND phantomID = $phantom AND dataSource = '$dataSource' AND stepSize = $step AND energy = $energy AND region = '$region' AND spot = $spot AND beam = '$beam' AND particle = '$particle' AND phase = $phase;";


	
// 	$existingData = mysqli_query($db, "$findGroupUser");
// 	// while($existing = $existingData->fetch_assoc())
// 	// {
// 	// 	$datasetID = $existing['datasetID'];
// 	// 	echo "$datasetID";
// 	// }	

// 	if($existingData == NULL)
// 	{
// 		$uploadMain = mysqli_query($db, "$insertFileMain");
// 		$datasetID = 0;
// 		$reconstructionID = 0;
// 		echo "Creating new dataset and uploading file.<br>";
// 	}

// 	switch($dataType)
// 	{
// 		case "Raw":
// 			$runNumber = $_SESSION['runNumber'];
// 			$runTags = $_SESSION['runTags'];
// 			$runAngle = $_SESSION['runAngle'];
// 			$insertFile = "INSERT INTO Raw VALUES('$datasetID', '$fileName', '$fileLocation', '$runNumber', '$runTags', '$runAngle', '$user', '$permissions');";
// 			echo "Uploading Raw file.<br>";
// 		break;

// 		case "Preprocessed":
// 			$processedDate = $_SESSION['processedDate'];
// 			$gt = $_SESSION['gt'];
// 			$code = $_SESSION['code'];
// 			$insertFile = "INSERT INTO Preprocessed VALUES('$datasetID','$fileName','$fileLocation', '$$processedDate', '$gt', '$code', '$user', '$permissions');";
// 			echo "Uploading Preprocessed file.<br>";
// 		break;

// 		case "Reconstruction":
// 			$processedDate = $_SESSION['processedDate'];
// 			$parameters = $_SESSION['parameters'];
// 			$code  = $_SESSION['code'];
// 			$notes = $_SESSION['notes'];
// 			$insertFile = "INSERT INTO Reconstruction VALUES('$datasetID', '$reconstructionID', '$fileName', '$fileLocation', '$code', '$processedDate', '$parameters', '$notes', '$user', '$permissions');";
// 			echo "Uploading Reconstruction file. <br>";
// 		break;

// 		case "Images":
// 			$processedDate = $_SESSION['processedDate'];
// 			$insertFile = "INSERT INTO Images VALUES('$reconstructionID', '$fileName', '$fileLocation', '$processedDate', '$user', '$permissions');";
// 			echo "Uploading Image.<br>";
// 		break;

// 		default:
// 			echo "There's been an error. Please try again.";
// 		break;
// 	}

// 	// echo "$insertFileMain";
// 	// echo "$insertFile";

// 	$uploadTable = mysqli_query($db, "$insertFile");

// 	echo "File has been uploaded.";

?>
</body>
</html>
