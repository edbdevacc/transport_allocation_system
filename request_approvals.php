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


    <!-- DIVISION DIRECTORS ------------------------------------------------------- -->
   <?php if ( $employeeData['usertype']=='HEAD'):?>
    <h3> Team Request </h3>
   
    <label for="requestFilter">Filter by Approval Status:</label>
<select id="requestFilter" name="requestFilter" style="margin-bottom: 20px;">
    <option value="pending">Pending</option>
    <option value="approved">Approved</option>
    <option value="approved by HOD">HOD Approved</option>
    <option value="rejected">Rejected</option>
    
    <option value="all">All</option>
</select>
<table id="participantTable" class="table table-bordered" style="margin-top: 20px; width: 100%;">
        <thead>
            <tr>
                <th></th>
                <th>Date & Time</th>
                <th>Name</th>
                <th>Location</th>
                <th>Participant Details</th>
                <th>Approval</th>
                <th>Action </th>
            </tr>
        </thead>
        <tbody id="requestHistoryList">
            <!-- Participants will be populated here -->
        </tbody>
    </table>

   <?php else: ?>



    <!-- HR DIRECTOR ------------------------------------------------------- -->
    <?php if ( $employeeData['usertype']=='HRDIRECTOR'):?>
       
       
        <button type="button" onclick="showSection('Tr_approvals')">Transport Approvals</button>
        <button type="button" onclick="showSection('team_reqs')">Team Requests</button>



        <div id="Tr_approvals" style="display: hide;">
      
        <h3> Transports Approved Head of Divisions  </h3>
        <label for="requestFilter">Filter by Approval Status:</label>
            <select id="requestFilter" name="requestFilter" style="margin-bottom: 20px;">
                <option value="all">All</option>
                <option value="approved by HOD">Pending</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
                
            </select>
            <table id="participantTable" class="table table-bordered" style="margin-top: 20px; width: 100%;">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Date & Time</th>
                            <th>Name</th>
                            <th>Location</th>
                            <th>Participant Details</th>
                            <th>HOD Approval</th>
                            <th>HR Approval</th>
                            <th>Action </th>
                        </tr>
                    </thead>
                    <tbody id="hodApprovedList">
                        
                    </tbody>
    </table> </div>
                    
    
    
    
                    <div id="team_reqs" style="display: hide;">
                    <h3> Team Request </h3>
                        
                        <label for="requestFilter">Filter by Approval Status:</label>
                        <select id="requestFilter" name="requestFilter" style="margin-bottom: 20px;">
                            <option value="all">All</option>
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="approved by HOD">HOD Approved</option>
                        <option value="rejected">Rejected</option>
                        
                        </select>
                        <table id="participantTable" class="table table-bordered" style="margin-top: 20px; width: 100%;">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Date & Time</th>
                                    <th>Name</th>
                                    <th>Location</th>
                                    <th>Participant Details</th>
                                    <th>Approval</th>
                                    <th>Action </th>
                                </tr>
                            </thead>
                            <!-- team daata -->
                            <tbody id="requestHistoryList">
                                
                            </tbody>
                        </table>

                    </div>

      <!-- Transport Officer ------------------------------------------------------- -->  
        <!--  ALL REQUESTS APPROVED BY HRD -->
        <?php else: ?>
            <?php if ( $employeeData['usertype']=='TRA'):?>
                <h3> Transports approved by HR DIRECTOR </h3>



                <label for="requestFilter">Filter by Approval Status:</label>
                    <select id="requestFilter" name="requestFilter" style="margin-bottom: 20px;">
                        <option value="all">All</option>
                        <option value="approved">approved by HRD</option>
                        <option value="llocated">Vehical Allocated</option>
                        <option value="assign">Assign Driver</option>
                        
                    </select>
                    <table id="participantTable" class="table table-bordered" style="margin-top: 20px; width: 100%;">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Date & Time</th>
                                    <th>Name</th>
                                    <th>Location</th>
                                    <th>Participant Details</th>
                                  
                                    <th>HR Approval</th>
                                    <th>Status</th>
                                    <th>Action </th>
                                </tr>
                            </thead>
                            <tbody id="hrdApprovedList">
                                <!-- Participants will be populated here -->
                            </tbody>
                        </table>
</div>


           

                
                <!--  ALL REQUESTS APPROVED BY HEADS -->
        <?php else: ?>
            <?php endif; ?>
    <?php endif; ?>
   <?php endif; ?>






    
    
</form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>



$(document).ready(function () {
    // Load all participants into the table on page load
    loadRequests('pending');
    loadHODApproveRequests('all');
    loadHRDApproveRequests('all');

    // Event listener for the dropdown filter
    $('#requestFilter').on('change', function () {
        var filterValue = $(this).val();
        loadRequests(filterValue);
        loadHODApproveRequests(filterValue);
        loadHRDApproveRequests(filterValue);
    });


    // Load Request List -----------------------
    function loadRequests(filter) {
        $.ajax({
            url: 'fetch_approval_request.php', // PHP script to fetch all participants
            type: 'GET',
            dataType: 'json',
            data: { approval_status: filter }, // Pass the filter to the server
            success: function (data) {
                // Clear the current table contents
                $("#requestHistoryList").empty();

                // Populate the table with participant data
                $.each(data, function (index, item) {
                    $("#requestHistoryList").append(
                        `<tr><td>${item.id}</td>
                            <td>${item.request_date}</td>
                            <td>${item.name}</td>
                            <td>${item.location}</td>
                            <td>${item.group}</td>
                            <td>${item.approval}</td>
                             <td>
               
             <a href="transport_details.php?id=${item.id}" class="button">  <button type="button">Show</button></a>
                ${item.approval === 'pending' ? `
                    <button type="button" onclick="approveRequest(${item.id})">Approve</button>
                    <button type="button"  onclick="rejectRequest(${item.id})">Reject</button>
                ` : ''}
           
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


       // Load hod approve List -----------------------
       function loadHODApproveRequests(filter) {
        $.ajax({
            url: 'fetch_HOD_approved_request.php', // PHP script to fetch all participants
            type: 'GET',
            dataType: 'json',
            data: { approval_status: filter }, // Pass the filter to the server
            success: function (data) {
                // Clear the current table contents
                $("#hodApprovedList").empty();

                // Populate the table with participant data
                $.each(data, function (index, item) {
                    $("#hodApprovedList").append(
                        `<tr><td>${item.id}</td>
                            <td>${item.request_date}</td>
                            <td>${item.name}</td>
                            <td>${item.location}</td>
                            <td>${item.group}</td>
                            <td>${item.head_approval==1? 'Approved':item.head_approval==3?
                            'Rejected':   'Not Approved'}</td>
                             <td>${item.hr_approval==1? 'Approved':item.hr_approval==3?
                            'Rejected':   'Not Approved'}</td>
                             <td>
               
             <a href="transport_details.php?id=${item.id}" class="button">  <button type="button">Show</button></a>
                ${item.hr_approval === '0' ? `
                    <button type="button" onclick="approveRequest_hr(${item.id})">Approve</button>
                    <button type="button"  onclick="rejectRequest_hr(${item.id})">Reject</button>
                ` : ''}
           
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



    function loadHRDApproveRequests(filter) {
        $.ajax({
            url: 'fetch_HRD_approved_request.php', // PHP script to fetch all participants
            type: 'GET',
            dataType: 'json',
            data: { approval_status: filter }, // Pass the filter to the server
            success: function (data) {
                // Clear the current table contents
                $("#hrdApprovedList").empty();

                // Populate the table with participant data
                $.each(data, function (index, item) {
                    $("#hrdApprovedList").append(
                        `<tr><td>${item.id}</td>
                            <td>${item.request_date}</td>
                            <td>${item.name}</td>
                            <td>${item.location}</td>
                            <td>${item.group}</td>
                            <td>${item.hr_approval==1? 'Approved':item.hr_approval==3?
                            'Rejected':   'Not Approved'}</td>
                         <td>${ item.approval}</td>
                             <td>
               
             <a href="transport_details.php?id=${item.id}" class="button">  <button type="button">Show</button></a>
              
              <a href="vehicle_allocate.php?id=${item.id}" class="button">  <button type="button">Allocate</button></a>

            ${item.allocated_vehicle === 'null' ? `
                    <button type="button" onclick="">Allocate</button>
                    <button type="button"  onclick="">Reject</button>
                ` : ''}
               
           
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
// ACTION HOD -----------------------
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




// HRD Request Selector ---------------------------------------------------
function showSection(sectionId) {
            // Hide both sections first
            document.getElementById('team_reqs').style.display = 'none';
            document.getElementById('Tr_approvals').style.display = 'none';

            // Show the selected section
            document.getElementById(sectionId).style.display = 'block';
}


</script>

</body>
</html>
