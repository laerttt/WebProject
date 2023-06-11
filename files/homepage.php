<?php
    session_start();
    
    if(!isset($_SESSION["username"]) || $_SESSION["username"]=="" || !isset($_SESSION["password"]) || $_SESSION["password"]==""){
        header("Location: login.php?error=unauthorised");
        exit();
    } else {
        $user = $_SESSION["username"];
        $pw = $_SESSION["password"];
    }
    
    if(isset($_POST["postText"]) && $_POST["postText"]!=""){
        uploadPost($_POST["postText"]);
    }
    
    if(isset($_GET["LogOut"]) && $_GET["LogOut"]=="yes"){
        session_destroy();
        removeCookies();
        header("Location: login.php");
        exit();
    }
    
    function removeCookies(){
        setcookie("fname","",time()-3600);
        setcookie("lname","",time()-3600);
        setcookie("email","",time()-3600);
        setcookie("username","",time()-3600);
        setcookie("password","",time()-3600);
    }
    
    function loadPosts(){
        $DBuser = "root";
        $DBpw = "";
        $DBname = "socialdb";
        $DBconn = new mysqli('localhost',$DBuser,$DBpw,$DBname);
        
        if ($DBconn->connect_error){
            die("Connection failed: " . $conn->connect_error);
        } else {
            $sql = "SELECT * FROM posts ORDER BY date DESC;";
            
            try {
                $result = $DBconn->query($sql);
                
                if($result->num_rows > 0){
                    echo "<p class='info'>Posts from other users</p><br>";
                    
                    while($row = $result->fetch_assoc()){
                        echo "<p class='info'>".$row["date"]." - <a href='profile.php?user=".$row["username"]."'>".$row["username"]."</a>: ".$row["body"]."</p><br>";
                    }
                } else {
                    echo "<p class='info'>There are no posts yet :(</p><br>";
                }
            } catch(Exception $ex) {
                echo "<h1 class='errorHeader'>Error: ".$ex->getMessage()."</h1><br><a class='Btn' href='homepage.php'>Return</a>";
            }
        }
    }
    
    function uploadPost($body){
        $DBuser = "root";
        $DBpw = "";
        $DBname = "socialdb";
        $DBconn = new mysqli('localhost',$DBuser,$DBpw,$DBname);
        $body = $DBconn->real_escape_string($body);
        
        if ($DBconn->connect_error){
            die("Connection failed: " . $conn->connect_error);
        } else {
            $sql = "INSERT INTO posts VALUES(NULL,'".$body."','".$_SESSION["username"]."');";
            
            try {
                if($result = $DBconn->query($sql)){
                    header("Location: homepage.php");
                    exit();
                } else {
                    echo $DBconn->error;
                }
            } catch(Exception $ex) {
                echo "<h1 class='errorHeader'>Error: ".$ex->getMessage()."</h1><br><a class='Btn' href='homepage.php'>Return</a>";
            }
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Homepage</title>
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

            .header {
                text-align: center;
                margin-bottom: 20px;
            }

            .welcome {
                font-size: 24px;
                color: #333;
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
                border-radius: 5px;
		border-color: #4286f4;
                transition: background-color 0.3s;
            }

            .divLink:hover {
            color: #333;
            background-color: #f5f5f5;
            border-color: #4286f4;
        }

            .postForm {
                display: flex;
                margin-bottom: 20px;
            }

            .postForm label {
                font-weight: bold;
                margin-right: 10px;
                line-height: 30px;
            }

            .postForm input[type="text"] {
                flex: 1;
                padding: 5px;
                border-radius: 5px;
                border: 1px solid #ccc;
                margin-right: 5px;
            }

            .postForm input[type="submit"] {
                background-color: #333;
                color: #fff;
                border: none;
                padding: 5px 10px;
                border-radius: 5px;
                cursor: pointer;
            }
            .postForm input[type="submit"]:hover{
                background-color: #000;
            }
            .post {
                margin-bottom: 10px;
                padding: 10px;
                border-radius: 5px;
                background-color: #333;
            }

            .post .info {
                font-size: 14px;
                color: #666;
                margin-bottom: 5px;
            }

            .post .username {
                font-size: 18px;
                font-weight: bold;
                margin-bottom: 5px;
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
            <div class="header">
                <h1 class="welcome">Welcome <?php echo $_SESSION["username"]; ?>!</h1>
            </div>
            <form class="postForm" method="POST">
                <label for="postText">Post something:</label>
                <input type="text" name="postText" id="postText">
                <input type="submit" value="Post">
            </form>

            <?php loadPosts(); ?>

        </div>
    </body>
</html>
