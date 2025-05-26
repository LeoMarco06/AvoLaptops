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

  // Function that change period of the reservation
  function changeReservationPeriod() {
    // Deseleziona tutti i laptop
    selectedLaptops.length = 0;
    selectedList.innerHTML = "";
    updateSummary();

    document.querySelectorAll(".locker-header").forEach((locker) => {
      deselectAllLaptopsInLocker(locker.dataset.lockerId);
    });
    const selectedDate = parseCustomDate(
      document.getElementById("start-date").value
    );
    const selectedStartTime = document.getElementById("start-time").value;
    const selectedEndTime = document.getElementById("end-time").value;
    document.getElementById("day-hid").value = selectedDate;

    if (!selectedDate || !selectedStartTime || !selectedEndTime) {
      alert("Please fill in all fields to apply the filter.");
      return;
    }

    // Perform AJAX request to filter laptops
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        try {
          const response = JSON.parse(this.responseText);
          locker_container.innerHTML = "";

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
        } catch (e) {
          console.error("Risposta non valida dal server:", this.responseText);
          alert("Errore interno del server. Contatta l'amministratore.");
        }
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
  };

  // Add event listener to the date picker
  document.getElementById("start-date").addEventListener("change", function () {
    changeReservationPeriod();
  });

  // Add event listener to the start time input
  document.getElementById("start-time").addEventListener("change", function () {
    changeReservationPeriod();
  });

  // Add event listener to the end time input
  document.getElementById("end-time").addEventListener("change", function () {
    changeReservationPeriod();
  });

  // Create a laptop item element
  function createLaptop(laptop) {
    const laptopItem = document.createElement("div");
    const possibleStatuses = [
      "maintenance",    // -1
      "unavailable",    // 0
      "available",      // 1
      "charging",       // 2
    ];
    const statusNames = [
      "Manutenzione",   // -1
      "Non disponibile",// 0
      "Disponibile",    // 1
      "Ricarica",       // 2
    ];
    // status va da -1 a 2, quindi aggiungi 1 per l'indice
    const statusClass = possibleStatuses[laptop.status + 1];
    const statusLabel = statusNames[laptop.status + 1];

    laptopItem.className = `laptop-item ${statusClass}`;
    laptopItem.dataset.laptopId = laptop.id;

    laptopItem.innerHTML = `
      <div class="laptop-info ${statusClass}">
        <i class="fas fa-laptop"></i>
        <span>${laptop.name} (${laptop.model})</span>
      </div>`;

    if (laptop.status === 1) {
      // Disponibile: mostra il bottone
      laptopItem.innerHTML += `<button class="btn-icon select-laptop">
               <i class="fas fa-plus"></i>
             </button>`;
    } else if (laptop.status === -1) {
      // Manutenzione
      laptopItem.innerHTML += `<span class="status-badge"><i class="fas fa-tools"></i>${statusLabel}</span>`;
    } else if (laptop.status === 0) {
      // Non disponibile
      laptopItem.innerHTML += `<span class="status-badge"><i class="fas fa-times"></i>${statusLabel}</span>`;
    } else if (laptop.status === 2) {
      // Ricarica
      laptopItem.innerHTML += `<span class="status-badge"><i class="fa-solid fa-bolt"></i>${statusLabel}</span>`;
    }

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
    <div class="locker-header" data-locker-id="${lockerId}">
        <h4 class="heading-4">Armadietto ${lockerId} - ${lock_class}</h4>
        <div>
        <span class="locker-status">${availableLaptops}/${laptops.length} disponibili</span>
        <button class="btn-icon toggle-locker" aria-expanded="false">
          <i class="fas fa-chevron-down"></i>
        </button>
        </div>
    </div>
    <div class="locker-buttons">
      <button type="button" class="btn btn-outline btn-small" onclick="selectAllLaptopsInLocker(${lockerId})">Seleziona tutto</button>
      <button type="button" class="btn btn-outline btn-small" onclick="deselectAllLaptopsInLocker(${lockerId})">Deseleziona tutto</button>
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
    <span > ${laptopName}</span >
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


  function selectAllLaptopsInLocker(lockerId) {
    let lockerCard = null;
    document.querySelectorAll('.locker-card').forEach(card => {
      const heading = card.querySelector('.heading-4');
      if (heading && heading.textContent.includes(`Armadietto ${lockerId}`)) {
        lockerCard = card;
      }
    });
    if (!lockerCard) return;
    lockerCard.querySelectorAll('.laptop-item.available .select-laptop:not(.selected)').forEach(btn => btn.click());
  }


  function deselectAllLaptopsInLocker(lockerId) {
    let lockerCard = null;
    document.querySelectorAll('.locker-card').forEach(card => {
      const heading = card.querySelector('.heading-4');
      if (heading && heading.textContent.includes(`Armadietto ${lockerId}`)) {
        lockerCard = card;
      }
    });
    if (!lockerCard) return;
    lockerCard.querySelectorAll('.laptop-item .select-laptop.selected').forEach(btn => {
      const laptopItem = btn.closest('.laptop-item');
      const laptopId = laptopItem.dataset.laptopId;
      const removeBtn = document.querySelector(`#selected-laptops li[data-laptop-id="${laptopId}"] .remove-laptop`);
      if (removeBtn) removeBtn.click();
    });
  }

  // Esporre le funzioni globalmente per l'onclick HTML
  window.selectAllLaptopsInLocker = selectAllLaptopsInLocker;
  window.deselectAllLaptopsInLocker = deselectAllLaptopsInLocker;
  window.selectLaptopById = selectLaptopById;

  // Remove the laptop data hidden div
  const laptopDataDiv = document.getElementById("laptops-data");
  if (laptopDataDiv) {
    laptopDataDiv.remove();
  }
});