<html>

<h1 style="text-align:center;">Upload Data</h1>

<form enctype="multipart/form-data" method="get" action="selectfileattributes.php">

<p>
<input type="hidden" name="MAX_FILE_SIZE" value="100000">
<input type="file" name="fileupload" value="fileupload">
<label for="fileupload">Select a file to upload.</label>
</p>

<p> 
Data Type:
<select name = "uploadDataType">
	<option value = " " >All Data Types</option>
	<option value = "Raw" >Unprocessed (Raw)</option>
	<option value = "Preprocessed" >Preprocessed</option>
	<option value = "Reconstruction" >Reconstruction</option>
	<option value = "Images" >Images</option>	
	<option value = "Calibration" >Calibration File</option>	
</select>
</p>

<p>
<input type="reset">
<input type="submit" value = "Upload">
</p>


</form>		



</html>