<html>
<h1 style="text-align:center;">Attribute Selection</h1>

<h3 style="text-align:center";>Please select the attributes associated with the chosen file.</h3>

	<form method="get" action="verifyupload.php">

<p>
<input type='submit' value = 'Submit'>
<input type='reset'>
</p>

<?php
session_start();

$uploadDataType = $_GET['uploadDataType'];
// echo "$uploadDataType";
$_SESSION['uploadDataType'] = $uploadDataType;
// echo $_SESSION['uploadDataType'];

if($uploadDataType !== "Calibration")
{
	echo "
	<p> 
	Facility:
	<select name = 'facility' required>
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
	<select name = 'dataSource' required>
		<option value = ' ' >All Technologies</option>
		<option value = 'pCT' >pCT</option>
		<option value = 'pRad' >pRad</option>
		<option value = 'HeCT' >HeCT</option>
		<option value = 'HeRad' >HeRad</option>
		<option value = 'pIVI' >pIVI</option>
		<option value = 'HeIVI' >HeIVI</option>
	</select>
	</p>	

	<p> 
	Phase:
	<select name = 'phase' required>
		<option value = ' ' >All Phases</option>
		<option value = '1' >Phase 1</option>
		<option value = '2' >Phase 2</option>
		<option value = '3' >Phase 3</option>
	</select>
	</p>
		
	<p> 
	Data Source:
	<select name='source' required>
		<option value = ' ' >All Sources</option>
		<option value = 'E' >Experimental</option>
		<option value = 'S' >Simulated</option>
	</select>
	</p>

	<p>
	Data Collection Date: 
	<input type='date' name='date' required>
	</p>

	<p> 
	Objects:
	<select name='phantom' required>
		<option value = ' ' >All Objects</option>
		<option value = '1' >Empty Run NOS</option>
		<option value = '2' >Empty Run Cal</option>
		<option value = '3' >Calibration</option>	
		<option value = '4' >Alignment (Rod)</option>
		<option value = '5' >Water</option>
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
	Particle type:
	<select name='particle' required>
		<option value = ' ' >Please select an option</option>
		<option value = 'Proton' >Proton</option>
		<option value = 'Carbon' >Carbon</option>
		<option value = 'Helium' >Helium</option>
	</select>
	</p>

	<hr>

	<p> 
	Output Data:
	<select name='output'>
		<option value = ' ' >All Output Data Types</option>
		<option value = 'CalSP' >Calibration (SP)</option>
		<option value = 'CalScP' >Calibration (ScP)</option>
		<option value = 'WEPLSP' >2D WEPL (SP)</option>
		<option value = 'WEPLScP' >2D WEPL (ScP)</option>
		<option value = 'Track' >Track Coordinates</option>
		<option value = 'RSP' >3D RSP</option>
		<option value = 'RScP' >3D RScP</option>
		<option value = 'EvD' >Energy vs Depth</option>
		<option value = 'Other' >Other</option>
	</select>
	</p>

	<p> 
	Analysis:
	<select name='analysis'>
		<option value = ' ' >All Analysis Types</option>
		<option value = 'Range' >Range Error</option>
		<option value = 'MTF' >MTF</option>
		<option value = 'RSP' >RSP Error</option>
	</select>
	</p>

	<p>
	Step Size:
	<select name='step'>
		<option value = ' ' >Please select an option</option>
		<option value = '0' >0 (Continuous)</option>
		<option value = '1' >1</option>
		<option value = '2' >2</option>
		<option value = '4' >4</option>
	</select>
	</p>

	<p>
	Energy:
	<select name='energy'>
		<option value = ' ' >Please select an option</option>
		<option value = '0' >0</option>
		<option value = '200' >200</option>
		<option value = '250' >250</option>
	</select>
	</p>

	<p>
	Region:
	<select name='region'>
		<option value = ' ' >Please select an option</option>
		<option value = 'Superior' >Superior</option>
		<option value = 'Inferior' >Inferior</option>
		<option value = 'Entire' >Entire</option>
	</select>
	</p>

	<p>
	Spot Size:
	<select name='spot'>
		<option value = ' ' >Please select an option</option>
		<option value = '1' >1</option>
		<option value = '2' >2</option>
	</select>
	</p>

	<p>
	Beam Type:
	<select name='beam'>
		<option value = ' ' >Please select an option</option>
		<option value = 'Pencil' >Pencil</option>
		<option value = 'Wiggle' >Wiggle</option>
		<option value = 'Scan' >Scan</option>
		<option value = 'Fixed' >Fixed</option>
	</select>
	</p>

	";


	switch($uploadDataType)
	{
		case 'Raw':
		echo "
		<p> 
		Run Number: 
		<textarea name='runNumber' rows='1' cols='30'>
		Enter the run number associated with your data.
		</textarea>
		</p>
		";
		echo "
		<p> 
		Run Tags:
		<textarea name='runTags' rows='1' cols='30'>
		Enter any run tags associated with your data.
		</textarea>
		</p>
		";
		echo "
		<p> 
		Run Angle:
		<textarea name='runAngle' rows='1' cols='30'>
		Enter the run angle associated with your data.
		</textarea>
		</p>
		";
		break;

		case 'Preprocessed':
		echo "
		<p>
		Processed Date:
		<input type='date' name='processedDate'>
		</p>
		";
		echo "
		<p>
		GEANT4/TOPAS:
		<select name='gt'>
			<option value = ' ' >Please select an option</option>
			<option value = 'GEANT4' >GEANT4</option>
			<option value = 'TOPAS' >TOPAS</option>
		</select>
		</p>
		";
		echo "
		<p>
		Code Version:
		<textarea name='codeVersion' rows='1' cols='30'>
		Enter the version of code used to process this file. 
		</textarea>
		</p>
		";
		break;

		case 'Reconstruction':
		echo "
		<p>
		Processed Date:
		<input type='date' name='processedDate'>
		</p>
		";
		echo "
		<p>
		Parameters:
		<textarea name='parameters' rows='1' cols='30'>
		Enter any parameters associated with this file. 
		</textarea>
		</p>
		";
		echo "
		<p>
		Code Version:
		<textarea name='codeVersion' rows='1' cols='30'>
		Enter the version of code used to process this file. 
		</textarea>
		</p>
		";
		echo "
		<p>
		Notes:
		<textarea name='notes' rows='1' cols='30'>
		Add notes associated with this file. 
		</textarea>
		</p>
		";
		break;

		case 'Images':
		echo "
		<p>
		Processed Date:
		<input type='date' name='processedDate'>
		</p>
		";
		break;

		default:
			echo "You must select a Data Type. Please return to the previous page and select a Data Type.";
		break;
	}

}
elseif($uploadDataType == "Calibration")
{
	echo "
	<p> 
	Facility Collected:
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
	Date Created:
	<input type='date' name='calibrationDate'>
	</p>
	";
}



?>

<p>
My Permissions:
<select name="userPermissions">
	<option value = " " >Please select an option</option>
	<option value = "r--" >Read Only</option>
	<option value = "rw-" >Read and Write</option>
	<option value = "rwx" >Read, Write, and Execute</option>
</select>
</p>

<p>
Group Permissions:
<select name="groupPermissions">
	<option value = " " >Please select an option</option>
	<option value = "r--" >Read Only</option>
	<option value = "rw-" >Read and Write</option>
	<option value = "rwx" >Read, Write, and Execute</option>
</select>
</p>

<p>
Public Permissions:
<select name="publicPermissions">
	<option value = " " >Please select an option</option>
	<option value = "r--" >Read Only</option>
	<option value = "rw-" >Read and Write</option>
	<option value = "rwx" >Read, Write, and Execute</option>
</select>
</p>



</form>

<?php
session_start();

$target_dir = "/home/www/uploads/";
$target_file = $target_dir . basename($_FILES['fileupload']['name']);
$uploadOK = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
$_SESSION['fileName'] = basename($_FILES['fileupload']['name']);
// echo "$target_file<br>";
// echo "$imageFileType<br>";
// print_r($_FILES);
// echo "The file size is: " . $_FILES['fileupload']['size'] . "<br>";
// echo "This should not be none: but it is |" . $_FILES['fileUpload']['tmp_name'] . "|<br>";
// echo "The error code is : " . $_FILES['fileUpload']['error'] . "<br>";

if(file_exists($target_file))
{
	echo "Sorry. This file name already exists. Please rename file and try again.";
	$uploadOK = 0;
}

if($uploadOK == 0)
{
	echo "Sorry. Your file could not be uploaded.<br>";
}
else
{

	if(move_uploaded_file($_FILES['fileupload']['tmp_name'], $target_file))
	{
		echo "The file " . basename($_FILES['fileupload']['name']) . " has been uploaded.<br>";
	}
	else
	{
		echo "Sorry. There was an error uploading your file. <br>";
	}
}




?>


</html>