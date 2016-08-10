<?php

require("db-connect.php");

session_start();

if(!isset($_SESSION['Username']))
{
header("Location: index.php");
exit();
}


$file = $_GET['dir']."/".$_GET['file'];

if($_GET['permission']=="public") 
$sql = "INSERT INTO permissions (fileName, permission)
VALUES ('$file', '$_GET[permission]')";
else
$sql = "DELETE FROM permissions WHERE fileName='$file'";

if (mysqli_query($conn, $sql)) {
echo "success";
}
?>
