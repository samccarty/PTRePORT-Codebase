<html>
<body>
<head>
<link rel="stylesheet" type="text/css" href="mystyle.css">
</head>

<h1 style="text-align:center;">Search Results</h1>

<br>
<hr>

<?php


session_start();

function sanitize_keyword($string)
{
  $string = preg_replace("/[^a-zA-Z0-9;]/", "", $string);
  return $string;
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

function mainTableHeaders()
{
	echo "<table border='1'>
	<tr>
	<th> Expand </th>
	<th>Date Created</th>
	<th>Data Source</th>
	<th>Sim vs Ex</th>
	<th>Phantom</th>
	<th>Facility</th>
	<th>Step Size</th>
	<th>Energy</th>
	<th>Region</th>
	<th>Spot Size</th>
	<th>Beam Type</th>
	<th>Particle Type</th>
	<th>Phase</th>
	</tr>";  
}

function rawTableHeaders()
{
	echo "<table border='1'>
	<tr>
	<th> Raw </th>
	<th>File Name</th>
	<th>File Location</th>
	<th>Run Number</th>
	<th>Run Tags</th>
	<th>Run Angle</th>
	<th>User</th>
	<th>Group</th>
	<th>File Permissions</th>
	</tr>";  
}

function preTableHeaders()
{
	echo "<table border='1'>
	<tr>
	<th> Preprocessed </th>
	<th>File Name</th>
	<th>File Location</th>
	<th>Preprocessed Date</th>
	<th>GEANT4/TOPAS</th>
	<th>Code Version Used</th>
	<th>User</th>
	<th>Group</th>
	<th>File Permissions</th>
	</tr>";  
}

function recTableHeaders()
{
	echo "<table border='1'>
	<tr>
	<th> Reconstruction </th>
	<th>File Name</th>
	<th>File Location</th>
	<th>Code Version Used</th>
	<th>Reconstruction Date</th>
	<th>Parameters</th>
	<th>Notes</th>
	<th>User</th>
	<th>Group</th>
	<th>File Permissions</th>
	</tr>";  
}

function imTableHeaders()
{
	echo "<table border='1'>
	<tr>
	<th> Images </th>
	<th>File Name</th>
	<th>File Location</th>
	<th>Reconstruction Date</th>
	<th>User</th>
	<th>Group</th>
	<th>File Permissions</th>
	</tr>";  
}

if (empty($_GET['facility']))
{
}
else 
{
	$facilityOrig = $_GET['facility'];
	$_SESSION['facilityOrig'] = $facilityOrig;
}
if (empty($_GET['dataSource']))
{
}
else 
{
	$dataSourceOrig = $_GET['dataSource'];
	$_SESSION['dataSourceOrig'] = $dataSourceOrig;
}
if (empty($_GET['phantom']))
{
}
else 
{
	$phantomOrig = $_GET['phantom'];
	$_SESSION['phantomOrig'] = $phantomOrig;
}
if (empty($_GET['source']))
{
}
else 
{
	$sourceOrig = $_GET['source'];
	$_SESSION['sourceOrig'] = $sourceOrig;
}
if (empty($_GET['dateStart']))
{
}
else 
{
	$dateStart = $_GET['dateStart'];
	$_SESSION['dateStart'] = $dateStart;

}
if (empty($_GET['dateEnd']))
{
}
else 
{
	$dateEnd = $_GET['dateEnd'];
	$_SESSION['dateEnd'] = $dateEnd;

}
if (empty($_GET['particle']))
{
}
else 
{
	$particleOrig = $_GET['particle'];
	$_SESSION['particleOrig'] = $particleOrig;
}
if (empty($_GET['energy']))
{
}
else 
{
	$energyOrig = $_GET['energy'];
	$_SESSION['energyOrig'] = $energyOrig;
}
if (empty($_GET['keyword']))
{
}
else 
{
	$keywordTemp = $_GET['keyword'];
	$keywordOrig = sanitize_keyword($keywordTemp);
	$_SESSION['keywordOrig'] = $keywordOrig;
}

// if (empty($_GET['phase']))
// {
// }
// else
// {
// 	$phaseOrig = $_GET['phase'];
// 	$_SESSION['phaseOrig'] = $phaseOrig;
// }

// echo "Keywords: Before: $keywordTemp & After: $keywordOrig<br>";


$facilityOrig = $_SESSION['facilityOrig'];
$dataSourceOrig = $_SESSION['dataSourceOrig'];
// $phaseOrig = $_SESSION['phaseOrig'];
$sourceOrig = $_SESSION['sourceOrig'];
$phantomOrig = $_SESSION['phantomOrig'];
$dateStart = $_SESSION['dateStart'];
$dateEnd = $_SESSION['dateEnd'];
$particleOrig = $_SESSION['particleOrig'];
$energyOrig = $_SESSION['energyOrig'];
$keywordOrig = $_SESSION['keywordOrig'];

// echo "The search parameters are $facilityOrig & $dataSourceOrig & $phaseOrig & $sourceOrig & $phantomOrig & $dateStart & $dateEnd";

if($dateStart != NULL)
{
	$myDateTime = DateTime::createFromFormat('Y-m-d', $dateStart);
	$formatDateStart = $myDateTime->format('Ymd');
}
if($dateEnd != NULL)
{
	$myDateTime = DateTime::createFromFormat('Y-m-d', $dateEnd);
	$formatDateEnd = $myDateTime->format('Ymd');
}

//Check to see if we need to perform keyword searches of the results
$keywordCheck = 0;

if(($keywordOrig != NULL) AND ($keywordOrig != ' '))
{
	$keywordCheck = 1;
}

// echo "keywordCheck: $keywordCheck<br>";
// echo "Keyword: $keywordOrig<br>";

$keywords = explode (';', $keywordOrig);
$numKeywords = sizeof($keywords);
$_SESSION['numKeywords'] = $numKeywords;
// echo "There are $numKeywords keywords.<br>";
// print_r($keywords);


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


//Create query string associated with given choices. 
$findMain = "SELECT * FROM Main WHERE ";

if($facilityOrig != " ")
{
	$findMain .= " facilityID = $facilityOrig ";
}
if($facilityOrig != " " AND ($dataSourceOrig != " " OR $phaseOrig != " " OR $sourceOrig != " " OR $phantomOrig != " " OR $particleOrig != ' ' OR $energyOrig != ' ' OR $dateStart != NULL OR $dateEnd != NULL))
{
	$findMain .= " AND ";
}
if($dataSourceOrig != " ")
{
	$findMain .= " dataSource = '$dataSourceOrig' ";
}
if($dataSourceOrig != " " AND ($phaseOrig != " " OR $sourceOrig != " " OR $phantomOrig != " " OR $particleOrig != ' ' OR $energyOrig != ' ' OR $dateStart != NULL OR $dateEnd != NULL))
{
	$findMain .= " AND ";
}
// if($phaseOrig != " ")
// {
// 	$findMain .= " phase = $phaseOrig ";
// }
// if($phaseOrig != " " AND ($sourceOrig != " " OR $phantomOrig != " " OR $dateStart != NULL OR $dateEnd != NULL))
// {
// 	$findMain .= " AND ";
// }
if($sourceOrig != " ")
{
	$findMain .= " source = '$sourceOrig' ";
}
if($sourceOrig != " " AND ($phantomOrig != " " OR $particleOrig != ' ' OR $energyOrig != ' ' OR $dateStart != NULL OR $dateEnd != NULL))
{
	$findMain .= " AND ";
}
if($phantomOrig != " ")
{
	$findMain .= " phantomID = $phantomOrig ";
}
if($phantomOrig != " " AND ($particleOrig != ' ' OR $energyOrig != ' ' OR $dateStart != NULL OR $dateEnd != NULL))
{
	$findMain .= " AND ";
}
if($particleOrig != " ")
{
	$findMain .= " particle = '$particleOrig' ";
}
if($particleOrig != " " AND ($energyOrig != " " OR $dateStart != NULL OR $dateEnd != NULL))
{
	$findMain .= " AND ";
}
if($energyOrig != " ")
{
	$findMain .= " energy = '$energyOrig' ";
}
if($energyOrig != " " AND ($dateStart != NULL OR $dateEnd != NULL))
{
	$findMain .= " AND ";
}
if($dateStart != NULL and $dateEnd != NULL)
{
	$findMain .= " date BETWEEN $formatDateStart AND $formatDateEnd";
}
if ($dateStart != NULL AND $dateEnd == NULL)
{
	$findMain .= " date >= $formatDateStart ";
}
if ($dateStart == NULL AND $dateEnd != NULL)
{
	$findMain .= " date <= $formatDateEnd ";
}
$findMain .= ";";

// echo "$findMain";

$resultMain = mysqli_query($db, "$findMain");

$dsCount = 0;

//find data that matches datasetID
if(mysqli_num_rows($resultMain) > 0)
{	     		
	while ($row = $resultMain->fetch_assoc()) 
	{
		// echo $row['datasetID']."<br>";
		$dsID = $row['datasetID'];
		$_SESSION['dsID'][$dsCount] = $dsID;

		// echo "dsIDs used:" . $_SESSION['dsID'][$dsCount];

		$dsCount = $dsCount + 1;

		$rawCheck = "raw$dsID";
		$preCheck = "pre$dsID";
		$recCheck = "rec$dsID";
		$imCheck = "im$dsID";

		if($keywordCheck == 1)
		{	
			for($count = 0; $count < $numKeywords; $count++)
			{
				$keywordOrig = $keywords[$count];
				// echo "$keywordOrig<br>";
				// echo "Checking for Keywords<br>";
				$findRaw = "SELECT * FROM Raw WHERE datasetID = $dsID AND (name LIKE '%$keywordOrig%' OR location LIKE '%$keywordOrig%' OR run LIKE '%$keywordOrig%' OR tags LIKE '%$keywordOrig%' OR angle LIKE '%$keywordOrig%');";
				// echo "$findRaw<br>";
				$rawMatch = mysqli_query($db, "$findRaw");
				$numRaw = mysqli_num_rows($rawMatch);
				// $finalNumRaw = $finalNumRaw + $numRaw;
				// $num = "numRaw$dsID";
				$num = $count . "numRaw$dsID";
				// echo "$num = $numRaw<br>";
				$_SESSION[$num] = $numRaw;

				$findPre = "SELECT * FROM Preprocessed WHERE datasetID = $dsID AND (name LIKE '%$keywordOrig%' OR location LIKE '%$keywordOrig%' OR gt LIKE '%$keywordOrig%' OR code_version LIKE '%$keywordOrig%');";
				// echo "$findPre<br>";
				$preMatch = mysqli_query($db, "$findPre");
				$numPre = mysqli_num_rows($preMatch);
				// $finalNumPre = $finalNumPre + $numPre;
				// $num = "numPre$dsID";
				$num = $count . "numPre$dsID";
				// echo "$num = $numPre<br>";
				$_SESSION[$num] = $numPre;

				$findRec = "SELECT * FROM Reconstruction WHERE datasetID = $dsID AND (name LIKE '%$keywordOrig%' OR location LIKE '%$keywordOrig%' OR code_version LIKE '%$keywordOrig%' OR parameters LIKE '%$keywordOrig%' OR notes LIKE '%$keywordOrig%');";
				// echo "$findRec<br>";
				$recMatch = mysqli_query($db, "$findRec");
				$numRec = mysqli_num_rows($recMatch);

				while($recon = $recMatch->fetch_assoc())
				{
					$reconID = $recon['reconstructionID'];
					$findIm = "SELECT * FROM Images WHERE reconstructionID = $reconID AND (name LIKE '%$keywordOrig%' AND location LIKE '%$keywordOrig%');";
					// echo "$findIm<br>";
					$imMatch = mysqli_query($db, "$findIm");
					$numIm = mysqli_num_rows($imMatch);
				}
				if(($numRaw > 0) OR ($numPre > 0) OR ($numRec > 0) OR ($numIm > 0))
				{
					mainTableHeaders();

					$date = $row['date'];
					$datasource = $row['datasource'];
					$source = $row['source'];
					$phantom = $row['phantomID'];
					$facility = $row['facilityID'];
					$step = $row['stepSize'];
					$energy = $row['energy'];
					$region = $row['region'];
					$spot = $row['spot'];
					$beam = $row['beam'];
					$particle = $row['particle'];
					$phase = $row['phase'];

					$phantom = intPhantom($phantom);
					$facility = intFacility($facility);
					$source = intSource($source);

						
					echo "<tr>
					<td> </td>
					<td>$date</td>
					<td>$datasource</td>
					<td>$source</td>
					<td>$phantom</td>
					<td>$facility</td>
					<td>$step</td>
					<td>$energy</td>
					<td>$region</td>
					<td>$spot</td>
					<td>$beam</td>
					<td>$particle</td>
					<td>$phase</td>
					</tr>"; 

					//Check to see if raw files are expanded
					if(isset($_GET[$rawCheck]) AND $numRaw > 0)
					{
						rawTableHeaders();
						echo "<form method='get' action='runfile2.php'><input type = 'submit' value ='Preprocess'>";
						$rawCount = 0;
						sort($rawMatch);
						echo "<br>Raw Match : <br>";
						print_r($rawMatch);
						while($rawRow = $rawMatch->fetch_assoc())
						{	

							$user = $rawRow['user'];
							$findGroup = "SELECT username, grp FROM Users WHERE userID = '$user' OR username = '$user';";
							$groupInfo = mysqli_query($db, "$findGroup");
							while($userInfo = $groupInfo->fetch_assoc())
							{
								$rawFileGroup = $userInfo['grp'];
								$rawFileUser = $userInfo['username'];
							}
							$rawCount = $rawCount + 1;
							echo "<tr>";
							echo "<td><input type = 'checkbox' name = 'rawbox$rawCount' value = '$dsID/" .  $rawRow['location'] . "'/></td>";
							echo "<td>" . $rawRow['name'] . "</td>";
							echo "<td>" . $rawRow['location'] . "</td>";
							echo "<td>" . $rawRow['run'] . "</td>";
							echo "<td>" . $rawRow['tags'] . "</td>";
							echo "<td>" . $rawRow['angle'] . "</td>";
							echo "<td> $rawFileUser </td>";
							echo "<td> $rawFileGroup </td>";
							echo "<td>" . $rawRow['permissions'] . "</td>";
							echo "</tr>";

						}

						echo "</form>";
					}
					//If not expanded, show number of files and expand option.
					else
					{
						echo "<tr>
						<td><form method='get' action='runfile2.php'> <input type = 'checkbox' name = 'rawbox' value = 'folderRaw/$dsID/$numRaw'/><input type = 'submit' value ='Preprocess'></form></td>
						<td> Raw </td>
						<td> $numRaw </td>
						<td><form method='get' action='datasearch2.php'><input type='checkbox' name='raw$dsID' value='raw$dsID'/><input type='submit' value='Expand'/></form></td>
						</tr>";
					}

					if(isset($_GET[$preCheck]) AND $numPre > 0)
					{
						preTableHeaders();
						echo "<form method='get' action='runfile2.php'><input type = 'submit' value ='Reconstruct'>";
						$preCount = 0;
						while($preRow = $preMatch->fetch_assoc())
						{
							$user = $preRow['user'];
							$findGroup = "SELECT username, grp FROM Users WHERE userID = '$user' OR username = '$user';";
							$groupInfo = mysqli_query($db, "$findGroup");
							while($userInfo = $groupInfo->fetch_assoc())
							{
								$preFileGroup = $userInfo['grp'];
								$preFileUser = $userInfo['username'];
							}
							$preCount =  $preCount + 1;
							echo "<tr>";
							echo "<td><input type = 'checkbox' name = 'prebox$preCount' value = '$dsID/" .  $preRow['location'] . "'/></td>";
							echo "<td>" . $preRow['name'] . "</td>";
							echo "<td>" . $preRow['location'] . "</td>";
							echo "<td>" . $preRow['date'] . "</td>";
							echo "<td>" . $preRow['gt'] . "</td>";
							echo "<td>" . $preRow['code_version'] . "</td>";
							echo "<td> $preFileUser </td>";
							echo "<td> $preFileGroup </td>";
							echo "<td>" . $preRow['permissions'] . "</td>";
							echo "</tr>";
						}

						echo "</form>";
					}
					else
					{
						echo "<tr>
						<td><form method='get' action='runfile2.php'> <input type = 'checkbox' name = 'prebox' value = 'folderPre/$dsID/$numPre'/><input type = 'submit' value ='Reconstruct'></form></td>
						<td> Preprocessed </td>
						<td> $numPre </td>
						<td><form method='get' action='datasearch2.php'><input type='checkbox' name='pre$dsID' value='pre$dsID'/><input type='submit' value='Expand'/></form></td>
						</tr>";
					}

					if(isset($_GET[$recCheck]) AND $numRec > 0)
					{
						$findRec = "SELECT * FROM Reconstruction WHERE datasetID = $dsID;";
						$recMatch = mysqli_query($db, "$findRec");
						
						recTableHeaders();
						while($recRow = $recMatch->fetch_assoc())
						{
							$user = $recRow['user'];
							$findGroup = "SELECT username, grp FROM Users WHERE userID = '$user' OR username = '$user';";
							$groupInfo = mysqli_query($db, "$findGroup");
							while($userInfo = $groupInfo->fetch_assoc())
							{
								$recFileGroup = $userInfo['grp'];
								$recFileUser = $userInfo['username'];
							}

							echo "<tr>";
							echo "<td></td>";
							echo "<td>" . $recRow['name'] . "</td>";
							echo "<td>" . $recRow['location'] . "</td>";
							echo "<td>" . $recRow['date'] . "</td>";
							echo "<td>" . $recRow['code_version'] . "</td>";
							echo "<td>" . $recRow['parameters'] . "</td>";
							echo "<td>" . $recRow['notes'] . "</td>";
							echo "<td> $recFileUser </td>";
							echo "<td> $recFileGroup </td>";
							echo "<td>" . $recRow['permissions'] . "</td>";
							echo "</tr>";
						}
					}
					else
					{
						echo "<tr>
						<td> </td>
						<td> Reconstruction </td>
						<td> $numRec </td>
						<td><form method='get' action='datasearch2.php'><input type='checkbox' name='rec$dsID' value='rec$dsID'/><input type='submit' value='Expand'/></form></td>
						</tr>";
					}

					if(isset($_GET[$imCheck]) AND $numIm > 0)
					{
						$findIm = "SELECT * FROM Images WHERE reconstructionID = $reconID;";
						$imMatch = mysqli_query($db, "$findIm");

						imTableHeaders();
						while($imRow = $imMatch->fetch_assoc())
						{	
							$user = $imRow['user'];
							$findGroup = "SELECT username, grp FROM Users WHERE userID = '$user' OR username = '$user';";
							$groupInfo = mysqli_query($db, "$findGroup");
							while($userInfo = $groupInfo->fetch_assoc())
							{
								$imFileGroup = $userInfo['grp'];
								$imFileUser = $userInfo['username'];
							}
							echo "<tr>";
							echo "<input type = 'checkbox' name = 'imbox' value = '" . $imRow['name'] . "/>";
							echo "<td>" . $imRow['name'] . "</td>";
							echo "<td>" . $imRow['location'] . "</td>";
							echo "<td>" . $imRow['date'] . "</td>";
							echo "<td> $imFileUser </td>";
							echo "<td> $imFileGroup </td>";
							echo "<td>" . $recRow['permissions'] . "</td>";
							echo "</tr>";
						}
					}
					else
					{
						echo "<tr>
						<td> </td>
						<td> Images </td>
						<td> $numIm </td>
						<td><form method='get' action='datasearch2.php'><input type='checkbox' name='im$dsID' value='im$dsID'/><input type='submit' value='Expand'/></form></td>
						</tr>";
						echo "<br>";	
					}		
				}
			}	
		}
		else
		{
			// echo "Not checking for keywords.<br>";
			$findRaw = "SELECT * FROM Raw WHERE datasetID = $dsID;";
			$rawMatch = mysqli_query($db, "$findRaw");
			$numRaw = mysqli_num_rows($rawMatch);
			$num = "0numRaw$dsID";
			$_SESSION[$num] = $numRaw;

			$findPre = "SELECT * FROM Preprocessed WHERE datasetID = $dsID;";
			$preMatch = mysqli_query($db, "$findPre");
			$numPre = mysqli_num_rows($preMatch);
			$num = "0numPre$dsID";
			$_SESSION[$num] = $numPre;

			$findRec = "SELECT * FROM Reconstruction WHERE datasetID = $dsID;";
			$recMatch = mysqli_query($db, "$findRec");
			$numRec = mysqli_num_rows($recMatch);

			while($recon = $recMatch->fetch_assoc())
			{
				$reconID = $recon['reconstructionID'];
				$findIm = "SELECT * FROM Images WHERE reconstructionID = $reconID;";
				$imMatch = mysqli_query($db, "$findIm");
				$numIm = mysqli_num_rows($imMatch);
			}
			if(($numRaw > 0) OR ($numPre > 0) OR ($numRec > 0) OR ($numIm > 0))
			{
				mainTableHeaders();

				$date = $row['date'];
				$datasource = $row['datasource'];
				$source = $row['source'];
				$phantom = $row['phantomID'];
				$facility = $row['facilityID'];
				$step = $row['stepSize'];
				$energy = $row['energy'];
				$region = $row['region'];
				$spot = $row['spot'];
				$beam = $row['beam'];
				$particle = $row['particle'];
				$phase = $row['phase'];

				$phantom = intPhantom($phantom);
				$facility = intFacility($facility);
				$source = intSource($source);

					
				echo "<tr>
				<td> </td>
				<td>$date</td>
				<td>$datasource</td>
				<td>$source</td>
				<td>$phantom</td>
				<td>$facility</td>
				<td>$step</td>
				<td>$energy</td>
				<td>$region</td>
				<td>$spot</td>
				<td>$beam</td>
				<td>$particle</td>
				<td>$phase</td>
				</tr>"; 

				//Check to see if raw files are expanded
				if(isset($_GET[$rawCheck]) AND $numRaw > 0)
				{
					rawTableHeaders();
					echo "<form method='get' action='runfile2.php'><input type = 'submit' value ='Preprocess'>";
					$rawCount = 0;
					while($rawRow = $rawMatch->fetch_assoc())
					{	
						$rawCount = $rawCount + 1;
						$user = $rawRow['user'];
						$findGroup = "SELECT username, grp FROM Users WHERE userID = '$user' OR username = '$user';";
						$groupInfo = mysqli_query($db, "$findGroup");
						while($userInfo = $groupInfo->fetch_assoc())
						{
							$rawFileGroup = $userInfo['grp'];
							$rawFileUser = $userInfo['username'];
						}

						echo "<tr>";
						echo "<td><input type = 'checkbox' name = 'rawbox$rawCount' value = '$dsID/" .  $rawRow['location'] . "'/></td>";
						echo "<td>" . $rawRow['name'] . "</td>";
						echo "<td>" . $rawRow['location'] . "</td>";
						echo "<td>" . $rawRow['run'] . "</td>";
						echo "<td>" . $rawRow['tags'] . "</td>";
						echo "<td>" . $rawRow['angle'] . "</td>";
						echo "<td> $rawFileUser </td>";
						echo "<td> $rawFileGroup </td>";
						echo "<td>" . $rawRow['permissions'] . "</td>";
						echo "</tr>";

					}

					echo "</form>";
				}
				//If not expanded, show number of files and expand option.
				else
				{
					echo "<tr>
					<td><form method='get' action='runfile2.php'> <input type = 'checkbox' name = 'rawbox' value = 'folderRaw/$dsID'/><input type = 'submit' value ='Preprocess'></form></td>
					<td> Raw </td>
					<td> $numRaw </td>
					<td><form method='get' action='datasearch2.php'><input type='checkbox' name='raw$dsID' value='raw$dsID'/><input type='submit' value='Expand'/></form></td>
					</tr>";
				}

				if(isset($_GET[$preCheck]) AND $numPre > 0)
				{
					preTableHeaders();
					echo "<form method='get' action='runfile2.php'><input type = 'submit' value ='Reconstruct'>";
					$preCount = 0;
					while($preRow = $preMatch->fetch_assoc())
					{
						$user = $preRow['user'];
						$findGroup = "SELECT username, grp FROM Users WHERE userID = '$user' OR username = '$user';";
						$groupInfo = mysqli_query($db, "$findGroup");
						while($userInfo = $groupInfo->fetch_assoc())
						{
							$preFileGroup = $userInfo['grp'];
							$preFileUser = $userInfo['username'];
						}
						$preCount =  $preCount + 1;
						echo "<tr>";
						echo "<td><input type = 'checkbox' name = 'prebox$preCount' value = '$dsID/" .  $preRow['location'] . "'/></td>";
						echo "<td>" . $preRow['name'] . "</td>";
						echo "<td>" . $preRow['location'] . "</td>";
						echo "<td>" . $preRow['date'] . "</td>";
						echo "<td>" . $preRow['gt'] . "</td>";
						echo "<td>" . $preRow['code_version'] . "</td>";
						echo "<td> $preFileUser </td>";
						echo "<td> $preFileGroup </td>";
						echo "<td>" . $preRow['permissions'] . "</td>";
						echo "</tr>";
					}

					echo "</form>";
				}
				else
				{
					echo "<tr>
					<td><form method='get' action='runfile2.php'> <input type = 'checkbox' name = 'prebox' value = 'folderPre/$dsID'/><input type = 'submit' value ='Reconstruct'></form></td>
					<td> Preprocessed </td>
					<td> $numPre </td>
					<td><form method='get' action='datasearch2.php'><input type='checkbox' name='pre$dsID' value='pre$dsID'/><input type='submit' value='Expand'/></form></td>
					</tr>";
				}

				if(isset($_GET[$recCheck]) AND $numRec > 0)
				{
					$findRec = "SELECT * FROM Reconstruction WHERE datasetID = $dsID;";
					$recMatch = mysqli_query($db, "$findRec");
					
					recTableHeaders();
					while($recRow = $recMatch->fetch_assoc())
					{
						$user = $recRow['user'];
						$findGroup = "SELECT username, grp FROM Users WHERE userID = '$user' OR username = '$user';";
						$groupInfo = mysqli_query($db, "$findGroup");
						while($userInfo = $groupInfo->fetch_assoc())
						{
							$recFileGroup = $userInfo['grp'];
							$recFileUser = $userInfo['username'];
						}

						echo "<tr>";
						echo "<td></td>";
						echo "<td>" . $recRow['name'] . "</td>";
						echo "<td>" . $recRow['location'] . "</td>";
						echo "<td>" . $recRow['date'] . "</td>";
						echo "<td>" . $recRow['code_version'] . "</td>";
						echo "<td>" . $recRow['parameters'] . "</td>";
						echo "<td>" . $recRow['notes'] . "</td>";
						echo "<td> $recFileUser </td>";
						echo "<td> $recFileGroup </td>";
						echo "<td>" . $recRow['permissions'] . "</td>";
						echo "</tr>";
					}
				}
				else
				{
					echo "<tr>
					<td> </td>
					<td> Reconstruction </td>
					<td> $numRec </td>
					<td><form method='get' action='datasearch2.php'><input type='checkbox' name='rec$dsID' value='rec$dsID'/><input type='submit' value='Expand'/></form></td>
					</tr>";
				}

				if(isset($_GET[$imCheck]) AND $numIm > 0)
				{
					$findIm = "SELECT * FROM Images WHERE reconstructionID = $reconID;";
					$imMatch = mysqli_query($db, "$findIm");

					imTableHeaders();
					while($imRow = $imMatch->fetch_assoc())
					{	
						$user = $imRow['user'];
						$findGroup = "SELECT username, grp FROM Users WHERE userID = '$user' OR username = '$user';";
						$groupInfo = mysqli_query($db, "$findGroup");
						while($userInfo = $groupInfo->fetch_assoc())
						{
							$imFileGroup = $userInfo['grp'];
							$imFileUser = $userInfo['username'];
						}
						echo "<tr>";
						echo "<input type = 'checkbox' name = 'imbox' value = '" . $imRow['name'] . "/>";
						echo "<td>" . $imRow['name'] . "</td>";
						echo "<td>" . $imRow['location'] . "</td>";
						echo "<td>" . $imRow['date'] . "</td>";
						echo "<td> $imFileUser </td>";
						echo "<td> $imFileGroup </td>";
						echo "<td>" . $recRow['permissions'] . "</td>";
						echo "</tr>";
					}
				}
				else
				{
					echo "<tr>
					<td> </td>
					<td> Images </td>
					<td> $numIm </td>
					<td><form method='get' action='datasearch2.php'><input type='checkbox' name='im$dsID' value='im$dsID'/><input type='submit' value='Expand'/></form></td>
					</tr>";
					echo "<br>";	
				}			
			}
		}
	}
}
else
{
	echo "<br>No results found matching these criteria. Please search again with different criteria.<br>";
}

// echo "dsCount: $dsCount";
$_SESSION['dsCount'] = $dsCount;

// echo "numRaw: $numRaw<br>";
// echo "numPre: $numPre<br>";

// echo "finalNumRaw: $finalNumRaw<br>";
// echo "finalNumPre: $finalNumPre<br>";
?>

</body>
</html>