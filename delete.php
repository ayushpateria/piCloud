<?php


session_start();

if(!isset($_SESSION['Username']))
{
header("Location: index.php");
exit();
}


$file = $_GET['dir']."/".$_GET['file'];

if (!unlink($file))
  {
  echo ("Error");
  }
else
  {
  echo ("Success");
  }
?>
