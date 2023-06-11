<!DOCTYPE html>
<html>
<head>
    <title>Welcome!</title>
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
        }
        
        .center h1 {
            font-size: 36px;
            margin-bottom: 20px;
        }
        
        .info {
            font-size: 18px;
            margin-bottom: 30px;
        }
        
        .Btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 20px;
            text-decoration: none;
            color: #fff;
            background-color: #4286f4;
            border-radius: 5px;
            margin: 0 10px;
        }
        
        .Btn:hover {
            background-color: #326fd9;
        }
    </style>
</head>
<body>
    <div class="center">
        <h1>Welcome to my website!</h1>
        <p class="info">Login or Register to continue.</p>
        <a class="Btn" href="login.php">Login</a>
        <a class="Btn" href="registration.php">Register</a>
    </div>
</body>
</html>
