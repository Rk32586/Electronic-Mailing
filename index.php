<?php
session_start();
$UserId=$_REQUEST['UserId'];
$pwd=$_REQUEST['pwd'];

if($_REQUEST['SignIn'])
{
	if($UserId=="" or $pwd=="")
	{
	$errorMsg="Fill UserId and password";
	}
	else
	{
		if(file_exists("userProfile/$UserId") and file_exists("userProfile/$UserId/$pwd"))
		{
		//check User Id & pwd:if true
		$_SESSION['UserId'] = $UserId;
		header("location: userAccount.php?event=inbox");
		}
		else
		{
		//else: errorMsg
		$errorMsg="Invalid Id or Pwd!";
		}
	}
}
?>
<html>
<head>
<meta charset="utf-8">
<title>Login Page</title>
<link href="index.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="header">
<img src="email.jpg" alt="" id="logo"/ style="width:400;height:100px;margin-left:470px">
</div>
<div id="wrapper">
<p>Sign In with your E-mail Account</p>
<form id="loginform" action=""  method="post"><!--login form starts-->
  <table id="logintable">
  <tr>
    <td id="errorMsg"><?php echo $errorMsg; ?></td>
  </tr>
  
  <tr>
    <td><input type="text" name="UserId" value placeholder="User ID" id="UId" ></td>
  </tr>
  <tr>
    <td><input type="password" name="pwd" value placeholder="Password" id="pwd"></td>
  </tr>
  <tr>
  <td>
  <input type="submit" value="Sign In" name="SignIn" id="login">
  </td>
  </tr>
</table>
<a href="registration_page.php" id="RegLink">Create an account</a>
</form>
</div>
</body>
</html>