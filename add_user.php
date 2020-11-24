<?php
include('navigation.php');
error_reporting(0);
if (!isset($_SESSION['userId']) || $_SESSION['isAdmin'] === "0")
{
	header("Location:index.php");
}
if (isset($_SESSION['username']))
{
        $username = $_SESSION['username'];
        $query = <<<END
        INSERT INTO statistics_pages(username, page)
        VALUES('{$username}', 'add_user.php')
END;
        $mysqli->query($query);
}
if (isset($_POST['username']) and isset($_POST['password']))
{
        $name = $mysqli->real_escape_string($_POST['username']);
        $pwd = $mysqli->real_escape_string($_POST['password']);
        $email = $mysqli->real_escape_string($_POST['email']);
        $fname = $mysqli->real_escape_string($_POST['fname']);
        $lname = $mysqli->real_escape_string($_POST['lname']);
	$isAdmin = $mysqli->real_escape_string($_POST['isAdmin']);

        $query = <<<END
        INSERT INTO smarthome_users(username,password,email,fname,lname,isAdmin)
        VALUES('{$name}','{$pwd}','{$email}',
        '{$fname}','{$lname}','{$isAdmin}')
END;
        if ($mysqli->query($query) !== TRUE)
        {
                die("Could not query database" . $mysqli->errno . " : " . $mysqli->error);
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
        <h3>No account?<br> Sign up here please</h3>
    </header>

    <form method="post" action="add_user.php" class="form">
        <div>
            <label for="fname" class="input">Fist name</label>
            <input name="fname" type="text" id="fname" class="form-control" placeholder="First name" required/>
        </div>
        <div>
            <label for="lname" class="input">Last name</label>
            <input name="lname" type="text" id="lname" class="form-control" placeholder="Last name" required/>
        </div>

        <div>
            <label for="email" class="input">Email</label>
            <input name="email" type="text" id="email" class="form-control" placeholder="Email address" required/>
        </div>
        <div>
            <label for="username" class="input">Username</label>
            <input name="username" type="text" id="username" class="form-control" placeholder="Username" required/>
        </div>
        <div>
            <label for="pwd" class="input">Password</label>
            <input name="password" type="text" id="pwd" class="form-control" placeholder="Password" required/>
        </div>
	<div>
	    <input name="isAdmin" type="checkbox" value="1" id="isAdmin" class="form-control">Administrator?
	</div>
        <div class="login">
            <input class="button other" type="submit" value="Sign Up">
            <input class="button other" type="reset" value="Reset">
        </div>

    </form>
</div>
</body>
</html>
