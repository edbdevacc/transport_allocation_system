<?php include 'post_transports.php'; ?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transport Request Form</title>

    <!-- Style -->
    <link rel="stylesheet" href="style/forms.css">

</head>
<body>
<div class="card">

  
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



// echo $employeeData['usertype'];
if ($employeeData['usertype']==='TRA') {
    
    echo   '<a href="vehicle_allocate.php?id=${item.id}" class="button">  <button type="button">Allocate a vehicle</button></a>';
    # code...
}else if($employeeData['usertype']=='HRDIRECTOR'){

    echo 'HRD';
    echo '<button type="button" onclick="approveRequest(${item.id})">Approve</button>';

}else{}



if ($result->num_rows > 0) {
    $file_path = 'localhost/My%20Projects/TAS/uploads/';
    $request_details = $result->fetch_assoc();
    
    $from_time_am_pm = date("h:i A", strtotime($request_details['from_time'] ));



    echo '<div style="display: flex; justify-content: space-between; align-items: center;">
    <div style="text-align: left;">
        <p>Receipt No : 000' . $request_id . ' </p>
    </div>
    <div style="text-align: right;">
        <p>EDB/HRM/FO/TRP/01</p>
    </div>
  </div>';


    echo '<div style="text-align: center;  text-decoration: underline;">
    <h3>APPLICATION FOR OFFICIAL TRANSPORT</h3></div>';

    echo '<p>Name (who required vehicle) <strong>' . $employeeData['name'] . '</strong>,   Designation  <strong>' . $employeeData['designation'] . '</strong>,   Mobile No <strong>' . $employeeData['contact'] . '</strong>,  Extension No <strong>' . $employeeData['extension'] . '</strong>
     , Division <strong>' . $employeeData['division'] . '</strong>
     , Nature of duties perform <strong>' . $request_details['transport_reason'] . '</strong>
    , Duration from <strong>' . date("h:i A", strtotime($request_details['from_time'] )) . '</strong> on <strong>' . $request_details['request_date'] . '</strong>  to <strong>' .date("h:i A", strtotime($request_details['to_time'] ))  . '</strong>
    , on <strong>' . $request_details['request_date'] . '</strong>
     , Description of route <strong>' . $request_details['route_description'] . '</strong>
    </p>';

    echo '<p>Name of Applicant : <strong>' . $employeeData['name'] . '</strong>
   </p></br></br>';

//    echo '<div style="display: flex; justify-content: space-between; align-items: center;">
//    <div style="text-align: left;">
//        <p>-----------------------------------</p>
//    </div>
//    <div style="text-align: right;">
//        <p>----------------------------------</p>
//    </div>
//  </div>';

//    echo '<div style="display: flex; justify-content: space-between; align-items: center;">
//    <div style="text-align: left;">
//        <p>Date :  </p>
//    </div>
//    <div style="text-align: right;">
//        <p>Signature of Applicant : </p>
//    </div>
//  </div>';



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
echo '<table border="1" cellpadding="5" cellspacing="0" width=100%>';
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

<script>
    

</script>
</html>