<!DOCTYPE html>
<html>
<head>
    <title>Registration</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            align-items: center;
            background-color: #f1f1f1;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            
        }

        .container {
            margin: 100px auto;
            max-width: 400px;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .errorPara {
            color: #f00;
            font-weight: bold;
            margin-bottom: 10px;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="password"],
        input[type="file"] {
            width: 93.5%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        input[type="button"] {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #333;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }

        input[type="button"]:hover {
            background-color: #555;
        }

        p {
            font-size: 14px;
            text-align: center;
            margin-top: 20px;
        }

        p a {
            color: #333;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Register</h1>
        <p class="errorPara" id="errorPara"></p>
        <form id="formi" action="reg_check.php" method="post" enctype="multipart/form-data">
            <label for="fname">First name:</label>
            <input type="text" id="fname" name="fname">

            <label for="lname">Last name:</label>
            <input type="text" id="lname" name="lname">

            <label for="photo">Profile picture:</label>
            <input type="file" id="fileToUpload" name="fileToUpload">

            <label for="email">E-Mail:</label>
            <input type="text" id="email" name="email">

            <label for="user">Username:</label>
            <input type="text" id="user" name="user">

            <label for="pw">Password:</label>
            <input type="password" id="pw" name="pw">

            <label for="cpw">Confirm Password:</label>
            <input type="password" id="cpw" name="cpw">

            <input type="button" value="Register" onclick="validate()">
        </form>

        <p><a href="login.php">Already have an account? Log in.</a></p>
    </div>

    <script>
        function validate() {
            var para = document.getElementById("errorPara");
            var user = document.getElementById("user").value;
            var pw = document.getElementById("pw").value;
            var cpw = document.getElementById("cpw").value;
            var email = document.getElementById("email").value;
            var fname = document.getElementById("fname").value;
            var lname = document.getElementById("lname").value;

            if (fname == null || fname.trim() === "") {
                para.innerHTML = "Enter first name!";
                return false;
            } else if (fname.length > 40) {
                para.innerHTML = "First name is too long (" + fname.length + "/40 characters)!";
                return false;
            } else if (lname.length > 40) {
                para.innerHTML = "Last name is too long (" + lname.length + "/40 characters)!";
                return false;
            } else if (lname == null || lname.trim() === "") {
                para.innerHTML = "Enter last name!";
                return false;
            } else if (email == null || email.trim() === "") {
                para.innerHTML = "Enter email!";
                return false;
            } else if (email.length > 40) {
                para.innerHTML = "Email is too long (" + email.length + "/40 characters)!";
                return false;
            } else if (user == null || user.trim() === "") {
                para.innerHTML = "Enter username!";
                return false;
            } else if (user.length > 20) {
                para.innerHTML = "Username is too long (" + user.length + "/20 characters)!";
                return false;
            } else if (pw == null || pw.trim() === "") {
                para.innerHTML = "Enter password!";
                return false;
            } else if (pw.length > 20) {
                para.innerHTML = "Password is too long (" + pw.length + "/20 characters)!";
                return false;
            } else if (pw.length < 8) {
                para.innerHTML = "Password is too short! (Password must be at least 8 characters)!";
                return false;
            } else if (cpw == null || cpw.trim() === "") {
                para.innerHTML = "Confirm password!";
                return false;
            } else if (pw != cpw) {
                para.innerHTML = "Passwords don't match!";
                return false;
            } else {
                document.getElementById("formi").submit();
            }
        }
    </script>
</body>
</html>
