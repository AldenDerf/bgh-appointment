<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment-form</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- For time picker -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />

    <!-- Bootstrap Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

<body>
    <div class='container mt-5'>
        <!-- Header -->
        <div class='container text-center mb-5 '>
            <img src="../image/BGHlogo.png" class="img-fluid mb-4" style="width: 150px;" alt="">
            <h2>Appointment Form</h2>
        </div>

        <div container-fluid>
            <!-- PENDING ICOn -->

            <div class='container-fluid align-self-center d-flex flex-column justify-content-center align-items-center mb-3' style=' width: 8rem; height:8rem; border-radius: 50%; background-color: #f9e076;'>
                <div style='font-size:30px; color: white'><i class="bi bi-hourglass-top"></i></div>
                <div style=' font-size:20px;color: white'>PENDING</div>
            </div>

            <div class='container-fluid' style='max-width:600px'>
                <p style='text-align: left; font-size:large'>
                    Dear Patient,
                </p>
                <p class="text-justify" style="text-align: justify; font-size:large" ;>
                    Your appointment status is currently listed as <span style='color: #DE970B; font-weight:bold;'>Pending</span>. Please note that the date and time of your appointment might be subject to change based on the availability of doctors or the volume of appointments. We'll confirm the details as soon as possible.
                </p>

                <p class="text-justify" style="text-align: justify; font-size:large" ;>
                    Thank you for your patience
                </p>

                <p >Regards, <br> BGH</p>
            </div>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>


</body>




</html>