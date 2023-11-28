 <?php
    define('DB_SERVER', "localhost");
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'bgh-appointment');

    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if ($conn === false) {
        die("ERROR: Could not connect to the server." . mysqli_connect_error());
    }
?>