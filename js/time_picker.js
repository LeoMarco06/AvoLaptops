const startTimeInput = document.getElementById("start-time");
const endTimeInput = document.getElementById("end-time");
const startTimeDropdown = document.getElementById("start-time-picker-dropdown");
const endTimeDropdown = document.getElementById("end-time-picker-dropdown");

// Generate time options from 8:00 to 19:00
function generateTimeOptions(dropdown) {
  const startHour = 8;
  const endHour = 17;

  for (let hour = startHour; hour <= endHour; hour++) {
    for (let minute = 0; minute < 60; minute += 30) {
      if (hour === endHour && minute > 0) {
        break; // Avoid adding to last hour hh:30
      }
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
          endTimeInput.value = addMinutes(this.dataset.time, 30);
        } else {
          endTimeInput.value = this.dataset.time;
        }
        dropdown.style.display = "none";
        //laptopFilter();
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

function addMinutes(timeStr, minsToAdd) {
  let [hours, minutes] = timeStr.split(":").map(Number);
  minutes += minsToAdd;

  // Handle overflow
  hours += Math.floor(minutes / 60);
  minutes %= 60;

  // Format back to "hour:min"
  return `${hours}:${minutes.toString().padStart(2, "0")}`;
}

// Generate the time options for both dropdowns
generateTimeOptions(startTimeDropdown);
generateTimeOptions(endTimeDropdown);

// Set up toggle functionality for both inputs
toggleDropdown(startTimeInput, startTimeDropdown);
toggleDropdown(endTimeInput, endTimeDropdown);
