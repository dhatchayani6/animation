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
</head>

<body>
    <section>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <button id="editBtn" style="display: none;">EDIT</button> <!-- Hidden initially -->
                    <button>REFRESH</button>
                    <table class="table">
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

    <!-- Edit Form -->
    <div id="editForm" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: white; padding: 20px; border: 1px solid black;">
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

    <script>
        // Get the edit button
        var editBtn = document.getElementById("editBtn");
        // Get the edit form
        var editForm = document.getElementById("editForm");

        // Function to populate the edit form with data from the selected row
        function populateEditForm(row) {
            // Get the cells of the selected row
            var cells = row.getElementsByTagName("td");

            // Get the values from the cells
            var eventId = cells[0].textContent;
            var eventCategory = cells[1].textContent;

            // Populate the edit form fields with the fetched values
            document.getElementById("event_id").value = eventId;
            document.getElementById("event_category").value = eventCategory;
            // Populate other fields similarly
        }

        // Add click event listener to the table
        document.querySelector("table").addEventListener("click", function(event) {
            // Check if the clicked element is a table cell (td)
            if (event.target.tagName.toLowerCase() === "td") {
                // Show the edit button
                editBtn.style.display = "inline-block";
                // Populate the edit form with data from the selected row
                populateEditForm(event.target.parentNode);
            } else {
                // Hide the edit button
                editBtn.style.display = "none";
            }
        });

        // Add click event listener to the edit button
        editBtn.addEventListener("click", function() {
            // Show the edit form
            editForm.style.display = "block";
        });

        // Add submit event listener to the edit form
        editForm.addEventListener("submit", function(event) {
            // Prevent the default form submission
            event.preventDefault();
            // Get the form data
            var formData = new FormData(this);
            // Perform your update operation with the form data using AJAX or any backend process
            // For example:
            /*
            fetch("update.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Handle response from the server
                console.log(data);
            })
            .catch(error => {
                console.error("Error:", error);
            });
            */
            // After updating, hide the edit form
            editForm.style.display = "none";
        });
    </script>
</body>

</html>
