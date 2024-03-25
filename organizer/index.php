<?php
// Establish a connection to MongoDB
require 'C:\xampp\htdocs\venuem\vendor\autoload.php';
$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$db = $mongoClient->eventmanagement; // Change 'eventmanagement' to your actual database name
$venueCollection = $db->addvenue; // Change 'addvenue' to your actual collection name for storing venues
$eventCollection = $db->bookevent; // Change 'bookevent' to your actual collection name for storing booked events

// Fetch venue names from MongoDB
$venuesCursor = $venueCollection->find([], ['projection' => ['venue_name' => 1]]);
$venues = iterator_to_array($venuesCursor);

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $eventcategory = $_POST['select']; // Assuming this is your event category
    $eventName = $_POST['eventname'];
    $resourcePersonName = $_POST['resourcename'];
    $resourcePersonDesignation = $_POST['designation'];
    $startDate = $_POST['startdate'];
    $startTime = $_POST['starttime'];
    $endDate = $_POST['enddate'];
    $endTime = $_POST['endtime'];
    $selectedVenue = $_POST['venue'];

    // Insert event data into MongoDB
    $result = $eventCollection->insertOne([

        'event_category' => $eventcategory,
        'event_name' => $eventName,
        'resource_person_name' => $resourcePersonName,
        'resource_person_designation' => $resourcePersonDesignation,
        'start_date' => $startDate,
        'start_time' => $startTime,
        'end_date' => $endDate,
        'end_time' => $endTime,
        'venue' => $selectedVenue
    ]);

    if ($result->getInsertedCount() > 0) {
        // Data inserted successfully
        $venueAdded = true; // Set flag variable to true
    }
}
?>

<?php include 'C:\xampp\htdocs\dproject\organizer\header.php';?>

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
    <section>
        <div class="container">
            <form method="post">
            <div class="row">
                <div class="col-lg-12">
                    <h2>BOOK EVENT</h2>
                </div>
                <div class="col-lg-4 mb-4">
                    <label>Event Category</label>
                    <select class="form-control" name="select" style="border: 0px;border-radius: 30px;padding: 11px;width: 90%;">
                        <option value="0">SELECT EVENT CATEGORY</option>
                        <option >SYMPOSIUM</option>
                        <option>ONE DAY SEMINAR</option>
                        <option>HACKATHON</option>
                        <option >ONE DAY WORKSHOP</option>
                        <option >OTHERS</option>
                       
                    </select> 
                </div>
                <div class="col-lg-4 mb-4">
                        <label>Event Name</label>
                        <input type="text" class="form-control" name="eventname" required="">
                </div>
                <div class="col-lg-4 mb-4">
                        <label>Broucher Invitations</label>
                        <input type="file" class="form-control" name="broucher" required="">
                </div>
                <div class="col-lg-4 mb-4">
                    <label>Resource Person Name</label>
                    <input type="text" class="form-control" name="resourcename" placeholder="Resource person Name" required="">
                </div>
                <div class="col-lg-4 mb-4">
                      <label for="email">Resource Person Designation</label>
                      <input type="text" class="form-control" name="designation" placeholder="Resource person designation" required="">
                </div>
                <div class="col-lg-4 mb-4">
                        <label>Resource Person Image</label>
                        <input class="form-control" type="file">
                </div>
                <div class="col-lg-2 mb-4">
                    <label>Choose Venue</label>
                    <select class="form-control" name="venue">
                        <option value="0">SELECT VENUE</option>
                        <?php foreach ($venues as $venue): ?>
                            <option value="<?php echo $venue['venue_name']; ?>"><?php echo $venue['venue_name']; ?></option>
                        <?php endforeach; ?>
                    </select> 
                </div>
                <div class="col-lg-2 mb-4">
                        <label>start date</label>
                        <input class="form-control" type="date" name="startdate">
                </div>
                <div class="col-lg-2 mb-4">
                        <label>start time</label>
                        <input class="form-control" type="time" name="starttime">
                </div>
                <div class="col-lg-2 mb-4">
                        <label>End date</label>
                        <input class="form-control" type="date" name="enddate">
                </div>
                <div class="col-lg-2 mb-4">
                        <label>end time</label>
                        <input class="form-control" type="time" name="endtime">
                </div>
            </div>
            <button type="submit">BOOK EVENT</button>
            </form>
        </div>
    </section>

     <!-- Bootstrap Bundle with Popper -->
     <script src="../js/jquery-3.7.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
</body>
</html>
