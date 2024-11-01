<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the request ID and vehicle ID from the POST data
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0; 
    $vehicleId = isset($_POST['vid']) ? (int)$_POST['vid'] : 0; 


    echo $id;
    echo $vehicleId;

    if ($id > 0 && $vehicleId > 0) {
        // Update the transport table's allocated_vehicle field and set transport_status to 'allocated'
        $query = "UPDATE transport SET allocated_vehicle = 2, transport_status = 'allocated' WHERE id = 201";
        $stmt = $conn->prepare($query);

        // Bind the vehicle ID and request ID
        $stmt->bind_param('ii', $vehicleId, $id); // 'ii' means both are integers

        if ($stmt->execute()) {
            // Successfully updated
            echo json_encode(['status' => 'success']);
        } else {
            // Failed to update
            echo json_encode(['status' => 'error', 'message' => 'Failed to approve the request.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid ID or vehicle ID provided.']);
    }

    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
