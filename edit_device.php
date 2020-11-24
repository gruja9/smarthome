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

    if (isset($_GET['id'])) {
        if (isset($_POST['name'])) {
            $name = $mysqli->real_escape_string($_POST['name']);
            $room = $mysqli->real_escape_string($_POST['room']);
            $query = <<<END
            UPDATE devices
            SET name = '{$name}',
            room = '{$room}'
            WHERE id = '{$_GET['id']}'
END;
        $mysqli->query($query);
        echo '<p class="status">Device edited</p>';
        }
        $query = <<<END
            SELECT * FROM devices
            WHERE id = '{$_GET['id']}'
END;
        $res = $mysqli->query($query);
        if ($res->num_rows > 0 ) {
            $row = $res->fetch_object();
            $content = <<<END
							<div class="container">
								<h1>Edit device</h1>
								<form method="POST">
										<input type="text"  name="name" placeholder="Device name" class="form-control"><br>
										<select name="room" id="room" class="options" required>
												<option value="" selected disabled hidden>Select room</option>
												<option value="kitchen">Kitchen</option>
												<option value="living room">Living Room</option>
										</select><br>
										<div class="login">
										<input type="submit" value="Save" class="button">
										</div>
								</form>
							</div>
END;
        }
    }
echo $content;
?>
</body>
</html>
