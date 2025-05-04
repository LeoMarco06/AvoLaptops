document.addEventListener("DOMContentLoaded", function () {
  // Initialize variables and DOM elements
  const lockers = {};
  const selectedLaptops = [];
  const locker_container = document.getElementById("lockers_container");
  const confirmBtn = document.getElementById("confirm-booking");
  const startDatePicker = document.getElementById("start-date-picker");
  const clearBtn = document.getElementById("clear-selection");
  const selectedList = document.getElementById("selected-laptops");

  // Update locker statuses
  const lockerCards = document.querySelectorAll(".locker-card");
  lockerCards.forEach((lockerCard) => {
    const laptopsContainer = lockerCard.querySelector(".locker-laptops");
    const totalLaptops = laptopsContainer.children.length;
    const availableLaptops = laptopsContainer.querySelectorAll(
      ".laptop-item.available"
    ).length;

    const lockerStatus = lockerCard.querySelector(".locker-status");
    lockerStatus.textContent = `${availableLaptops}/${totalLaptops} available`;
  });

  toggleButtonFunction();

  // Handle booking confirmation
  confirmBtn.addEventListener("click", function () {
    const bookingDate = document.getElementById("booking-date").value;
    const returnDate = document.getElementById("return-date").value;

    if (selectedLaptops.length > 0) {
      if (!bookingDate || !returnDate) {
        alert("Please select booking and return dates.");
        return;
      }

      alert(
        `Booking confirmed for ${selectedLaptops.length} laptop(s)!\nFrom ${bookingDate} to ${returnDate}`
      );

      clearBtn.click(); // Reset after confirmation
    }
  });

  // Update the summary of selected laptops
  function updateSummary() {
    const summaryContent = document.querySelector(".summary-content p");

    if (selectedLaptops.length > 0) {
      summaryContent.textContent = `${selectedLaptops.length} laptop(s) selected`;
      confirmBtn.disabled = false;
    } else {
      summaryContent.textContent = "No laptops selected";
      confirmBtn.disabled = true;
    }
  }

  // Initialize date picker and set up filters
  initDatePicker("start-date", "start-date-picker");
  setupDatePickerListeners(startDatePicker);

  // Apply filters to laptops
  document.getElementById("filter-btn").addEventListener("click", function () {
    const selectedDate = document.getElementById("start-date").value;
    const selectedStartTime = document.getElementById("start-time").value;
    const selectedEndTime = document.getElementById("end-time").value;

    if (!selectedDate || !selectedStartTime || !selectedEndTime) {
      alert("Please fill in all fields to apply the filter.");
      return;
    }

    const xmlhttp = new XMLHttpRequest();
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
          });
        });

        Object.keys(lockers).forEach((lockerId) => {
          const lockerCard = createLocker(
            lockerId,
            lockers[lockerId],
            selectedLaptops
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
      "laptop_filter.php?date=" +
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
    const possibleStatuses = ["maintenance", "available", "unavailable"];
    const statusNames = ["Manutenzione", "Disponibile", "Non disponibile"];
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
        laptop.status === 0
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
  function createLocker(lockerId, laptops, selectedLaptops) {
    const lockerCard = document.createElement("div");
    lockerCard.className = "locker-card";
    let availableLaptops = laptops.filter(
      (laptop) => laptop.status === 0
    ).length;

    lockerCard.innerHTML = `
      <div class="locker-header">
        <h4 class="heading-4">Locker ${lockerId}</h4>
        <span class="locker-status">${availableLaptops}/${laptops.length} available</span>
        <button class="btn-icon toggle-locker" aria-expanded="false">
          <i class="fas fa-chevron-down"></i>
        </button>
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

  // Load laptops on page initialization
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
    });
  });

  Object.keys(lockers).forEach((lockerId) => {
    const lockerCard = createLocker(
      lockerId,
      lockers[lockerId],
      selectedLaptops
    );
    locker_container.appendChild(lockerCard);
  });

  toggleButtonFunction();
  laptopListener(selectedLaptops);
  document.getElementById("selected-laptops").innerHTML = "";
  updateSummary();

  document.body.removeChild(document.getElementById("laptops-data"));
});
