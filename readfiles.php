<html>
<body>
<?php

function intPhantom($phantomInfo)
{

   	switch($phantomInfo)
   	{
   		case 'Empty':
   		$phantom = 1;
   		break;

   		case 'CalEmp':
   		$phantom = 2;
   		break;

		case 'Calibration':
		$phantom = 3;
		break;

		case 'Rod':
		$phantom = 4;
		break;

		case 'Water':
		$phantom = 5;
		break;

		case 'CTP404_Sensitom':
		$phantom = 6;
		break;

		case 'CTP528_Linepair':
		$phantom = 7;
		break;

		case 'CTP515_Low_Contrast':
		$phantom = 8;
		break;

		case 'CTP554_Dose':
		$phantom = 9;
		break;

		case 'CIRSPHP0':
		$phantom = 10;
		break;

		case 'CIRSPHP1':
		$phantom = 11;
		break;

		case 'LMU_DECT':
		$phantom = 12;
		break;

		case 'CIRS_Edge':
		$phantom = 13;
		break;

		case 'Birks':
		$phantom = 14;
		break;

		default:
		$phantom = 15;
		break;
	}

	return $phantom;
}

session_start();
$currentUser = 'imported';
$currentGroup = $_SESSION['currentGroup'];

//Run through filenames.txt and store each file path in $fileList

$fileList = array();
$filenames = fopen("filenames.txt", "r");
$count = 0;

while (($line = fgets($filenames)) !== false)
{
	array_push($fileList, $line);
	$count = $count + 1;
}



fclose($filenames);

echo $fileList[1555] . "<br>";
echo "$count<br>";
echo "It worked!<br>";




//Connect to Database
$servername = "localhost";
$username = ; //username redacted 
$password = ; //password redacted
$defaultdb = "mccarty_pct_data";
$db = mysqli_connect("$servername", "$username", "$password", "$defaultdb");
echo "Connected to Database<br>";
if (mysqli_connect_errno() OR !$db)
{
	echo "Failed to connect to MySQL : " . mysqli_connect_error();
	    			die("Connection failed. :*( <br>");
}

//Interpret Path Names and Store Data
for($i = 0; $i < $count; $i++)
{
	$fileLocation = $fileList[$i];
	$fileLocation = substr($fileLocation, 1);
	$fileName = basename($fileList[$i]);
	// echo "$fileName<br>";
	list($ion, $pct, $org, $phantom, $simEx) = explode('/', $fileLocation);
	$phantom = IntPhantom($phantom);
	// echo "$fileLocation<br>";
	// echo "$ion | $pct | $org | $phantom | $simEx<br>";

	switch ($simEx)
	{
		case 'Reference_Images':
			// echo "<br>Reference Image<br>";
			// echo "$fileName<br>";
			// echo "$fileLocation<br>";
			$source = "R";
			$checkDuplicate = "SELECT datasetID FROM Main WHERE source = '$source' AND phase = 2;";
			// echo "$checkDuplicate<br>";
			$duplicate = mysqli_query($db, "$checkDuplicate");
			if($row = $duplicate->fetch_assoc())
			{
				$dsID = $row['datasetID'];
				$storeFileImage = "INSERT INTO Images VALUES('$dsID', '$fileName', '$fileLocation', ' ', '$currentUser', 'rwxrwxrwx');";
				// echo "$storeFileImage<br>";
				mysqli_query($db, "$storeFileImage");
			}
			else
			{
				$storeFileMain = "INSERT INTO Main VALUES('0',' ', '$source', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ' , 2);";
				// echo "$storeFileMain<br>";
				mysqli_query($db,"$storeFileMain");
				$checkDuplicate = "SELECT datasetID FROM Main WHERE source = '$source' AND phase = 2;";
				// echo "$checkDuplicate<br>";
				$duplicate = mysqli_query($db, "$checkDuplicate");
				while($row = $duplicate->fetch_assoc())
				{
					$dsID = $row['datasetID'];
					// echo "$dsID";
					$storeFileImage = "INSERT INTO Images VALUES('$dsID', '$fileName', '$fileLocation', ' ', '$currentUser', 'rwxrwxrwx');";
					// echo "$storeFileImage<br>";
					mysqli_query($db, $storeFileImage);
				}
			}
		break;

		case 'Simulated':
			// echo "<br>Simulated Data<br>";
			// echo "$fileName<br>";
			// echo "$fileLocation<br>";
			$source = 'S';
			list($ion, $pct, $org, $phantom, $simEx, $gtDate, $procDate, $inOut) = explode('/', $fileLocation);
			$phantom = IntPhantom($phantom);
			// echo "$gtDate<br>";
			list($gt, $date) = explode("_", $gtDate);
			list($file, $angle) = explode("_", $fileName);

			//Check for Main file matching this source
			$checkDuplicate = "SELECT datasetID FROM Main WHERE source = '$source' AND date = 
				'$date' AND phantomID = $phantom AND phase = 2;";
			// echo "$checkDuplicate<br>";
			$duplicate = mysqli_query($db, "$checkDuplicate");
			if($row = $duplicate->fetch_assoc())
			{
				$dsID = $row['datasetID'];
				if($inOut == 'Input')
				{
					$storeFileRaw = "INSERT INTO Raw VALUES('$dsID', '$fileName', '$fileLocation', ' ', ' ', '$angle', '$currentUser', 'rwxrwxrwx');";
					// echo "$storeFileRaw<br>";
					mysqli_query($db, "$storeFileRaw");
				}
				if($inOut == 'Output')
				{
					list($ion, $pct, $org, $phantom, $simEx, $gtDate, $procDate, $inOut, $procDate, $recDate) = explode('/', $fileLocation);
					$phantom = IntPhantom($phantom);
					if($recDate == $fileName)
					{
						$storeFilePreprocessed = "INSERT INTO Preprocessed VALUES('$dsID', '$fileName', '$fileLocation', '$procDate', '$gt', ' ', '$currentUser', 'rwxrwxrwx');";
						// echo "$storeFilePreprocessed<br>";
						mysqli_query($db, "$storeFilePreprocessed");
					}
					else
					{
						$storeFileReconstruction = "INSERT INTO Reconstruction VALUES('$dsID', 0, '$fileName', '$fileLocation', ' ', '$recDate', ' ', 'Imported from Kodiak', '$currentUser', 'rwxrwxrwx');";
						// echo "$storeFileReconstruction<br>";
						mysqli_query($db, "$storeFileReconstruction");
					}
				}
			}
			else
			{
				$storeFileMain = "INSERT INTO Main VALUES(0,'$date', '$source', ' ', '$phantom', ' ', ' ', ' ', ' ', ' ', ' ', ' ' , 2);";
				// echo "$storeFileMain<br>";
				mysqli_query($db,"$storeFileMain");
				$checkDuplicate = "SELECT datasetID FROM Main WHERE source = '$source' AND date = 
				'$date' AND phantomID = $phantom AND phase = 2;";
				// echo "$checkDuplicate<br>";
				$duplicate = mysqli_query($db, "$checkDuplicate");
				while($row = $duplicate->fetch_assoc())
				{
					$dsID = $row['datasetID'];
					if($inOut == 'Input')
					{
						$storeFileRaw = "INSERT INTO Raw VALUES('$dsID', '$fileName', '$fileLocation', ' ', ' ', '$angle', '$currentUser', 'rwxrwxrwx');";
						// echo "$storeFileRaw<br>";
						mysqli_query($db, "$storeFileRaw");
					}
					if($inOut == 'Output')
					{
						list($ion, $pct, $org, $phantom, $simEx, $gtDate, $procDate, $inOut, $procDate, $recDate) = explode('/', $fileLocation);
						$phantom = IntPhantom($phantom);
						if($recDate == $fileName)
						{
							$storeFilePreprocessed = "INSERT INTO Preprocessed VALUES('$dsID', '$fileName', '$fileLocation', '$procDate', '$gt', ' ', '$currentUser', 'rwxrwxrwx');";
							// echo "$storeFilePreprocessed<br>";
							mysqli_query($storeFilePreprocessed);
						}
						else
						{
							$storeFileReconstruction = "INSERT INTO Reconstruction VALUES('$dsID', 0, '$fileName', '$fileLocation', ' ', '$recDate', ' ', 'Imported from Kodiak', '$currentUser', 'rwxrwxrwx');";
							// echo "$storeFileReconstruction<br>";
							mysqli_query($db, "$storeFileReconstruction");
						}
					}
				}
			}
		break;

		case 'Experimental':
			// echo "<br>Experimental Data <br>";
			// echo "$fileName<br>";
			// echo "$fileLocation<br>";		
			$source = 'E';	
			list($ion, $pct, $org, $phantom, $simEx, $date, $runTag, $inOut) = explode('/', $fileLocation);
			$phantom = IntPhantom($phantom);
			$source = 'E';
			list($run, $tag) = explode("_", $runtag);
			list($file, $angle) = explode("_", $fileName);


			$checkDuplicate = "SELECT datasetID FROM Main WHERE source = '$source' AND phantomID = $phantom AND date = '$date' AND phase = 2;";
			// echo "$checkDuplicate<br>";
			$duplicate = mysqli_query($db, "$checkDuplicate");
			if($row = $duplicate->fetch_assoc())
			{
				$dsID = $row['datasetID'];
				if ($inOut == 'Input')
				{
					$storeFileRaw = "INSERT INTO Raw VALUES('$dsID', '$fileName', '$fileLocation', '$run', '$tag', '$angle', '$currentUser', 'rwxrwxrwx');";
					// echo "$storeFileRaw<br>";
					mysqli_query($db, "$storeFileRaw");
				}
				if ($inOut == 'Output')
				{
					list($ion, $pct, $org, $phantom, $SimEx, $date, $runtag, $inOut, $procDate, $rec) = explode('/', $fileLocation);
					$phantom = IntPhantom($phantom);

					if($rec == 'Reconstruction')
					{
						list($ion, $pct, $org, $phantom, $SimEx, $date, $runtag, $inOut, $procDate, $rec, $recDate) = explode('/', $fileLocation);
						$storeFileReconstruction = "INSERT INTO Reconstruction VALUES('$dsID', '0', '$fileName', '$fileLocation', ' ', '$recDate', ' ', 'Imported from Kodiak', '$currentUser', 'rwxrwxrwx');";
						// echo "$storeFileReconstruction<br>";
						mysqli_query($db, "$storeFileReconstruction");
					}
					else
					{
						$storeFilePreprocessed = "INSERT INTO Preprocessed VALUES('$dsID', '$fileName', '$fileLocation', '$procDate', ' ', ' ', '$currentUser', 'rwxrwxrwx');";
						// echo "$storeFilePreprocessed<br>";
						mysqli_query($db, "$storeFilePreprocessed");
					}
				}
			}
			else
			{
				$storeFileMain = "INSERT INTO Main VALUES('0','$date', '$source', ' ', '$phantom', ' ', ' ', ' ', ' ', ' ', ' ', ' ' , 2);";
				// echo "$storeFileMain<br>";
				mysqli_query($db,"$storeFileMain");
				$checkDuplicate = "SELECT datasetID FROM Main WHERE source = '$source' AND phantomID = $phantom AND date = '$date' AND phase = 2;";
				// echo "$checkDuplicate<br>";
				$duplicate = mysqli_query($db, "$checkDuplicate");
				while($row = $duplicate->fetch_assoc())
				{
					$dsID = $row['datasetID'];
					if ($inOut == 'Input')
					{
						$storeFileRaw = "INSERT INTO Raw VALUES('$dsID', '$fileName', '$fileLocation', '$run', '$tag', '$angle', '$currentUser', 'rwxrwxrwx');";
						// echo "$storeFileRaw<br>";
						mysqli_query($db, "storeFileRaw");
					}
					if ($inOut == 'Output')
					{
						list($ion, $pct, $org, $phantom, $SimEx, $date, $runtag, $inOut, $procDate, $rec) = explode('/', $fileLocation);
						$phantom = IntPhantom($phantom);

						if($rec == 'Reconstruction')
						{
							list($ion, $pct, $org, $phantom, $SimEx, $date, $runtag, $inOut, $procDate, $rec, $recDate) = explode('/', $fileLocation);
							$storeFileReconstruction = "INSERT INTO Reconstruction VALUES('$dsID', '0', '$fileName', '$fileLocation', ' ', '$recDate', ' ', 'Imported from Kodiak', '$currentUser', 'rwxrwxrwx');";
							// echo "$storeFileReconstruction<br>";
							mysqli_query($db, "$storeFileReconstruction");
						}
						else
						{
							$storeFilePreprocessed = "INSERT INTO Preprocessed VALUES('$dsID', '$fileName', '$fileLocation', '$procDate', ' ', ' ', '$currentUser', 'rwxrwxrwx');";
							// echo "$storeFilePreprocessed<br>";
							mysqli_query($db, "$storeFilePreprocessed");
						}
					}

				}
			}
		break;

		default:
			echo "There has been an error reading in this file.<br>";
			echo "$filename<br>";
			echo "$i<br><br>";
		break;
	}
}


?>
</body>
</html>