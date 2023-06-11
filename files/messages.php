<?php
session_start();
if (!isset($_SESSION["username"]) || $_SESSION["username"] == "" || !isset($_SESSION["password"]) || $_SESSION["password"] == "") {
    header("Location: login.php?error=unauthorised");
    exit();
} else {
    $user = $_SESSION["username"];
    $pw = $_SESSION["password"];
}

if (isset($_POST["postText"]) && $_POST["postText"] != "") {
    uploadPost($_POST["postText"]);
}

if (isset($_GET["return"]) && $_GET["return"] == "yes") {
    unset($_SESSION["msgUser"]);
    unset($_POST["msgUser"]);
    unset($_POST["msgText"]);
}

if (!isset($_POST["msgUser"]) && isset($_SESSION["msgUser"])) {
    $_POST["msgUser"] = $_SESSION["msgUser"];
}

if (isset($_POST["msgText"]) && $_POST["msgText"] != "") {
    uploadMsg($_POST["msgText"]);
}

function userExists()
{
    $DBuser = "root";
    $DBpw = "";
    $DBname = "socialdb";
    $DBconn = new mysqli('localhost', $DBuser, $DBpw, $DBname);

    if ($DBconn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        $sql = "SELECT * FROM users WHERE username='" . $_POST["msgUser"] . "';";
        try {
            $result = $DBconn->query($sql);
            if ($result->num_rows == 0)
                return false;
            else {
                if (!isset($_SESSION["msgUser"]))
                    $_SESSION["msgUser"] = $_POST["msgUser"];
                return true;
            }
        } catch (Exception $ex) {
            echo "<h1 class='errorHeader'>Error: " . $ex->getMessage() . "</h1><br><a class='Btn' href='homepage.php'>Return</a>";
        }
    }
}

function loadMsgs()
{
    $DBuser = "root";
    $DBpw = "";
    $DBname = "socialdb";
    $DBconn = new mysqli('localhost', $DBuser, $DBpw, $DBname);

    if ($DBconn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        $user1 = $_SESSION["username"];
        $user2 = $_POST["msgUser"];
        $sql = "SELECT * FROM messages WHERE (sender='" . $user1 . "' AND receiver='" . $user2 . "') OR (sender = '" . $user2 . "' AND receiver = '" . $user1 . "') ORDER BY date DESC;";
        try {
            $result = $DBconn->query($sql);
            if ($result->num_rows > 0) {
                echo "<p class='info'>Messages with " . $user2 . ":</p><br>";
                while ($row = $result->fetch_assoc()) {
                    if ($row["sender"] == $user1) {
                        echo "<p class='sentMsg'>" . $row["date"] . "<br>" . $user1 . "<br>" . $row["body"] . "</p><br>";
                    } else {
                        echo "<p class='receivedMsg'>" . $row["date"] . "<br><a href='profile.php?user=" . $user2 . "'>" . $user2 . "</a><br>" . $row["body"] . "</p><br>";
                    }
                }
            } else {
                echo "<p class='info'>You haven't exchanged any messages with " . $user2 . " yet!</p><br>";
            }
        } catch (Exception $ex) {
            echo "<h1 class='errorHeader'>Error: " . $ex->getMessage() . "</h1><br><a class='Btn' href='messages.php'>Return</a>";
        }
    }
}

function userSelected()
{
    return ((isset($_POST["msgUser"]) && $_POST["msgUser"] != "") || (isset($_SESSION["msgUser"]) && $_SESSION["msgUser"] != "") || (isset($_POST["msgText"]) && $_POST["msgText"] != ""));
}

function uploadMsg($body)
{
    $DBuser = "root";
    $DBpw = "";
    $DBname = "socialdb";
    $DBconn = new mysqli('localhost', $DBuser, $DBpw, $DBname);
    $body = $DBconn->real_escape_string($body);

    if ($DBconn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } else {
        $sql = "INSERT INTO messages VALUES(NULL, '" . $_SESSION["username"] . "', '" . $_SESSION["msgUser"] . "','" . $body . "');";
        try {
            if ($result = $DBconn->query($sql)) {
                header("Location: messages.php");
                exit();
            } else
                echo $DBconn->error;
        } catch (Exception $ex) {
            echo "<h1 class='errorHeader'>Error: " . $ex->getMessage() . "</h1><br><a class='Btn' href='messages.php?return=yes'>Return</a>";
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Messages</title>
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

        .errorHeader {
            color: #f00;
        }

        .info {
            font-weight: bold;
        }

        .msgForm {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
        }

        .msgForm label {
            margin-right: 5px;
        }

        .msgForm input[type="text"] {
            margin-right: 5px;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            flex: 1;
        }

        .msgForm input[type="button"] {
            margin-right: 5px;
            font-size: 11px;
            align-items: center;
            padding: 5px 10px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .msgForm input[type="button"]:hover {
            background-color: #000;

        }
        .back{
            font-size: 12px;
            text-decoration: none;
            align-items: center;
            padding: 5px 10px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .back:hover{
            background-color: #000; 
        }
        
        .messages {
            margin-top: 20px;
            border-top: 1px solid #ccc;
            padding-top: 20px;
        }

        .sentMsg,
        .receivedMsg {
            background-color: #f2f2f2;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        
        .sentMsg {
            background-color: #e3e3e3;
            text-align: right;
            transition: 0.3s;
        }
        .sentMsg:hover{
            background-color: #cccbca;
        }
        .receivedMsg {
            background-color: #e3e3e3;
            text-align: left;
            transition: 0.3s;
        }
        .receivedMsg:hover{
            background-color: #cccbca;
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
        <p id="errorPara" class="errorHeader">
            <?php if (isset($_GET["error"]) && $_GET["error"] == "userNotFound")
                echo "This user doesn't exist!"; ?>
        </p>
        <?php
        if (userSelected()) {
            if (userExists()) {
                echo '<form id="msgSend" class="msgForm" method="POST">
                    <label for="msgText" class="info">Send a message to ' . $_POST["msgUser"] . ':</label>
                    <input type="text" name="msgText" id="msgText">
                    <input type="button" value="Send" onclick="validateMsgSend()">
                    <a class="back" href="messages.php?return=yes">Back</a><br>
                </form>';
                loadMsgs();
            } else {
                header("Location: messages.php?error=userNotFound");
                exit();
            }
        } else {
            echo "<form id='msgSearch' class='msgForm' action='messages.php' method='POST'>
            <label for='msgUser' class='info'>Enter username:</label>
            <input type='text' name='msgUser' id='msgUser'>
            <input type='button' value='Search' onclick='validateMsgSearch()'><br>
        </form>";
        }
        ?>
    </div>
    <script>
        function validateMsgSend() {
            var msg = document.getElementById("msgText").value;
            if (msg == null || msg === "") {
                document.getElementById("errorPara").innerHTML = "Please enter a message!";
            } else if (msg.length > 500) {
                document.getElementById("errorPara").innerHTML = "Message can't contain more than 500 characters! This message contains " + msg.length + " characters!";
            } else {
                document.getElementById("msgSend").submit();
            }
        }

        function validateMsgSearch() {
            var user = document.getElementById("msgUser").value;
            if (user == null || user === "") {
                document.getElementById("errorPara").innerHTML = "Please enter the username of the user you want to message!";
            } else {
                document.getElementById("msgSearch").submit();
            }
        }
    </script>
</body>

</html>