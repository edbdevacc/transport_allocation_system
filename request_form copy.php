 
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



    <div id="viewForm" style="display: hide;">

    <h5>Transport Details</h5>
    <card>
    <div>
    <label  style="font-weight: bold;"> Date</label> 
    <div>
        <label >From : </label> 
            <input type="date" id="transportDate" name="transportDate" required style="width: 130px; display: inline-block;">
            <input type="time" id="fromTime" name="fromTime" required style="width: 70px; display: inline-block;">
            <label>To  : </label> 
            <input type="date" id="to_date" name="to_date" style="width: 130px; display: inline-block;">
            <input type="time" id="toTime" name="toTime" required style="width: 70px; display: inline-block;">
        </div>
    </div>
    </br>
      
    

   
    <div>
        <label style="font-weight: bold;"> Location</label> 
            <div>
                
                <input type="text" name="pickLocation" placeholder="Pick Location" required style="width: 275px; display: inline-block;">
                <input type="text" name="dropLocation" placeholder="Drop Location" required style="width: 275px; display: inline-block;">
               
                </div>
        </div>
    </br>
  

    <div>
        <label>Description of route : </label>
        <textarea name="routeDescription" rows="3" placeholder="Enter route description here..." required></textarea>
    </div>
    </br>

    <div>
        <label style="font-weight: bold;">Transport Reason : </label>
        <textarea name="transportReason" rows="3" placeholder="Enter Transport Reason here..." required></textarea>
    </div>
    </br>

            <!-- Emp Type -->
            <div style="border: 1px solid #ccc; padding: 10px; border-radius: 5px;"> 
            <div style="display: flex; align-items: center; gap: 100px;">
                <label style="font-weight: bold;">Is this Outstation transport?</label>
                <div>
                    <label for="outstation">Yes</label>
                    <input type="radio" value="outstation" id="outstation" name="transportType" class="toggleRadio" />
                </div>
                <div>
                    <label for="not_outstation">No</label>
                    <input type="radio" value="not_outstation" id="not_outstation" name="transportType" class="toggleRadio" checked />
                </div>
            </div>
            </div>
            <br>    

        <!-- Participant Type -->
        <div style="border: 1px solid #ccc; padding: 10px; border-radius: 5px;"> 
            <div style="display: flex; align-items: center; gap:100px;">
                <label style="font-weight: bold; width: 148px;">Participant Type :</label>
                <div>
                    <label for="group">Group</label>
                    <input type="radio" value="group" id="group" name="participantType" class="toggleRadio" />
                </div>
                <div>
                    <label for="single">Single</label>
                    <input type="radio" value="single" id="single" name="participantType" class="toggleRadio" checked />
                </div>
            </div>



            <!-- <div id="participantsDetails"  style="display: none;" > -->
    


            
        <!-- <div class="participantEntry" style='display: hide;'>
            <input type="text" id="participantName" placeholder="Participant Name" style="width: 130px; display: inline-block;">
            <input type="text" id="designation" placeholder="Designation" style="width: 130px; display: inline-block;">
            <input type="text" id="epf" placeholder="EPF" style="width: 130px; display: inline-block;">
            <input type="button" name="add" value="Add" class="styledButton" id="addButton" style="width: 50px; display: inline-block;">
        </div>

    </div> -->
    <!-- </div> -->



    <div id="participantsDetails" style="display: none;">
    <div class="participantEntry">
        <div class="participant-row">
            <input type="text" class="participantName" placeholder="Participant Name" name="name[]" style="width: 130px; display: inline-block;">
            <input type="text" class="designation" placeholder="Designation" name="designation[]" style="width: 100px; display: inline-block;">
            <input type="number" class="epf" placeholder="EPF" name="epf_no[]" style="width: 80px; display: inline-block;">
            <input type="button" value=" + Add" onclick="addParticipantRow()" style="width: 60px; display: inline-block; border: 1px solid black; border-radius: 4px;">
            <input type="button" value="Remove" onclick="removeParticipantRow(this)" style="width: 70px; display: inline-block;">
        </div>
    </div>
</div>


<div>
</div>
    </div>
    </br>
  <!-- Attachments -->

  <label class="mainLabel">Attachments</label>         
    <input type="file" name="file" id="file">                                          
    <input type="submit" name="submit" value="Request Transport">


    </div>

    <div id="accessMSG" style="display: hide;">

    </div>

</form>
    </div>
    </card>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>

<script>



        // Function to add a new row of participant fields
        function addParticipantRow() {
            const participantsDiv = document.getElementById("participants");

            // Check if any existing EPF number is empty or if the new EPF number already exists
            const epfInputs = participantsDiv.querySelectorAll("input[name='epf_no[]']");
            let isValid = true;
            let newEPF = null;

            epfInputs.forEach((input) => {
                if (input.value === "") {
                    alert("Please fill in all EPF numbers before adding a new row.");
                    isValid = false;
                } else if (newEPF === null) {
                    newEPF = input.value; // Set the new EPF value
                } else if (input.value === newEPF) {
                    alert("EPF number must be unique.");
                    isValid = false;
                }
            });

            // If validation fails, don't add a new row
            if (!isValid) return;

            // Create a new row for participant fields
            const newRow = document.createElement("div");
            newRow.className = "participant-row";
            newRow.innerHTML = `
            <div class="participantEntry">
                <input type="text" placeholder="Participant Name" name="name[]" style="width: 130px; display: inline-block;">
                
                <input type="text" placeholder="Designation" name="designation[]" style="width: 100px; display: inline-block;">
                
                <input type="number" placeholder="EPF" name="epf_no[]" style="width: 80px; display: inline-block;">
                
                <input type="button" value=" + Add" onclick="addParticipantRow()" style="width: 60px; display: inline-block; border: 1px solid black; border-radius: 4px;"> 
                <input type="button" value="Remove" onclick="removeParticipantRow(this)" style="width: 70px; display: inline-block;">
            </div>
            `;
            
            participantsDiv.appendChild(newRow);
        }

        // Function to remove a participant row
        function removeParticipantRow(button) {
            button.parentElement.remove();
        }





    // Form Validation -------------

    //   date validation
    const dateInput = document.getElementById('transportDate');
    const to_date = document.getElementById('to_date');
    
    const today = new Date();
    const todayString = today.toISOString().split('T')[0];
    dateInput.setAttribute('min', todayString);
    to_date.setAttribute('min', todayString);

    const oneMonthLater = new Date();
    oneMonthLater.setMonth(today.getMonth() + 1);
    const oneMonthLaterString = oneMonthLater.toISOString().split('T')[0];

    dateInput.setAttribute('max', oneMonthLaterString);
    to_date.setAttribute('max', oneMonthLaterString);

    // time validation
    const fromTimeInput = document.getElementById('fromTime');
    const toTimeInput = document.getElementById('toTime');

    toTimeInput.addEventListener('input', validateTime);
    fromTimeInput.addEventListener('input', validateTime);


    const fromDate = document.getElementById("transportDate");
  const toDate = document.getElementById("to_date");

  fromDate.addEventListener("change", function() {
    toDate.value = fromDate.value; // Set 'To' date to the selected 'From' date
    toDate.min = fromDate.value;   // Prevent selecting an earlier date in 'To' field
  });



    function validateTime() {
        const fromTime = fromTimeInput.value;
        const toTime = toTimeInput.value;
        
       
        if (fromTime && toTime && toTime <= fromTime) {
           
            alert('The "To" time cannot be earlier than the "From" time.');
            toTimeInput.value = ''; 
        }
    }



    // ----------------------------
    
    document.addEventListener('DOMContentLoaded', function () {
        const groupRadio = document.getElementById('group');
        const singleRadio = document.getElementById('single');
        const participantsDetails = document.getElementById('participantsDetails');
        const addButton = document.getElementById('addButton');
        const participantCount = document.getElementById('participantCount');


        // Function to toggle visibility of Participants Details
        function toggleParticipantsDetails() {
            participantsDetails.style.display = groupRadio.checked ? 'block' : 'none'; // Show or hide
        }

        // Listners -------------------------------------------
           
        document.addEventListener('DOMContentLoaded', function () {
           
            addButton.addEventListener('click', addParticipant);
            

            toggleParticipantsDetails();
        });

        // Event listeners for radio buttons
        groupRadio.addEventListener('change', toggleParticipantsDetails);
        singleRadio.addEventListener('change', toggleParticipantsDetails);

        // Event listener for the add button
        addButton.addEventListener('click', addParticipant);
       

        // Initial check
        toggleParticipantsDetails();
    });



    // Auto Suggest partneers
  $(document).ready(function () {
    // Function to initialize autocomplete for participant name fields
    function initAutocomplete() {
        $(".participantName").autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: 'getParticipants.php',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        term: request.term
                    },
                    success: function (data) {
                        response($.map(data, function (item) {
                            return {
                                label: item.name,
                                value: item.name,
                                designation: item.designation,
                                epf: item.epf
                            };
                        }));
                    }
                });
            },
            select: function (event, ui) {
                // Find the current participant row to fill in the designation and EPF
                var $row = $(this).closest('.participant-row');
                $row.find('.designation').val(ui.item.designation);
                $row.find('.epf').val(ui.item.epf);
                // Set the participant name
                $(this).val(ui.item.value);
                return false; // Prevent the default behavior
            }
        });
    }

    // Initialize autocomplete for existing rows
    initAutocomplete();

    // Example function to add new participant row
    window.addParticipantRow = function() {
        var newRow = `
            <div class="participant-row">
                <input type="text" class="participantName" placeholder="Participant Name" name="name[]" style="width: 130px; display: inline-block;">
                <input type="text" class="designation" placeholder="Designation" name="designation[]" style="width: 100px; display: inline-block;">
                <input type="number" class="epf" placeholder="EPF" name="epf_no[]" style="width: 80px; display: inline-block;">
                <input type="button" value=" + Add" onclick="addParticipantRow()" style="width: 60px; display: inline-block; border: 1px solid black; border-radius: 4px;">
                <input type="button" value="Remove" onclick="removeParticipantRow(this)" style="width: 70px; display: inline-block;">
            </div>
        `;
        $('#participantsDetails').append(newRow);
        initAutocomplete(); // Re-initialize autocomplete for new row
    }

    // Example function to remove a participant row
    window.removeParticipantRow = function(button) {
        $(button).closest('.participant-row').remove();
    }
});


</script>
</html>
