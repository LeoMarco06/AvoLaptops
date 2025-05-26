const startTimeInput = document.getElementById("start-time");
const endTimeInput = document.getElementById("end-time");
const startTimeDropdown = document.getElementById("start-time-picker-dropdown");
const endTimeDropdown = document.getElementById("end-time-picker-dropdown");

// Ottieni l'orario attuale nel formato "HH:MM"
function getCurrentTimeString() {
  const now = new Date();
  let hours = now.getHours();
  let minutes = now.getMinutes();
  // Arrotonda ai 30 minuti successivi
  if (minutes >= 30) {
    hours += 1;
    minutes = 0;
  } else {
    minutes = 30;
  }
  // Limita all'orario di chiusura
  if (hours > 17) {
    hours = 17;
    minutes = 0;
  }
  return `${hours.toString().padStart(2, "0")}:${minutes.toString().padStart(2, "0")}`;
}

// Modifica la funzione per accettare minTime dinamico
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

      // Nascondi orari precedenti a minTime
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

// Show or hide the dropdown
function toggleDropdown(input, dropdown, isEndTime = false) {
  input.addEventListener("click", function () {
    if (isEndTime) {
      // Rigenera le opzioni in base all'orario di inizio selezionato
      generateTimeOptions(dropdown, startTimeInput.value);
    }
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
toggleDropdown(endTimeInput, endTimeDropdown, true);

// Mostra solo orari validi per oggi
function isTodaySelected() {
  const selectedDate = document.getElementById("start-date").value;
  const today = new Date();
  const dd = String(today.getDate()).padStart(2, "0");
  const mm = String(today.getMonth() + 1).padStart(2, "0");
  const yyyy = today.getFullYear();
  const todayStr = `${dd} ${["Gen","Feb","Mar","Apr","Mag","Giu","Lug","Ago","Set","Ott","Nov","Dic"][today.getMonth()]} ${yyyy}`;
  return selectedDate === todayStr;
}

// Rigenera le opzioni quando si apre il time picker di inizio
startTimeInput.addEventListener("click", function () {
  let minTime = null;
  if (isTodaySelected()) {
    minTime = getCurrentTimeString();
  }
  generateTimeOptions(startTimeDropdown, minTime);
  startTimeDropdown.style.display = "block";
});

// Rigenera le opzioni per end time come prima
endTimeInput.addEventListener("click", function () {
  generateTimeOptions(endTimeDropdown, startTimeInput.value);
  endTimeDropdown.style.display = "block";
});

// Chiudi i dropdown cliccando fuori
document.addEventListener("click", function (e) {
  if (!startTimeDropdown.contains(e.target) && e.target !== startTimeInput) {
    startTimeDropdown.style.display = "none";
  }
  if (!endTimeDropdown.contains(e.target) && e.target !== endTimeInput) {
    endTimeDropdown.style.display = "none";
  }
});
