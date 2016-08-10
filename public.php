<?php
require("db-connect.php");

 $dir = isset($_GET['dir']) ? $_GET['dir'] : $defaultdir;  
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
  

  
	
	
	

	<title>piCloud - Your Own Personal Cloud</title>


	<!-- Include our stylesheet -->
	<link href="assets/css/styles.css" rel="stylesheet"/>

</head>
<body>

 <nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#"><img src="assets/images/Cloud-icon.png" height="30px"/> </a>
    </div>
	   

    <ul class="nav navbar-nav navbar-right">
      <li><a href="#"><span class="glyphicon glyphicon-user"></span> Guest</a></li>
      <li><a href="index.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
    </ul>
  </div>
</nav>


	<div class="filemanager">
		<div class="breadcrumbs">
		 
<?php

$bc = explode("/", $dir);
echo '<a href="public.php?dir='.$bc[0].'"><span class="folderName">
		'.$bc[0].'</span></a>
		';
$cdir = $bc[0];
for($i = 1; $i < count($bc)-1; $i++)
{
$cdir .=  "/".$bc[$i]; 
echo '	 <span class="arrow">→</span>	<a href="public.php?dir='.$cdir.'"><span class="folderName">
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
			
				if(in_array($dir."/".$f, $filesArray))
		        {
					$files[] = array(
					"name" => $f,
					"type" => "file",
					"path" => $dir . '/' . $f,
					"size" => filesize($dir . '/' . $f) // Gets the size of this file
				);
				}

			
					
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

				echo '<li class="folders"><a href="public.php?dir='.$dir . '/' . $f["name"].'" title="'.$f["path"].'" class="folders"><span class="icon folder full"></span><span class="name">'.$f["name"].'</span> </a></li>';

		}
	}

 if(isset($files))
	{	
		
		foreach($files as $f)
		{
			
					echo '<li class="files">
					<a href="download.php?file='. $f["path"].'" title="'.$f["path"].'" class="files">
					<span class="icon file f-'.pathinfo($f["name"], PATHINFO_EXTENSION).'">.'.pathinfo($f["name"], PATHINFO_EXTENSION).'</span>
					<span class="name">'.$f["name"].'</span> <span class="details">'. formatBytes($f["size"], 0).'</span>
					</span></li>';
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
