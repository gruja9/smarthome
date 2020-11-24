<?php
include('navigation.php');
if (!isset($_SESSION['userId']) || $_SESSION['isAdmin'] === "0")
{
        header("Location:index.php");
}
if (isset($_SESSION['username']))
{
        $username = $_SESSION['username'];
        $query = <<<END
        INSERT INTO statistics_pages(username, page)
        VALUES('{$username}', 'statistics.php')
END;
        $mysqli->query($query);
}
if (isset($_GET['clear']) and ($_GET['clear'] === '1'))
{
	$query = "DELETE FROM statistics_ip";
	$mysqli->query($query);
	$query = "DELETE FROM statistics_pages";
	$mysqli->query($query);
	header("Location:statistics.php");
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name=”viewport” content=”width=device-width” />
    <title>Smart Home</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
<div class="header">
    <h1>Smart home control</h1>

    <?php
    echo $navigation;
    ?>
</div>

<?php
$content = '<div class="container">';
$content .= '<form method="post" action="statistics.php?clear=1"><input type="submit" value="Clear Statistics"></form><br>';
$query = <<<END
SELECT * FROM statistics_ip
END;
$res = $mysqli->query($query);
if ($res->num_rows > 0)
{
	$content .= <<<END
	<h1>IP Statistics</h1><br>
	<table border="1">
	    <tr>
		<th>IP</th>
		<th>Times visited</th>
	    </tr>
END;
	while ($row = $res->fetch_object())
	{
		$content .= <<<END
		<tr>
		    <td>{$row->ip}</td>
		    <td>{$row->times}</td>
		</tr>
END;
	}
	$content .= "</table>";
}

$query = <<<END
SELECT * FROM statistics_pages
END;
$res = $mysqli->query($query);
if ($res->num_rows > 0)
{
	$content .= <<<END
	<h1>Accessed Pages Statistics</h1><br>
	<table border="1">
	    <tr>
		<th>Username</th>
		<th>Accessed Page</th>
		<th>Timestamp</th>
	    </tr>
END;
	while ($row = $res->fetch_object())
	{
		$content .= <<<END
		<tr>
		    <td>{$row->username}</td>
		    <td>{$row->page}</td>
		    <td>{$row->timestamp}</td>
		</tr>
END;
	}
	$content .= "</table>";
}
$content .= "</div>";

echo $content;
?>
