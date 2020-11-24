<?php
include('navigation.php');
if (!isset($_SESSION['userId']) || $_SESSION['isAdmin'] === "0")
{
        header("Location:index.php");
}
$query = <<<END
DELETE FROM devices
where id = '{$_GET['id']}'
END;
$mysqli->query($query);
header('Location:device_actions.php');
echo $navigation;
?>
