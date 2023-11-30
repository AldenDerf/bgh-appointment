<?php

include("../config.php");


// Retrieve the reference_num from the URL parameter
$reference_num = $_GET['reference_num'] ?? ''; // Sanitize or validate as needed

if (empty($reference_num)) {
    // Redirect to index.php if the reference number is empty
    header("Location: ../index.php");
    exit();
}



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


function cancelAppointment($conn, $reference_num)
{
    $status = 'aborted';

    $sql = "UPDATE appointments SET status = ? WHERE appointment_ref_num = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ss", $status, $reference_num);

        if ($stmt->execute()) {
            // Appointment status updated successfully
            return true;
        } else {
            // Error updating status
            $stmt->close();
            return false;
        }
    }

    // Close statement if it hasn't been closed
    if (isset($stmt)) {
        $stmt->close();
    }

    return false;
}

// Usage of the function
if (isset($_POST["btn-cancel-appointment"])) {
    // Call the function to cancel appointment
    if (cancelAppointment($conn, $reference_num)) {
        //Redirect after sucessful cancellation
        header("Location: success_cancel.php?reference_num=" . $reference_num);
    } else {
        echo "Cancellation faild. Please try again.";
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <title>Updated Successfully</title>

    <style>
        /* Your CSS styles remain unchanged */
        body {
            font-family: sans-serif;
            background-color: #f2f2f2;
        }

        .card-body {
            padding: 2rem;
        }

        /* Your additional CSS styles */
        .position-relative {
            position: relative;
        }

        /* Your additional CSS styles */
        .btn-circle {
            border-radius: 50%;
            width: 50px;
            /* Adjust button size as needed */
            height: 50px;
            /* Adjust button size as needed */
            line-height: 50px;
            /* Center the icon vertically */
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.5rem;
            /* Adjust icon size */
        }

        .btn-circle i {
            line-height: 0;
            /* Reset line height for the icon */
        }


        .position-absolute-topright {
            position: absolute;
            top: 10px;
            right: 10px;
            display: flex;
            flex-direction: row;
            /* Ensure buttons display horizontally */
        }

        /* Margin between the buttons */
        .position-absolute-topright .btn {
            margin-right: 5px;
            /* Adjust marg
            
            in as needed */
        }

        @media (max-width: 575.98px) {
            .hide-on-xs {
                display: none !important;
            }
        }
    </style>
</head>

<body>
    <div class="container mt-5">

        <div class="row">
            <div class="col-md-6 offset-md-3">

                <div class="card border-0 shadow-sm">

                    <div class="card-body" style='background-color: white'>
                        <h3 class="text-info text-center mb-3">
                            Successfully Updated
                        </h3>
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
                                    <span id="time-id">
                                        <?php echo $appointment_time; ?>
                                    </span>
                                </b>
                            </p>
                        </div>

                        <p>Please arrive 15 minutes before your scheduled appointment time. If you fail to arrive on time for your appointment, it will be considered "canceled," and you'll need to schedule a new appointment.</p>
                    </div>

                    <!-- Print and Download button -->
                    <!-- Circular buttons positioned outside the card body -->
                    <div class="position-absolute-topright">
                        <!-- print -->
                        <button type="button" class="btn btn-light btn-circle hide-on-xs" id='printBtn'>
                            <i class="bi bi-printer"></i>
                        </button>

                        <!-- Download -->
                        <button type="button" class="btn btn-light btn-circle" id="downloadBtn">
                            <i class="bi bi-box-arrow-down"></i>
                        </button>
                    </div>

                    <!-- Edit and Cancel button -->
                    <div class="container-fluid mb-5">
                        <div class="row">
                            <div class="col-md-6">
                                <button id='changeAppointmentBtn' type="button" class="btn btn-info btn-block mb-3" style='width: 100%'><i class="bi bi-pencil-square"></i> Change appointment</button>
                            </div>

                            <div class="col-md-6">
                                <!--  -->
                                <form method='post' action='./view-appointment.php?reference_num=<?php echo $reference_num; ?>'>
                                    <button name='btn-cancel-appointment' type="submit" class="btn btn-danger btn-block" style='width: 100%'><i class="bi bi-x-lg"></i> Cancel appointment</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Bach to main menu -->
                    <div class='container text-center mb-5'>
                        <a href="../index.php?clear=true" type='button' class='btn btn-primary btn-lg btn-block'>
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

<!-- JavaScript -->
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
        // Your existing JavaScript code for printing the content
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

    const reference_num = '<?php echo $reference_num; ?>';

    $(document).ready(function() {
        $('#changeAppointmentBtn').on('click', function() {
            window.location.href = `./change-appointment-form.php?reference_num=${reference_num}`;
        });
    });

    // Date conversion from YYYY-DD-MM to Month DD, YYYY
    function convertDateFormat(dateString) {
        // Split the date string into month, day, and year
        console.log(dateString)
        var [year, month, day] = dateString.split('-');

        // Convert month to its index (subtract 1 as months are zero-indexed)
        var monthIndex = parseInt(month, 10) - 1;



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

    //Displaying the date converted
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

    //Time convertion from 24hours to 12 hours format
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

    // Displaying the converted time
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
</script>

</html>