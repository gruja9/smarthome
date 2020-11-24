<?php
include('navigation.php');
if (isset($_POST['username']) and isset($_POST['password']))
{
        $name = $mysqli->real_escape_string($_POST['username']);
        $pwd = $mysqli->real_escape_string($_POST['password']);
        $query = <<<END
        SELECT username, password, id, isAdmin FROM smarthome_users
        WHERE username = '{$name}'
        AND password = '{$pwd}'
END;
        $result = $mysqli->query($query);
        if ($result->num_rows > 0)
        {
                $row = $result->fetch_object();
                $_SESSION["username"] = $row->username;
                $_SESSION["userId"] = $row->id;
		$_SESSION["isAdmin"] = $row->isAdmin;
                header("Location:index.php");
        }
        else
        {
                echo "Wrong username or password. Try again!";
        }
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
<div class="container">
    <header>
      <h1>Welcome to</h1>
      <img src="img/company_logo.png" alt="Company logo" width="150" height="120">
      <h4>Please proceed to login</h4>
    </header>

    <form method="post" action="login.php" class="form">
      <div>
        <label for="email" class="input">Email</label>
        <input name="username" type="text" id="email" class="form-control" placeholder="Username" required/>
      </div>
      <div>
        <label for="pwd" class="input">Password</label>
        <input name="password" type="text" id="pwd" class="form-control" placeholder="Password" required/>
      </div>
      <div class="login">
        <input class="button" type="submit" value="Login">
      </div>

    </form>
  </div>
</body>
</html>



