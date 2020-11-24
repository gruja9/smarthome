<?php
include('navigation.php');
$ip = $_SERVER['REMOTE_ADDR'];
$query = <<<END
SELECT * FROM statistics_ip
WHERE ip = '{$ip}'
END;
$res = $mysqli->query($query);
if ($res->num_rows > 0)
{
	$row = $res->fetch_object();
	$times = $row->times + 1;
	$query = <<<END
	UPDATE statistics_ip
	SET times = $times
	WHERE ip = '{$ip}'
END;
	$mysqli->query($query);
}
else
{
	$times = 1;
	$query = <<<END
	INSERT INTO statistics_ip(ip, times)
	VALUES('{$ip}', $times)
END;
	$mysqli->query($query);
}
?>

<!DOCTYPE html>
<html lang=en>

<head>
	<meta charset="utf-8">
	<title>Smart home</title>
	<link rel="stylesheet" href="css/stylesheet.css">

</head>

<body>
	<div class="header">
	<h1>Smart home control</h1>

		<?php
		echo $navigation;
		?>
	</div>

</body>
</html>
