<?php
    session_start(); // Start session

    if (!isset($_SESSION["username"]) || $_SESSION["username"] == "" || !isset($_SESSION["password"]) || $_SESSION["password"] == "") {
        header("Location: login.php?error=unauthorised");
        exit();
    } else {
        $user = $_SESSION["username"];
        $pw = $_SESSION["password"];
    }

    function write($name)
    {
        return $_SESSION["sql"][$name];
    }

    function isCurrentUser()
    {
        return (!isset($_GET["user"]) || $_GET["user"] == "" || $_GET["user"] == $_SESSION["username"]);
    }

    function writeOther($name)
    {
        $DBuser = "root";
        $DBpw = "";
        $DBname = "socialdb";
        $DBconn = new mysqli('localhost', $DBuser, $DBpw, $DBname); // SQL connection

        if ($DBconn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else {
            $sql = "SELECT * FROM users WHERE username = '" . $_GET["user"] . "';";
            try {
                $result = $DBconn->query($sql);
                $row = $result->fetch_assoc();
                return $row[$name];
            } catch (Exception $ex) {
                echo "<h1 class='errorHeader'>Error: " . $ex->getMessage() . "</h1><br><a class='Btn' href='profile.php'>Return</a>";
            }
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php if (isCurrentUser()) echo "My Profile"; else echo $_GET["user"]; ?></title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: gray;
            margin: 0;
            padding: 0;
        }

        .container {
                max-width: 800px;
                margin: 0 auto;
                padding: 20px;
                background-color: #f5f5f5;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                border-radius: 5px;
                margin-top: 20px;
            }

        
        .menuDiv {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px;
            background-color: #f2f2f2;
        }

        .divLink {
            text-decoration: none;
            background-color: #4286f4;
            color: #f5f5f5;
            padding: 10px;
            border-width: 2px;
            border-radius: 5px;
            border-color: #333;
            transition: background-color 0.3s;
        }
        .divLink:hover {
            color: #333;
            background-color: #f5f5f5;
            border-color: #4286f4;
        }

        h1 {
            margin-top: 0;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="button"] {
            margin-top: 5px;
            padding: 5px 10px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        input[type="button"]:hover {
            background-color: #000;
        }

        img {
            max-width: 200px;
            height: auto;
        }
    </style>
</head>

<div class="menuDiv">
    <img width="50px" height="50px" src="<?php echo $_SESSION["photo"]; ?>">
    <a class="divLink" href="profile.php">Profile</a>
    <a class="divLink" href="homepage.php">Homepage</a>
    <a class="divLink" href="messages.php">Messages</a>
    <a class="divLink" href="members.php">Members</a>
    <a class="divLink" href="homepage.php?LogOut=yes">Log out</a>
    <a class="divLink" href="contact.php">Contact</a>
</div>
<div class="container">
    <h1><?php if (isCurrentUser()) echo "My Profile"; else echo $_GET["user"]; ?></h1>
    <form action="update.php?First=1">
        <a href="<?php if (isCurrentUser()) echo $_SESSION["photo"]; else echo writeOther('photo'); ?>"
           target="_blank"><img src="<?php if (isCurrentUser()) echo $_SESSION["photo"]; else echo writeOther('photo'); ?>" alt="Profile Picture"></a><br>
        <label for="date">Date Joined:</label>
        <input type="text" id="date" name="date" value="<?php if (isCurrentUser()) echo write('date'); else echo writeOther('date'); ?>" disabled><br>
        <label for="fname">First name:</label>
        <input type="text" id="fname" name="fname" value="<?php if (isCurrentUser()) echo write('fname'); else echo writeOther('fname'); ?>" disabled><br>
        <label for="lname">Last name:</label>
        <input type="text" id="lname" name="lname" value="<?php if (isCurrentUser()) echo write('lname'); else echo writeOther('lname'); ?>" disabled><br>
        <label for="email">E-Mail:</label>
        <input type="text" id="email" name="email" value="<?php if (isCurrentUser()) echo write('email'); else echo writeOther('email'); ?>" disabled><br>
        <label for="user">Username:</label>
        <input type="text" id="user" name="user" value="<?php if (isCurrentUser()) echo $user; else echo writeOther('username'); ?>" disabled><br>
        <?php if (isCurrentUser()) {
            echo '<label for="pw">Password:</label>
            <input type="text" id="pw" name="pw" value="' . $pw . '" disabled><br>
            <a href="update.php?First=1"><input type="button" value="Update"></a><br>';}?>
    </form>
</div>
</body>
</html>
