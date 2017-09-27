<?php
session_start();
?>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
<link href="welcomeMsg.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="wrapper"><!-- page starts-->
	<div id="header"><!--header starts-->
    
    Welcome: <?php echo $_SESSION['UserId']; ?><br>
	 Password:<?php echo $_SESSION['Password'];?>
  	
	</div><!--header ends-->
    
    <div id="confirmation_box"><!--confirmartion box starts-->
    <h1 align="center">Account Created</h1><br><br>
    <p align="center">
	<a href="logout.php">Back to Login Page-></a></p>
    
    </div><!--confirmation box ends-->
</div><!--page ends-->
</body>
</html>