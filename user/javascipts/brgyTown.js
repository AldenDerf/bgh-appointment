// Disabling time texbox
function disableTextBox() {
  var timeTextBox = document.getElementById("timepicker");
  timeTextBox.readOnly = true;
}

// Disabling date texbox
function disableTextBoxDate() {
  var dateTextBox = document.getElementById("datepicker");
  dateTextBox.readOnly = true;
}

// //to 12 hour
// function convertTo12HourFormat(hour, minute) {
//   let period = "AM"; // Set default period to AM

//   if (hour >= 12) {
//     period = "PM";
//     hour = hour - 12; // Convert to 12-hour format
//   }

//   if (hour === 0) {
//     hour = 12; // Midight (00:00) is 12 AM
//   }

//   return hour + ":" + (minute < 10 ? "0" : "") + minute + " " + period;
// }

function convertTo12HourFormat(hour, minute) {
  let period = "AM"; // Set default period to AM

  if (hour >= 12) {
    period = "PM";
    hour = hour - 12; // Convert to 12-hour format
  }

  if (hour === 0) {
    hour = 12; // Midnight (00:00) is 12 AM
  }

  return hour + ":" + (minute < 10 ? "0" : "") + minute + " " + period;
}

function convertAndDisplay() {
  const timePicker = document.getElementById("timepicker");
  const timeString = timePicker.value;
  const time = timeString.split(":");

  const hour = parseInt(time[0]);
  const minute = parseInt(time[1]);

  const twelveHourTime = convertTo12HourFormat(hour, minute);
  timePicker.value = twelveHourTime; // Set the value of the input field
}

// date convertion mm/dd/yyy to Month dd, yyyy
function convertDateFormated(dateString) {
  const months = [
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December",
  ];

  const [month, day, year] = dateString.split("/");
  const monthName = months[parseInt(month) - 1];

  return `${monthName} ${parseInt(day)}, ${year}`;
}

function convertAndDisplayDate() {
  const datePicker = document.getElementById("datepicker");
  const formattedDate = convertDateFormated(datePicker.value);
  datePicker.value = formattedDate; // Set the value of the input field
}
