<?php
set_time_limit(240);
include "inccon.php";
?>
<html>
<head>
</head>
<body>
<?php					
	$result = mysql_query("SELECT user_id FROM de_login");
	if ($result)
	{
		$numrows = mysql_num_rows($result);
		if ($numrows > 0)
		{
			for ($i=0; $i<$numrows; $i++)
			{
				$values = mysql_fetch_array($result);
				$id = $values["user_id"];
				$result2 = mysql_query("SELECT * FROM de_user_data where user_id='$id'");
				if ($result2)
				{
					$numrows2 = mysql_numrows($result2);
					if ($numrows2 == 0)
					{
						print("FEHLENDER DATENSATZ: ID $id<br><br>");
					}
				}
			}
		}
	}
	mysql_close($db);
?>
</body>
</html>
