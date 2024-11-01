<?php include 'connection.php'; ?> 

<?php
// POST TRANSPORT DATA ----------------------------------
if (isset($_POST['submit'])) {

    
    $partnerData = isset($_POST['partners']) ? json_decode($_POST['partners'], true) : null;


    echo $partnerData;

    if ($employeeData['usertype'] == 'EMP') {
        

        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO transport 
            (id, request_user, apply_date, employee_type, participant_type, Transport_type, transport_reason, request_date, to_date, from_time, to_time, from_location, to_location, route_description, attachments, group_count, head_approval, hr_approval, allocated_vehicle, assigned_driver, transport_status) 
            VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );

        // Bind parameters
        $stmt->bind_param("ssssssssssssssssssss", 
            $request_user, 
            $apply_date, 
            $employee_type, 
            $participant_type, 
            $transport_type, 
            $transport_reason, 
            $request_date,
            $to_date, 
            $request_from_time, 
            $requested_to_time, 
            $from_location, 
            $to_location, 
            $route_description, 
            $attachments, 
            $group_count, 
            $head_approval, 
            $hr_approval, 
            $allocated_vehicle, 
            $assigned_driver, 
            $transport_status
        );


        $participant_count = strval(count($_POST['name'])-1);

        // Set parameters
        $request_user = $employeeId;
        $apply_date = date('Y-m-d H:i:s');
        $employee_type = 'staff';
        $participant_type = $_POST['participantType'];
        $transport_reason = $_POST['transportReason'];
        $request_date = $_POST['transportDate'];
        $to_date = $_POST['to_date'];
        $request_from_time = $_POST['fromTime'];
        $requested_to_time = $_POST['toTime'];
        $from_location = $_POST['pickLocation'];
        $to_location = $_POST['dropLocation'];
        $route_description = $_POST['routeDescription'];
        $head_approval = '0';
        $hr_approval = '0';
        $allocated_vehicle = '';
        $assigned_driver = '';
        $transport_status = 'pending';
        $group_count = $participant_count;


        // Determine transport type
        if ($_POST['transportType'] == 'outstation') {
            $transport_type = 'Outstation';
        } else {
            if ($request_from_time < '08:15:00') {
                $transport_type = 'before office';
            } elseif ($request_from_time >= '08:15:00' && $request_from_time <= '16:15:00') {
                $transport_type = 'day duties';
            } else {
                $transport_type = 'after office';
            }
        }

        // Fetch the last transport ID
        $transport_id = $conn->insert_id;
        $current_date = date('Y-m-d_H-i-s');

        

        // IMAGE UPLOAD ----------------------
       // Check if file is uploaded
            if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
                echo 'File name: ' . $_FILES['file']['name'] . "<br>"; // Output the file name instead of the whole array

                $uploadedFile = $_FILES['file'];
                $fileName = $uploadedFile['name'];
                $fileTmpPath = $uploadedFile['tmp_name'];
                $fileSize = $uploadedFile['size'];
                $fileType = $uploadedFile['type'];
                $fileExtension = pathinfo($uploadedFile['name'], PATHINFO_EXTENSION);
                $uploadDir = 'uploads/';

                $newFileName = "transport_{$trsnsport_id['id']}_{$current_date}.$fileExtension";
                $uploadFilePath = $uploadDir . basename($newFileName);

                // Check file size (optional)
                if ($fileSize > 2000000) { // Limit to 2MB
                    die('Error: File size is larger than 2MB.');
                }

                // Move the uploaded file to the target directory
                if (move_uploaded_file($fileTmpPath, $uploadFilePath)) {
                    echo $newFileName;
                    $attachments = $newFileName;
                } else {
                    echo "Error uploading your file.";
                }
            } else {
                echo "Error: " . $_FILES['file']['error'];
            }

        // Execute the transport statement
        if ($stmt->execute()) {
            echo "New record created successfully";
            $transport_id = $conn->insert_id;
            echo   $transport_id;


            // Add Participants ------
            $names = $_POST['name'];
            $designations = $_POST['designation'];
            $epf_nos = $_POST['epf_no'];

            for ($i = 0; $i < count($names); $i++) {
                // echo $names[$i];
                $name = trim($names[$i]);
                $designation = trim($designations[$i]);
                $epf_no = trim($epf_nos[$i]);
            
                // Check if any of the fields are empty
                if (empty($name) || empty($designation) || empty($epf_no)) {
                    echo "Skipping empty entry at index $i<br>";
                    continue; // Skip this iteration if any field is empty
                }
            
                $participant_sql = "INSERT INTO paticipants (name, designation, epf_no, transport_id)
                                    VALUES ('$name', '$designation', '$epf_no', '$transport_id')";
            
                if ($conn->query($participant_sql) !== TRUE) {
                    echo "Error inserting participant at index $i: " . $conn->error . "<br>";
                }
            }
        
            echo "Transport request and participants added successfully!";

            header("Location: request_history.php");

         
        } else {
            echo "Error: " . $stmt->error;
        }
    }else{
        echo '<h3 style="border: 2px solid red; padding: 10px; color: black; width: 300px; text-align: center;"> Sorry! you have not access to apply </h3>';
    }
}
?>
