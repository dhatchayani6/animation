<?php
require 'C:\xampp\htdocs\venuem\vendor\autoload.php';

// MongoDB connection
$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$collection = $mongoClient->eventmanagement->registerdb;

// Handle user login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Find user in the registerdb collection by email
    $user = $collection->findOne(['email' => $email]);
    if ($user) {
        // Verify the password
        if ($password === $user['password']) { // Check if password matches
            // Password is correct, login successful
            session_start();
            $_SESSION['message'] = "Login successful.";
            header("Location: header.php");
            exit();
        } else {
            // Password is incorrect
            echo "Invalid password.";
        }
    } else {
        // User not found with the given email
        echo "User not found.";
    }
}
?>

<?php include 'C:\xampp\htdocs\dproject\student\header.php';?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet" />
    <!-- Custom CSS -->
     <style>
        form{
            background: grey;
            width: 50%;
            height: 50%;
            margin-left: 25%;
            margin-top: 70px;
            border: 0px;
            border-radius: 18px;
        }
        form input[type="text"], form input[type="password"],label {
            border: 0px;
            border-radius: 20px;
            width: 155%;
            padding: 10px;
            margin-left: 70%;
        }
        h2{
            text-align: center;
            color: #ffff;
            padding: 10px;
        }
        button {
            margin-top: 55px;
            margin-left: 32%;
            cursor: pointer;
            border: 0px;
            border-radius: 10px;
            padding: 13px;
            width: 25%;
            margin-bottom: 60px;
        }
        label{
            border: 0px;
            border-radius: 20px;
            width: 127%;
            padding: 10px;
            margin-left: 70%;
            color: #ffff;
        }
        p {
            margin-top: -50px;
        padding: 41px;
        text-align: center;
        color: #ffff;
            }
            a {
                color: #000000;
    text-decoration: none;
    font-size: 30px;
}
     </style>
</head>
<body>
<section>
    <div class="container">
        <form method="POST">
            <div class="row">
                <div class="col-lg-12">
                    <h2>LOGIN</h2>
                    <div class="col-lg-4">
                        <label class="form-label">EMAIL</label>
                        <input type="text" class="form-control" id="name1" name="email" required>
                    </div>
                    <div class="col-lg-4">
                        <label  class="form-label">PASSWORD</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                </div>
                
            </div>
            <button type="submit"  name="login">Login</button>
            <p>CLICK HERE TO REGISTER&nbsp;<a href="register.php">REGISTER HERE</a></p>
        </form>
    </div>
</section>

     <!-- Bootstrap Bundle with Popper -->
     <script src="../js/jquery-3.7.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>
