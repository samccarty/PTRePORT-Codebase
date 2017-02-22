<html>
<body>
<?php

session_start();
$currentUser = 'imported';
$currentGroup = $_SESSION['currentGroup'];

//Run through filenames.txt and store each file path in $fileList

$fileList = array();
$filenames = fopen("heliumfilenames.txt", "r");
$count = 0;

while (($line = fgets($filenames)) !== false)
{
	array_push($fileList, $line);
	$count = $count + 1;
}



fclose($filenames);

echo $fileList[15] . "<br>";
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
	$fileName = basename($fileList[$i]);
	echo "$fileName<br>";
	list($ion, $pct, $helium) = explode('/', $fileLocation);
	
	if(strpos($fileName, 'empty'))
	{
		$phantom = 1;
	}
	elseif(strpos($fileName, 'CalEmp'))
	{
		$phantom = 2;
	}
	elseif(strpos($fileName, 'Callib'))
	{
		$phantom = 3;
	}
	elseif(strpos($fileName, 'Rod'))
	{
		$phantom = 4;
	}
	elseif(strpos($fileName, 'Water'))
	{
		$phantom = 5;
	}
	elseif(strpos($fileName, 'CTP404'))
	{
		$phantom = 6;
	}
	elseif(strpos($fileName, 'CTP528'))
	{
		$phantom = 7;
	}
	elseif(strpos($fileName, 'SensitomLinePair'))
	{
		$phantom = 15;
	}
	elseif(strpos($fileName, 'WaterLowContrast'))
	{
		$phantom = 15;
	}
	elseif(strpos($fileName, 'CTP515'))
	{
		$phantom = 8;
	}
	elseif(strpos($fileName, 'CTP554'))
	{
		$phantom = 9;
	}
	elseif(strpos($fileName, 'CIRSPHP0'))
	{
		$phantom = 10;
	}
	elseif(strpos($fileName, 'CIRSPHP1'))
	{
		$phantom = 11;
	}
	elseif(strpos($fileName, 'LMU_DECT'))
	{
		$phantom = 12;
	}
	elseif(strpos($fileName, 'Edge'))
	{
		$phantom = 13;
	}
	elseif(strpos($fileName, 'Birks'))
	{
		$phantom = 14;
	}
	else
	{
		$phantom = 15;
	}

	// echo "$fileLocation<br>";
	// echo "$ion | $pct | $org | $phantom | $simEx<br>";
		
			$source = 'E';	
			$date = '20161203';
			list($phantominfo, $run, $tag, $angle) = explode('_', $fileName);
			if($angle == '')
			{
				$angle = $runtag;
			}

			$checkDuplicate = "SELECT datasetID FROM Main WHERE source = '$source' AND phantomID = $phantom AND date = '$date' AND particle = 'helium' AND phase = 2;";
			// echo "$checkDuplicate<br>";
			$duplicate = mysqli_query($db, "$checkDuplicate");
			if($row = $duplicate->fetch_assoc())
			{
				$dsID = $row['datasetID'];

				$storeFileRaw = "INSERT INTO Raw VALUES('$dsID', '$fileName', '$fileLocation', '$run', '$tag', '$angle', '$currentUser', 'rwxrwxrwx');";
				// echo "$storeFileRaw<br>";
				mysqli_query($db, "$storeFileRaw");
			}
			else
			{
				$storeFileMain = "INSERT INTO Main VALUES('0','$date', '$source', ' ', '$phantom', ' ', ' ', ' ', ' ', ' ', ' ', 'helium' , 2);";
				// echo "$storeFileMain<br>";
				mysqli_query($db,"$storeFileMain");
				$checkDuplicate = "SELECT datasetID FROM Main WHERE source = '$source' AND phantomID = $phantom AND date = '$date' AND particle ='helium' AND phase = 2;";
				// echo "$checkDuplicate<br>";
				$duplicate = mysqli_query($db, "$checkDuplicate");
				while($row = $duplicate->fetch_assoc())
				{
					$dsID = $row['datasetID'];
					$storeFileRaw = "INSERT INTO Raw VALUES('$dsID', '$fileName', '$fileLocation', '$run', '$tag', '$angle', '$currentUser', 'rwxrwxrwx');";
						// echo "$storeFileRaw<br>";
					mysqli_query($db, "storeFileRaw");		
				}
			}

			// echo "There has been an error reading in this file.<br>";
			// echo "$filename<br>";
			// echo "$i<br><br>";

}


?>
</body>
</html>