<?php
include("../config.php");

// Assuming the reference number is retrieved from the URL parameter
$reference_num = $_GET['reference_num'] ?? ''; // Sanitize or validate as needed

//   if (empty($reference_num)) {
//     //Redirect to index.php if the reference number is empty
//     header("Location: ../index.php");
//     exit();
//   }

// Initialize variables to hold appointment details
$firstname = $middle_initial = $lastname = $appointment_time =
    $appointment_date = $purpose = '';

// Fetch appointment details to hold appointment details
$sql = "SELECT * FROM appointments WHERE appointment_ref_num = ?";


if ($stmt = $conn->prepare($sql)) {
    // Bind the paramete
    $stmt->bind_param("s", $reference_num);

    // Execcute the query
    if ($stmt->execute()) {
        // Get the result
        $result = $stmt->get_result();

        //Check if an rows were returned

        if ($result->num_rows > 0) {

            //Fetch data
            while ($row = $result->fetch_assoc()) {
                $firstname = $row['firstname'];
                $middle_initial = $row['middle_initial'];
                $lastname = $row['lastname'];
                $appointment_time = $row['appointment_time'];
                $appointment_date = $row['appointment_date'];
                $purpose = $row['purpose'];
            }
        } else {
            echo "No records found";
        }
    } else {
        echo "Error executing the query: " . $stmt->error;
    }
}

$stmt->close();
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
                        <h3 class="text-danger text-center mb-3">
                            Successfully Aborted
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
                                    <?php echo $appointment_date; ?>
                                </b>
                            </p>
                            <p>
                                Time:<b>
                                    <?php echo $appointment_time; ?>
                                </b>
                            </p>
                        </div>

                        <p>You have <span class='text-danger'><b>successfully canceled your appointment</b></span>. Your reference number is currently inactive, and any searches for this appointment will be unavailable.</p>
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

    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>