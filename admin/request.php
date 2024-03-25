<?php
include 'C:\xampp\htdocs\dproject\vendor\autoload.php';
// Include the header file
include 'C:\xampp\htdocs\dproject\organizer\header.php';

// MongoDB connection
$mongoClient = new MongoDB\Client("mongodb://localhost:27017");
$collection = $mongoClient->eventmanagement->bookevent; // Assuming 'bookevent' is the collection name

// Fetch data from MongoDB collection
$events = $collection->find();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Add Bootstrap CSS if you're using Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/request.css">
</head>
<body>
    <div class="overlay">
        
    </div> 
    <!-- Edit Form -->
<div id="editForm"  style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: white; padding: 20px; border: 1px solid black;">
    <h2>Edit Event</h2>
    <form method="post">
        <input type="hidden" id="event_id" name="event_id">
        <div>
            <label for="event_category">Event Category:</label>
            <input type="text" id="event_category" name="event_category">
        </div><br>
        <div>
            <label for="event_name">Event Name:</label>
            <input type="text" id="event_name" name="event_name">
        </div><br>
        <div>
            <label for="guest_name">Guest Name:</label>
            <input type="text" id="guest_name" name="guest_name">
        </div><br>
        <div>
            <label for="guest_designation">Guest Designation:</label>
            <input type="text" id="guest_designation" name="guest_designation">
        </div><br>
        <div>
            <label for="start_date">Starting Date:</label>
            <input type="date" id="start_date" name="start_date">
        </div><br>
        <div>
            <label for="start_time">Starting Time:</label>
            <input type="time" id="start_time" name="start_time">
        </div><br>
        <div>
            <label for="end_date">Ending Date:</label>
            <input type="date" id="end_date" name="end_date">
        </div><br>
        <div>
            <label for="end_time">Ending Time:</label>
            <input type="time" id="end_time" name="end_time">
        </div><br>
        <div>
            <label for="status">Status:</label>
            <select id="status" name="status">
                <option value="approved">Approved</option>
                <option value="denied">Denied</option>
                <option value="pending">Pending</option>
            </select>
        </div>
        <button type="submit">Update</button>
    </form>
</div>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <button id="editBtn" style="display: none;">EDIT</button>
                    <button>REFRESH</button>
                    <table class="table" id="eventTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>CATEGORY</th>
                                <th>VENUE NAME</th>
                                <th>GUEST NAME</th>
                                <th>GUEST DESIGNATION</th>
                                <th>STARTING DATE</th>
                                <th>STARTING TIME</th>
                                <th>ENDING DATE</th>
                                <th>ENDING TIME</th>
                                <th>STATUS</th>
                                <th>LIVE</th>
                            </tr>
                        </thead>

                        <?php foreach ($events as $event): ?>
                            <tr>
                                <td><?php echo $event['_id']; ?></td>
                                <td><?php echo isset($event['event_category']) ? $event['event_category'] : 'N/A'; ?></td>
                                <td><?php echo $event['event_name']; ?></td>
                                <td><?php echo $event['resource_person_name']; ?></td>
                                <td><?php echo $event['resource_person_designation']; ?></td>
                                <td><?php echo $event['start_date']; ?></td>
                                <td><?php echo $event['start_time']; ?></td>
                                <td><?php echo $event['end_date']; ?></td>
                                <td><?php echo $event['end_time']; ?></td>
                                <td>Request</td>
                                <td>TBD</td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- Add Bootstrap JS if you're using Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Get the table element
        var table = document.getElementById("eventTable");

        // Add click event listener to the table
        table.addEventListener("click", function(event) {
            // Check if the clicked element is a table cell (td)
            if (event.target.tagName.toLowerCase() === "td") {
                // Show the edit button
                document.getElementById("editBtn").style.display = "inline-block";
            } else {
                // Hide the edit button
                document.getElementById("editBtn").style.display = "none";
            }
        });

        // Add click event listener to the edit button
        document.getElementById("editBtn").addEventListener("click", function() {
            // Show the edit form as a pop-up
            document.getElementById("editForm").style.display = "block";
        });

        // Close the edit form when clicking outside of it
        window.addEventListener("click", function(event) {
            if (event.target === document.getElementById("editForm")) {
                document.getElementById("editForm").style.display = "none";
            }
        });
    </script>
<script>
    // Function to populate the edit form with data from the selected row
    function populateEditForm(row) {
        // Get the cells of the selected row
        var cells = row.getElementsByTagName("td");

        // Get the values from the cells
        var eventId = cells[0].textContent;
        var eventCategory = cells[1].textContent;
        var eventName = cells[2].textContent;
        var guestName = cells[3].textContent;
        var guestDesignation = cells[4].textContent;
        var startDate = cells[5].textContent;
        var startTime = cells[6].textContent;
        var endDate = cells[7].textContent;
        var endTime = cells[8].textContent;

        // Populate the edit form fields with the fetched values
        document.getElementById("event_id").value = eventId;
        document.getElementById("event_category").value = eventCategory;
        document.getElementById("event_name").value = eventName;
        document.getElementById("guest_name").value = guestName;
        document.getElementById("guest_designation").value = guestDesignation;
        document.getElementById("start_date").value = startDate;
        document.getElementById("start_time").value = startTime;
        document.getElementById("end_date").value = endDate;
        document.getElementById("end_time").value = endTime;
    }

    // Function to update the table with edited values
    function updateTable() {
        // Get the values from the edit form
        var eventId = document.getElementById("event_id").value;
        var eventCategory = document.getElementById("event_category").value;
        var eventName = document.getElementById("event_name").value;
        var guestName = document.getElementById("guest_name").value;
        var guestDesignation = document.getElementById("guest_designation").value;
        var startDate = document.getElementById("start_date").value;
        var startTime = document.getElementById("start_time").value;
        var endDate = document.getElementById("end_date").value;
        var endTime = document.getElementById("end_time").value;

        // Find the row in the table with the corresponding event ID
        var rows = document.getElementById("eventTable").getElementsByTagName("tr");
        for (var i = 0; i < rows.length; i++) {
            var cells = rows[i].getElementsByTagName("td");
            if (cells.length > 0 && cells[0].textContent === eventId) {
                // Update the table cells with the new values
                cells[1].textContent = eventCategory;
                cells[2].textContent = eventName;
                cells[3].textContent = guestName;
                cells[4].textContent = guestDesignation;
                cells[5].textContent = startDate;
                cells[6].textContent = startTime;
                cells[7].textContent = endDate;
                cells[8].textContent = endTime;
                break; // Exit the loop once the row is updated
            }
        }
    }

    // Add submit event listener to the edit form
    document.getElementById("editForm").addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent form submission
        // Update the table with edited values
        updateTable();
        // Hide the edit form
        document.getElementById("editForm").style.display = "none";
    });

    // Get the table element
    var table = document.getElementById("eventTable");

    // Add click event listener to the table
    table.addEventListener("click", function(event) {
        // Check if the clicked element is a table cell (td)
        if (event.target.tagName.toLowerCase() === "td") {
            // Show the edit button
            document.getElementById("editBtn").style.display = "inline-block";
            // Populate the edit form with data from the selected row
            populateEditForm(event.target.parentNode);
        } else {
            // Hide the edit button
            document.getElementById("editBtn").style.display = "none";
        }
    });

    // Close the edit form when clicking outside of it
    window.addEventListener("click", function(event) {
        if (event.target === document.getElementById("editForm")) {
            document.getElementById("editForm").style.display = "none";
        }
    });
</script>
<script>
    // Add submit event listener to the edit form
document.getElementById("editForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent form submission
    // Update the table with edited values
    updateTable();
    // Hide the edit form
    document.getElementById("editForm").style.display = "none";
});

// Function to update the table with edited values
function updateTable() {
    // Get the values from the edit form
    var eventId = document.getElementById("event_id").value;
    var eventCategory = document.getElementById("event_category").value;
    var eventName = document.getElementById("event_name").value;
    var guestName = document.getElementById("guest_name").value;
    var guestDesignation = document.getElementById("guest_designation").value;
    var startDate = document.getElementById("start_date").value;
    var startTime = document.getElementById("start_time").value;
    var endDate = document.getElementById("end_date").value;
    var endTime = document.getElementById("end_time").value;
    var status = document.getElementById("status").value;

    // Find the row in the table with the corresponding event ID
    var rows = document.getElementById("eventTable").getElementsByTagName("tr");
    for (var i = 0; i < rows.length; i++) {
        var cells = rows[i].getElementsByTagName("td");
        if (cells.length > 0 && cells[0].textContent === eventId) {
            // Update the table cells with the new values
            cells[1].textContent = eventCategory;
            cells[2].textContent = eventName;
            cells[3].textContent = guestName;
            cells[4].textContent = guestDesignation;
            cells[5].textContent = startDate;
            cells[6].textContent = startTime;
            cells[7].textContent = endDate;
            cells[8].textContent = endTime;
            cells[9].textContent = status; // Update the status column
            break; // Exit the loop once the row is updated
        }
    }
}

</script>