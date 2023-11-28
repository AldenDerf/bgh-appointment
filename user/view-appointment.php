<!--  -->

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
    <title>View Appointment</title>


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
    <!-- Header -->
    <nav class="navbar navbar-light bg-light" style='height: 80px; padding: 5px'>
        <div class='container d-flex justify-content-start align-items-center'>
            <a class="navbar-brand" href='#'>
                <img src="../image/BGHlogo.png" class='img-fluid ' style='height: 60px;'>
            </a>
            <h2 class="m-0 ml-3 d-none d-sm-block">BGH Online Appointment</h2>
            <h5 class="m-0 ml-3 d-block d-sm-none">BGH Online Appointment</h5>
        </div>
    </nav>

    <div class="container mt-5 mb-5">

        <div class="row">
            <div class="col-md-6 offset-md-3">

                <div class="card border-0 shadow-sm" style='background-color: white;'>

                    <div class="card-body" style='background-color: white;'>
                        <h4 class="text-success text-center mb-3">
                            View Appointment
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
                                    <?php echo $appointment_date; ?>
                                </b>
                            </p>
                            <p>
                                Time:<b>
                                    <?php echo $appointment_time; ?>
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

                    <form method='post' action='./view-appointment.php?reference_num=<?php echo $reference_num; ?>'>
                        <!-- Edit and Cancel button -->
                        <div class="container-fluid mb-3">

                            <div class="row">
                                <!-- Change Appointment -->
                                <div class="col-md-6">
                                    <button id='changeAppointmentBtn' type="button" class="btn btn-info btn-block mb-3" style='width: 100%'><i class="bi bi-pencil-square"></i> Change appointment</button>
                                </div>

                                <!-- Cancel appointment -->

                                <div class="col-md-6">

                                    <button type='button' class="btn btn-danger btn-block" style='width: 100%' data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                                        <i class="bi bi-x-lg"></i> Cancel appointment
                                    </button>

                                </div>
                            </div>

                            <!--Do really want to cancel your appointment  Modal -->
                            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content ">
                                        <div class='modal-header'>
                                            <h5>Verify Appointment Cancellation</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to cancel this appointment?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" name='btn-cancel-appointment' class="btn btn-primary">Yes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- Bach to main menu -->
                    <div class='container text-center mb-3'>
                        <a href="../index.php?clear=true" type='button' class='btn btn-primary btn-lg btn-block'>
                            <i class="bi bi-house-door-fill"></i> Back to Main
                        </a>
                    </div>
                </div>

            </div>
        </div>


    </div>

    <!-- Footer -->
    <footer class="footer mt-auto py-3 " style='bottom: 0;'>
        <div class="container text-center">
            <span class="text-muted">© <?php echo date('Y'); ?> Batanes General Hospital</span>
        </div>
    </footer>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>

<script>
    function downloadDivAsImage() {
        const element = document.querySelector('.card-body');

        // Create a promise that resolves when all images inside the element are loaded
        const imagesLoaded = Array.from(element.querySelectorAll('img')).map(img =>
            new Promise(resolve => {
                if (img.complete) {
                    resolve();
                } else {
                    img.onload = resolve;
                }
            })
        );

        // After all images are loaded, capture the element
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


    // Function to handle the Print button click event
    function handlePrintButtonClick() {
        var content = document.querySelector('.card-body').innerHTML; // Get content of the specific div

        var printWindow = window.open('', '_blank'); // Open a new window
        printWindow.document.open();
        printWindow.document.write('<html><head><title>Print</title>');
        printWindow.document.write('<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">'); // Add Bootstrap CSS
        printWindow.document.write('</head><body>'); // Start printing

        // Wrap content in a div with class for print-specific styles
        printWindow.document.write('<div class="print-content">' + content + '</div>');

        printWindow.document.write('</body></html>'); // Close printing
        printWindow.document.close();
        printWindow.print(); // Trigger the print dialog
    }

    // Add a click event listener to the Print button
    document.getElementById('printBtn').addEventListener('click', handlePrintButtonClick);


    // Extracting PHP reference number to JavaScript
    const reference_num = '<?php echo $reference_num; ?>'

    // assigning reference_number in header when clicking the #changeAppointmentBtn
    $(document).ready(function() {


        // Add a click event listener to the button
        $('#changeAppointmentBtn').on('click', function() {


            //Redirect to change-appointment-func.php with the reference number
            window.location.href = `./change-appointment-form.php?reference_num=${reference_num}`;
        });
    });
</script>