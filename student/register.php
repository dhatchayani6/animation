<?php
require 'C:\xampp\htdocs\venuem\vendor\autoload.php';

// MongoDB connection
$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$collection = $mongoClient->eventmanagement->registerdb;

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $mobileNumber = $_POST["mobilenumber"];
    $password = $_POST["password"];

    // Prepare document to insert
    $document = [
        "name" => $name,
        "email" => $email,
        "mobileNumber" => $mobileNumber,
        "password" => $password // Store hashed password
    ];

    // Insert document into MongoDB collection
    $insertResult = $collection->insertOne($document);

    // Check if insertion was successful
    if ($insertResult->getInsertedCount() > 0) {
        // Redirect to login page
        header("Location: login.php");
        exit();
    } else {
        echo "Failed to register user.";
    }
}
?>

<?php include 'C:\xampp\htdocs\dproject\student\header.php';?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
            width: 160%;
            padding: 10px;
            margin-left: 70%;
        }
        h2{
            text-align: center;
            color: #ffff;
            padding: 20px;
        }
        button {
            margin-top: 55px;
            margin-left: 35%;
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
     </style>
</head>
<body>
<section>
    <div class="container">
        <form method="POST">
            <div class="row">
                <div class="col-lg-12">
                    <h2>REGISTER</h2>
                    <div class="col-lg-4">
                        <label class="form-label">NAME</label>
                        <input type="text" class="form-control" id="name1" name="name" required>
                    </div>
                    <div class="col-lg-4">
                        <label class="form-label">EMAIL</label>
                        <input type="text" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="col-lg-4">
                        <label class="form-label">MOBILE NUMBER</label>
                        <input type="text" class="form-control" id="mobilenumber" name="mobilenumber" required>
                    </div>
                    <div class="col-lg-4">
                        <label  class="form-label">PASSWORD</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                </div>
                
            </div>
            <button type="submit"  name="register">REGISTER</button>
        </form>
    </div>
</section>

     <!-- Bootstrap Bundle with Popper -->
     <script src="../js/jquery-3.7.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>

</body>
</html>
