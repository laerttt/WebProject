<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
        }

        .center {
            text-align: center;
            max-width: 400px;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .center h1 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .errorHeader {
            color: red;
            margin-bottom: 10px;
        }

        label {
            display: block;
            text-align: left;
            font-size: 16px;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="password"] {
            width: 275px;
            padding: 10px;
            font-size: 16px;
            border-radius: 3px;
            border: 1px solid #ccc;
            margin-bottom: 15px;
        }

        input[type="button"] {
            display: block;
            width: 300px;
            padding: 10px;
            font-size: 16px;
            color: #fff;
            background-color: #4286f4;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        input[type="button"]:hover {
            background-color: #326fd9;
        }

        p {
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="center">
        <h1>Login</h1>
        <p id="errorPara" class="errorHeader"></p>
        <form id="formi" action="login_check.php" method="post">
            <label for="user">Username:</label>
            <input type="text" id="user" name="user">

            <label for="pw">Password:</label>
            <input type="password" id="pw" name="pw">

            <input type="button" value="Login" onclick="validate()">
        </form>
        <p><a href="registration.php">Create a new account.</a></p>
    </div>

    <script>
        function validate() {
            var para = document.getElementById("errorPara");
            var user = document.getElementById("user").value;
            var pw = document.getElementById("pw").value;
            if (user == null || user == "") {
                para.innerHTML = "Enter username!";
                return false;
            } else if (pw == null || pw == "") {
                para.innerHTML = "Enter password!";
                return false;
            } else {
                document.getElementById("formi").submit();
            }
        }
    </script>
</body>
</html>
