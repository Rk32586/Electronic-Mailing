<?php  echo"<form method='post' action='userAccount.php'>";
echo"<div id='inbox_header'>";
echo "<h3>Trash</h3><br>";
echo "<input type='submit' value='Delete Forever' id='deleteFor' name='trashDel'>";
echo"</div>";
echo"<table id='inbox_table'>";
$res=scandir("userProfile/$UserId/trash");
array_shift($res);
array_shift($res);
$i=0;
foreach($res as $k=>$v)
{
			echo "<tr>"."<td align='left'>";
			echo "<input type='checkbox' name='mtm[$i]' value='$v'> : <a href='userAccount.php?atm=$v'>$v</a>'";
			echo"</td>";
			echo"<td width='20%' style='font-size:20px'>";
			echo date("H:i d F Y",filectime("userProfile/$UserId/trash/$v"));
			echo"</td>"."</tr>";
			$i=$i+1;
}
echo "</table>";
echo "</form>";
//if there are no mail
		   if ($i==0)
		   {
	echo "There are no emails in your Trash folder."; 
			}
	
?>