<?php include 'connection.php'; ?> 
<?php

// Prepare the SQL query
$query = "SELECT * FROM vehicle";

$result = $conn->query($query);

// Initialize the $vehicleList array
$vehicleList = [];

// Check if there are results
if ($result->num_rows > 0) {
    // Loop through each row and map to $vehicleList format
    while ($row = $result->fetch_assoc()) {
        $vehicleList[] = [
            'id'=>$row['id'],
            'vehicle_no' => $row['vehicle_no'],
            'type' => $row['type'],
            'seat_count' => $row['seat_count'],
            'availability' => $row['availability'],
            'status' => $row['status'],
        ];
    }
} else {
    echo "No data found in the vehicles table.";
}


$approvalStatus = isset($_GET['status']) ? $_GET['status'] : 'all';

// Filter vehicleList based on the search term and status
$result = array_filter($vehicleList, function ($vehicle) use ( $approvalStatus) {
    $statusMatch = $approvalStatus === 'all' || stripos($vehicle['status'], $approvalStatus) !== false;
    return  $statusMatch;
});

// Return filtered vehicleList as JSON
header('Content-Type: application/json');
echo json_encode(array_values($result));
?>
