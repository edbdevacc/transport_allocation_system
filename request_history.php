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
    /* Add border to the table */
    #participantTable {
        border-collapse: collapse; /* Ensures that borders are collapsed together */
    }
    
    #participantTable th,
    #participantTable td {
        border: 1px solid black; /* Adds a solid border to table cells */
        padding: 8px; /* Adds some padding inside the cells */
        text-align: left; /* Aligns text to the left */
    }

    #participantTable th {
        background-color: #f2f2f2; /* Optional: adds a background color to the header */
    }
</style>
</head>
<body>

<div class="card">
<form action="request_form.php" method="POST" enctype="multipart/form-data">
<h1>Application for Official Transports</h1>
    
    <!-- Request Employee Details -->
    <h5>Request Employee Details</h5>

    <?php if ($employeeData): ?>
    <div class="request-info">
        <p style="font: size 13px;">
            Requested By: <strong><?php echo htmlspecialchars($employeeData['name']); ?></strong>
            (<?php echo htmlspecialchars($employeeData['designation']); ?>) - <?php echo htmlspecialchars($employeeData['division']); ?>
        </p>
    </div>
    <?php else: ?>
        <p>No employee found.</p>
    <?php endif; ?>
   
    <label for="approvalFilter">Filter by Approval Status:</label>
<select id="approvalFilter" name="approvalFilter" style="margin-bottom: 20px;">
    <option value="all">All</option>
    <option value="pending">Pending</option>
    <option value="approved">Approved</option>
    <option value="rejected">Rejected</option>
</select>
    <h5>Request List</h5>
    <table id="participantTable" class="table table-bordered" style="margin-top: 20px; width: 100%;">
        <thead>
            <tr>
                <th>Date & Time</th>
                <th>Location</th>
                <th>Approval</th>
                <th> </th>
            </tr>
        </thead>
        <tbody id="requestHistoryList">
            <!-- Participants will be populated here -->
        </tbody>
    </table>

    
</form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function () {
    // Load all participants into the table on page load
    loadParticipants('all');
    

    // Event listener for the dropdown filter
    $('#approvalFilter').on('change', function () {
        var filterValue = $(this).val();
        loadParticipants(filterValue);
    });



   

    // Function to load participants based on filter
    function loadParticipants(filter) {
        $.ajax({
            url: 'fetch_user_request_history.php', // PHP script to fetch all participants
            type: 'GET',
            dataType: 'json',
            data: { approval_status: filter }, // Pass the filter to the server
            success: function (data) {
                // Clear the current table contents
                $("#requestHistoryList").empty();

                // Populate the table with participant data
                $.each(data, function (index, item) {
                    $("#requestHistoryList").append(
                        `<tr>
                            <td>${item.request_date}</td>
                            <td>${item.location}</td>
                            <td>${item.approval}</td>
                            <td>
               
             <a href="transport_details.php?id=${item.id}" class="button">  
             <button type="button">Show</button></a>
               
           
            </td>
                        </tr>`
                    );
                });
            },
            error: function () {
                alert("Error loading participants.");
            }
        });
    }
});

</script>

</body>
</html>
