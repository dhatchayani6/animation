<?php
session_start();

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connect to MongoDB
    require 'C:\xampp\htdocs\venuem\vendor\autoload.php';
    $mongoClient = new MongoDB\Client("mongodb://localhost:27017");
    $db = $mongoClient->eventmanagement; // Change 'your_database_name' to your actual database name
    $collection = $db->admindb;

    // Retrieve email and password from the form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if email and password are empty
    if (empty($email) || empty($password)) {
        $_SESSION['login_message'] = "Email and Password are required.";
    } else {

        // Insert user data into the database
        $result = $collection->insertOne([
            'email' => $email,
            'password' => $password
        ]);

        if ($result->getInsertedCount() > 0) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['login_message'] = "Organizer Login Successful.";
        } else {
            $_SESSION['login_message'] = "Failed to insert user data into the database.";
        }
    }

    // Redirect back to the index.php page
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet" />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/login.css"/>
</head>
<body>

<div class="login-box">
  <h2>LOGIN PAGE</h2>
  <form id="adminlogin" method="post">
    <div class="user-box">
      <input type="text" name="email" pattern="[^ @]*@[^ @]*" >
      <label>EMAIL ID</label>
      <span id="email-error" style="color: red; display: none; margin-bottom: 25px;">Email is required</span>
    </div>
    <div class="user-box">
      <input type="password" name="password">
      <label>PASSWORD</label>
      <span id="password-error" style="color: red; display: none;">Password is required</span>
    </div>
    <button type="button" id="bt_adminlogin">Login</button>
  </form>
</div>
<script>
  document.getElementById("bt_adminlogin").addEventListener("click", function (event) {
    var adminEmail = document.querySelector("input[name='email']").value;
    var adminPassword = document.querySelector("input[name='password']").value;
    var emailError = document.getElementById("email-error");
    var passwordError = document.getElementById("password-error");
    
    if (adminEmail === "") {
      emailError.style.display = "block";
    } else {
      emailError.style.display = "none";
    }
    
    if (adminPassword === "") {
      passwordError.style.display = "block";
    } else {
      passwordError.style.display = "none";
    }
    
    if (adminEmail === "" || adminPassword === "") {
      alert("Email and Password are required.");
    } else {
      document.getElementById("adminlogin").submit();
    }
  });
</script>

</body>
</html>
