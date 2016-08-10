<?php

session_start();

if(!isset($_SESSION['Username']))
{
header("Location: index.php");
exit();
}



if(mkdir($_GET['dir']."/".$_POST['dirName']))
	echo "Success";

?>
