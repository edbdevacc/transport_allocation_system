<?php include 'connection.php'; ?> 
<?php
$division =  $employeeData['division'];
$sql = "SELECT transport.*,employees.name FROM transport JOIN employees ON transport.request_user = employees.id WHERE head_approval=1 ORDER BY transport.id DESC";

$result = $conn->query($sql);


$requestHistory = [];

// Check if there are results
if ($result->num_rows > 0) {
    // Loop through each row and map to $requestHistory format
    while ($row = $result->fetch_assoc()) {


        // ===================
        if ($row['group_count'] != 0) {
            $groupData="have group";
            $participantsSql = "SELECT * FROM `paticipants` WHERE transport_id={$row['id']}";
            $participantsResult = $conn->query($participantsSql);
            
            $participantNames = [];
            if ($participantsResult->num_rows > 0) {
                while ($participantRow = $participantsResult->fetch_assoc()) {
                    $participantNames[] = $participantRow['name'];
                }
            }
            $groupData = implode(', ', $participantNames) . ' (' . $row['group_count'] . ')';
        } else {
            $groupData = 'Single Transport';
        }

        // Add the current request to the $requestHistory array
        $requestHistory[] = [
            'request_date' => $row['request_date'] ,
            'location' => 'From ' . $row['from_location'] . ' - to ' . $row['to_location'],
            'group' => $groupData,
            'approval' => $row['transport_status'],   
            'id'=>$row['id'],
            'name'=>$row['name'],
            'head_approval'=>$row['head_approval'],
            'hr_approval'=>$row['hr_approval'],
            'allocated_vehicle'=>$row['allocated_vehicle'],
            'assigned_driver'=>$row['assigned_driver'],
            
        ];

        
    }

        // ===================



        // $requestHistory[] = [
        //     'request_date' => $row['request_date'] . ' - from ' . $row['from_time'] . ' - to ' . $row['to_time'],
        //     'location' => 'From ' . $row['from_location'] . ' - to ' . $row['to_location'],
        //     'group' => ($row['group_count'] == 0) ? 'Single Transport' : 'Nisha, bandara, sdasda (' . $row['group_count'] . ')',
        //     'approval' => $row['transport_status']
        // ];
    
    
    
    
    
    
}

// Get the search term and approval status from the query parameters
$term = isset($_GET['term']) ? $_GET['term'] : '';
$approvalStatus = isset($_GET['approval_status']) ? $_GET['approval_status'] : 'all';

// Filter requestHistory based on the search term and approval status
$result = array_filter($requestHistory, function ($history) use ($term, $approvalStatus) {
    // Check approval status filter
    if ($approvalStatus !== 'all' && stripos($history['approval'], $approvalStatus) === false) {
        return false;
    }
    // Check term filter
    if (!empty($term) && stripos($history['request_date'], $term) === false) {
        return false;
    }
    return true;
});

// Return filtered requestHistory as JSON
header('Content-Type: application/json');
echo json_encode(array_values($result));
?>

