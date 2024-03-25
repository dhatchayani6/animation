<!-- <?php
// Include MongoDB PHP library
require 'C:\xampp\htdocs\venuem\vendor\autoload.php';

// Establish a connection to MongoDB
$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$db = $mongoClient->eventmanagement; // Change 'your_database_name' to your actual database name
$collection = $db->addvenue;

$venueAdded = false; // Initialize flag variable

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $venueName = $_POST['venuename'];
    $venueLocation = $_POST['venuelocation'];
    $venueCapacity = $_POST['venuecapacity'];
    $venueFloor = $_POST['venuefloor'];
    $area = $_POST['area'];
    $image = $_FILES['image']['name'];

    // Validate the form data if needed

    // Insert data into MongoDB
    $result = $collection->insertOne([
        'venue_name' => $venueName,
        'venue_location' => $venueLocation,
        'venue_capacity' => $venueCapacity,
        'venue_floor' => $venueFloor,
        'area' => $area,
        'image' => $image // Store the image path in the database
    ]);

    if ($result->getInsertedCount() > 0) {
        // Data inserted successfully
        $venueAdded = true; // Set flag variable to true
    }
}

// Retrieve data from MongoDB
$venues = $collection->find();



?> -->

<?php include 'C:\xampp\htdocs\dproject\admin\header.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet" />
    <!-- Custom CSS -->
    <link href="../css/index.css" rel="stylesheet" />
</head>

<body>
    <section class="index">
        <div class="container">
            <h2>VENUES</h2>
            <?php if ($venueAdded): ?>
                <div class="alert alert-success" role="alert">
                    Venue added successfully.
                </div>
            <?php endif; ?>
            <div class="row">
                <?php foreach ($venues as $venue): ?>
                    <div class="col-lg-4 mb-4">
                        <div class="card">
                        <img src="../uploads/<?php echo $venue['image']; ?>" class="card-img-top" alt="Venue Image">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $venue['venue_name']; ?></h5>
                                <p class="card-text">Location: <?php echo $venue['venue_location']; ?></p>
                                <p class="card-text">Capacity: <?php echo $venue['venue_capacity']; ?></p>
                                <p class="card-text">Floor: <?php echo $venue['venue_floor']; ?></p>
                                <p class="card-text">Area: <?php echo $venue['area']; ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="add-venue">
        <div class="container">
            <h2>Add Venue</h2>
            <form method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-lg-4 mb-4">
                        <label>Venue Name</label>
                        <input type="text" class="form-control" name="venuename" required="">
                    </div>
                    <div class="col-lg-4 mb-4">
                        <label>Venue Location</label>
                        <input type="text" class="form-control" name="venuelocation" required="">
                    </div>
                    <div class="col-lg-4 mb-4">
                        <label>Venue Capacity</label>
                        <input type="number" class="form-control" name="venuecapacity" required="">
                    </div>
                    <div class="col-lg-4 mb-4">
                        <label>Venue Floor</label>
                        <input type="number" class="form-control" name="venuefloor" required="">
                    </div>
                    <div class="col-lg-4 mb-4">
                        <label>Area</label>
                        <input type="number" class="form-control" name="area" required="">
                    </div>
                    <div class="col-lg-4 mb-4">
                        <label>Image</label>
                        <input class="form-control" type="file" name="image">
                    </div>
                </div>
                <button type="submit" >Add Venue</button>
            </form>
        </div>
    </section>

    <!-- Bootstrap Bundle with Popper -->
    <script src="../js/jquery-3.7.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>

</html>
