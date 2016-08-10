<?php
require("db-connect.php");

session_start();

if(!isset($_SESSION['Username']))
{
header("Location: index.php");
exit();
}



?>
<!DOCTYPE html>
<html>
<head lang="en">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
 <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="assets/js/bootstrap-filestyle.min.js"> </script>
<script type="text/javascript" src="assets/js/jquery.form.min.js"></script>

<link href="assets/css/bootstrap-switch.min.css" rel="stylesheet">
<script src="assets/js/bootstrap-switch.min.js"></script>
	<script>
	$(document).ready(function(){
$("[name='my-checkbox']").bootstrapSwitch();
$('input[name="my-checkbox"]').on('switchChange.bootstrapSwitch', function(event, state) {

  
  if(state)
  var url_ = "permission.php?dir=<?php $dir = isset($_GET['dir']) ? $_GET['dir'] : $defaultdir; echo $dir; ?>&file="+$(this).attr("data-file")+"&permission=private";
	else
  var url_ = "permission.php?dir=<?php $dir = isset($_GET['dir']) ? $_GET['dir'] : $defaultdir; echo $dir; ?>&file="+$(this).attr("data-file")+"&permission=public";

  
      $.ajax({url: url_, success: function(result){
			// Do nothing.
	  }});
  
  

});
	var options = { 
			target:   '#output',   // target element(s) to be updated with server response 
			beforeSubmit:  beforeSubmit,  // pre-submit callback 
			success:       afterSuccess,  // post-submit callback 
			uploadProgress: OnProgress, //upload progress callback 
			resetForm: true        // reset the form after successful submit 
		}; 
		
	 $('#MyUploadForm').submit(function() { 
			$(this).ajaxSubmit(options);  			
			// always return false to prevent standard browser submit and page navigation 
			return false; 
		});
		
	 $('#makeDirForm').ajaxForm(function() { 
               location.reload();
            }); 
		

	

//function after succesful file upload (when server response)
function afterSuccess()
{
	$('#submit-btn').show(); //hide submit button
	$('#loading-img').hide(); //hide submit button
	$('#progressbox').delay( 1000 ).fadeOut(); //hide progress bar
	location.reload();

}

//function to check file size before uploading.
function beforeSubmit(){
    //check whether browser fully supports all File API
   if (window.File && window.FileReader && window.FileList && window.Blob)
	{
		
		if( !$('#FileInput').val()) //check empty input filed
		{
			$("#output").html("Please select a file.");
			return false
		}
		
		var fsize = $('#FileInput')[0].files[0].size; //get file size
 
		
		//Allowed file size is less than 500 MB (104857600)
		if(fsize>524288000) 
		{
			$("#output").html("<b>"+bytesToSize(fsize) +"</b> Too big file! <br />File is too big, it should be less than 500 MB.");
			return false
		}
				
		$('#submit-btn').hide(); //hide submit button
		$('#loading-img').show(); //hide submit button
		$("#output").html("");  
	}
	else
	{
		//Output error to older unsupported browsers that doesn't support HTML5 File API
		$("#output").html("Please upgrade your browser, because your current browser lacks some new features we need!");
		return false;
	}
}

//progress bar function
function OnProgress(event, position, total, percentComplete)
{
    //Progress bar
	$('#progressbox').show();
    $('#progressbar').width(percentComplete + '%') //update progressbar percent complete
    $('#statustxt').html(percentComplete + '%'); //update status text
    if(percentComplete>50)
        {
            $('#statustxt').css('color','#000'); //change status text to white after 50%
        }
}

//function to format bites bit.ly/19yoIPO
function bytesToSize(bytes) {
   var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
   if (bytes == 0) return '0 Bytes';
   var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
   return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
}

 
  $('.confirmDelete').on('click', function(e) {

	        e.preventDefault();

	        var el = $(this);

	        var dataFile = el.attr('data-file');

	         

	        $('#confirmDelete').find('#frm_body').html("Do you really want to delete this file?")

	        .end().find('#frm_title').html("Sure?")

	        .end().modal('show');

	         

	        $('#confirmDelete').find('#confirm').attr('data-file', dataFile);

	  });

	 

	  $('#confirmDelete').on('click', '#confirm', function(e) {

	        var id = $(this).attr('data-file');

	      
		 
  var url_ = "delete.php?dir=<?php $dir = isset($_GET['dir']) ? $_GET['dir'] : $defaultdir; echo $dir; ?>&file="+$(this).attr("data-file");

  
      $.ajax({url: url_, success: function(result){
			location.reload();
	  }});
	  
	  

	  });
 
  
  
	
}); 

</script>

	
	

	<title>piCloud - Your Personal Cloud</title>


	<!-- Include our stylesheet -->
	<link href="assets/css/styles.css" rel="stylesheet"/>
	<link rel="shortcut icon" href="assets/images/Cloud-icon.png">
</head>
<body>

 <nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#"><img src="assets/images/Cloud-icon.png" height="30px"/> </a>
    </div>
	   

    <ul class="nav navbar-nav navbar-right">
      <li><a href="#"><span class="glyphicon glyphicon-user"></span> <?php echo $_SESSION['Name']; ?></a></li>
      <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
    </ul>
  </div>
</nav>

	<div class="filemanager">

		<div class="uploadBox">
  <!-- Trigger the modal with a button -->
  <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myUpload">Upload</button>

  <!-- Modal -->
  <div class="modal fade" id="myUpload" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Upload a File</h4>
        </div>
        <div class="modal-body">
			<form role="form" action="upload.php?dir=<?php echo $dir; ?>" method="post" enctype="multipart/form-data" id="MyUploadForm">
				<div class = "form-group">
					<label for="upload"> <h5>Select File : </h5></label>
					<input type="file" name="FileInput" id="FileInput" class="filestyle" data-buttonName="btn-primary">
				</div>

				<button type="submit" id="submit-btn" class="btn btn-default">Upload</button>
				<img src="images/ajax-loader.gif" id="loading-img" style="display:none;" alt="Please Wait"/>
			</form>
			<div id="progressbox" ><div id="progressbar"></div ><div id="statustxt">0%</div></div>
<div id="output"></div>
		</div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
  <div class="modal fade" id="makeDir" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Create New Directory</h4>
        </div>
        <div class="modal-body">
		
	<form role="form" action="createdir.php?dir=<?php echo $dir; ?>" method="post" id="makeDirForm">
				<div class = "form-group">
					<label for="directory"> <h5>Directory Name : </h5></label>
					<input type="text" name="dirName" id="dirName" class="form-control">
				</div>

				<button type="submit" id="submit-btn" class="btn btn-default">Create</button>
					</form>
				
		
		</div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  




  </div>

		<div class="modal fade" id="confirmDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" id="frm_title">
                Sure?
            </div>
            <div class="modal-body" id="frm_body">
                Do you really want to delete this file?
            </div>
           <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
	        <button type="button" class="btn btn-danger" id="confirm">Delete</button>

	      </div>
        </div>
    </div>
</div>
		<div class="breadcrumbs">
		<span style="vertical-align: middle; position:relative; top:8px; padding-right:20px;"><input type="image" src="assets/images/newdir.png" width="40px" data-toggle="modal" data-target="#makeDir"></span> 
<?php

$bc = explode("/", $dir);
echo '<a href="dashboard.php?dir='.$bc[0].'"><span class="folderName">
		'.$bc[0].'</span></a>
		';
$cdir = $bc[0];
for($i = 1; $i < count($bc)-1; $i++)
{
$cdir .=  "/".$bc[$i]; 
echo '	 <span class="arrow">→</span>	<a href="dashboard.php?dir='.$cdir.'"><span class="folderName">
		'.$bc[$i].'</span></a>
		';
}
if(count($bc) != 1)	
echo '	 <span class="arrow">→</span>	<span class="folderName">
		'.$bc[count($bc)-1].'</span>';	
?>
		</div>
		<ul style="" class="data animated">
		
<?php



$filesArray = array();

$sql = "SELECT * FROM permissions";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    
while($row = mysqli_fetch_assoc($result)) {
$filesArray[] = $row['fileName'];
}
}

$files = array();

$folders = array();

	// Is there actually such a folder/file?

	if(file_exists($dir)){
	
		foreach(scandir($dir) as $f) {
		
			if(!$f || $f[0] == '.') {
				continue; // Ignore hidden files
			} 
			
			if(is_dir($dir . '/' . $f)) {

				// The path is a folder
				$folders[] = array(
					"name" => $f,
					"type" => "folder",
					"path" => $dir . '/' . $f
				);

			}
			
			else {

				// It is a file
			
				$files[] = array(
					"name" => $f,
					"type" => "file",
					"path" => $dir . '/' . $f,
					"size" => filesize($dir . '/' . $f) // Gets the size of this file
				);

			
					
			}
		}
		function formatBytes($size, $precision = 2)
{
    $base = log($size, 1024);
    $suffixes = array('', 'KB', 'MB', 'GB', 'TB');   

    return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
}

	if(isset($folders))
	{
		foreach($folders as $f)
		{

				echo '<li class="folders"><a href="dashboard.php?dir='.$dir . '/' . $f["name"].'" title="'.$f["path"].'" class="folders"><span class="icon folder full"></span><span class="name">'.$f["name"].'</span> </a></li>';

		}
	}

 if(isset($files))
	{	
		
		foreach($files as $f)
		{
			echo '<li class="files"><span style="position: absolute; right: 10px; top: 10px; z-index:2"><input class="confirmDelete" type="image" data-title="test"  name="delete" data-file="'.$f["name"].'" src="assets/images/delete-xxl.png" width="20px"></span><a href="download.php?file='. $f["path"].'" title="'.$f["path"].'" class="files"><span class="icon file f-'.pathinfo($f["name"], PATHINFO_EXTENSION).'">.'.pathinfo($f["name"], PATHINFO_EXTENSION).'</span><span class="name">'.$f["name"].'</span> <span class="details">'. formatBytes($f["size"], 0).'</span></a><span class="details" style="top: 86px; left: 115px;"><input type="checkbox" name="my-checkbox" data-on-text="Private" data-off-text="Public" data-off-color="success" data-file="'.$f["name"].'"  data-size="mini" '; 
			if(!in_array($dir."/".$f["name"], $filesArray))
			echo 'checked';
			
			echo '></span></li>';

		}
}
 

 	if(count($folders)==0 && count($files)==0)
echo '		<div style="display: block" class="nothingfound">
			<div class="nofiles"></div>
			<span>No files here.</span>
		</div>
';

	}

?>

	
		</ul>


	</div>



	
</body>
</html>
