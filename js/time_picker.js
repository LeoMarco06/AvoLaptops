<<<<<<< HEAD
const startTimeInput = document.getElementById("start-time");
const endTimeInput = document.getElementById("end-time");
const startTimeDropdown = document.getElementById("start-time-picker-dropdown");
const endTimeDropdown = document.getElementById("end-time-picker-dropdown");

// Generate time options from 8:00 to 19:00
function generateTimeOptions(dropdown) {
  const startHour = 8;
  const endHour = 19;

  for (let hour = startHour; hour <= endHour; hour++) {
    for (let minute = 0; minute < 60; minute += 30) {
      const formattedHour = hour.toString().padStart(2, "0");
      const formattedMinute = minute.toString().padStart(2, "0");
      const timeOption = `${formattedHour}:${formattedMinute}`;

      const optionElement = document.createElement("div");
      optionElement.textContent = timeOption;
      optionElement.dataset.time = timeOption;

      // Add click event to select the time
      optionElement.addEventListener("click", function () {
        if (dropdown === startTimeDropdown) {
          startTimeInput.value = this.dataset.time;
        } else {
          endTimeInput.value = this.dataset.time;
        }
        dropdown.style.display = "none";
      });

      dropdown.appendChild(optionElement);
    }
  }
}

// Show or hide the dropdown
function toggleDropdown(input, dropdown) {
  input.addEventListener("click", function () {
    dropdown.style.display =
      dropdown.style.display === "block" ? "none" : "block";
  });

  // Close the dropdown when clicking outside
  document.addEventListener("click", function (e) {
    if (!dropdown.contains(e.target) && e.target !== input) {
      dropdown.style.display = "none";
    }
  });
}

function parseTime(timeString) {
  return timeString + ":00";
}

// Generate the time options for both dropdowns
generateTimeOptions(startTimeDropdown);
generateTimeOptions(endTimeDropdown);

// Set up toggle functionality for both inputs
toggleDropdown(startTimeInput, startTimeDropdown);
toggleDropdown(endTimeInput, endTimeDropdown);
=======
const startTimeInput = document.getElementById("start-time");
const endTimeInput = document.getElementById("end-time");
const startTimeDropdown = document.getElementById("start-time-picker-dropdown");
const endTimeDropdown = document.getElementById("end-time-picker-dropdown");

// Generate time options from 8:00 to 19:00
function generateTimeOptions(dropdown) {
  const startHour = 8;
  const endHour = 19;

  for (let hour = startHour; hour <= endHour; hour++) {
    for (let minute = 0; minute < 60; minute += 30) {
      const formattedHour = hour.toString().padStart(2, "0");
      const formattedMinute = minute.toString().padStart(2, "0");
      const timeOption = `${formattedHour}:${formattedMinute}`;

      const optionElement = document.createElement("div");
      optionElement.textContent = timeOption;
      optionElement.dataset.time = timeOption;

      // Add click event to select the time
      optionElement.addEventListener("click", function () {
        if (dropdown === startTimeDropdown) {
          startTimeInput.value = this.dataset.time;
        } else {
          endTimeInput.value = this.dataset.time;
        }
        dropdown.style.display = "none";
      });

      dropdown.appendChild(optionElement);
    }
  }
}

// Show or hide the dropdown
function toggleDropdown(input, dropdown) {
  input.addEventListener("click", function () {
    dropdown.style.display =
      dropdown.style.display === "block" ? "none" : "block";
  });

  // Close the dropdown when clicking outside
  document.addEventListener("click", function (e) {
    if (!dropdown.contains(e.target) && e.target !== input) {
      dropdown.style.display = "none";
    }
  });
}

function parseTime(timeString) {
  return timeString + ":00";
}

// Generate the time options for both dropdowns
generateTimeOptions(startTimeDropdown);
generateTimeOptions(endTimeDropdown);

// Set up toggle functionality for both inputs
toggleDropdown(startTimeInput, startTimeDropdown);
toggleDropdown(endTimeInput, endTimeDropdown);
>>>>>>> origin/Backend_logic
