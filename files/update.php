<?php
    session_start(); // Start session

    if (!isset($_SESSION["username"]) || $_SESSION["username"] == "" || !isset($_SESSION["password"]) || $_SESSION["password"] == "") {
        header("Location: login.php?error=unauthorised");
        exit();
    } else {
        $user = $_SESSION["username"];
        $pw = $_SESSION["password"];

        $updateChosen = false;
        $sql = "UPDATE users"; // Update info

        updateSql("fname");
        updateSql("lname");
        updateSql("email");
        updateSql("username");
        updateSql("password");

        // If delete picture selected
        if (isset($_GET["photo"]) && $_GET["photo"] == "null") {
            $sql = "UPDATE users SET photo='nullProfilePic.png' WHERE username='" . $_SESSION["username"] . "';";
            $DBuser = "root";
            $DBpw = "";
            $DBname = "socialdb";
            $DBconn = new mysqli('localhost', $DBuser, $DBpw, $DBname); // SQL connection

            if ($DBconn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            } else {
                if ($DBconn->query($sql) === true) {
                    $_SESSION["photo"] = "nullProfilePic.png";
                    header("Location: update.php");
                    exit();
                } else {
                    header("Location: update.php?UpdateError=Error");
                    exit();
                }
            }
        }

        if ($updateChosen == true) {
            $sql = $sql . " WHERE username='" . write("username") . "';";
            $DBuser = "root";
            $DBpw = "";
            $DBname = "socialdb";
            $DBconn = new mysqli('localhost', $DBuser, $DBpw, $DBname); // SQL connection

            if ($DBconn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            } else {
                if ($DBconn->query($sql) === true) {
                    $sql = "SELECT * FROM users WHERE username = '" . $user . "' AND password = '" . $pw . "';";

                    try {
                        $result = $DBconn->query($sql);
                        if ($result->num_rows > 0) { // User exists
                            $row = $result->fetch_assoc();
                            $_SESSION["username"] = $user;
                            $_SESSION["password"] = $pw;
                            $_SESSION["sql"] = $row;

                            header("Location: homepage.php");
                            exit();
                        } else {
                            echo "This user doesn't exist!";
                        }
                    } catch (Exception $ex) {
                        echo "Error: " . $ex->getMessage();
                    }
                } else {
                    header("Location: update.php?UpdateError=Error");
                    exit();
                }
            }
        } else if (!isset($_GET["First"])) {
            header("Location: profile.php");
            exit();
        }
    }

    function write($name)
    {
        return $_SESSION["sql"][$name];
    }

    function updateSql($name)
    {
        if (isset($_GET[$name]) && $_GET[$name] != "") {
            global $updateChosen, $sql, $user, $pw;
            $updateChosen = true;
            if ($sql != "UPDATE users") $sql = $sql . " AND";
            $sql = $sql . " SET " . $name . "='" . $_GET[$name] . "'";

            if ($name == "username") $user = $name;
            if ($name == "password") $pw = $name;

            setcookie($name, $_GET[$name], time() + (60 * 5)); // Set cookie for 5 minutes
        }
    }

    function checkUpdateError()
    {
        if (isset($_GET["UpdateError"]) && $_GET["UpdateError"] == "Error") {
            echo "There was an error during the update operation!";
        }
    }

    function writeCookie($name)
    {
        if (isset($_COOKIE[$name])) return $_COOKIE[$name];
        else return "";
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Update information</title>
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
                text-align: center;
                margin-bottom: 20px;
            }

            form {
                display: flex;
                flex-direction: column;
            }

            label {
                font-weight: bold;
                margin-bottom: 5px;
            }

            input[type="text"] {
                padding: 10px;
                margin-bottom: 10px;
                border: 1px solid #ccc;
            }

            input[type="submit"],
            input[type="button"] {
                font-size: 12px;
            text-decoration: none;
            align-items: center;
            padding: 5px 10px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 5px;
            }

            input[type="submit"]:hover,
            input[type="button"]:hover {
                background-color: #000;
            }
        </style>
    </head>
    <body>
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
            <h1>Update information</h1>
            <?php checkUpdateError(); ?>
            <form action="update.php" method="get">
                <label for="fname">First name:</label>
                <input type="text" id="fname" name="fname" value="<?php echo writeCookie("fname"); ?>">

                <label for="lname">Last name:</label>
                <input type="text" id="lname" name="lname" value="<?php echo writeCookie("lname"); ?>">

                <label for="email">E-Mail:</label>
                <input type="text" id="email" name="email" value="<?php echo writeCookie("email"); ?>">

                <label for="user">Username:</label>
                <input type="text" id="user" name="username" value="<?php echo writeCookie("username"); ?>">

                <label for="pw">Password:</label>
                <input type="text" id="pw" name="password" value="<?php echo writeCookie("password"); ?>">

                <input type="submit" value="Save">
                <div>
                    <a href="uploadPhoto.php?visit=yes"><input type="button" value="Change profile picture"></a>
                    <a href="update.php?photo=null"><input type="button" value="Delete profile picture"></a>
                </div>
                <a href="homepage.php"><input type="button" value="Back"></a>
            </form>
        </div>
    </body>
</html>
