/*
  ==============================================================
  ==================== DATE PICKER FUNCTIONS ===================
  ==============================================================
*/

// Get the index of a month by its full name
function getMonthIndex(monthName) {
  const months = [
    "Gennaio",
    "Febbraio",
    "Marzo",
    "Aprile",
    "Maggio",
    "Giugno",
    "Luglio",
    "Agosto",
    "Settembre",
    "Ottobre",
    "Novembre",
    "Dicembre",
  ];
  return months.indexOf(monthName);
}

// Parse a custom date string into a JavaScript Date object
function parseCustomDate(dateStr) {
  if (!dateStr) return null;

  const [day, monthAbbr, year] = dateStr.split(" ");
  const monthNames = [
    "Gen",
    "Feb",
    "Mar",
    "Apr",
    "Mag",
    "Giu",
    "Lug",
    "Ago",
    "Set",
    "Ott",
    "Nov",
    "Dic",
  ];
  const monthIndex = monthNames.indexOf(monthAbbr) + 1;

  return year + "-" + monthIndex + "-" + day;
}

// Disable past dates and limit future dates in the picker
function disablePastDates(picker) {
  const today = new Date();
  today.setHours(0, 0, 0, 0);

  const max = new Date();
  max.setDate(max.getDate() + 14);
  max.setHours(0, 0, 0, 0);

  const currentMonthElement = picker.querySelector(".current-month");
  const currentYearElement = picker.querySelector(".current-year");

  const currentMonth = getMonthIndex(currentMonthElement.textContent);
  const currentYear = parseInt(currentYearElement.textContent);

  const days = picker.querySelectorAll(
    ".date-picker-days div:not(.prev-month):not(.next-month)"
  );

  days.forEach((day) => {
    const dayNumber = parseInt(day.textContent);
    if (isNaN(dayNumber)) return;

    const dayDate = new Date(currentYear, currentMonth, dayNumber);
    dayDate.setHours(0, 0, 0, 0);

    if (dayDate < today || dayDate > max) {
      day.classList.add("disabled");
      day.style.pointerEvents = "none";
      day.style.opacity = "0.5";
    } else {
      day.classList.remove("disabled");
      day.style.pointerEvents = "auto";
      day.style.opacity = "1";
    }
  });
}

// Set up navigation buttons for the date picker
function setupDatePickerListeners(picker) {
  const headerButtons = picker.querySelectorAll(".date-picker-header button");

  headerButtons.forEach((button) => {
    button.addEventListener("click", () => {
      setTimeout(() => disablePastDates(picker), 10);
    });
  });

  setTimeout(() => disablePastDates(picker), 100);
}

// Initialize the date picker with input and picker elements
function initDatePicker(inputId, pickerId) {
  const input = document.getElementById(inputId);
  const picker = document.getElementById(pickerId);

  let currentDate = new Date();
  let selectedDate = null;

  input.addEventListener("click", function (e) {
    e.stopPropagation();

    document.querySelectorAll(".date-picker").forEach((p) => {
      if (p.id !== pickerId) p.style.display = "none";
    });

    picker.style.display = picker.style.display === "none" ? "block" : "none";

    if (picker.style.display === "block") {
      renderCalendar();
    }
  });

  document.addEventListener("click", function (e) {
    if (!picker.contains(e.target) && e.target !== input) {
      picker.style.display = "none";
    }
  });

  picker.querySelector(".prev-month").addEventListener("click", function () {
    currentDate.setMonth(currentDate.getMonth() - 1);
    renderCalendar();
  });

  picker.querySelector(".next-month").addEventListener("click", function () {
    currentDate.setMonth(currentDate.getMonth() + 1);
    renderCalendar();
  });

  picker.querySelector(".prev-year").addEventListener("click", function () {
    currentDate.setFullYear(currentDate.getFullYear() - 1);
    renderCalendar();
  });

  picker.querySelector(".next-year").addEventListener("click", function () {
    currentDate.setFullYear(currentDate.getFullYear() + 1);
    renderCalendar();
  });

  picker.querySelector(".today-btn").addEventListener("click", function () {
    currentDate = new Date();
    selectDate(new Date());
  });

  picker.querySelector(".clear-btn").addEventListener("click", function () {
    selectedDate = null;
    input.value = "";
    renderCalendar();
  });

  function renderCalendar() {
    const firstDayOfMonth = new Date(
      currentDate.getFullYear(),
      currentDate.getMonth(),
      1
    );

    const lastDayOfMonth = new Date(
      currentDate.getFullYear(),
      currentDate.getMonth() + 1,
      0
    );

    const daysInMonth = lastDayOfMonth.getDate();
    const startingDay = firstDayOfMonth.getDay();
    const adjustedStartingDay = startingDay === 0 ? 6 : startingDay - 1;

    const monthNames = [
      "Gennaio",
      "Febbraio",
      "Marzo",
      "Aprile",
      "Maggio",
      "Giugno",
      "Luglio",
      "Agosto",
      "Settembre",
      "Ottobre",
      "Novembre",
      "Dicembre",
    ];

    picker.querySelector(".current-month").textContent =
      monthNames[currentDate.getMonth()];
    picker.querySelector(".current-year").textContent =
      currentDate.getFullYear();

    const weekdays = ["Lun", "Mar", "Mer", "Gio", "Ven", "Sab", "Dom"];
    const weekdaysContainer = picker.querySelector(".date-picker-weekdays");
    weekdaysContainer.innerHTML = weekdays
      .map((day) => `<div>${day}</div>`)
      .join("");

    const daysContainer = picker.querySelector(".date-picker-days");
    daysContainer.innerHTML = "";

    const prevMonthLastDay = new Date(
      currentDate.getFullYear(),
      currentDate.getMonth(),
      0
    ).getDate();

    for (let i = 0; i < adjustedStartingDay; i++) {
      const dayElement = document.createElement("div");
      dayElement.classList.add("prev-month");
      dayElement.textContent = prevMonthLastDay - adjustedStartingDay + i + 1;
      daysContainer.appendChild(dayElement);
    }

    const today = new Date();

    for (let i = 1; i <= daysInMonth; i++) {
      const dayElement = document.createElement("div");
      dayElement.textContent = i;

      if (
        i === today.getDate() &&
        currentDate.getMonth() === today.getMonth() &&
        currentDate.getFullYear() === today.getFullYear()
      ) {
        dayElement.classList.add("today");
      }

      if (
        selectedDate &&
        i === selectedDate.getDate() &&
        currentDate.getMonth() === selectedDate.getMonth() &&
        currentDate.getFullYear() === selectedDate.getFullYear()
      ) {
        dayElement.classList.add("selected");
      }

      dayElement.addEventListener("click", function () {
        selectDate(
          new Date(currentDate.getFullYear(), currentDate.getMonth(), i)
        );
      });

      daysContainer.appendChild(dayElement);
    }

    const totalDays = adjustedStartingDay + daysInMonth;
    const remainingDays = 7 - (totalDays % 7);

    if (remainingDays < 7) {
      for (let i = 1; i <= remainingDays; i++) {
        const dayElement = document.createElement("div");
        dayElement.classList.add("next-month");
        dayElement.textContent = i;
        daysContainer.appendChild(dayElement);
      }
    }

    disablePastDates(picker);
  }

  function selectDate(date) {
    selectedDate = date;
    input.value = formatDate(date);
    picker.style.display = "none";
    renderCalendar();
  }

  window.selectDate = selectDate;

  function formatDate(date) {
    if (!date) return "";

    const day = date.getDate();
    const monthNames = [
      "Gen",
      "Feb",
      "Mar",
      "Apr",
      "Mag",
      "Giu",
      "Lug",
      "Ago",
      "Set",
      "Ott",
      "Nov",
      "Dic",
    ];
    const month = monthNames[date.getMonth()];
    const year = date.getFullYear();

    return `${day} ${month} ${year}`;
  }

  renderCalendar();

  window.initDatePicker = initDatePicker;
  window.formatDate = formatDate;
}