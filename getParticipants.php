<?php include 'connection.php'; ?> 
<?php

$sql = "SELECT * FROM employees WHERE usertype NOT IN ('REPORTER', 'DIRECTOR', 'BOARD', 'HRDIRECTOR','HEAD') AND id<>$employeeId";
$result = $conn->query($sql);

// Initialize the $participants array
$participants = [];

// Check if there are results
if ($result->num_rows > 0) {
    // Loop through each row and map to $participants format
    while ($row = $result->fetch_assoc()) {
        $participants[] = [
            'name' => $row['name'],
            'designation' => $row['designation'],
            'epf' => $row['epf_no']
        ];
    }
} else {
    echo "No data found in the employees table.";
}

// Get the search term from the query parameters
$term = isset($_GET['term']) ? $_GET['term'] : '';


// Filter participants based on the search term
$result = array_filter($participants, function ($participant) use ($term) {
    return stripos($participant['name'], $term) !== false;
});

// Return filtered participants as JSON
header('Content-Type: application/json');
echo json_encode(array_values($result));
?>
