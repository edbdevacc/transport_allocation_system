<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the request ID from the AJAX POST data
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0; // Safely check if 'id' exists and cast to integer

    if ($id > 0) {
        // Update the transport table's head_approval field to 'approved'
        $query = "UPDATE transport SET head_approval = 1, transport_status='approved by HR Director',hr_approval = 1  WHERE id = ?";
        $stmt = $conn->prepare($query);
        
        // Bind the correct variable
        $stmt->bind_param('i', $id); // Use $id instead of $requestId

        if ($stmt->execute()) {
            // Successfully updated
            echo json_encode(['status' => 'success']);
            
        } else {
            // Failed to update
            echo json_encode(['status' => 'error', 'message' => 'Failed to approve the request.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid ID provided.']);
    }

    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
