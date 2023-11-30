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
                        <input type='text' name='firstname' class='
                                form-control
                                <?php echo (!empty($firstnameErr)) ? 'is-invalid' : '' ?>
                                ' id='firstname' placeholder='First name' value='<?php echo $firstname; ?>'>
                        <div class='invalid-feedback'>
                            <?php echo (!empty($firstnameErr)) ? $firstnameErr : '' ?>
                        </div>
                    </div>

                    <!-- Middle Initial -->
                    <div class="form-group col-md-2 mb-1">
                        <label for='middle-initial'>M.I.</label>
                        <input type='text' name='middle-initial' class='form-control <?php echo (!empty($middle_initialErr)) ? 'is-invalid' : '' ?>' id='middle-initial' placeholder='M.I.' value='<?php echo $middle_initial; ?>'>
                        <div class='invalid-feedback'>
                            <?php echo (!empty($middle_initialErr) ? $middle_initialErr : '') ?>
                        </div>
                    </div>

                    <!-- Last Name -->
                    <div class="form-group col-md-5 mb-1">
                        <label for='lastname'>Last Name</label>
                        <input type='text' name='lastname' class='form-control
                            <?php echo (!empty($lastnameErr)) ? 'is-invalid' : '' ?>
                            ' id='lastname' placeholder='Last Name' value='<?php echo $lastname; ?>'>
                        <div class='invalid-feedback'>
                            <?php echo (!empty($lastnameErr)) ? $lastnameErr : '' ?>
                        </div>
                    </div>
                </div>

                <!-- Mobile Number -->
                <div class='form-group mb-4'>
                    <label for='mobile-number'>Mobile Number</label>
                    <div class="input-group">
                        <div class="input-group-text">
                            +63
                        </div>
                        <input type='number' name='mobile-number' class='form-control
                            <?php echo (!empty($mobile_numberErr)) ? 'is-invalid' : '' ?>
                            ' id='mobile-number' placeholder='9XXXXXXXXX' value='<?php echo $mobile_number; ?>'>
                        <div class='invalid-feedback'>
                            <?php echo (!empty($mobile_numberErr)) ? $mobile_numberErr : ''; ?>
                        </div>
                    </div>

                </div>

                <!-- Address -->
                <div class="row g-3 mb-4">
                    <!-- Town -->
                    <div class="form-group col-md-6">
                        <label for='town'>From what town</label>
                        <select name='town' class='
                                form-select
                                <?php echo (!empty($townErr) ? 'is-invalid' : '') ?>
                                ' id='town'>
                        </select>
                        <div class='invalid-feedback'>
                            <?php echo (!empty($townErr)) ? $townErr : '' ?>
                        </div>
                    </div>

                    <!-- Barangay -->
                    <div class="form-group col-md-6">
                        <label for='barangay'>Barangay</label>
                        <select name='barangay' class="
                                form-select
                                <?php
                                echo (!empty($barangayErr)) ? 'is-invalid' : '';
                                ?>
                                " id='barangay'>

                        </select>
                        <div class='invalid-feedback'>
                            <?php
                            echo (!empty($barangayErr)) ? $barangayErr : '';
                            ?>
                        </div>
                    </div>
                </div>

                <!-- Date and time picker -->
                <div class="row g-3 mb-4">
                    <!-- Time picker -->
                    <div class='form-group col-md-6 '>
                        <label for='timepicker'>Pick time</label>
                        <input name='appointment-time' id='appoint-date' type="time"  class="form-control 
                            <?php
                            echo (!empty($timeErr)) ? 'is-invalid border border-danger' : '';
                            ?>"  value='<?php echo $time; ?>'>

                        <script>
                            console.log('<?php echo $timeErr; ?>')
                        </script>

                    </div>


                    <!-- Date Picker -->
                    <div class='form-group col-md-6'>
                        <label for='datepicker'>Pick Date</label>
                        <input name='appointment-date' type="date" class="form-control <?php echo (!empty($dateErr)) ? 'is-invalid border border-danger' : ''; ?>" value="<?php echo $date; ?>" onchange="convertAndDisplayDate()">
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

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include Bootstrap Bundle (Bootstrap JS + Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Include Datepicker and Timepicker JS -->
    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js"></script>

    <!-- Your script for initializing Datepicker and Timepicker -->
</body>
<script>
    $(document).ready(function() {
        $('#timepicker').timepicker({
            uiLibrary: 'bootstrap5'
        });

        $('#datepicker').datepicker({
            uiLibrary: 'bootstrap5'
        });
    });

    let towns = [{
            townName: "Choose..",
            value: "",
        },
        {
            townName: "Basco",
            value: "Basco",
        },

        {
            townName: "Mahatao",
            value: "Mahatao",
        },

        {
            townName: "Ivana",
            value: "Ivana",
        },

        {
            townName: "Uyugan",
            value: "Uyugan",
        },

        {
            townName: "Sabtang",
            value: "Sabtang",
        },

        {
            townName: "Itbayat",
            value: "Itbayat",
        },
    ];

    // Barangay APIS
    function barangays(town) {
        switch (town) {
            case "Basco":
                return [{
                        brgyName: "Ihubok I(Kaychanarianan)",
                        value: "kaychanariananan",
                    },
                    {
                        brgyName: "Ihubok II (Kayvaluganan)",
                        value: "Kayvaluganan",
                    },
                    {
                        brgyName: "Kayhuvokan",
                        value: "Kayhuvokan",
                    },
                    {
                        brgyName: "San Antonion",
                        value: "San Antonio",
                    },
                    {
                        brgyName: "San Joaqiun",
                        value: "San Joaquin",
                    },
                ];

            case "Mahatao":
                return [{
                        brgyName: "Kaumbakan",
                        value: "Kaumbakan",
                    },
                    {
                        brgyName: "Hañib",
                        value: "Hañib",
                    },
                    {
                        brgyName: "Panatayan",
                        value: "Panatayan",
                    },
                    {
                        brgyName: "Uvoy (Poblacion)",
                        value: "Uvoy",
                    },
                ];

            case "Ivana":
                return [{
                        brgyName: "Radiwan",
                        value: "Radiwan",
                    },
                    {
                        brgyName: "Salagao",
                        value: "Salagao",
                    },
                    {
                        brgyName: "San Vicente",
                        value: "San Vicente",
                    },
                    {
                        brgyName: "Tuhel",
                        value: "Tuhel",
                    },
                ];

            case "Uyugan":
                return [{
                        brgyName: "Kayuganan (Poblacion)",
                        value: "Kayuganan",
                    },
                    {
                        brgyName: "Kayvaluganan (Poblacion)",
                        value: "Kayvaluganan",
                    },
                    {
                        brgyName: "Itbud",
                        value: "Itbud",
                    },
                    {
                        brgyName: "Imnahbu",
                        value: "Imnahbu",
                    },
                ];

            case "Sabtang":
                return [{
                        brgyName: "Sinakan (Poblacion)",
                        value: "Sinakan",
                    },
                    {
                        brgyName: "Malakdang (Poblacion)",
                        value: "Malakdang",
                    },
                    {
                        brgyName: "Savidug",
                        value: "Savidug",
                    },
                    {
                        brgyName: "Chavayan",
                        value: "Chavayan",
                    },
                    {
                        brgyName: "Sumnanga",
                        value: "Sumnanga",
                    },
                ];

            case "Itbayat":
                return [{
                        brgyName: "Santa Rosa",
                        value: "Santa Rosa",
                    },
                    {
                        brgyName: "Santa Maria(Marapuy)",
                        value: "Santa Maria",
                    },
                    {
                        brgyName: "Sata Lucia (Kayhauhasan)",
                        value: "Santa Lucia",
                    },
                    {
                        brgyName: "San Rafael (Idiang)",
                        value: "San Rafael",
                    },
                ];
        }
    }

    document.addEventListener("DOMContentLoaded", function() {
        let selectTown = document.getElementById("town").value;
        let barangaySelect = document.getElementById("barangay");
        let selectedBrgy = '<?php echo $barangay; ?>'

        // Enable/disable barangay dropdown based on town selection
        barangaySelect.disabled = selectTown === "";

        if (selectTown !== "") {
            barangaySelect.innerHTML = ""; // Clear previous options
            let barangayList = barangays(selectTown);

            let defaultOption = document.createElement("option");
            defaultOption.text = "choose..";
            defaultOption.value = "";
            barangaySelect.appendChild(defaultOption);

            barangayList.forEach(function(barangay) {
                let option = document.createElement("option");
                option.text = barangay.brgyName;
                option.value = barangay.value;

                if (barangay.value === selectedBrgy) {
                    option.selected = true;
                }

                barangaySelect.appendChild(option);
            });
        }
    });
    // Event listener for Town select
    document.getElementById("town").addEventListener("change", function() {
        let selectTown = this.value;
        let barangaySelect = document.getElementById("barangay");
        let selectedBrgy = '<?php echo $barangay; ?>'

        //   Enable/disable barangay dropdown based on town selection
        barangaySelect.disabled = selectTown === "";
        barangaySelect.innerHTML = ""; // Clear previous options

        let barangayList = barangays(selectTown);
        console.log(selectTown)

        let defaultOption = document.createElement("option");
        defaultOption.text = "choose..";
        defaultOption.value = "";
        barangaySelect.appendChild(defaultOption);

        barangayList.forEach(function(barangay) {
            let option = document.createElement("option");
            option.text = barangay.brgyName;
            option.value = barangay.value;

            if (barangay.value === selectedBrgy) {
                option.selected = true;
            }


            barangaySelect.appendChild(option);
        });
    });

    //Initial population of Town Select
    let selectTown = document.getElementById("town");
    let selectedTown = "<?php echo $town; ?>";
    console.log(selectedTown)
    towns.forEach(function(town) {
        let optionElement = document.createElement("option");
        optionElement.textContent = town.townName;
        optionElement.value = town.value;

        if (town.value === selectedTown) {
            optionElement.selected = true;
        }

        selectTown.appendChild(optionElement);
    });
</script>

</html>