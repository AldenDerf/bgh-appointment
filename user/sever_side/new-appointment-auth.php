<?php
ob_start(); // Start output buffering
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Validate Form Data
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Get current date and time
function currentDateTime()
{
    date_default_timezone_set('Asia/Manila');
    $currentDateTime = new DateTime();
    return $currentDateTime->format('Y-m-d H:i:s');
}

// Variables initialization
$firstname = $middle_initial = $lastname =
    $mobile_number = $town = $barangay =
    $time = $date = $purpose = "";

$status = 'scheduled';


// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and retrieve form input values
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $middle_initial = mysqli_real_escape_string($conn, $_POST['middle-initial']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $mobile_number = mysqli_real_escape_string($conn, $_POST['mobile-number']);
    $town = mysqli_real_escape_string($conn, $_POST['town']);
    $barangay = isset($_POST['barangay']) ? mysqli_real_escape_string($conn, $_POST['barangay']) : '';
    $time = mysqli_real_escape_string($conn, $_POST['appointment-time']);
    $date = mysqli_real_escape_string($conn, $_POST['appointment-date']);
    $purpose = mysqli_real_escape_string($conn, $_POST['purpose']);



    $sql = "
                INSERT INTO appointments
                (firstname, middle_initial, lastname, mobile_number, 
                town, barangay, appointment_time, appointment_date, 
                purpose, status, date_requested, appointment_ref_num)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $conn->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param(
            "ssssssssssss",
            $param_firstname,
            $param_middle_initial,
            $param_lastname,
            $param_mobile_number,
            $param_town,
            $param_barangay,
            $param_appointment_time,
            $param_appointment_date,
            $param_purpose,
            $param_status,
            $param_date_requested,
            $param_reference_num
        );

        $reference_num = uniqid();

        // Set parameters
        $param_firstname = $firstname;
        $param_middle_initial = $middle_initial;
        $param_lastname = $lastname;
        $param_mobile_number = $mobile_number;
        $param_town = $town;
        $param_barangay = $barangay;
        $param_appointment_time = $time;
        $param_appointment_date = $date;
        $param_purpose = $purpose;
        $param_status = $status;
        $param_date_requested = currentDateTime();
        $param_reference_num = $reference_num;

        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Records created successfully. Redirect to..
            ob_end_clean(); // Clean (erase) the buffer before header modification
            header("Location: appointment-confirm.php?reference_num=" . $reference_num);
            exit; // Ensure script stops here after header modification

        } else {
            echo "Oops! Something went wrong. Please try again later ";
        }

        // Close statement
        $stmt->close();
    } else {
        echo "Oops! Something went wrong with the database connection ";
    }
}

// Close connection
$conn->close();
