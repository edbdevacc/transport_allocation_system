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
<body>
<div class="card">
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

<?php
require_once 'connection.php'; // Ensure your database connection

// Get the request ID from the URL
$request_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch details from the database
$sql = "SELECT transport.*,employees.* FROM transport JOIN employees ON transport.request_user = employees.id WHERE transport.id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $request_id);
$stmt->execute();
$result = $stmt->get_result();
$result1 =$result;


// echo $employeeData['usertype'];
if ($employeeData['usertype']==='TRA') {
    
    
        echo '<a href="vehicle_allocate.php?id=.${item.id}"><div style="padding: 15px; text-align: center;  border-radius: 8px; display: inline-block;">
        <button type="button"  style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer;">
            Allocate a vehicle
        </button>
    </div></a>';


        echo '<div style="padding: 15px; text-align: center; border-radius: 8px; display: inline-block;">
        <button type="button" onclick="rejectRequest('.$request_id.')" style="padding: 10px 20px; background-color: #f44336; color: white; border: none; border-radius: 5px; cursor: pointer;">
            Reject
        </button>
        </div>';
    
}else if($employeeData['usertype']=='HRDIRECTOR'){
   
    
    
  

    echo '<div style="padding: 15px; text-align: center;  border-radius: 8px; display: inline-block;">
        <button type="button" onclick="approveRequest_hr('.$request_id.')" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer;">
            Approve
        </button>
    </div>';

    echo '<div style="padding: 15px; text-align: center; border-radius: 8px; display: inline-block;">
    <button type="button" onclick="rejectRequest_hr('.$request_id.')" style="padding: 10px 20px; background-color: #f44336; color: white; border: none; border-radius: 5px; cursor: pointer;">
        Reject
    </button>
    </div>';

    

}else if($employeeData['usertype']=='HEAD'){

    echo '<div style="padding: 15px; text-align: center;  border-radius: 8px; display: inline-block;">
    <button type="button" onclick="approveRequest('.$request_id.')" style="padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer;">
        Approve
    </button>
  </div>';

  echo '<div style="padding: 15px; text-align: center; border-radius: 8px; display: inline-block;">
  <button type="button" onclick="rejectRequest('.$request_id.')" style="padding: 10px 20px; background-color: #f44336; color: white; border: none; border-radius: 5px; cursor: pointer;">
      Reject
  </button>
</div>';

    
       
  

}else{}



if ($result->num_rows > 0) {
    $file_path = 'localhost/My%20Projects/TAS/uploads/';
    $request_details = $result->fetch_assoc();
    echo '<h1>Transport Request Details</h1>';



    echo '<a href="print_request.php?id='.$request_id.'" class="button"><div style="text-align: right;"> <input type="button" name="submit" value="Print" style="width: 100px;"> </div></a>';


    // Combined details table
    echo '<table border="1" cellpadding="5" cellspacing="0" width=100% id="participantTable" class="table table-bordered" > ';
    
    
    // Single Row for Transport and Employee Details
    // echo '<tr><td><strong>DATA</strong></td><td>' . htmlspecialchars($request_details['name']) . '</td></tr>';
    echo '<tr><td><strong>Name (who required vehicle)</strong></td><td>' . htmlspecialchars($request_details['name']) ."    (".htmlspecialchars($request_details['epf_no']) . ") ". " - ".htmlspecialchars($request_details['division']) .'</td></tr>';
    echo '<tr><td><strong>Transport Status</strong></td><td>' . strtoupper(htmlspecialchars($request_details['transport_status'])) . '</td></tr>';
    echo '<tr><td><strong>Request Duration</strong></td><td>' ."From <strong>" . htmlspecialchars( date("h:i A", strtotime($request_details['from_time'] ))) ."</strong> on <strong>".  htmlspecialchars($request_details['request_date']) .'</strong> to <strong>'. htmlspecialchars( date("h:i A", strtotime($request_details['to_time'] )))."</strong> on <strong>". htmlspecialchars($request_details['to_date']) . '</strong></td></tr>';
    // echo '<tr><td><strong>Request Date</strong></td><td>' . htmlspecialchars($request_details['to_date']) . '</td></tr>';
    // echo '<tr><td><strong>Apply Date</strong></td><td>' . htmlspecialchars($request_details['apply_date']) . '</td></tr>';
    // echo '<tr><td><strong>Email</strong></td><td>' . htmlspecialchars($request_details['email']) . '</td></tr>';
    // echo '<tr><td><strong>EPF No</strong></td><td>' .strtoupper(htmlspecialchars($request_details['epf_no'])). '</td></tr>';
    // echo '<tr><td><strong>Division</strong></td><td>' . htmlspecialchars($request_details['division']) . '</td></tr>';
    // echo '<tr><td><strong>Employee Type</strong></td><td>' .strtoupper( htmlspecialchars($request_details['employee_type']) ). '</td></tr>';
    echo '<tr><td><strong>Participant Type</strong></td><td>' .strtoupper(htmlspecialchars($request_details['participant_type'])). '</td></tr>';
    echo '<tr><td><strong>Transport Type</strong></td><td>' .strtoupper(htmlspecialchars($request_details['transport_type']))  . '</td></tr>';
    echo '<tr><td><strong>Transport Reason</strong></td><td>' . htmlspecialchars($request_details['transport_reason']) . '</td></tr>';
    // echo '<tr><td><strong>From Time</strong></td><td>' . htmlspecialchars( date("h:i A", strtotime($request_details['from_time'] ))) . '</td></tr>';
    // echo '<tr><td><strong>To Time</strong></td><td>' . htmlspecialchars(date("h:i A", strtotime($request_details['to_time'] ))) . '</td></tr>';
    echo '<tr><td><strong>Location</strong></td><td> From <strong>' . htmlspecialchars($request_details['from_location']) . '</strong> to <strong>' . htmlspecialchars($request_details['to_location']) . '</strong></td></tr>';

    echo '<tr><td><strong>To Location</strong></td><td>' . htmlspecialchars($request_details['to_location']) . '</td></tr>';
    echo '<tr><td><strong>Route Description</strong></td><td>' . htmlspecialchars($request_details['route_description']) . '</td></tr>';
    echo '<tr><td><strong>Group Count</strong></td><td>' . htmlspecialchars($request_details['group_count']) . '</td></tr>';
    echo '<tr><td><strong>Designation</strong></td><td>' .strtoupper(htmlspecialchars($request_details['designation']))  . '</td></tr>';
    echo '<tr><td><strong>Contact</strong></td><td>' . htmlspecialchars($request_details['contact']) . '</td></tr>';
    echo '<tr><td><strong>Extension</strong></td><td>' . htmlspecialchars($request_details['extension']) . '</td></tr>';
    echo '<tr><td><strong>Attachment</strong></td><td><a href="http://' . htmlspecialchars($file_path) . htmlspecialchars($request_details['attachments']). '" target="_blank">'. htmlspecialchars($request_details['attachments']) .'</a></td></tr>';
    echo '</table>';




     // Add other employee fields as necessary
} else {
    echo '<p>No details found for this transport request.</p>';
}


$sql_participant = "SELECT transport.*,employees.*,paticipants.* FROM transport JOIN employees ON transport.request_user = employees.id JOIN paticipants ON transport.id = paticipants.transport_id WHERE transport.id=?";
$stmt_p = $conn->prepare($sql_participant);
$stmt_p->bind_param('i', $request_id);
$stmt_p->execute();


$part_result = $stmt_p->get_result();
if ($part_result->num_rows > 0) {
    echo '<h5>Participants</h5>';
echo '<table border="1" cellpadding="5" cellspacing="0" width=100% id="participantTable" class="table table-bordered">';
echo '<tr><td><strong>Employee Name</strong></td><td><strong>Designation<strong></td> <td> <strong>EPF No</strong></td></tr>';
while ($row = $part_result->fetch_assoc()) {
    echo '
    <tr>
    <td>' . htmlspecialchars($row['name']) . '</td>
    <td>' . htmlspecialchars($row['designation']) . '</td>
    <td>' . htmlspecialchars($row['epf_no']) . '</td>
    
    </tr>';
}
}else{

}




// Close the statement and connection
$stmt->close();
$conn->close();
?>
</card>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    // Approve HOD 
function approveRequest(id) {
    $.ajax({
        url: 'approve_request_head.php',
        type: 'POST', // POST is correct for data updates
        data: { id: id },
        dataType: 'json',
        success: function (response) {

            console.log(response);

            if (response.status === 'success') {
                alert('Request approved successfully.');
                // Reload the table based on the current filter to reflect the update
                location.reload(); 
                loadRequests($('#requestFilter').val());
            } else {
                alert('Error: ' + response.message);
                console.error('Server responded with an error:', response);
            }
        },
        error: function (xhr, status, error) {
            alert('Error approving the request.');
            console.error('AJAX error - Status:', status, 'Error:', error, 'Response Text:', xhr.responseText);
        }
    });
}

// REJECT HOD 
function rejectRequest(id) {
    $.ajax({
        url: 'reject_request_head.php',
        type: 'POST', // POST is correct for data updates
        data: { id: id },
        dataType: 'json',
        success: function (response) {

            console.log(response);

            if (response.status === 'success') {
                alert('Request Rejected successfully.');
                // Reload the table based on the current filter to reflect the update
                location.reload(); 
                loadRequests($('#requestFilter').val());
            } else {
                alert('Error: ' + response.message);
                console.error('Server responded with an error:', response);
            }
        },
        error: function (xhr, status, error) {
            alert('Error approving the request.');
            console.error('AJAX error - Status:', status, 'Error:', error, 'Response Text:', xhr.responseText);
        }
    });
}



// ACTION HRD---------------------
// Approve HRD 
function approveRequest_hr(id) {
    $.ajax({
        url: 'approve_request_hrd.php',
        type: 'POST', // POST is correct for data updates
        data: { id: id },
        dataType: 'json',
        success: function (response) {

            console.log(response);

            if (response.status === 'success') {
                alert('Request approved successfully.');
                // Reload the table based on the current filter to reflect the update
                location.reload();
                loadRequests($('#requestFilter').val());


            } else {
                alert('Error: ' + response.message);
                console.error('Server responded with an error:', response);
            }
        },
        error: function (xhr, status, error) {
            alert('Error approving the request.');
            console.error('AJAX error - Status:', status, 'Error:', error, 'Response Text:', xhr.responseText);
        }
    });
}

// REJECT HRD 
function rejectRequest_hr(id) {
    $.ajax({
        url: 'reject_request_hrd.php',
        type: 'POST', // POST is correct for data updates
        data: { id: id },
        dataType: 'json',
        success: function (response) {

            console.log(response);

            if (response.status === 'success') {
                alert('Request Rejected successfully.');
                // Reload the table based on the current filter to reflect the update
                location.reload();
                loadRequests($('#requestFilter').val());
            } else {
                alert('Error: ' + response.message);
                console.error('Server responded with an error:', response);
            }
        },
        error: function (xhr, status, error) {
            alert('Error approving the request.');
            console.error('AJAX error - Status:', status, 'Error:', error, 'Response Text:', xhr.responseText);
        }
    });
}


</script>
</html>