<html>
<body>
<h1 style="text-align:center;">Upload Verification</h1>


<?php
session_start();

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

function calTableHeaders()
{
	echo "<table border='1'>
	<tr>
	<th>Facility</th>
	<th>Calibration Date</th>
	<th>File Name</th>
	<th>File Location</th>
	<th>User</th>
	<th>Group</th>
	<th>File Permissions</th>
	</tr>";  
}

$sameDataGroup = $_GET['sameDataGroup'];
$_SESSION['sameDataGroup'] = $sameDataGroup;

$dataType = $_SESSION['uploadDataType'];
// echo "$dataType <br>";
	$fileName = $_SESSION['fileName'];
	$dataSource = $_GET['dataSource'];			
	$facility = $_GET['facility'];	
	$facilityFull = intFacility($facility);	
	$phantom = $_GET['phantom'];
	$phantomFull = intPhantom($phantom);			
	$source = $_GET['source'];
	if($source == "E")
	{
		$sourceFull = "Experimental";
	}			
	if($source == "S")
	{
		$sourceFull = "Simulated";
	}
	$date = $_GET['date'];
	if($date != NULL)
	{
	$myDateTime = DateTime::createFromFormat('Y-m-d', $date);
	$formatDate = $myDateTime->format('Ymd');			
	}
	$phase = $_GET['phase'];			
	$group = $_SESSION['currentGroup'];			
	$user = $_SESSION['currentUser'];
	$step = $_GET['step'];
	$energy = $_GET['energy'];
	$region = $_GET['region'];
	$spot = $_GET['spot'];
	$beam = $_GET['beam'];
	$particle = $_GET['particle'];
	$calibrationDate = $_GET['calibrationDate'];
	$userPermissions = $_GET['userPermissions'];
	$groupPermissions = $_GET['groupPermissions'];
	$publicPermissions = $_GET['publicPermissions'];
	$permissions = "$userPermissions" . "$groupPermissions" . "$publicPermissions";
	$fileLocation = "/home/www/uploads/$fileName";



// echo "$dataSource & $facility & $dataType & $phantom & $source & $date & $formatDate & $procDate & $phase & $phase & $group & $user & $step & $energy & $region & $spot & $beam & $particle";

	switch ($dataType) 
	{
		case 'Raw':
		$runNumber = $_GET['runNumber'];
		$runTags = $_GET['runTags'];
		$runAngle = $_GET['runAngle'];
		$_SESSION['runNumber'] = $runNumber;
		$_SESSION['runTags'] = $runTags;
		$_SESSION['runAngle'] = $runAngle;
		rawTableHeaders();
		echo "<tr>";
		echo "<td> Raw </td>";
		echo "<td> $formatDate </td>";
		echo "<td> $dataSource </td>";
		echo "<td> $sourceFull </td>";
		echo "<td> $phantomFull </td>";
		echo "<td> $facilityFull </td>";
		echo "<td> $fileName </td>";
		echo "<td> $fileLocation </td>";
		echo "<td> $runNumber </td>";
		echo "<td> $runTags </td>";
		echo "<td> $runAngle </td>";
		echo "<td> $step </td>";
		echo "<td> $energy </td>";		
		echo "<td> $region </td>";
		echo "<td> $spot </td>";	
		echo "<td> $beam </td>";
		echo "<td> $particle </td>";
		echo "<td> $phase </td>";
		echo "<td> $user </td>";	
		echo "<td> $group </td>";
		echo "<td> $permissions </td>";																							
		echo "</tr>";
		echo "<br>";

		break;
		
		case 'Preprocessed':
		$processedDate = $_GET['processedDate'];
		if($processedDate != NULL)
		{
			$myDateTime = DateTime::createFromFormat('Y-m-d', $processedDate);
			$procDate = $myDateTime->format('Ymd');	
		}
		$gt = $_GET['gt'];
		$code = $_GET['codeVersion'];
		$_SESSION['processedDate'] = $processedDate;
		$_SESSION['gt'] = $gt;
		$_SESSION['code'] = $code;
		preTableHeaders();
		echo "<tr>";
		echo "<td> Preprocessed </td>";
		echo "<td> $formatDate </td>";
		echo "<td> $dataSource </td>";
		echo "<td> $sourceFull </td>";
		echo "<td> $phantomFull </td>";
		echo "<td> $facilityFull </td>";
		echo "<td> $fileName </td>";
		echo "<td> $procDate </td>";
		echo "<td> $fileLocation </td>";
		echo "<td> $gt </td>";
		echo "<td> $code </td>";
		echo "<td> $step </td>";
		echo "<td> $energy </td>";		
		echo "<td> $region </td>";
		echo "<td> $spot </td>";	
		echo "<td> $beam </td>";
		echo "<td> $particle </td>";
		echo "<td> $phase </td>";
		echo "<td> $user </td>";	
		echo "<td> $group </td>";
		echo "<td> $permissions </td>";																							
		echo "</tr>";
		echo "<br>";		

		break;
		
		case 'Reconstruction':
		$processedDate = $_GET['processedDate'];
		if($processedDate != NULL)
		{
			$myDateTime = DateTime::createFromFormat('Y-m-d', $processedDate);
			$procDate = $myDateTime->format('Ymd');	
		}
		$parameters = $_GET['parameters'];
		$code = $_GET['codeVersion'];
		$notes = $_GET['notes'];
		$_SESSION['processedDate'] = $processedDate;
		$_SESSION['parameters'] = $parameters;
		$_SESSION['code'] = $code;
		$_SESSION['notes'] = $notes;
		recTableHeaders();
		echo "<tr>";
		echo "<td> Reconstruction </td>";
		echo "<td> $formatDate </td>";
		echo "<td> $dataSource </td>";
		echo "<td> $sourceFull </td>";
		echo "<td> $phantomFull </td>";
		echo "<td> $facilityFull </td>";
		echo "<td> $fileName </td>";
		echo "<td> $procDate </td>";
		echo "<td> $fileLocation </td>";
		echo "<td> $parameters </td>";
		echo "<td> $code </td>";
		echo "<td> $notes </td>";		
		echo "<td> $step </td>";
		echo "<td> $energy </td>";		
		echo "<td> $region </td>";
		echo "<td> $spot </td>";	
		echo "<td> $beam </td>";
		echo "<td> $particle </td>";
		echo "<td> $phase </td>";
		echo "<td> $user </td>";	
		echo "<td> $group </td>";
		echo "<td> $permissions </td>";																							
		echo "</tr>";
		echo "<br>";	

		break;

		case 'Images':
		$processedDate = $_GET['processedDate'];
		if($processedDate != NULL)
		{
			$myDateTime = DateTime::createFromFormat('Y-m-d', $processedDate);
			$procDate = $myDateTime->format('Ymd');	
		}
		$_SESSION['processedDate'] = $processedDate;
		imTableHeaders();
		echo "<tr>";
		echo "<td> Images </td>";
		echo "<td> $formatDate </td>";
		echo "<td> $sourceFull </td>";
		echo "<td> $phantomFull </td>";
		echo "<td> $facilityFull </td>";
		echo "<td> $fileName </td>";
		echo "<td> $procDate </td>";
		echo "<td> $fileLocation </td>";
		echo "<td> $phase </td>";
		echo "<td> $user </td>";	
		echo "<td> $group </td>";
		echo "<td> $permissions </td>";																							
		echo "</tr>";
		echo "<br>";

		break;

		case 'Calibration':
		// $fileLocation = "/ion/pCT_data/calibration_files/$calibrationDate";
		calTableHeaders();
		echo "<tr>";
		echo "<td> $facilityFull </td>";
		echo "<td> $calibrationDate </td>";
		echo "<td> $fileName </td>";
		echo "<td> $fileLocation </td>";
		echo "<td> $user </td>";	
		echo "<td> $group </td>";
		echo "<td> $permissions </td>";														
		echo "</tr>";
		echo "<br>";
		break;

		default:
			echo "You must select a Data Type. Please return to the previous screen and try again.";
		break;
	}

	$_SESSION['dataSource'] = $dataSource;			
	$_SESSION['facility'] = $facility;	
	$_SESSION['phantom'] = $phantom;
	$_SESSION['source'] = $source;			
	$_SESSION['date'] = $date;
	$_SESSION['phase'] = $phase;
	$_SESSION['group'] = $group;
	$_SESSION['user'] = $user;		
	$_SESSION['step'] = $step;
	$_SESSION['energy'] = $energy;
	$_SESSION['region'] = $region;
	$_SESSION['spot'] = $spot;
	$_SESSION['beam'] = $beam;
	$_SESSION['particle'] = $particle;
	$_SESSION['permissions'] = $permissions;
	$_SESSION['fileName'] = $fileName;
	$_SESSION['fileLocation'] = $fileLocation;


//Move file from uploads folder on server to correct folder on Kodiak
// $filename = $_SESSION['fileName'];
// switch ($dataType) 
// {
// 	case 'Raw':
// 		$makeFile = shell_exec('ssh mccartys@kodiak.baylor.edu; cd /ion/pCT_data/raw_data; mkdir $formatDate');
// 		$out = shell_exec('cd /home/www/uploads; scp $fileName mccartys@kodiak.baylor.edu:/ion/pCT_data/raw_data/$formatDate');
// 	break;

// 	case 'Preprocessed':
// 		$makeFile = shell_exec('ssh mccartys@kodiak.baylor.edu; cd /ion/pCT_data/preprocessed_data; mkdir $procDate');
// 		$out = shell_exec('cd /home/www/uploads; scp $fileName mccartys@kodiak.baylor.edu:/ion/pCT_data/preprocessed_data/$procDate');
// 		$procDate
// 	break;

// 	case 'Reconstruction':
// 		$makeFile = shell_exec('ssh mccartys@kodiak.baylor.edu; cd /ion/pCT_data/raw_data; mkdir $procDate');
// 		$out = shell_exec('cd /home/www/uploads; scp $fileName mccartys@kodiak.baylor.edu:/ion/pCT_data/projection_data/$procDate');
// 		$procDate
// 	break;	
	
// 	case 'Images':
// 		$makeFile = shell_exec('ssh mccartys@kodiak.baylor.edu; cd /ion/pCT_data/projection_data; mkdir $procDate');
// 		$out = shell_exec('cd /home/www/uploads; scp $fileName mccartys@kodiak.baylor.edu:/ion/pCT_data/projection_data/$procDate');
// 	break;

// 	default:
		
// 	break;
// }


?>

<form method="post" action="performupload.php">
<input type = 'submit' name = "upload" value="Confirm Data Upload">
</form>
<br>



</body>
</html>