<?php
session_start();
$UserId=$_SESSION['UserId'];
$pwd=$_REQUEST['pwd'];
if(!isset($_SESSION['UserId']))
header("location:index.php");
//start theme
$themeName=$_REQUEST['themeName'];
if($themeName)
{
file_put_contents("userProfile/$UserId/theme",$themeName);
}
touch("userProfile/$UserId/theme");
$rData=file_get_contents("userProfile/$UserId/theme");
date_default_timezone_set("Asia/Kolkata");
//end theme
?>
<html>
<head>
<meta charset="utf-8">
<title>User Account</title>
<link href="userAccount.css" rel="stylesheet" type="text/css">
</head>
<body background="themes/<?php echo $rData; ?>">
<div id="wrapper"><!-- page starts-->
<div id="header"><!--header starts-->
    
    Welcome: <?php echo $_SESSION['UserId']; ?>
	
  <a href="logout.php" id="logout">Logout</a>
    <a href="userAccount.php?event=setting" id="setting">Setting</a>
    </div><!--header ends-->
   
<table id="tab" border="1"><!--Mid Page starts-->
    <tr>
    <td id="functionbox"><!--function box starts-->
    
    <ul>
      <li><a href="userAccount.php?event=compose">Compose</a></li>
    <li><a href="userAccount.php?event=inbox">Inbox</a></li>
    <li><a href="userAccount.php?event=sent">Sent</a></li>
    <li><a href="userAccount.php?event=outbox">Outbox</a></li>
    <li><a href="userAccount.php?event=trash">Trash</a></li>
    </ul> 
    

<!--function chatRoom header starts-->
    <div id="labelFun">
    Chat Room
    </div>
    <!--function ChatRoom header ends-->
    
 <?php
 //sending frnd request starts
	$frndId=$_REQUEST['frndId'];
	if($_REQUEST['FrndReq'])
	{
		if($frndId=="")
		{
		echo "FrndId must fill!";
		}
		else
		{
			if(file_exists("userProfile/$frndId"))
			{
$subject="Friend request by $UserId";
$msg="<p><a href='userAccount.php?acpt=$UserId'>Click here to accept</a></p><p><a href='userAccount.php?rjct=$UserId'>Click here to reject</a></p>";
file_put_contents("userProfile/$frndId/inbox/$subject",$msg);
echo "Friend Request Send.";
			}
			else
			{
			echo "Invalid Id req..";	
			}
		}
	}
//sending frnd request ends--
?>
    
<!--form for send frnd request to anyone-->
<form>
	<input type="text" name="frndId"></br>
		<input type="submit" name="FrndReq" value="Add Friend">
	</form>
 <!--form ends-->
 
 <?php
	//accept frndReq
	$acpt=$_REQUEST['acpt'];
	if($acpt)
	{
		if(file_exists("userProfile/$UserId/chatRoom/$acpt"))
		{
		echo "already in frndList";
		}
		else
		{
		mkdir("userProfile/$UserId/chatRoom/$acpt");
		mkdir("userProfile/$acpt/chatRoom/$UserId");
		}
	}
	
	//reject frndReq
	$rjct=$_REQUEST['rjct'];
	if($rjct)
	{
	$subject="Rejected by $UserId";
	$msg="Rejected by $UserId";
	file_put_contents("userProfile/$rjct/inbox/$subject",$msg);
	}
	?>
    
    <?php
// see frndList
	
$FrndList=scandir("userProfile/$UserId/chatRoom");
array_shift($FrndList);
array_shift($FrndList);
foreach($FrndList as $k=>$v)
{
echo "<a href='userAccount.php?aUser=$v'>$v</a>";
}
?>
    
    </td><!--function box ends-->
    
    
    <td id="contentbox"><!--content box starts-->
 
   	<?php
//start label msg printing

echo $labelMsg1;

//end label msg printing
	
	
	//start event tracking
		if($_REQUEST['event']==setting)
		{
			include ("setting.php");
			  
		}
		
		if($_REQUEST['event']==compose)
		{
		include("compose.php");
		}
		
		if($_REQUEST['event']==inbox)
		{
			
            include("inbox.php");
		}
		
		if($_REQUEST['event']==sent)
		{
         include("sent.php");   
		}
		
		if($_REQUEST['event']==outbox)
		{
			include("outbox.php");
		}
		
		if($_REQUEST['event']==trash)
		{
			include("trash.php");
		}
	
		if($_REQUEST['event']==changePassword)
		{
		include("change_pwd.php");
		}
		
		if($_REQUEST['event']==change_theme)
		{
			include("change_theme.php");		
		}
		//end event tracking
		//change password starts---
 
 	$UserId=$_SESSION['UserId'];
 	$CurrPwd=$_REQUEST['CurrPwd'];
 	$NewPwd=$_REQUEST['NewPwd'];
 	$ConPwd=$_REQUEST['ConPwd'];
 
 if($_REQUEST['chngPwd'])
 	{
		if($CurrPwd=="" or $NewPwd=="" or
		$ConPwd=="")
		{
		$errorMsg="Fill All Require Fields";
		include("change_pwd.php");
		}
		
		else
		{
			if(file_exists("userProfile/$UserId/$CurrPwd"))
			{
				if($NewPwd==$ConPwd)
				{
				rename("userProfile/$UserId/$CurrPwd","userProfile/$UserId/$ConPwd");
	echo "your password has been changed.";	
				}
				else
				{
				$errorMsg="New Password and Confirm password are different";
				include("change_pwd.php");
				}
			} 
			else
			{
			$errorMsg= "Current Password did not match";
			include("change_pwd.php");
			}
			
		}
	}	
 //pasword change ends--
 
 
 //compose mail start...
 $UserId=$_SESSION['UserId'];
$toUser=$_REQUEST['toUser'];
$subject=$_REQUEST['subject'];
$message=$_REQUEST['message'];

//for sending a mail
if($_REQUEST['send'])
{
	if($toUser=="" or $subject=="" or 
	$message=="")
		
		{
		$errorMsg= "Fill All Require Fields";
		include("compose.php");
		}
	
	else
		{
		//if toUser exist
			if(file_exists("userProfile/$toUser"))
			{
            $subjectLine="$UserId $subject";
			file_put_contents("userProfile/$toUser/inbox/$subjectLine",$message);
	     	echo "Your Mail Has Been Sent sucessfully";
		
		//send msg to the ID account(sent)
		$subjectLine="$toUser $subject";
			file_put_contents("userProfile/$UserId/sent/$subjectLine",$message);
		
			}
//if toUser not exists
	//send msg to the ID account(inbox) with msgFailed noti...
			else
			{
			$subjectLine="$toUser $subject msg failed!";
			echo "User Id does not exist";	
			}
		}
}
//for saving a mail (draft)
$subjectLine="Me $subject";
if($_REQUEST['save'])
{
	file_put_contents("userProfile/$UserId/draft/$subjectLine",$message);
	echo"Your Mail Has Been saved In Draft Sucessfully";
}
//compose mail ends...
?>
<?php
	//inbox
	$aim=$_REQUEST['aim'];
		if($aim)
		{
		echo "<h3>$aim</h3>";
	include("userProfile/$UserId/inbox/$aim");		
		}
	//draft
	$adm=$_REQUEST['adm'];
		if($adm)
		{
		echo "<h3>$adm</h3>";
	include("userProfile/$UserId/draft/$adm");		
		}
	//sent
	$asm=$_REQUEST['asm'];
		if($asm)
		{
		echo "<h3>$asm</h3>";
	include("userProfile/$UserId/sent/$asm");		
		}
		//trash
	$atm=$_REQUEST['atm'];
		if($atm)
		{
		echo "<h3>$atm</h3>";
	include("userProfile/$UserId/trash/$atm");		
		}
//end access mail
//delete a mail from inbox ang send it to trash
if($_POST['inbDel'])
	{
			
		if(!$_POST['mim'])
		{
		echo "Select Atleast One Message!";
		include("inbox.php");	
		}
		else
		{
			$c=0;
		foreach($_POST['mim'] as $mail ) 	
		{
            //for moving a file in trash box.
	$fnmS="userProfile/$UserId/inbox/$mail";
	$fnmT="userProfile/$UserId/trash/$mail";
		copy($fnmS,$fnmT);
		
		//now delete this file from sentbox.
		unlink($fnmS);		
		$c=$c+1;
		}
		echo "$c conversation has been moved to the Trash";
		include("inbox.php");
		
		}
	}
//delete a mail from sentbox ang send it to trash
if($_POST['sentDel'])
	{
			
		if(!$_POST['msm'])
		{
		echo "Select Atleast One Message!";
		include("sent.php");	
		}
		else
		{
			$c=0;
		foreach($_POST['msm'] as $mail ) 	
		{
            //for moving a file in trash box.
	$fnmS="userProfile/$UserId/sent/$mail";
	$fnmT="userProfile/$UserId/trash/$mail";
		copy($fnmS,$fnmT);
		
		//now delete this file from sentbox.
		unlink($fnmS);		
		$c=$c+1;
		}
		echo "$c conversation has been moved to the Trash";
		include("sent.php");
		
		}
	}
	
//delete a mail from outbox(Draft) ang send it to trash
if($_POST['outDel'])
{		
		if(!$_POST['mom'])
		{
		echo "Select Atleast One Message!";
		include("outbox.php");	
		}
		else
		{	$c=0;
		foreach($_POST['mom'] as $mail ) 	
		{
            //for moving a file in trash box.
	$fnmS="userProfile/$UserId/draft/$mail";
	$fnmT="userProfile/$UserId/trash/$mail";
		copy($fnmS,$fnmT);
		
		//now delete this file from outbox.
		unlink($fnmS);		
		$c=$c+1;
		}
		echo "$c conversation has been moved to the Trash";
		include("outbox.php");
	}
}
	//delete a mail from trash
if($_POST['trashDel'])
{
		
	if(!$_POST['mtm'])
	{
		echo "Select Atleast One Message!";
		include("trash.php");
	}
	else
	{	$c=0;
		foreach($_POST['mtm'] as $mail ) 	
		{
            //path of a file
	$fnmS="userProfile/$UserId/trash/$mail";
		
		//now delete this file from trash.
		unlink($fnmS);		
		$c=$c+1;
		}
		echo "$c conversation has been deleted permanently";
		include("trash.php");
		
	}
}
?>
</td><!--content box ends-->
</tr>
</table><!--mid page ends-->
</body>
</html>