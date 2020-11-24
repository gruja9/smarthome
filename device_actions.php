<!DOCTYPE html>
<html lang=en>
<head>
	<meta charset="utf-8">
	<title>Smart home</title>
	<link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <div class="header">
	<h1>Smart home control</h1>
		<?php
		include('navigation.php');
		echo $navigation;
		?>
    </div>



<?php
if (!isset($_SESSION['userId']) || $_SESSION['isAdmin'] === "0")
{
        header("Location:index.php");
}
if (isset($_SESSION['username']))
{
        $username = $_SESSION['username'];
        $query = <<<END
        INSERT INTO statistics_pages(username, page)
        VALUES('{$username}', 'device_actions.php')
END;
        $mysqli->query($query);
}

    if (isset($_POST['name'])) {
        $name = $mysqli->real_escape_string($_POST['name']);
        $room = $mysqli->real_escape_string($_POST['room']);
        $query = <<<END
        INSERT INTO devices (name,room)
        VALUES('{$name}','{$room}')
END;
        $mysqli->query($query);
        echo "Device added";
    }
    $content = <<<END
		<div class="container">
		  <h1 id="h1device">Add device</h1>
		  <form id="device_form" method="POST" action="device_actions.php">
		      <input type="text" name="name" placeholder="Device name" class="form-control"><br>
		      <select name="room" id="room" class="options">
		          <option value="kitchen">Kitchen</option>
		          <option value="living room">Living Room</option>
		        </select><br>
		        <div class="login">
		          <input id="sub" type="submit" value="Add device" class="inline">
		          <input id="res" type="reset" value="Reset" class="inline">
		        </div>
END;
echo $content;


    $devices = '<h1 id="h1device">All Devices</h1><br>';
    $query = <<<END
    SELECT * FROM devices
END;
    $res = $mysqli->query($query);
    if ($res->num_rows > 0) {
        while ($row = $res->fetch_object()) {
            $devices .= <<<END
                <p class="device_name">{$row->name} - {$row->room}</p><a class="device_action" href="del_device.php?id={$row->id}" onclick="return confirm('Are you sure?')">
                Remove device</a> <a class="device_action" href="edit_device.php?id={$row->id}">Edit device</a><br>
END;
        }
    }
$devices .= '</div>';
echo $devices;



?>
</body>
</html>
