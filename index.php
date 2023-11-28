<?php
ob_start(); // Start output buffering
include('./config.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);
$inputed = '';
$inputedErr = '';



if (isset($_POST["view-details"])) {
    $inputed = mysqli_real_escape_string($conn, $_POST["inputed-reference"]);
    $inputed = trim($inputed);

    // Validation
    if (empty($_POST['inputed-reference'])) {
        $inputedErr = 'Please enter reference number!';
    }

    // Prepare and execute query
    $sql = "SELECT appointment_ref_num FROM appointments WHERE appointment_ref_num = ? && status = ?";

    if ($stmt = $conn->prepare($sql)) {
        $status = 'scheduled';
        //Blind the parameter
        $stmt->bind_param('ss', $inputed, $status);

        // Executed the query
        if ($stmt->execute()) {
            //Get all the result
            $result = $stmt->get_result();

            // Check if any rows were returned
            if ($result->num_rows > 0) {
                // Fetch data
                $row = $result->fetch_assoc();
                $reference_num = $row['appointment_ref_num'];
                // Free the result
                $result->free_result();

                // Redirect with reference number if found
                header('Location: ./user/view-appointment.php?reference_num=' . $reference_num);
                $inputed = '';
                ob_end_flush(); // Flush output buffer
                exit();
            } else {
                $inputedErr = 'No Records found';
            }

            // Close statement
            $stmt->close();
        } else {
            echo "Error executing the query" . $stmt->error;
        }
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
    <title>BGH-Appointment</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>

<body>


    <!-- Header -->
    <!-- Header -->
    <nav class="navbar navbar-light bg-light" style='height: 80px; padding: 5px'>
        <div class='container d-flex justify-content-start align-items-center'>
            <a class="navbar-brand" href='#'>
                <img src="./image/BGHlogo.png" class='img-fluid ' style='height: 60px;'>
            </a>
            <h2 class="m-0 ml-3 d-none d-sm-block">BGH Online Appointment</h2>
            <h5 class="m-0 ml-3 d-block d-sm-none">BGH Online Appointment</h5>
        </div>
    </nav>



    <!-- New Appointment -->
    <div class='container mt-5 '>
        <div class="card  mb-5" style='max-width: 450px; margin: auto'>
            <div class="card-header" style='background-color: #0066b2; color: white'>
                <h5 class="card-title text-center">New Appointment</h5>
            </div>
            <div class="card-body text-center">
                <p class="card-text">Schedule a new appointment</p>
                <a href="./user/appointment-form.php" class="btn " style='background-color: #0066b2; font-weight: bold; color: white ;'>New Appointment</a>
            </div>
        </div>
    </div>

    <!-- View Appointment -->
    <div class='container-fluid d-flex justify-content-center'>
        <div class="card text-center mb-5" style='max-width: 450px'>
            <div class="card-header" style='background-color: #3cb043; color: white'>
                <h5 class="card-title">View Your Scheduled Appointment</h5>
            </div>
            <div class="card-body">
                <p class="card-text">Please enter your reference number to view the details of your appointment..</p>
                <form method='post' action='index.php' id='viewForm'>
                    <div class='container-fluid mb-4'>

                        <div class='container-fluid align-self-center d-flex justify-content-center align-items-center'>
                            <div class='form-group '>
                                <input type='text' id='submitRef' name='inputed-reference' class="form-control <?php echo (!empty($inputedErr)) ? 'is-invalid' : ''; ?>" style="width: 100%;" placeholder="XXXXX.." value="<?php echo htmlspecialchars($inputed); ?>" autocomplete="off">
                                <div class='invalid-feedback'>
                                    <?php echo (!empty($inputedErr)) ? $inputedErr : '' ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn" id='view-appoint-id' name="view-details" style='background-color: #3cb043; font-weight: bold; color: white;'>View Appointment</button>
                </form>
            </div>
        </div>
    </div>
    </div>

    <!-- Footer -->
    <footer class="footer mt-auto py-3" style='bottom: 0;'>
        <div class="container text-center">
            <span class="text-muted">© 2023 Batanes General Hospital</span>
        </div>
    </footer>

    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
<script>
    // Initially hide the element
    $('#view-appoint-id').hide();

    // Listen for input changes on the text field
    $('#submitRef').on('input', function() {
        //Check if the input field is empty
        if ($(this).val().trim() === '') {
            // Hide the element if the input is empty
            $('#view-appoint-id').hide();
        } else {
            // Show the element if there's input
            $('#view-appoint-id').show();
        }
    })
</script>

</html>