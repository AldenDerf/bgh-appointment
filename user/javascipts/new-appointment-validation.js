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
document.getElementById('town-select').addEventListener('change', function () {
    let selecTown = document.getElementById('town-select');
    let townError = document.getElementById('town-error');

    if (selecTown.value === '') {
        selecTown.classList.add('is-invalid');
        townError.textContent = 'Please choose town!'
    }else{
        selecTown.classList.remove("is-invalid");
        selecTown.classList.add("is-valid");
        townError.textContent = "";
    }
});

// Barangay select field validation
document.getElementById('barangay').addEventListener('change', function () {
    let barangayErr = document.getElementById('barangay-error');

    if( this.value === ''){
        this.classList.add('is-invalid');
        barangayErr.textContent = 'Please choose barangay!';
    } else {
        this.classList.remove('is-invalid');
        this.classList.add('is-valid');
        barangayErr.textContent='';
    }

    console.log(this.value);
});

// Appointment date validation
document.addEventListener('DOMContentLoaded', function (){
    const dateInput = document.querySelector("input[name='appointment-date']");
    const dateError = document.getElementById('date-error');

    dateInput.addEventListener('change', function(){
        const selectedDate = new Date(this.value);
        const currentDate = new Date();
        const dayOfWeek = selectedDate.getDay();

        // Check if the selected date is a Saturday or Sunday (0 or 6 are Sunday and Saturday respectively)
        if( dayOfWeek === 0 || dayOfWeek === 6 ){
            dateError.textContent = 'Please select a date from Monday to Friday.';
            dateInput.classList.add('is-invalid');
            return;
        }

        // Check if the selected date is not today or in the past
        if( selectedDate < currentDate ){
            dateError.textContent = 'Please select a date equal to or later than today.';
            dateInput.classList.add('is-invalid');
            return;
        }

        // Reset if no errors
        dateError.textContent = '';
        dateInput.classList.remove('is-invalid');
        dateInput.classList.add('is-valid'); 
    });
});

