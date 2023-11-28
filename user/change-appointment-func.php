<?php
ob_start(); // Start output buffering
include("../config.php");
// Retrieve the reference_num from the URL parameter

$reference_num = $_GET['reference_num'] ?? ''; // Sanitize or validate as needed

// if (empty($reference_num)) {
//     // Redirect to index.php if the reference number is empty
//     header("Location: ../index.php");
//     exit();
// }

//  Validate Form Data
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


// Variables
$firstname = $middle_initial = $lastname =
    $mobile_number = $town = $barangay =
    $time = $date = $purpose = "";
$status = 'scheduled';


// Variables for errors
$firstnameErr = $middle_initialErr = $lastnameErr = $mobile_numberErr = $townErr = $barangayErr = $timeErr = $dateErr = $purposeErr = '';

// Processing form data when form is submitted
if (
    isset($_POST['btn-update-appoint'])
) {
    // receive all input values from the form
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $middle_initial = mysqli_real_escape_string($conn, $_POST['middle-initial']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $mobile_number = mysqli_real_escape_string($conn, $_POST['mobile-number']);
    $town = mysqli_real_escape_string($conn, $_POST['town']);
    $barangay = isset($_POST['barangay']) ? mysqli_real_escape_string($conn, $_POST['barangay']) : '';
    $time = mysqli_real_escape_string($conn, $_POST['appointment-time']);
    $date = mysqli_real_escape_string($conn, $_POST['appointment-date']);
    $purpose = mysqli_real_escape_string($conn, $_POST['purpose']);

    // Validate middle initial

    if (!empty($_POST['middle-initial']) && (!preg_match("/^[a-zA-ZñÑ -']*$/", $middle_initial))) {
        $middle_initialErr = "Only letters and white space allowed!";
    }


    // Validate firstname
    if (empty($_POST['firstname'])) {
        $firstnameErr = 'First name is required!';
    } else {
        if (!preg_match("/^[a-zA-ZñÑ -']*$/", $firstname)) {
            $firstnameErr = "Only letters and white space allowed!";
        }
    }


    // Validate last name
    if (empty($_POST["lastname"])) {
        $lastnameErr = "Last name is required!";
    } else {

        if (!preg_match("/^[a-zA-ZñÑ -']*$/", $lastname)) {
            $lastnameErr = "Only letters and white space allowed!";
        }
    }

    // Validate mobile number
    if (
        empty($_POST['mobile-number'])
    ) {
        $mobile_numberErr = 'Mobile number is required!';
    } else {
        if (!preg_match("/^9[0-9]{9}$/", $mobile_number)) {
            $mobile_numberErr = "The mobile number is invalid!";
        }
    }

    // Validate Town
    if (empty($_POST["town"])) {
        $townErr = "Town is required!";
    }

    // Validate Barangay
    if (empty($_POST["barangay"])) {
        $barangayErr = "Barangay is required!";
    }

    // Validate time
    if (empty($_POST["appointment-time"])) {
        $timeErr = "Please select time for your appointment";
    }

    // Validate date
    if (empty($_POST["appointment-date"])) {
        $dateErr = 'Please select date for your appointment';
    }

    // Validate purpose
    if (empty($_POST['purpose'])) {
        $purposeErr = "Purpose is required!";
    }

    // Checks errors before inserting in database
    if (
        (empty($firstnameErr)) && (empty($middle_initialErr)) && (empty($lastnameErr)) &&
        (empty($mobile_numberErr)) && (empty($townErr)) &&
        (empty($barangayErr)) && (empty($timeErr)) &&
        (empty($dateErr)) && (empty($purposeErr))
    ) {

        $sql = "
                UPDATE appointments
                SET firstname = ?, middle_initial = ?, 
                lastname = ?, mobile_number = ?, 
                town = ?, barangay = ?, 
                appointment_time = ?, appointment_date = ?, 
                purpose = ?, date_requested =?  WHERE appointment_ref_num = ? ";

        if ($stmt = $conn->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param(
                "sssssssssss",
                $param_firstname,
                $param_middle_initial,
                $param_lastname,
                $param_mobile_number,
                $param_town,
                $param_barangay,
                $param_appointment_time,
                $param_appointment_date,
                $param_purpose,
                $param_date_requested,
                $param_reference_num
            );

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
            $param_date_requested = currentDateTime();
            $param_reference_num = trim($_GET['reference_num'] ?? '');



            // Attempt to excute the prepared statement
            if ($stmt->execute()) {

                // Records created successfully. Redirect to ..
                header("Location: successful-change.php?reference_num=" . $reference_num);

                // Reset form field variables except for the status and date
                $firstname = $middle_initial = $lastname =
                    $mobile_number = $town = $barangay =
                    $time = $date = $purpose = "";
                ob_end_flush(); // Flush output buffer
            } else {
                echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($conn);
} else {
    // Check existence of id parameter before processing further
    if (!empty($reference_num)) {

        // Prepare a select statement
        $sql = 'SELECT * FROM appointments WHERE appointment_ref_num = ?';

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Bind varaibles to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt,  "s", $param_reference_num);

            // set parameters
            $param_reference_num = $reference_num;

            // Attempt to execute the prepare statement
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);

                if (mysqli_num_rows($result) == 1) {
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    // Retrieve individual field value
                    $firstname = $row["firstname"];
                    $middle_initial = $row["middle_initial"];
                    $lastname = $row["lastname"];
                    $mobile_number = $row["mobile_number"];
                    $town = $row["town"];
                    $barangay = $row["barangay"];
                    $time = $row["appointment_time"];
                    $date = $row["appointment_date"];
                    $purpose = $row["purpose"];
                } else {
                    echo 'No record found';
                }
            } else {
                echo 'Oops! Something went wrong. Please try again later';
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);

        // Close connection
        mysqli_close($conn);
    } else {
        echo "Reference number not found";
    }
}
?>