<html>
<body>

<h1 style="text-align:center;">Process Files</h1>

<?php

function calibTableHeaders()
{
	echo "<table border='1'>
	<tr>
	<th> Select </th>
	<th> Name </th>		
	<th> Location </th>
	<th> Date Created </th>
	<th> Facility </th>
	</tr>";  
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

session_start();

$_SESSION['fileRaw'] = NULL;
$_SESSION['filePre'] = NULL;

$rawCount = 0;
$preCount = 0;

$numRaw = array(array());
$numPre = array(array());

$dsCount = $_SESSION['dsCount'];
$numKeywords = $_SESSION['numKeywords'];
// echo "dsCount =  $dsCount<br>";
$dsID = array();

for($keyCount = 0; $keyCount < $numKeywords; $keyCount++)
{	
	for($count = 0; $count < $dsCount; $count++)
	{
		$dsID[$count] = $_SESSION['dsID'][$count];
		$num1 = $keyCount . 'numRaw' . $_SESSION['dsID'][$count];
		$num2 = $keyCount . 'numPre' . $_SESSION['dsID'][$count];
		// echo "num1: $num1 & num2: $num2 <br>";
		$numRawTemp = $_SESSION[$num1];
		$numPreTemp = $_SESSION[$num2];
		// echo "$numRawTemp & $numPreTemp<br>";
		$numRaw[$keyCount][$count] = $numRawTemp;
		$numPre[$keyCount][$count] = $numPreTemp;
	}
}

// print_r($numRaw);
// print_r($numPre);

// echo "<br>DatasetIDs: ";
// print_r($dsID);
// echo "<br>NumRaw: ";
// print_r($numRaw);
// echo "<br>NumPre: ";
// print_r($numPre);

$fileRaw = array();
$filePre = array();

$folderTestRaw = $_GET['rawbox'];
$folderRaw = substr($folderTestRaw, 0, 6);
$folderTestPre = $_GET['prebox'];
$folderPre = substr($folderTestPre, 0, 6);

$count = 1;
$rawCheck = "rawbox1";

// echo "Value: " . isset($_GET[$rawCheck]) . "<br>";

while($_GET[$rawCheck] == 0 AND $count < 100) 
{
	$rawCheck = "rawbox$count";
	$count = $count + 1;
	// echo "$rawCheck<br>";
}

$count = 1;
$preCheck = "prebox1";

while ($_GET[$preCheck] == 0 AND $count < 100) 
{
	$preCheck = "prebox$count";
	$count  = $count + 1;
	// echo "$preCheck<br>";	
}

$tempRaw = $_GET[$rawCheck];
$tempPre = $_GET[$preCheck];
// echo "$tempRaw and $tempPre<br>";
list($dsIDRaw,$fileTempRaw,$numRawSelected) = explode('/', $tempRaw);
list($dsIDPre,$fileTempPre,$numPreSelected) = explode('/', $tempPre);

// echo "numRawSelected: $numRawSelected & numPreSelected: $numPreSelected<br>";

// echo "folderRaw: $folderRaw & folderPre: $folderPre<br>";

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

//If an entire folder was selected, read all associated file into $fileRaw and $filePre
if($folderRaw == "folder")
{
	// echo "<br>You selected to Preprocess an entire Raw folder.<br>";
	list($folderRaw, $dsIDSelected) = explode('/', $folderTestRaw);
	// echo "Data Set: $dsIDSelected<br>";
	$_SESSION['dsIDSelected'] = $dsIDSelected;
	$findRaw = "SELECT location FROM Raw WHERE datasetID = $dsIDSelected;";
	$resultRaw = mysqli_query($db, "$findRaw");
	if(mysqli_num_rows($resultRaw) > 0)
	{	     		
		$rawSize = 0;
		while ($row = $resultRaw->fetch_assoc()) 
		{
			$fileRaw[$rawSize] = $row['location'];
			$rawSize = $rawSize + 1;
		}
	}

}
elseif($folderPre == "folder")
{
	// echo "<br>You selected to Reconstruct an entire Preprocessed Folder.<br>";
	list($folderPre, $dsIDSelected) = explode('/', $folderTestPre);
	// echo "Data Set: $dsIDSelected<br>";
	$_SESSION['dsIDSelected'] = $dsIDSelected;
	$findPre = "SELECT location FROM Preprocessed WHERE datasetID = $dsIDSelected;";
	$resultPre = mysqli_query($db, "$findPre");
	if(mysqli_num_rows($resultPre) > 0)
	{	     		
		$preSize = 0;
		while ($row = $resultPre->fetch_assoc()) 
		{
			$filePre[$preSize] = $row['location'];
			$preSize = $preSize + 1;
		}
	}
}
//If an entire folder was not selected, find only the selected files. 
else
{
	//Retrieve the number of datafiles associated with the selected datasetID from the arrays $numRaw and $numPre.
	$numRawSelected = 0;
	$numPreSelected = 0;

	for($keyCount = 0; $keyCount < $numKeywords; $keyCount++)
	{
		for($count = 0; $count < $dsCount; $count++)
		{	
			if($dsID[$count] == $dsIDRaw)
			{
				$numRawSelected = $numRaw[$keyCount][$count];
				// echo "numRawSelected: $numRawSelected<br>";
			}
			elseif($dsID[$count] == $dsIDPre)
			{
				$numPreSelected = $numPre[$keyCount][$count];
				// echo "numPreSelected: $numPreSelected<br>";
			}
		}

		//Read through a number of files equal to the number possible. If there is a non-null value associated, read file name into an array $fileRaw or $filePre
		for($count = 0; $count <= $numRawSelected; $count++)
		{	
			$rawCheck = "rawbox$count";
			// echo "rawCheck: $rawCheck<br>";
			if (empty($_GET[$rawCheck]))
			{
			}
			else 
			{
				$temp = $_GET[$rawCheck];
				$fileTemp = strstr($temp, '/ion/');
				$fileRaw[$rawCount] = $fileTemp;
				$_SESSION['fileRaw'][$rawCount] = $fileTemp;
				$rawCount = $rawCount + 1;
			}
		}
		// echo "Raw Array: ";
		// print_r($_SESSION['fileRaw']);

		for($count = 0; $count <= $numPreSelected; $count++)
		{	
			$preCheck = "prebox$count";
			// echo "preCheck: $preCheck<br>";
			if (empty($_GET[$preCheck]))
			{
			}
			else 
			{
				$temp = $_GET[$preCheck];
				$fileTemp = strstr($temp, '/ion/');
				$filePre[$preCount] = $fileTemp;
				$_SESSION['filePre'][$preCount] = $fileTemp;
				$preCount = $preCount + 1;
			}
		}
		// echo "Pre Array: ";
		// print_r($_SESSION['filePre']);
	}
	// echo "$preCount & $rawCount<br>";
}
	
	//Determine number of results and store in SESSION variable. 
	$rawSize = sizeof($fileRaw);
	$_SESSION['rawSize'] = $rawSize;
	// echo "$rawSize<br>";
	$preSize = sizeof($filePre);
	$_SESSION['preSize'] = $preSize;
	// echo "$preSize<br>";
	$_SESSION['rawCount'] = $rawCount;
	$_SESSION['preCount'] = $preCount;

	//If no files are found, return error.
	if($rawSize == 0 AND $preSize == 0)
	{
		echo "Please select a file.<br>";
	}

	// print_r($fileRaw);
	// print_r($filePre);

	//If Raw files were selected, display Preprocessing options. 
	if($rawSize > 0)
	{
		echo "You have chosen to preprocess $rawSize raw file(s).<br>";
		echo "<form method='get' action='runresult2.php'>
			
		<input type = 'submit' value = 'Run'>
		<input type = 'reset'>

		<p>
		File Permissions for You:
		<select name = 'userPer'>
			<option value = 'r--' >Read Only</option>
			<option value = 'rw-' >Read and Write</option>
			<option value = 'rwx' >Read, Write, and Execute</option>
		</select>
		</p>	

		<p>
		File Permissions for Your Group:
		<select name = 'groupPer'>
			<option value = 'r--' >Read Only</option>
			<option value = 'rw-' >Read and Write</option>
			<option value = 'rwx' >Read, Write, and Execute</option>
		</select>
		</p>	

		File Permissions for Everyone Else:
		<select name = 'publicPer'>
			<option value = 'r--' >Read Only</option>
			<option value = 'rw-' >Read and Write</option>
			<option value = 'rwx' >Read, Write, and Execute</option>
		</select>
		</p>
		";



		//Find correct Calibration File.
		$fileTest = $fileRaw[0];
		//This Helium method will have to be altered once a better organization system can be agreed upon. 
		if(strpos($fileTest, 'He') !== false)
		{
			$date = '10032016';
			$findCalib = "SELECT * FROM Calibration WHERE name LIKE '%He%' ORDER BY DATEDIFF(date, '$date') LIMIT 8;";
		}
		else
		{
			// echo "Test File: $fileTest<br>";
			list($dash, $ion, $pct, $org, $phantom, $simEx, $date, $runtag, $input, $file) = explode('/', $fileTest);
					// echo "Collection Date: $date<br>";
			$findCalib = "SELECT * FROM Calibration ORDER BY DATEDIFF(date, '$date') LIMIT 8;";
		}

		// echo "Search: $findCalib<br>";
		$resultCalib = mysqli_query($db, "$findCalib");
		// echo "Number of Results: " . mysqli_num_rows($resultCalib);
		if(mysqli_num_rows($resultCalib) > 0)
		{	     		
			echo "<table>";
			calibTableHeaders();
			echo "The closest Calibration Files Available are the following. Make sure these are acceptable before continuing.<br>";

			$calibCount = 0;
			while ($closestCalib = $resultCalib->fetch_assoc()) 
			{
				$calib = $closestCalib['name'];
				$calibLocation = $closestCalib['location'];
				$calibDate = $closestCalib['date'];
				$calibFacility = $closestCalib['facilityID'];
				$calibFacility = intFacility($calibFacility);

				echo "<tr>";
				echo "<td> <input type='checkbox' name='calib$calibCount' value='$calibLocation' > </td>";					
				echo "<td> $calib </td>";
				echo "<td> $calibLocation </td>";
				echo "<td> $calibDate </td>";
				echo "<td> $calibFacility </td>";				
				echo "</tr>";

				$calibCount = $calibCount + 1;
			}

			echo "</table>";
		}

		echo "
	 	</form>
	 	<hr>";

	}
	//If Preprocessed Files were selected, display Reconstruction options.
	if($preSize > 0)
	{
		echo "You have chosen to reconstruct $preSize preprocessed file(s).<br>";
		 	echo "<form method='get' action='runresult2.php'>
			
			<input type = 'submit' value = 'Run'>			 	
			<input type = 'reset'>

			<p>
			Enter a lambda value:
			<input type='number' min='0' max='1' step='0.0001' name = 'lambda' required>
			</p>

			<p>
			Use rsync?
			<select name = 'rsync'>
				<option value = 'false' >No</option>
				<option value = 'true' >Yes</option>
			</select>
			</p>	

			<p>
			File Permissions for You:
			<select name = 'userPer'>
				<option value = 'r--' >Read Only</option>
				<option value = 'rw-' >Read and Write</option>
				<option value = 'rwx' >Read, Write, and Execute</option>
			</select>
			</p>	

			<p>
			File Permissions for Your Group:
			<select name = 'groupPer'>
				<option value = 'r--' >Read Only</option>
				<option value = 'rw-' >Read and Write</option>
				<option value = 'rwx' >Read, Write, and Execute</option>
			</select>
			</p>	

			File Permissions for Everyone Else:
			<select name = 'publicPer'>
				<option value = 'r--' >Read Only</option>
				<option value = 'rw-' >Read and Write</option>
				<option value = 'rwx' >Read, Write, and Execute</option>
			</select>
			</p>		


		 	</form>
		 	<hr>";
	}

$numRaw = sizeof($fileRaw);
$numPre = sizeof($filePre);

for($count = 0; $count < $numRaw; $count ++)
{
	$temp = $fileRaw[$count];
	$_SESSION['fileRaw'][$count] = $temp;
}
for($count = 0; $count < $numPre; $count ++)
{
	$temp = $filePre[$count];
	$_SESSION['filePre'][$count] = $temp;
}

?>
</body>
</html>				