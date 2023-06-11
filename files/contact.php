<?php
    session_start();
    if(!isset($_SESSION["username"]) || $_SESSION["username"]=="" || !isset($_SESSION["password"]) || $_SESSION["password"]==""){
        header("Location: login.php?error=unauthorised");
		exit();
    }
?>
<!DOCTYPE html>
<html>
    <style>
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
    </style>
    <head>
        <title>Homepage</title>
        <link rel="stylesheet" href="style.css">
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
        </div><br>
        <div class="center">
            <a class="Btn" href="mailto:example@gmail.com">Contact Us</a><br>
        </div>

    </body>
</html>
