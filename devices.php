<?php
include('navigation.php');
if (!isset($_SESSION['userId']))
{
	header("Location:index.php");
}
if (isset($_SESSION['username']))
{
        $username = $_SESSION['username'];
        $query = <<<END
        INSERT INTO statistics_pages(username, page)
        VALUES('{$username}', 'devices.php')
END;
        $mysqli->query($query);
}
if (isset($_GET['id']))
{
	$id = $mysqli->real_escape_string($_GET['id']);
	$query = <<<END
	SELECT * FROM devices
	WHERE id = '{$id}'
END;
	$res = $mysqli->query($query);
	if ($res->num_rows > 0)
	{
	    $row = $res->fetch_object();
	    if ($row->state === '0')
	    {
		$state = '1';
	    }
	    else
	    {
		$state = '0';
	    }
	}
	$query = <<<END
	UPDATE devices
	SET state = '{$state}'
	WHERE id = '{$id}'
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

<?php
$kitchen = '<button class="collapsible">Kitchen</button> <div class="content">';
$queryKitchen = <<<END
SELECT * FROM devices
WHERE room = "kitchen"
END;
$res = $mysqli->query($queryKitchen);
if ($res->num_rows > 0) {
    while ($row = $res->fetch_object())
    {
	if ($row->state === '1')
	{
	    $kitchen .= <<<END
	    <form method="post" action="devices.php?id={$row->id}">
		<input class="control" type="submit" style="background-color: green" value="{$row->name}">
	    </form>
END;
	}
	else
	{
            $kitchen .= <<<END
            <form method="post" action="devices.php?id={$row->id}">
		<input class="control" type="submit" value="{$row->name}">
	    </form>
END;
        }
    }
    $kitchen .= '</div>';
}


$livingroom = '<button class="collapsible">Living Room</button> <div class="content">';
$queryLivingroom = <<<END
SELECT * FROM devices 
WHERE room = "living room"
END;
$res = $mysqli->query($queryLivingroom);
if ($res->num_rows > 0) {
    while ($row = $res->fetch_object()) {
	if ($row->state === '1')
	{
	    $livingroom .= <<<END
	    <form method="post" action="devices.php?id={$row->id}">
		<input class="control" type="submit" style="background-color: green" value="{$row->name}">
	    </form>
END;
	}
	else
	{
            $livingroom .= <<<END
            <form method="post" action="devices.php?id={$row->id}">
		<input class="control" type="submit" value="{$row->name}">
	    </form>
END;
	}
    }
    $livingroom .= '</div>';
}
echo $kitchen;
echo $livingroom;
?>

<script>
var coll = document.getElementsByClassName("collapsible");
var i;
for (i = 0; i < coll.length; i++)
{
    coll[i].addEventListener("click", function ()
    {
        this.classList.toggle("active");
        var content = this.nextElementSibling;
        if (content.style.maxHeight)
	{
            content.style.maxHeight = null;
        }
	else
	{
            content.style.maxHeight = content.scrollHeight + "px";
        }
     });
}
</script>
</body>
</html>
