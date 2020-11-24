<?php
include_once('navigation.php');
if (!isset($_SESSION['userId']) || $_SESSION['isAdmin'] === "0")
{
        header("Location:index.php");
}

if (isset($_GET['id']))
{
	$id = $mysqli->real_escape_string($_GET['id']);
	$query = <<<END
	DELETE FROM smarthome_users
	WHERE id = '{$id}'
END;
	$mysqli->query($query);
	header('Location:users.php');
}
echo $navigation;
?>
