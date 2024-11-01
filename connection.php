<?php


// Server Connection
$servername = "localhost";  
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'transport_allocatoion'; 

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    
    die("Connection failed: " . $conn->connect_error);
}



// Fetch Data --------------------------------
$employeeId = 5 ; 
$sql = "SELECT * FROM employees WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $employeeId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $employeeData = $result->fetch_assoc();
} else {
    echo "No employee found with ID = $employeeId";
}






// $stmt->close();
// $conn->close();
?>