<?php

$login = 1;

if(isset($_POST['submit']))
{
session_start();

require("db-connect.php");


$sql = "SELECT * FROM config WHERE Username='".$_POST['form-username']."' AND Password='".$_POST['form-password']."'";
$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));


if (mysqli_num_rows($result) > 0) {
    
while($row = mysqli_fetch_assoc($result)) {

$_SESSION['Username'] = $row['Username'];
$_SESSION['Name'] = $row['Name'];
header("Location: dashboard.php");
}
}
else
$login = 0;

}

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
                            <h1><strong>pi</strong>Cloud</h1>
                            <div class="description">
                            	<p>
	                            	Turn your Raspberry Pi into your own cloud server and access the files on your external hard disk from anywhere! 
                            	</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 form-box">
                        	<div class="form-top">
                        		<div class="form-top-left">
                        			<h3>Set Up</h3>
                            		<p>Let's configure your piCloud.</p>
                        		</div>
                        		<div class="form-top-right">
                        			<i class="fa fa-key"></i>
                        		</div>
                            </div>
                            <div class="form-bottom">
			                    <form role="form" action="config.php" method="post" class="login-form">
									<div class="form-group">
			                    		<label class="sr-only" for="form-username">Hard Disk Location :</label>
			                        	<input type="text" name="diskloc" placeholder="Hard Disk Path (Ex: /media/Toshiba)" class="form-diskloc form-control" id="form-diskloc">
			                        </div>
									<div class="form-group">
										<h5>Login Details : So that your files are only yours..</h5>
									</div>
									<div class="form-group">
			                    		<label class="sr-only" for="form-username">Username</label>
			                        	<input type="text" name="form-username" placeholder="Username..." class="form-username form-control" id="form-username">
			                        </div>
			                        <div class="form-group">
			                        	<label class="sr-only" for="form-password">Password</label>
			                        	<input type="password" name="form-password" placeholder="Password..." class="form-password form-control" id="form-password">
			                        </div>
									<div class="form-group">
			                    		<label class="sr-only" for="form-name">Name</label>
			                        	<input type="text" name="form-name" placeholder="Your Name..." class="form-name form-control" id="form-name">
			                        </div>
									<div class="form-group">
										<h5>MySQL Database Details : </h5>
									</div>
									<div class="form-group">
			                    		<label class="sr-only" for="form-dbname">DB Name</label>
			                        	<input type="text" name="dbname" placeholder="DB Name" class="dbname form-control" id="dbname">
			                        </div>
			                        <div class="form-group">
			                        	<label class="sr-only" for="form-password">DB User</label>
			                        	<input type="text" name="dbuser" placeholder="DB User" class="dbuser form-control" id="dbuser">
			                        </div>
			                        <div class="form-group">
			                        	<label class="sr-only" for="form-password">Password</label>
			                        	<input type="password" name="dbpwd" placeholder="Password" class="dbpwd form-control" id="dbpwd">
			                        </div>
								
								<button type="submit" name="submit" class="btn">Set Up!</button>
			                    </form>
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