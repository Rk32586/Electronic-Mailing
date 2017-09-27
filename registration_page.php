<?php
include 'resource.php';
session_start();
//for data
$UserId=$_REQUEST['UserId'];
$pwd=$_REQUEST['pwd'];
$Fname=$_REQUEST['FName'];
$Date=$_REQUEST['Date'];
$Month=$_REQUEST['Month'];
$Year=$_REQUEST['Year'];
$ConNum=$_REQUEST['ConNum'];
$add=$_REQUEST['Address'];

$Oc=$_REQUEST['Oc'];
$Uc=$_REQUEST['Uc'];
if($_REQUEST['submit'])
{
	if($UserId=="" or $pwd=="" or $Fname=="" or $Date=="" or
		$Month=="" or $Year==""  or $ConNum=="" or $add=="" or
		$Uc=="" )
	{
		$errorMsg="Fill fields";
	}	
    else
	{
	  if($Oc!=$Uc)
	  {
		$errorMsg="wrong captcha";
	  }
	  else
	  {
		if(file_exists("userProfile/$UserId"))
		{
		  //check User Id if already taken by other
		   $errorMsg="Id is already available";
		}
		else
		{
		   //New Profile
		    mkdir("userProfile/$UserId");
			mkdir("userProfile/$UserId/images");
			mkdir("userProfile/$UserId/inbox");
			mkdir("userProfile/$UserId/sent");
			mkdir("userProfile/$UserId/draft");
			mkdir("userProfile/$UserId/trash");
			mkdir("userProfile/$UserId/chatRoom");
			$details=$Fname."\t".$Date."-".$Month."-".$Year."\t".$ConNum."\t".$add;
			$_SESSION['UserId'] = $UserId;
			$_SESSION['Password'] =$pwd;
	        file_put_contents("userProfile/$UserId/$pwd",$details);
			$a=$_FILES['t']['name'];
	        $b=$_FILES['tmp_name']['t'];
	        $store="userProfile/$UserId/images".$a;
	        move_uploaded_file($b,$store);
			//move_uploaded_file($_FILES['img']['tmp_name'],"userProfile/$UserId/".$_FILES['img']['name']);
		    header("location: welcomeMsg.php");
		}
	  }	
    }
}
?>
<html>
<head>
<meta charset="utf-8">
<title>REGISTRATION</title>
<link href="registration_page.css" rel="stylesheet" type="text/css">
</head>
<body>
  <div id="wrapper"><!-- page starts-->
  <div id="header"><!--header starts-->
  <img src="mail1.png" alt="" id="logo"/ style="width:60px">
  <a href="index.php" id="SignInLink">Sign In</a>
  </div><!--header ends-->
  <p id="text">Create your Account</p>
    <form id="RegistrationForm" action="#" method="post">
    <table id="RegistrationTable">
    <tr>
       <td id="error"><?php echo $errorMsg; ?></td>
    </tr>
    <tr>
       <td><input type="Email" value placeholder="Create User Id" 
        name="UserId" id="UId"></td>
    </tr>
    <tr>
       <td><input type="password" value placeholder="Create password" 
       name="pwd" id="UId"></td>
    </tr>
    <tr>
       <td><input type="text" value placeholder="Full Name" 
       name="FName" id="UId"></td>
    </tr>
    <tr>
      <td>
       <select id="date" name="Date">
       <option>Date</option>
       <?php
	   for($i=0;$i<$Cdate;$i++)
	   { 
        	echo "<option>".$date[$i]."</option>";	
	   }
	   ?>
       </select>
       <select id="month" name="Month">
       <option>Month</option>
       <?php
	   for($i=0;$i<$Cmonth;$i++)
	   {
	        echo "<option>".$month[$i]."</option>";	
	   }
	   ?>
       </select>
    
       <select id="year" name="Year">
       <option>Year</option>
       <?php
	   for($i=0;$i<$Cyear;$i++)
	   {
	       echo "<option>".$year[$i]."</option>";	
	   }
	   ?>
       </select>
       </td>
    </tr>
  
    <tr>
      <td><input type="text" value placeholder="Contact Number" 
      name="ConNum" id="UId"></td>
    </tr>
    <tr>
      <td><input type="text" value placeholder="Address" 
      name="Address" id="UId"></td>
    </tr>
    <tr>
    <td><h2 style="color:#00F">Upload Your Image</h2></td>
    </tr>
    <tr>
      <td><input type="file" name="t"/></td>
    </tr>
    <tr>
      <td><input type="text" value="<?php echo $captcha; ?>" name="Oc"
       id="UId1" readonly ></td>
    </tr>
    <tr>
    <td><input type="text" value placeholder="Enter captcha code"
    name="Uc" id="UId1"></td>
    </tr>
    <tr>
    <td>
      <input type="submit" value="Create Account" name="submit" id="UId2">
    </td>
    </tr>
</table>
</form>
</div><!--Page ends-->
</body>
</html>