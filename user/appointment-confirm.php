<!--  -->

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
                                    <?php echo $appointment_date; ?>
                                </b>
                            </p>
                            <p>
                                Time:<b>
                                    <?php echo $appointment_time; ?>
                                </b>
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


    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

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
    </script>
</body>

</html>