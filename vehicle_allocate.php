<?php include 'connection.php'; ?> 
<?php include 'post_transports.php'; ?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transport Request Form</title>

    <!-- Style -->
    <link rel="stylesheet" href="style/forms.css">
    <style>
        #participantTable {
            border-collapse: separate; 
        }

        #participantTable th,
        #participantTable td {
            border: 1px solid #ccc; 
            padding: 8px;
            text-align: left;
        }

        #participantTable th {
            background-color: #f2f2f2; 
        }
    </style>
</head>

<?php 
$request_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
echo $request_id;
?>
<body>

<div class="card">
    <form action="request_form.php" method="POST" enctype="multipart/form-data">
        <h1>Application for Official Transports</h1>
        
        <!-- Request Employee Details -->
        <h5>Request Employee Details</h5>
        
        <?php if ($employeeData): ?>
        <div class="request-info">
            <p style="font-size: 13px;">
                Requested By: <strong><?php echo htmlspecialchars($employeeData['name']); ?></strong>
                (<?php echo htmlspecialchars($employeeData['designation']); ?>) - <?php echo htmlspecialchars($employeeData['division']); ?>
            </p>
        </div>
        <?php else: ?>
            <p>No employee found.</p>
        <?php endif; ?>
       
        <label for="statusFilter">Filter by Approval Status:</label>
        <select id="statusFilter" name="statusFilter" style="margin-bottom: 20px;">
            <option value="all">All</option>
            <option value="available">Available</option>
            <option value="unavailable">Unavailable</option>
            <option value="maintain">Under Maintenance </option>
        </select>
        
        <h5>Vehicle List</h5>
        <table id="participantTable" class="table table-bordered" style="margin-top: 20px; width: 100%;">
            <thead>
                <tr>
                    <th>Vehicle No</th>
                    <th>Type</th>
                    <th>Seats</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="requestHistoryList">
                <!-- Vehicles will be populated here -->
            </tbody> 
        </table>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function () {
    // Load all vehicles into the table on page load
    loadVehicles('all');

    // Event listener for the dropdown filter
    $('#statusFilter').on('change', function () {
        var filterValue = $(this).val();
        console.log("Selected Filter: " + filterValue); // Debugging
        loadVehicles(filterValue);
    });

    // Function to load vehicles based on filter
    function loadVehicles(filter) {
        $.ajax({
            url: 'fetch_vehicles.php', // PHP script to fetch all vehicles
            type: 'GET',
            dataType: 'json',
            data: { status: filter}, // Pass the filter to the server
            success: function (data) {
                // Clear the current table contents
                $("#requestHistoryList").empty();

                // Populate the table with vehicle data
                $.each(data, function (index, item) {
                    $("#requestHistoryList").append(
                        `<tr>
                            <td>${item.vehicle_no}</td>
                            <td>${item.type}</td>
                            <td>${item.seat_count}</td>
                            <td>${item.status}</td>
                           <td><button type="button" onclick="allocateVehicle('<?php echo $request_id; ?>', '${item.vehicle_no}')">Allocate</button></td>

                        </tr>`
                    );
                });
            },
            error: function (xhr, status, error) {
                alert("Error loading vehicles: " + xhr.responseText);
                console.error("Status:", status, "Error:", error);
            }
        });
    }

});


// Approve HOD 
function allocateVehicle(id, vid) {

alert(id);
    $.ajax({
            url: 'allocate_vehicles.php',
            type: 'POST', // POST is correct for data updates
            data: { id: id, vid: vid  },
            dataType: 'json',
            success: function (response) {
                console.log(response);

                if (response.status === 'success') {
                    alert('Vehicle allocated successfully.');
                    loadVehicles($('#statusFilter').val());
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function (xhr, status, error) {
                alert('Error approving the request.');
                console.error('Status:', status, 'Error:', error, 'Response:', xhr.responseText);
            }
        });
}
</script>

</body>
</html>
