let isFirstNameOk = false;
let isLastNameOK = false;
let middleNameOk = false;
let isMobileNameOk = false;
let isTownOk = false;
let isBarangayOk = false;
let isTimeOk = false;
let isDateOk = false;
let isPurposeOk = false;

// First name field validation
document.getElementById("firstname").addEventListener("input", function () {
  let firstNameInput = document.getElementById("firstname");
  let firstNameError = document.getElementById("firstname-error");

  // Regular expression  for validation (assuming here)
  let firstNameRegex = /^[a-zA-Z\s'\-\u00F1\u00D1\p{L}]+$/u;

  //Check if the firstname field is empty or contains invalid characters
  if (firstNameInput.value.trim() === "") {
    firstNameError.textContent = "First name is required!";
    firstNameInput.classList.add("is-invalid");
  } else if (!firstNameRegex.test(firstNameInput.value)) {
    firstNameError.textContent = "Please enter a valid first name!";
    firstNameInput.classList.add("is-invalid");
  } else {
    firstNameError.textContent = "";
    firstNameInput.classList.remove("is-invalid");
    firstNameInput.classList.add("is-valid");
  }
});

//Last name field validation
document.getElementById("lastname").addEventListener("input", function () {
  lastNameInput = document.getElementById("lastname");
  lastNameError = document.getElementById("lastname-error");

  // Regular expression  for validation (assuming here)
  let lastNameRegex = /^[a-zA-Z\s'\-\u00F1\u00D1\p{L}]+$/u;

  // Check if the lastname field is empty or contains invalid characters
  if (lastNameInput.value.trim() === "") {
    lastNameInput.classList.add("is-invalid");
    lastNameError.textContent = "Last name is required!";
  } else if (!lastNameRegex.test(lastNameInput.value)) {
    lastNameInput.classList.add("is-invalid");
    lastNameError.textContent = "Please enter a valid last name!";
  } else {
    lastNameInput.classList.remove("is-invalid");
    lastNameInput.classList.add("is-valid");
    lastNameError.textContent = "";
  }
});

// Mobile number field validation
document.getElementById("mobile-number").addEventListener("input", function () {
  let mobileNumInput = document.getElementById("mobile-number");
  let mobileNumError = document.getElementById("mobile-num-error");

  // Regular Expression for mobile number
  let mobileNumRegex = /^9\d{9}$/;

  // Check if the mobile number field is empty or contains invalid character
  if (mobileNumInput.value.trim() === "") {
    mobileNumInput.classList.add("is-invalid");
    mobileNumError.textContent = "Mobile number is required!";
  } else if (!mobileNumRegex.test(mobileNumInput.value)) {
    mobileNumInput.classList.add("is-invalid");
    mobileNumError.textContent = "Please enter a valid number!";
  } else {
    mobileNumInput.classList.remove("is-invalid");
    mobileNumInput.classList.add("is-valid");
    mobileNumError.textContent = "";
  }
});

// Town select field validation
document.getElementById("town-select").addEventListener("change", function () {
  let selecTown = document.getElementById("town-select");
  let townError = document.getElementById("town-error");

  if (selecTown.value === "") {
    selecTown.classList.add("is-invalid");
    townError.textContent = "Please choose town!";
    // Barangay input
  } else {
    selecTown.classList.remove("is-invalid");
    selecTown.classList.add("is-valid");
    townError.textContent = "";
  }
});

// Barangay select field validation
document.getElementById("barangay").addEventListener("change", function () {
  let barangayErr = document.getElementById("barangay-error");

  if (this.value === "") {
    this.classList.add("is-invalid");
    barangayErr.textContent = "Please choose barangay!";
  } else {
    this.classList.remove("is-invalid");
    this.classList.add("is-valid");
    barangayErr.textContent = "";
  }
});

// Appointment date, time validation, and purpose input
document.addEventListener("DOMContentLoaded", function () {
  // Date Variables
  const dateInput = document.querySelector("input[name='appointment-date']");
  const dateError = document.getElementById("date-error");

  //  Time Variables
  const timeInput = document.getElementById("timepicker");
  const timeError = document.getElementById("time-error");
  timeInput.disabled = true;

  // Purpose Variables
  const purposeInput = document.getElementById("purpose");
  const purposeErr = document.getElementById("purpose-error");

  // Date change function
  dateInput.addEventListener("change", function () {
    // Get the selected date, current date, day of the week, and current time
    const selectedDate = new Date(this.value);
    const currentDate = new Date();
    const dayOfWeek = selectedDate.getDay();
    const currentTime = new Date().toLocaleTimeString("en-PH", {
      hour12: false,
      hour: "2-digit",
      minute: "2-digit",
    });

    const isSameDay =
      selectedDate.toDateString() === currentDate.toDateString();
    const isPastTime = currentTime > "12:30";

    // Check if the selected date is a Saturday or Sunday (0 or 6 are Sunday and Saturday respectively)
    if (dayOfWeek === 0 || dayOfWeek === 6) {
      dateError.textContent = "Please select a date from Monday to Friday.";
      dateInput.classList.add("is-invalid");
      timeInput.disabled = true;
      isDateOk = false;
      return;
    }

    // Check if the selected date is not today or in the past
    if (selectedDate.setHours(0, 0, 0, 0) < currentDate.setHours(0, 0, 0, 0)) {
      dateError.textContent =
        "Please select a date equal to or later than today.";
      dateInput.classList.add("is-invalid");
      timeInput.disabled = true;
      isDateOk = false;
      return;
    }

    if (isSameDay && isPastTime) {
      dateError.textContent =
        "Booking appointments for today is no longer possible; the request is only available until 12:30. Please change your appointment date.";
      dateInput.classList.add("is-invalid");
      timeInput.disabled = true;
      isDateOk = false;
      return;
    }

    // Reset date error and input class
    dateError.textContent = "";
    dateInput.classList.remove("is-invalid");
    dateInput.classList.add("is-valid");
    timeInput.disabled = false;
    isDateOk = true;
  });

  // Time change function
  timeInput.addEventListener("change", function () {
    // if the date input has no error
    if (!dateInput.classList.contains("is-invalid")) {
      //  Get the selected date and time, and current time
      const selectedDate = new Date(dateInput.value);
      const currentTime = new Date().toLocaleTimeString(`en-PH`, {
        hour12: false,
        hour: "2-digit",
        minute: "2-digit",
      });
      const selectedTime = this.value;

      const currentDate = new Date();
      const isSameDay =
        selectedDate.toDateString() === currentDate.toDateString();
      console.log(currentTime);
      const isBeforeTime = currentTime < "12:30";

      // If it's the same day and before 12:30 PM
      if (isSameDay && isBeforeTime) {
        // Check if the selected time is not within the valid range (1pm - 3pm)
        if (selectedTime < "13:00" || selectedTime > "16:00") {
          // Display error meeesage and mark input as invalid
          timeError.textContent =
            "Appointments are now only available from 1pm to 4pm today.";
          this.classList.add("is-invalid");
        } else {
          // Clear error message and mark input as valid
          timeError.textContent = "";
          this.classList.remove("is-invalid");
          this.classList.add("is-valid");
        }
      } else {
        const selectedTimeHours = parseInt(selectedTime.split(":")[0]); // Extract hours from selected time
        const selectedTimeMinutes = parseInt(selectedTime.split(":")[1]); // Extract minutes from selected time
        const selectedTimeInMinutes =
          selectedTimeHours * 60 + selectedTimeMinutes; // Convert selected time to total minutes

        if (selectedTimeInMinutes < 8 * 60 || selectedTimeInMinutes > 16 * 60) {
          // Display error meeesage and mark input as invalid
          timeError.textContent =
            "Appointments are only available from 8am to 4am.";
          this.classList.add("is-invalid");
        } else {
          // Clear error message and mark input as valid
          timeError.textContent = "";
          this.classList.remove("is-invalid");
          this.classList.add("is-valid");
        }
      }
    }
  });

  // Purpose input function
  purposeInput.addEventListener("input", function () {
    if (this.value.trim() === "") {
      this.classList.add("is-invalid");
      purposeErr.textContent = "Purpose number is required!";
    } else {
      this.classList.remove("is-invalid");
      this.classList.add("is-valid");
      purposeErr.textContent = "";
    }
  });
});

document.querySelector("form").addEventListener("submit", function (event) {
  // Prevent form submission
  event.preventDefault();

  let formIsValid = true; // Flag to track form validity

  // Check for empty fields
  const formInputs = document.querySelectorAll(
    ".needs-validation input:not([id='middle-initial']), .needs-validation select, .needs-validation textarea"
  );

  formInputs.forEach((input) => {
    const errorFeedback =
      input.parentElement.querySelector(".invalid-feedback");

    if (input.value.trim() === "") {
      input.classList.add("is-invalid");
      errorFeedback.textContent = "This field is required."; // Error message for empty fields
      formIsValid = false;
     } //else {
    //   input.classList.remove("is-invalid");
    //   input.classList.add("is-valid");
    //   errorFeedback.textContent = ""; // Clear error message for valid fields
    // }
  });

  // Check for invalid fields
  const invalidInputs = document.querySelectorAll(
    ".needs-validation .is-invalid"
  );


  // If the form is valid, proceed with form submission
  if (formIsValid) {
    this.submit(); // Submit the form
  } else {
    // Display a message or handle the invalid form state
    console.log(
      "Form is incomplete or contains errors. Please fill out all fields correctly."
    );
    
  }
});
