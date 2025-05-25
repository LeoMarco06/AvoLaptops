document.addEventListener("DOMContentLoaded", function () {
  const lockers = {};
  const selectedLaptops = [];
  const locker_container = document.getElementById("lockers_container");
  const confirmBtn = document.getElementById("confirm-booking");
  const startDatePicker = document.getElementById("start-date-picker");
  const clearBtn = document.getElementById("clear-selection");
  const selectedList = document.getElementById("selected-laptops");

  const lockerCards = document.querySelectorAll(".locker-card");

  lockerCards.forEach((lockerCard) => {
    const laptopsContainer = lockerCard.querySelector(".locker-laptops");
    const totalLaptops = laptopsContainer.children.length;
    const availableLaptops = laptopsContainer.querySelectorAll(
      ".laptop-item.available"
    ).length;

    // Update the locker status with available/total laptops
    const lockerStatus = lockerCard.querySelector(".locker-status");
    lockerStatus.textContent = `${availableLaptops}/${totalLaptops} disponibili`;
  });

  toggleButtonFunction();

  // Handle booking confirmation
  confirmBtn.addEventListener("click", function () {
    // Get values from visible inputs
    const day = document.getElementById("start-date").value;
    const start = document.getElementById("start-time").value;
    const end = document.getElementById("end-time").value;

    // Assign them to the hidden fields
    document.getElementById("hidden-day").value = parseCustomDate(day);
    document.getElementById("hidden-start-time").value = start;
    document.getElementById("hidden-end-time").value = end;

    if (selectedLaptops.length > 0) {
      alert(
        `Booking confirmed for ${selectedLaptops.length} laptop(s)!\nFrom ${day} to ${end}`
      );

      //submit the form
      document.getElementById("booking-summary-form").submit();
    }
  });

  // Update the summary of selected laptops
  function updateSummary() {
    const summaryContent = document.querySelector(".summary-content p");

    if (selectedLaptops.length > 0) {
      summaryContent.textContent = `${selectedLaptops.length} PC selezionati`;
      confirmBtn.disabled = false;
    } else {
      summaryContent.textContent = "Nessun PC selezionato";
      confirmBtn.disabled = true;
    }
  }

  // Initialize date picker and set up filters
  const today = new Date();
  const yyyy = today.getFullYear();
  const mm = String(today.getMonth() + 1).padStart(2, "0");
  const dd = String(today.getDate()).padStart(2, "0");
  const formattedToday = `${yyyy}-${mm}-${dd}`;

  // Calcola la data massima (oggi + 14 giorni)
  const maxDateObj = new Date(today);
  maxDateObj.setDate(today.getDate() + 14);
  const maxY = maxDateObj.getFullYear();
  const maxM = String(maxDateObj.getMonth() + 1).padStart(2, "0");
  const maxD = String(maxDateObj.getDate()).padStart(2, "0");
  const formattedMax = `${maxY}-${maxM}-${maxD}`;

  // Passa minDate e maxDate a initDatePicker
  initDatePicker(
    "start-date",
    "start-date-picker",
    formattedToday,
    formattedMax
  );
  setupDatePickerListeners(
    startDatePicker,
    new Date(formattedToday),
    new Date(formattedMax)
  );

  document.getElementById("filter-btn").addEventListener("click", function () {
    const selectedDate = parseCustomDate(
      document.getElementById("start-date").value
    );
    const selectedStartTime = document.getElementById("start-time").value;
    const selectedEndTime = document.getElementById("end-time").value;
    document.getElementById("day-hid").value = parseCustomDate(selectedDate);

    if (!selectedDate || !selectedStartTime || !selectedEndTime) {
      alert("Please fill in all fields to apply the filter.");
      return;
    }

    // Perform AJAX request to filter laptops
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        locker_container.innerHTML = "";

        const response = JSON.parse(this.responseText);
        const lockers = {};

        response.forEach((laptop) => {
          if (!lockers[laptop.lap_locker]) {
            lockers[laptop.lap_locker] = [];
          }
          lockers[laptop.lap_locker].push({
            id: laptop.lap_id,
            name: laptop.lap_name,
            model: laptop.lap_model,
            status: laptop.lap_status,
            lock_class: laptop.lock_class,
          });
        });

        Object.keys(lockers).forEach((lockerId) => {
          const lockerCard = createLocker(
            lockerId,
            lockers[lockerId],
            selectedLaptops,
            lockers[lockerId][0].lock_class
          );
          locker_container.appendChild(lockerCard);
        });

        toggleButtonFunction();
        laptopListener(selectedLaptops);
        document.getElementById("selected-laptops").innerHTML = "";
        updateSummary();
      } else if (this.readyState == 4) {
        alert("Error: " + this.statusText);
      }
    };

    xmlhttp.open(
      "GET",
      "../include/functions/laptop_filter.php?date=" +
        selectedDate +
        "&start_time=" +
        selectedStartTime +
        "&end_time=" +
        selectedEndTime,
      true
    );
    xmlhttp.send();
  });

  // Create a laptop item element
  function createLaptop(laptop) {
    const laptopItem = document.createElement("div");
    const possibleStatuses = [
      "maintenance",
      "unavailable",
      "available",
      "charging",
    ];
    const statusNames = [
      "Manutenzione",
      "Non disponibile",
      "Disponibile",
      "Ricarica",
    ];
    const statusClass = possibleStatuses[laptop.status + 1];
    const statusLabel = statusNames[laptop.status + 1];

    laptopItem.className = `laptop-item ${statusClass}`;
    laptopItem.dataset.laptopId = laptop.id;

    laptopItem.innerHTML = `
      <div class="laptop-info ${statusClass}">
        <i class="fas fa-laptop"></i>
        <span>${laptop.name} (${laptop.model})</span>
      </div>
      ${
        laptop.status === 1
          ? `<button class="btn-icon select-laptop">
               <i class="fas fa-plus"></i>
             </button>`
          : `<span class="status-badge">
               <i class="fas ${
                 laptop.status === -1 ? "fa-tools" : "fa-times"
               }"></i> ${statusLabel}
             </span>`
      }
    `;

    return laptopItem;
  }

  // Create a locker card element
  function createLocker(lockerId, laptops, selectedLaptops, lock_class) {
    const lockerCard = document.createElement("div");
    lockerCard.className = "locker-card";
    let availableLaptops = laptops.filter(
      (laptop) => laptop.status === 1
    ).length;

    lockerCard.innerHTML = `
      <div class="locker-header">
        <h4 class="heading-4">Armadietto ${lockerId} - ${lock_class}</h4>
        <div>
        <span class="locker-status">${availableLaptops}/${laptops.length} disponibili</span>
        <button class="btn-icon toggle-locker" aria-expanded="false">
          <i class="fas fa-chevron-down"></i>
        </button>
        </div>
      </div>
      <div class="locker-laptops" style="display: none;">
      </div>
    `;

    const lockerLaptops = lockerCard.querySelector(".locker-laptops");

    laptops.forEach((laptop) => {
      const laptopItem = createLaptop(laptop);
      lockerLaptops.appendChild(laptopItem);
    });

    laptopListener(selectedLaptops);

    return lockerCard;
  }

  // Toggle locker visibility
  function toggleButtonFunction() {
    const toggleButtons = document.querySelectorAll(".toggle-locker");
    toggleButtons.forEach((button) => {
      button.addEventListener("click", () => {
        const lockerCard = button.closest(".locker-card");
        const lockerLaptops = lockerCard.querySelector(".locker-laptops");
        const lockerHeader = lockerCard.querySelector(".locker-header");

        const isExpanded = button.getAttribute("aria-expanded") === "true";
        button.setAttribute("aria-expanded", !isExpanded);
        lockerLaptops.style.display = isExpanded ? "none" : "grid";

        lockerHeader.classList.toggle("expanded", !isExpanded);

        const icon = button.querySelector("i");
        icon.classList.toggle("fa-chevron-down", isExpanded);
        icon.classList.toggle("fa-chevron-up", !isExpanded);
      });
    });
  }

  // Manage laptop selection
  function laptopListener(selectedLaptops) {
    document.querySelectorAll(".select-laptop").forEach((btn) => {
      btn.addEventListener("click", function () {
        const laptopItem = this.closest(".laptop-item");
        const laptopId = laptopItem.dataset.laptopId;
        const laptopName =
          laptopItem.querySelector(".laptop-info span").textContent;

        if (!selectedLaptops.includes(laptopId)) {
          selectedLaptops.push(laptopId);

          const listItem = document.createElement("li");
          listItem.dataset.laptopId = laptopId;
          listItem.innerHTML = `
                              <span>${laptopName}</span>
                              <button class="btn-icon remove-laptop">
                                  <i class="fas fa-times"></i>
                              </button>
                              <input type="hidden" name="laptop_ids[]" value="${laptopId}">
                          `;

          selectedList.appendChild(listItem);
          laptopItem.querySelector(".select-laptop i").className =
            "fas fa-check";
          laptopItem.querySelector(".select-laptop").classList.add("selected");

          updateSummary();
        }
      });
    });

    selectedList.addEventListener("click", function (e) {
      if (e.target.closest(".remove-laptop")) {
        const listItem = e.target.closest("li");
        const laptopId = listItem.dataset.laptopId;

        const index = selectedLaptops.indexOf(laptopId);
        if (index > -1) {
          selectedLaptops.splice(index, 1);
        }
        listItem.remove();

        const laptopItem = document.querySelector(
          `.laptop-item[data-laptop-id="${laptopId}"]`
        );
        if (laptopItem) {
          laptopItem.querySelector(".select-laptop i").className =
            "fas fa-plus";
          laptopItem
            .querySelector(".select-laptop")
            .classList.remove("selected");
        }

        updateSummary();
      }
    });

    clearSelectionListener();
  }

  // Clear all selected laptops
  function clearSelectionListener() {
    clearBtn.addEventListener("click", function () {
      selectedLaptops.length = 0;
      selectedList.innerHTML = "";

      document.querySelectorAll(".select-laptop").forEach((btn) => {
        btn.querySelector("i").className = "fas fa-plus";
        btn.classList.remove("selected");
      });

      updateSummary();
    });
  }

  // Loading of the laptops at the beginning
  const response = JSON.parse(
    document.getElementById("laptops-data").textContent
  );
  selectedLaptops.length = 0;

  response.forEach((laptop) => {
    if (!lockers[laptop.lap_locker]) {
      lockers[laptop.lap_locker] = [];
    }
    lockers[laptop.lap_locker].push({
      id: laptop.lap_id,
      name: laptop.lap_name,
      model: laptop.lap_model,
      status: laptop.lap_status,
      lock_class: laptop.lock_class,
    });
  });

  Object.keys(lockers).forEach((lockerId) => {
    const lockerCard = createLocker(
      lockerId,
      lockers[lockerId],
      selectedLaptops,
      lockers[lockerId][0].lock_class
    );
    locker_container.appendChild(lockerCard);
  });

  toggleButtonFunction();
  laptopListener(selectedLaptops);
  document.getElementById("selected-laptops").innerHTML = "";
  updateSummary();

  function selectLaptopById(lap_id) {
    const laptopItem = document.querySelector(
      `.laptop-item[data-laptop-id="${lap_id}"]`
    );
    if (!laptopItem) {
      alert("Laptop non trovato o non disponibile per la selezione.");
      return;
    }

    const selectBtn = laptopItem.querySelector(".select-laptop");
    if (selectBtn && !selectBtn.classList.contains("selected")) {
      selectBtn.click();
    } else if (selectBtn && selectBtn.classList.contains("selected")) {
      alert("Questo laptop è già nel carrello.");
    } else {
      alert("Questo laptop non è selezionabile.");
    }
  }

  window.selectLaptopById = selectLaptopById;
});
