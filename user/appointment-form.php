<?php
include("../config.php");
include('./sever_side/new-appointment-auth.php');
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Appointment</title>

    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Include Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

    <!-- Include Datepicker and Timepicker CSS -->
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />

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

    <!-- Back button -->
    <div class="container mt-2">
        <a class="btn " style="font-size: large; font-weight:bolder;" href="../index.php"><i class="bi bi-arrow-left"></i></i></a>
    </div>

    <div class='container'>

        <!-- the back button should be here -->
        <h4 class='text-center'>Appointment Form</h4>


        <!-- Form -->
        <div class='container mt-3 mb-5'>
            <form class='needs-validation' method='post' action='appointment-form.php'>
                <div class='row g-3 mb-4'>

                    <!-- First Name -->
                    <div class="form-group col-md-5 mb-1">
                        <label for='firstname'>First Name</label>
                        <input type='text' name='firstname' class='form-control' id='firstname' placeholder='First name'>
                        <div class='invalid-feedback' id='firstname-error'>
                        </div>
                    </div>

                    <!-- Middle Initial -->
                    <div class="form-group col-md-2 mb-1">
                        <label for='middle-initial'>M.I. (<span style='font-style:italic; font-size:smaller;'>Optional</span>)</label>
                        <input type='text' name='middle-initial' class='form-control' id='middle-initial' placeholder='M.I.'>
                        <div class='invalid-feedback' id='middlename-error'></div>
                    </div>

                    <!-- Last Name -->
                    <div class="form-group col-md-5 mb-1">
                        <label for='lastname'>Last Name</label>
                        <input type='text' name='lastname' class='form-control' id='lastname' placeholder='Last Name'>
                        <div class='invalid-feedback' id='lastname-error'></div>
                    </div>
                </div>

                <!-- Mobile Number -->
                <div class='form-group mb-4'>
                    <label for='mobile-number'>Mobile Number</label>
                    <div class="input-group">
                        <div class="input-group-text">
                            +63
                        </div>
                        <input type='number' name='mobile-number' class='form-control' id='mobile-number' placeholder='9XXXXXXXXX'>
                        <div class='invalid-feedback' id='mobile-num-error'></div>
                    </div>

                </div>

                <!-- Address -->
                <div class="row g-3 mb-4">

                    <!-- Town -->
                    <div class="form-group col-md-6">
                        <label for='town-select'>From what town</label>
                        <select name='town' class='form-select' id='town-select'>
                            <option value='' selected>Choose...</option>
                        </select>
                        <div class='invalid-feedback' id='town-error'></div>
                    </div>

                    <!-- Barangay -->
                    <div class="form-group col-md-6">
                        <label for='barangay'>Barangay</label>
                        <select name='barangay' class='form-select' id='barangay'>
                            <option value='' selected>Choose...</option>
                        </select>
                        <div class='invalid-feedback' id='barangay-error'></div>
                    </div>
                </div>

                <!-- Date and time picker -->
                <div class="row g-3 mb-4">
                    <!-- Time picker -->
                    <div class='form-group col-md-6 '>
                        <label for='timepicker'>Pick time</label>
                        <input name='appointment-time' id='appoint-date' type="time" class="form-control 
                            <?php
                            echo (!empty($timeErr)) ? 'is-invalid border border-danger' : '';
                            ?>" value='<?php echo $time; ?>'>

                        <script>
                            console.log('<?php echo $timeErr; ?>')
                        </script>

                    </div>


                    <!-- Date Picker -->
                    <div class='form-group col-md-6'>
                        <label for='datepicker'>Pick Date (<span style='font-size:11px; font-style:italic;'>dd-mm-yyyy</span>)</label>
                        <input name='appointment-date' type="date" class="form-control">
                        <div class="invalid-feedback" id='date-error'></div>
                    </div>
                </div>

                <!-- Purpose -->
                <div class='form-group mb-5'>
                    <label for='purpose'>Purpose</label>
                    <textarea name='purpose' class="form-control <?php echo (!empty($purposeErr)) ? 'is-invalid' : ''; ?>" id='purpose' placeholder="Please enter your purpose..." rows='4'><?php echo $purpose; ?></textarea>
                    <div class='invalid-feedback'>
                        <?php echo (!empty($purposeErr)) ? $purposeErr : ''; ?>
                    </div>
                </div>

                <!-- Buttons -->
                <div class='form-group text-center '>
                    <button type="submit" name='btn-new-appoint' class="btn btn-primary me-4">Submit</button>
                    <a href="../index.php" type="button" class="btn btn-outline-dark">Cancel</a>
                </div>

            </form>
        </div>

    </div>

    <!-- Footer -->
    <footer class="footer mt-auto py-3" style='bottom: 0;'>
        <div class="container text-center">
            <span class="text-muted">© 2023 Batanes General Hospital</span>
        </div>
    </footer>



    <!-- Include Bootstrap Bundle (Bootstrap JS + Popper.js) -->
    <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>

    <!-- new-appointment-validation.js -->
    <script src="./javascipts/new-appointment-validation.js"></script>

    <!-- for town and barangay -->
    <script src='./javascipts/batanesTowns.js'></script>
</body>

</html>