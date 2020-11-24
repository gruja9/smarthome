<?php
session_name('Smart_Home');
session_start();
$mysqli = new mysqli("localhost", "", "", "");
$navigation = <<<END
	<nav class="navigation">
		<a href="index.php">Home</a>
END;
if (!isset($_SESSION['userId']))
{
	$navigation .= '<a href="login.php">Login</a>';
}
if (isset($_SESSION['userId']))
{
	$navigation .= '<a href="devices.php">Devices</a>';
	if ($_SESSION['isAdmin'] === "1")
	{
		$navigation .= '<a href="admin.php">Admin</a>';
		$navigation .= '<a href="statistics.php">Statistics</a>';
	}
	$navigation .= '<a href="logout.php">Logout</a>';
}
$navigation .= "</nav>";
?>
