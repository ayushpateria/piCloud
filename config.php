<?php

if(isset($_POST['submit']))
{

$myfile = fopen("db-connect.php", "w") or die("Unable to open file!");
$code = '<?php


$servername = "localhost";
$dbname = "'.$_POST['dbname'].'";
$username = "'.$_POST['dbuser'].'";
$password = "'.$_POST['dbpwd'].'";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$defaultdir = "'.$_POST['diskloc'].'";

?>';
fwrite($myfile, $code);
fclose($myfile);

require("db-connect.php");


$sql = "CREATE TABLE IF NOT EXISTS config (
  Username varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  Password text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  Name text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (Username)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

$sql2 = "INSERT INTO config (Username, Password, Name) VALUES
('".$_POST['form-username']."', '".$_POST['form-password']."', '".$_POST['form-name']."')";


$sql3 = "CREATE TABLE IF NOT EXISTS permissions (
  ID int(100) NOT NULL AUTO_INCREMENT,
  fileName text NOT NULL,
  permission varchar(100) NOT NULL,
  PRIMARY KEY (ID)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;";

$r1 = mysqli_query($conn, $sql);
$r2 =  mysqli_query($conn, $sql2);
$r3 = mysqli_query($conn, $sql3);


if($r1 && $r2 && $r3)
{
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>piCloud - Set Up</title>

        <!-- CSS -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="assets/css/form-elements.css">
        <link rel="stylesheet" href="assets/css/login_style.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="assets/images/Cloud-icon.png">
    </head>

    <body>

        <!-- Top content -->
        <div class="top-content">
        	
            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text">
                            <h1><strong>Cool</strong></h1>
                            <div class="description">
                            	<p>
	                            	Congrats! Your piCloud has been successfully set up. You are ready to go.  
                            	</p>
								<p><strong><a href="index.php">Click Here</a></strong> to login. </p>
                            </div>
                        </div>
                    </div>
        

                </div>
            </div>
            
        </div>


        <!-- Javascript -->
        <script src="assets/js/jquery-1.11.1.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.backstretch.min.js"></script>
        <script src="assets/js/scripts.js"></script>
        
        <!--[if lt IE 10]>
            <script src="assets/js/placeholder.js"></script>
        <![endif]-->

    </body>

</html>


<?php
}

}
?>