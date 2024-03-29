<?php

include("./change-appointment-func.php");
?>
<script>
    console.log('<?php echo $reference_num; ?>')
</script>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment-form</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <!-- bootstrap button -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

    <!-- For time picker -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
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
    <div class="container mt-1">
        <a class="btn " style="font-size: large; font-weight:bolder;" href="./view-appointment.php?reference_num=<?php echo $reference_num; ?>"><i class="bi bi-arrow-left"></i></i></a>
    </div>
    <div class='container mt-2'>

        <!-- Change Appointment -->
        <h4 class='text-center'>Change Appointment</h4>

        <!-- Form -->
        <div class='container mb-5 mt-4'>
            <form class='needs-validation' method='post' action='./change-appointment-form.php?reference_num=<?php echo $reference_num; ?>'>
                <div class='row g-3 mb-4'>
                    <!-- reference number -->
                    <input type="hidden" name="reference_num" value="<?php echo $reference_num; ?>">

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
                        <input name='appointment-time' type="time" class="form-control 
                            <?php
                            echo (!empty($timeErr)) ? 'is-invalid border border-danger' : '';
                            ?>"  value='<?php echo $time; ?>'>

                        <script>
                            console.log('<?php echo $timeErr; ?>')
                        </script>

                    </div>


                    <!-- Date Picker -->
                    <div class='form-group col-md-6'>
                        <label for='datepicker'>Pick Date (<span style='font-size:11px; font-style:italic;'>dd-mm-yyyy</span>)</label>
                        <input name='appointment-date' type="date" class="form-control <?php echo (!empty($dateErr)) ? 'is-invalid border border-danger' : ''; ?>" value="<?php echo $date; ?>"  onchange="convertAndDisplayDate()">
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
                    <button type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="btn btn-primary me-4">Save</button>

                    <!-- Cancel Button -->
                    <button id='updateCancelbtn' type="button" class="btn btn-outline-dark">Cancel</button>
                </div>

                <!--Do really want to update your appointment  Modal -->
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content ">
                            <div class='modal-header'>
                                <h5>Confirm Appointment Update</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Do you really want to update your appointment?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" name='btn-update-appoint' class="btn btn-primary">Yes</button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>





    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

    <!-- Town and Barangay -->
    <script src="./javascipts/brgyTown.js"></script>
</body>

<!-- Script -->
<script>
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
    // Date picker
    $('#timepicker').timepicker({
        uiLibrary: 'bootstrap5'
    });

    // Time picker
    $('#datepicker').datepicker({
        uiLibrary: 'bootstrap5'
    });

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

    // Extracting PHP reference number to JavaScript
    const reference_num = '<?php echo $reference_num; ?>'

    // Assigning reference number to Javascript
    $(document).ready(function() {

        // Add a click event listener to the button
        $('#updateCancelbtn').on('click', function() {

            // Redirect to view-appointment.php
            window.location.href = `./view-appointment.php?reference_num=${reference_num}`;
        });
        arguments
    });
</script>
</html>