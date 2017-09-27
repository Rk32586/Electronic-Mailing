<?php	 
echo"<form method='post' action='userAccount.php'>";
echo"<div id='inbox_header'>";
echo "<h3>Sent Mails</h3><br>";
echo "<input type='submit' value='Delete' id='delete' name='sentDel'>";
echo"</div>";
echo"<table id='inbox_table'>";
$res=scandir("userProfile/$UserId/sent");
array_shift($res);
array_shift($res);
$i=0;
foreach($res as $k=>$v)
{
	    echo "<tr>"."<td align='left'>";
		echo "<input type='checkbox' name='msm[$i]' value='$v'> : <a href='userAccount.php?asm=$v'>$v";
		echo"</td>";
	    echo"<td width='20%' style='font-size:20px'>";
	    echo date("H:i d F Y",filectime("userProfile/$UserId/sent/$v"));
	    echo"</td>"."</tr>";
	    $i=$i+1;
}
echo "</table>";
echo "</form>";
//if there are no mail
if ($i==0)
{
	echo "There are no emails in your Sent folder."; 
}
?>