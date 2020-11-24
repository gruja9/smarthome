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
        VALUES('{$username}', 'users.php')
END;
        $mysqli->query($query);
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
$content = '<div class="container"><h1>Users</h1>';
$query = <<<END
SELECT * FROM smarthome_users
END;
$res = $mysqli->query($query);
if ($res->num_rows > 0)
{
	while ($row = $res->fetch_object())
	{
		$content .= <<<END
			First name: {$row->fname}<br>
			Last name: {$row->lname}<br>
			Username: {$row->username}<br>
END;
		if ($row->isAdmin === "0")
		{
			$content .= "Admin: no<br>";
		}
		else
		{
			$content .= "Admin: yes<br>";
		}
		$content .= <<<END
		<a href="delete_user.php?id={$row->id}" onclick="return confirm('Are you sure?')">Remove user</a>
		<a href="edit_user.php?id={$row->id}">Edit user</a><br><br>
END;
	}
}
$content .= '</div>';
echo $content;
?>
