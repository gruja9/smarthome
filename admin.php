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
	VALUES('{$username}', 'admin.php')
END;
	$mysqli->query($query);
}
?>

<!DOCTYPE html>
<html lang="en">

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

<button class="collapsible">Manage Users</button>
<div class="content">
    <form action="add_user.php">
	<input class="control" type="submit" value="Add Users">
    </form>
    <form action="users.php">
	<input class="control" type="submit" value="Edit Users">
    </form>
</div>

<button class="collapsible">Manage Devices</button>
<div class="content">
    <form action="device_actions.php">
        <input class="control" type="submit" value="Edit devices" />
    </form>
</div>

<script>
    var coll = document.getElementsByClassName("collapsible");
    var i;

    for (i = 0; i < coll.length; i++) {
        coll[i].addEventListener("click", function () {
            this.classList.toggle("active");
            var content = this.nextElementSibling;
            if (content.style.maxHeight) {
                content.style.maxHeight = null;
            } else {
                content.style.maxHeight = content.scrollHeight + "px";
            }
        });
    }
</script>

</body>
</html>

<!-- Admin:
- Lägga till Devices
- Ta bort Devices
- Edit device
- Ta bort användare
-->
