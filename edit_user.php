<?php
include_once('navigation.php');
error_reporting(0);
if (!isset($_SESSION['userId']) || $_SESSION['isAdmin'] === "0")
{
        header("Location:index.php");
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
$content = '<div class="container"><h1>Edit User</h1>';
if (isset($_GET['id']) and isset($_POST['username']))
{
	$fname = $mysqli->real_escape_string($_POST['fname']);
	$lname = $mysqli->real_escape_string($_POST['lname']);
	$username = $mysqli->real_escape_string($_POST['username']);
	$password = $mysqli->real_escape_string($_POST['password']);
	$isAdmin = $mysqli->real_escape_string($_POST['isAdmin']);
	$id = $mysqli->real_escape_string($_GET['id']);
	$query = <<<END
	UPDATE smarthome_users
	SET fname = '{$fname}',
	lname = '{$lname}',
	username = '{$username}',
	password = '{$password}',
	isAdmin = '{$isAdmin}'
	WHERE id = '{$id}'
END;
	$mysqli->query($query) or die("Could not query database!");
	header("Location:users.php");
}
$id = $mysqli->real_escape_string($_GET['id']);
$query = <<<END
	SELECT * FROM smarthome_users
	WHERE id = '{$id}'
END;
	$res = $mysqli->query($query);
	if ($res->num_rows > 0)
	{
		$row = $res->fetch_object();
		$content .= <<<END
		<form method="post" action="edit_user.php?id={$row->id}">
		First name: <input type="text" name="fname" value="{$row->fname}"><br>
		Last name: <input type="text" name="lname" value="{$row->lname}"><br>
		Username: <input type="text" name="username" value="{$row->username}"><br>
		Password: <input type="password" name="password" value="{$row->password}"><br>
END;
		if ($row->isAdmin === '1')
		{
			$content .= 'Admin: <input type="checkbox" name="isAdmin" value="1" checked><br>';
		}
		else
		{
			$content .= 'Admin: <input type="checkbox" name="isAdmin" value="1"><br>';
		}
		$content .= <<<END
		<input type="submit" value="Save">
		</form>
		</div>
END;
	}
echo $content;
?>
