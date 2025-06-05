const startTimeInput = document.getElementById("start-time");
const endTimeInput = document.getElementById("end-time");
const startTimeDropdown = document.getElementById("start-time-picker-dropdown");
const endTimeDropdown = document.getElementById("end-time-picker-dropdown");

// Returns the next available half-hour time slot as a string
function getCurrentTimeString() {
  const now = new Date();
  let hours = now.getHours();
  let minutes = now.getMinutes();

  if (minutes >= 30) {
    hours += 1;
    minutes = 0;
  } else {
    minutes = 30;
  }

  if (hours > 17) {
    hours = 17;
    minutes = 0;
  }

  return `${hours.toString().padStart(2, "0")}:${minutes.toString().padStart(2, "0")}`;
}

// Generates time options for the dropdown, hiding those before or equal to minTime
function generateTimeOptions(dropdown, minTime = null) {
  dropdown.innerHTML = "";
  const startHour = 8;
  const endHour = 17;

  for (let hour = startHour; hour <= endHour; hour++) {
    for (let minute = 0; minute < 60; minute += 30) {
      if (hour === endHour && minute > 0) break;

      const formattedHour = hour.toString().padStart(2, "0");
      const formattedMinute = minute.toString().padStart(2, "0");
      const timeOption = `${formattedHour}:${formattedMinute}`;

      // Hide times before or equal to minTime
      if (minTime && timeOption <= minTime) continue;

      const optionElement = document.createElement("div");
      optionElement.textContent = timeOption;
      optionElement.dataset.time = timeOption;

      optionElement.addEventListener("click", function () {
        if (dropdown === startTimeDropdown) {
          startTimeInput.value = this.dataset.time;
          endTimeInput.value = addMinutes(this.dataset.time, 30);
          startTimeInput.dispatchEvent(new Event("change"));
          endTimeInput.dispatchEvent(new Event("change"));
        } else {
          endTimeInput.value = this.dataset.time;
          endTimeInput.dispatchEvent(new Event("change"));
        }
        dropdown.style.display = "none";
      });

      dropdown.appendChild(optionElement);
    }
  }
}

// Adds minutes to a time string (HH:mm)
function addMinutes(timeStr, minsToAdd) {
  let [hours, minutes] = timeStr.split(":").map(Number);
  minutes += minsToAdd;
  hours += Math.floor(minutes / 60);
  minutes %= 60;
  return `${hours}:${minutes.toString().padStart(2, "0")}`;
}

// Checks if the selected date is today
function isTodaySelected() {
  const selectedDate = document.getElementById("start-date").value;
  const today = new Date();
  const dd = String(today.getDate()).padStart(2, "0");
  const yyyy = today.getFullYear();
  const todayStr = `${dd} ${["Gen","Feb","Mar","Apr","Mag","Giu","Lug","Ago","Set","Ott","Nov","Dic"][today.getMonth()]} ${yyyy}`;
  return selectedDate === todayStr;
}

// Checks if the selected date is in the future
function isFutureDateSelected() {
  const selectedDate = document.getElementById("start-date").value;
  if (!selectedDate) return false;
  const today = new Date();
  const [selDay, selMonthStr, selYear] = selectedDate.split(" ");
  const monthNames = ["Gen","Feb","Mar","Apr","Mag","Giu","Lug","Ago","Set","Ott","Nov","Dic"];
  const selMonth = monthNames.indexOf(selMonthStr);
  const selDate = new Date(Number(selYear), selMonth, Number(selDay));
  // Remove time part for comparison
  today.setHours(0,0,0,0);
  selDate.setHours(0,0,0,0);
  return selDate > today;
}

// --- EVENT LISTENERS ---

// Start time input click: open/close dropdown and manage logic
startTimeInput.addEventListener("click", function (e) {
  e.stopPropagation();
  // Close all date pickers
  document.querySelectorAll(".date-picker").forEach(p => p.style.display = "none");
  // Toggle dropdown: if already open, close and return
  if (startTimeDropdown.style.display === "block") {
    startTimeDropdown.style.display = "none";
    return;
  }
  // Close end time dropdown if open
  endTimeDropdown.style.display = "none";

  let minTime = null;

  // Get current date and time
  const now = new Date();
  const currentHour = now.getHours();
  const currentMinute = now.getMinutes();

  // Get selected date
  const startDateInput = document.getElementById("start-date");
  const today = new Date();
  today.setHours(0, 0, 0, 0);

  const selectedDateStr = startDateInput.value;
  let selectedDate = null;
  if (selectedDateStr) {
    const [selDay, selMonthStr, selYear] = selectedDateStr.split(" ");
    const monthNames = ["Gen","Feb","Mar","Apr","Mag","Giu","Lug","Ago","Set","Ott","Nov","Dic"];
    const selMonth = monthNames.indexOf(selMonthStr);
    selectedDate = new Date(Number(selYear), selMonth, Number(selDay));
    selectedDate.setHours(0, 0, 0, 0);
  }

  // If today and time > 17, set date to tomorrow and show all times
  if (
    selectedDate &&
    selectedDate.getTime() === today.getTime() &&
    currentHour >= 17
  ) {
    const tomorrow = new Date(today);
    tomorrow.setDate(today.getDate() + 1);

    // Format "D MMM YYYY"
    const day = tomorrow.getDate();
    const monthNames = ["Gen", "Feb", "Mar", "Apr", "Mag", "Giu", "Lug", "Ago", "Set", "Ott", "Nov", "Dic"];
    const month = monthNames[tomorrow.getMonth()];
    const year = tomorrow.getFullYear();
    const tomorrowStr = `${day} ${month} ${year}`;

    // Update date input if different
    if (startDateInput.value !== tomorrowStr) {
      startDateInput.value = tomorrowStr;
      startDateInput.dispatchEvent(new Event("change", { bubbles: true }));
    }

    minTime = null;
  } else if (
    selectedDate &&
    selectedDate.getTime() === today.getTime() &&
    currentHour >= 8 &&
    (currentHour < 16 || (currentHour === 16 && currentMinute < 30))
  ) {
    // If today and time is between 8:00 and 16:29, show only times after current (next half hour)
    minTime = getCurrentTimeString();

    // Set default value to the next available half-hour slot, but not after 16:30
    let defaultTime = minTime;
    if (defaultTime > "16:30") defaultTime = "16:30";
    startTimeInput.value = defaultTime;
    endTimeInput.value = addMinutes(defaultTime, 30);
    startTimeInput.dispatchEvent(new Event("change"));
    endTimeInput.dispatchEvent(new Event("change"));
  } else if (isTodaySelected()) {
    // If today and time < 8 show all times
    if (currentHour < 8) {
      minTime = null;
      // Set default to 08:00
      startTimeInput.value = "08:00";
      endTimeInput.value = "08:30";
      startTimeInput.dispatchEvent(new Event("change"));
      endTimeInput.dispatchEvent(new Event("change"));
    }
  } else if (isFutureDateSelected()) {
    minTime = null;
    // Set default to 08:00
    startTimeInput.value = "08:00";
    endTimeInput.value = "08:30";
    startTimeInput.dispatchEvent(new Event("change"));
    endTimeInput.dispatchEvent(new Event("change"));
  } else {
    minTime = null;
    // Set default to 08:00
    startTimeInput.value = "08:00";
    endTimeInput.value = "08:30";
    startTimeInput.dispatchEvent(new Event("change"));
    endTimeInput.dispatchEvent(new Event("change"));
  }

  // In any case, do not allow start time after 16:30
  function filterMaxStartTime(dropdown) {
    Array.from(dropdown.children).forEach(option => {
      if (option.dataset.time > "16:30") {
        option.style.display = "none";
      }
    });
  }

  generateTimeOptions(startTimeDropdown, minTime);
  filterMaxStartTime(startTimeDropdown);
  startTimeDropdown.style.display = "block";
});

// End time input click: open/close dropdown and show only times after start time
endTimeInput.addEventListener("click", function (e) {
  e.stopPropagation();
  // Close all date pickers
  document.querySelectorAll(".date-picker").forEach(p => p.style.display = "none");
  // Toggle dropdown: if already open, close and return
  if (endTimeDropdown.style.display === "block") {
    endTimeDropdown.style.display = "none";
    return;
  }
  // Close start time dropdown if open
  startTimeDropdown.style.display = "none";

  // Show only times after start time
  generateTimeOptions(endTimeDropdown, startTimeInput.value);
  endTimeDropdown.style.display = "block";
});

// Close time pickers if clicking outside or on a date picker
document.addEventListener("click", function (e) {
  if (!startTimeDropdown.contains(e.target) && e.target !== startTimeInput) {
    startTimeDropdown.style.display = "none";
  }
  if (!endTimeDropdown.contains(e.target) && e.target !== endTimeInput) {
    endTimeDropdown.style.display = "none";
  }
  // If clicking on a date picker, close both time pickers
  if (e.target.classList && e.target.classList.contains("date-picker")) {
    startTimeDropdown.style.display = "none";
    endTimeDropdown.style.display = "none";
  }
});

// Close time pickers if clicking any element inside the date picker (days, header, etc.)
document.querySelectorAll(".date-picker").forEach(function(picker) {
  picker.addEventListener("mousedown", function() {
    startTimeDropdown.style.display = "none";
    endTimeDropdown.style.display = "none";
  });
});

// --- ONLY ONE DROPDOWN OPEN AT A TIME (close time pickers when opening date picker) ---
document.querySelectorAll(".date-picker-input").forEach(function(input) {
  input.addEventListener("click", function () {
    startTimeDropdown.style.display = "none";
    endTimeDropdown.style.display = "none";
    // Close all other date pickers except the one related to the clicked input
    document.querySelectorAll(".date-picker").forEach(function(picker) {
      if (picker.previousElementSibling !== input) picker.style.display = "none";
    });
  });
});

document.addEventListener("DOMContentLoaded", function () {
  const startDateInput = document.getElementById("start-date");
  const today = new Date();
  today.setHours(0, 0, 0, 0);

  const now = new Date();
  const currentHour = now.getHours();
  const currentMinute = now.getMinutes();

  const selectedDateStr = startDateInput.value;
  let selectedDate = null;
  if (selectedDateStr) {
    const [selDay, selMonthStr, selYear] = selectedDateStr.split(" ");
    const monthNames = ["Gen","Feb","Mar","Apr","Mag","Giu","Lug","Ago","Set","Ott","Nov","Dic"];
    const selMonth = monthNames.indexOf(selMonthStr);
    selectedDate = new Date(Number(selYear), selMonth, Number(selDay));
    selectedDate.setHours(0, 0, 0, 0);
  }

  // If today and time is between 8:00 and 16:29, set default start time to the next available half-hour slot (not after 16:30)
  if (
    selectedDate &&
    selectedDate.getTime() === today.getTime() &&
    currentHour >= 8 &&
    (currentHour < 16 || (currentHour === 16 && currentMinute < 30))
  ) {
    let defaultTime = getCurrentTimeString();
    if (defaultTime > "16:30") defaultTime = "16:30";
    startTimeInput.value = defaultTime;
    endTimeInput.value = addMinutes(defaultTime, 30);
    startTimeInput.dispatchEvent(new Event("change"));
    endTimeInput.dispatchEvent(new Event("change"));
  }
});