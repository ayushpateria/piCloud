<?php

session_start();

if(!isset($_SESSION['Username']))
{
header("Location: index.php");
exit();
}


$target_path = $_GET['dir']."/";

$target_path = $target_path . basename( $_FILES['FileInput']['name']); 

if(move_uploaded_file($_FILES['FileInput']['tmp_name'], $target_path)) {
    echo "The file ".  basename( $_FILES['FileInput']['name']). 
    " has been uploaded";
} else{
    echo "There was an error uploading the file, please try again!";
}
?>
