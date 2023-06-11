<?php
    session_start();
    if(!isset($_SESSION["username"]) || $_SESSION["username"]=="" || !isset($_SESSION["password"]) || $_SESSION["password"]==""){
        header("Location: login.php?error=unauthorised");
        exit();
    }
    if(!isset($_GET["visit"]) || $_GET["visit"]!="yes"){
        $imgDir = uploadImg();
        if($imgDir !== 0 && $imgDir !=""){
            $sql = "UPDATE users SET photo='".$imgDir."' WHERE username='".$_SESSION["username"]."';";
            $DBuser = "root";
            $DBpw = "";
            $DBname = "socialdb";
            $DBconn = new mysqli('localhost',$DBuser,$DBpw,$DBname); //sql connection

            if ($DBconn->connect_error){
                die("Connection failed: " . $conn->connect_error);
            }else{
                if($DBconn->query($sql)===true){
                    $_SESSION["photo"] = $imgDir;
                    header("Location: update.php");
                    exit();
                } else {
                    header("Location: update.php?UpdateError=Error");
                    exit();
                }
            }
        } else {
            header("Location: update.php?UpdateError=Error");
            exit();
        }
    }

    function uploadImg(){
        $target_dir = "uploads/profilePics/";
        $name = $_FILES["fileToUpload"]["name"];
        $extt = explode(".", $name);
        $ext = end($extt);
        $datee = date("d-m-y--h-i-s");
        $target_file = $target_dir .$_SESSION["username"]."-".$datee.".".$ext;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        try {
            // Check if image file is a actual image or fake image
            if(isset($_POST["submit"])) {
                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                if($check !== false) {
                    echo "File is an image - " . $check["mime"] . ".";
                    $uploadOk = 1;
                } else {
                    echo "File is not an image.";
                    $uploadOk = 0;
                }
            }

            // Check if file already exists
            if (file_exists($target_file)) {
                echo "Sorry, file already exists.";
                $uploadOk = 0;
            }

            // Check file size
            if ($_FILES["fileToUpload"]["size"] > 500000) {
                echo "Sorry, your file is too large.";
                $uploadOk = 0;
            }

            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" ) {
                echo "Sorry, only JPG, JPEG & PNG files are allowed.";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your file was not uploaded.";
            } else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                    echo "The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
                    return $target_file;
                } else {
                    echo "Sorry, there was an error uploading your file.";
                    return 0;
                }
            }
        } catch(Exception $ex) {
            echo "<h1 class='errorHeader'>Error: ".$ex->getMessage()."</h1><br><a class='Btn' href='registration.php'>Return</a>";
            return 0;
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Change Profile Picture</title>
        <link rel="stylesheet" href="style.css">
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
            }

            .container {
                max-width: 400px;
                margin: 0 auto;
                padding: 20px;
                background-color: #fff;
                border-radius: 4px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            h1 {
                text-align: center;
                margin-top: 0;
            }

            form {
                margin-top: 20px;
            }

            label {
                display: block;
                margin-bottom: 10px;
                font-weight: bold;
            }

            input[type="file"] {
                margin-bottom: 10px;
            }

            input[type="submit"],
            input[type="button"] {
                background-color: #333;
                color: #fff;
                border: none;
                padding: 10px 20px;
                font-size: 16px;
                border-radius: 5px;
                cursor: pointer;
                transition: 0.3s;
            }

            input[type="submit"]:hover,
            input[type="button"]:hover {
                background-color: #000;
            }

            .error {
                color: red;
                margin-top: 10px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Change Profile Picture</h1>
            <form action="uploadPhoto.php" method="post" enctype="multipart/form-data">
                <label for="photo">Select a new profile picture:</label>
                <input type="file" id="fileToUpload" name="fileToUpload">
                <input type="submit" value="Set Profile Picture">
                <a href="update.php?First=1"><input type="button" value="Back"></a>
            </form>
        </div>
    </body>
</html>
