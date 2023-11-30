<?php

include("../config.php");

// Retrieve the reference_num from the URL parameter
$reference_num = $_GET['reference_num'] ?? ''; // Sanitize or validate as needed

// Prepare and exectute the query
$sql = "SELECT * FROM appointments WHERE appointment_ref_num = ?";

if ($stmt = $conn->prepare($sql)) {
    //Bind the parameter
    $stmt->bind_param("s", $reference_num);

    // Execute the query
    if ($stmt->execute()) {
        // Get all the result
        $result = $stmt->get_result();

        // Check if any rows were returned
        if ($result->num_rows > 0) {
            //Fetch data
            while ($row = $result->fetch_assoc()) {
                $firstname = $row['firstname'];
                $middle_initial = $row['middle_initial'];
                $lastname = $row['lastname'];
                $appointment_time = $row['appointment_time'];
                $appointment_date = $row['appointment_date'];
            }

            // Free the result
            $result->free_result();
        } else {
            echo "no recods found";
        }

        // Close statement
        $stmt->close();
    } else {
        echo "Error executing the query" . $stmt->error;
    }
}
// Close connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment created</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>

    <!-- bootstrap icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <style>
        /* Your CSS styles remain unchanged */
        body {
            font-family: sans-serif;
            background-color: #f2f2f2;
        }

        .card-body {
            padding: 2rem;
        }
    </style>
</head>

<body>
    <div class="container mt-5">

        <div class="row">
            <div class="col-md-6 offset-md-3">

                <div class="card border-0 shadow-sm">

                    <div class="card-body" style='background-color: white'>
                        <h4 class="text-success text-center mb-3">
                            Appointment Successfully Created
                        </h4>
                        <h3 class='text-center'><b><?php echo $reference_num; ?></b></h3>
                        <div class="patient-details">
                            <h5>Patient Details</h5>
                            <p>
                                Patient Name: <b>
                                    <?php echo $firstname . ' ' . $middle_initial . ' ' . $lastname; ?>
                                </b>
                            </p>
                            <p>
                                Date: <b>
                                    <span id='date-id'>
                                        <?php echo $appointment_date; ?>
                                    </span>
                                </b>
                            </p>
                            <p>
                                Time:<b>
                                    <span id='time-id'>
                                        <?php echo $appointment_time; ?>
                                    </span> </b>
                            </p>
                        </div>

                        <p><b><span class='text-success'>Please arrive 15 minutes before your scheduled appointment time</span></b>. If you fail to arrive on time for your appointment, it will be considered "canceled," and you'll need to schedule a new appointment.</p>
                    </div>

                    <!-- Print and Download button -->
                    <div class="container text-center mb-5">
                        <div class="row">
                            <div class="col">
                                <button type="button" class="btn btn-light me-3 " id='printBtn'>
                                    <i class="bi bi-printer"></i> Print
                                </button>
                                <button type="button" class="btn btn-light ms-3" id="downloadBtn">
                                    <i class="bi bi-box-arrow-down"></i> Download
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Bach to main menu -->
                    <div class='container text-center mb-5'>
                        <a href="../index.php" type='button' class='btn btn-primary btn-lg btn-block'>
                            <i class="bi bi-house-door-fill"></i> Back to Main
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

<script>
    function downloadDivAsImage() {
        const element = document.querySelector('.card-body');

        // Create a promise for loaded images
        const imagesLoaded = Array.from(element.querySelectorAll('img')).map(img =>
            new Promise(resolve => {
                if (img.complete) {
                    resolve();
                } else {
                    img.onload = resolve;
                }
            })
        );

        // Capture the element after all images are loaded
        Promise.all(imagesLoaded).then(() => {
            html2canvas(element, {
                backgroundColor: getComputedStyle(element).backgroundColor
            }).then(canvas => {
                const link = document.createElement('a');
                link.download = 'appointment_confirmation.png';
                link.href = canvas.toDataURL();
                link.click();
            });
        });
    }

    document.getElementById('downloadBtn').addEventListener('click', downloadDivAsImage);

    function handlePrintButtonClick() {
        var content = document.querySelector('.card-body').innerHTML;
        var printWindow = window.open('', '_blank');
        printWindow.document.open();
        printWindow.document.write('<html><head><title>Print</title>');
        printWindow.document.write('<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">');
        printWindow.document.write('</head><body>');

        // Wrap content for print-specific styles
        printWindow.document.write('<div class="print-content">' + content + '</div>');
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    }

    document.getElementById('printBtn').addEventListener('click', handlePrintButtonClick);

    // Coverted time
    document.addEventListener("DOMContentLoaded", function() {
        var displayedTime = document.getElementById('time-id');
        if (displayedTime) {
            var timeIn12HourFormat = convertTo12HourFormat(displayedTime.innerText);
            displayedTime.innerText = timeIn12HourFormat;
            console.log(timeIn12HourFormat);
        } else {
            console.error("Element with ID 'time-id' not found");
        }
    });

    //Date converted
    document.addEventListener("DOMContentLoaded", function() {
        var displayedDate = document.getElementById('date-id');
        if (displayedDate) {
            var dateConvert = convertDateFormat(displayedDate.innerText);
            displayedDate.innerText = dateConvert;
            console.log(dateConvert);
        } else {
            console.error("Element with ID 'date-id' not found");
        }
    });

    function convertTo12HourFormat(time24) {
        // Split the time into hours and minutes
        var [hours, minutes] = time24.split(':');

        // Convert the hours to a number
        hours = parseInt(hours, 10);

        // Determine AM or PM suffix
        var suffix = hours >= 12 ? 'PM' : 'AM';

        // Convert hours to 12-hour format
        hours = hours % 12 || 12;

        // Format the time in 12-hour format
        var time12 = hours + ':' + minutes + ' ' + suffix;

        return time12;
    }

    function convertDateFormat(dateString) {
        // Split the date string into month, day, and year
        console.log(dateString)
        var [year, month, day] = dateString.split('-');

        // Convert month to its index (subtract 1 as months are zero-indexed)
        var monthIndex =  parseInt(month, 10) - 1;

     
       
        // Define an array for month names
        var monthNames = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];

        // Get the month name from the array
        var monthName = monthNames[monthIndex];

        // Format the date in the desired format
        var formattedDate = monthName + ' ' + day + ', ' + year;

        return formattedDate;
    }

    // var displayedTime = document.getElementById('time-id').innerText;
    // convertTo24HourFormat(displayedTime);
    // console.log(timeIn12HourFormat);
</script>

</html>