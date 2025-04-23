document.addEventListener("DOMContentLoaded", function () {
  // Select all locker cards
  const lockerCards = document.querySelectorAll(".locker-card");

  lockerCards.forEach((lockerCard) => {
    // Get the locker-laptops container
    const laptopsContainer = lockerCard.querySelector(".locker-laptops");

    // Count all laptops
    const totalLaptops = laptopsContainer.children.length;

    // Count available laptops
    const availableLaptops = laptopsContainer.querySelectorAll(
      ".laptop-item.available"
    ).length;

    // Update the locker status
    const lockerStatus = lockerCard.querySelector(".locker-status");
    lockerStatus.textContent = `${availableLaptops}/${totalLaptops} disponibili`;
  });

  // Manage laptop selection
  const selectedLaptops = [];
  const selectedList = document.getElementById("selected-laptops");
  const confirmBtn = document.getElementById("confirm-booking");
  const clearBtn = document.getElementById("clear-selection");

  // Add laptop to the selection
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
                            <input type="hidden" name="laptop_id[]" value="${laptopId}">
                        `;

        selectedList.appendChild(listItem);
        laptopItem.querySelector(".select-laptop i").className = "fas fa-check";
        laptopItem.querySelector(".select-laptop").classList.add("selected");

        updateSummary();
      }
    });
  });

  // Remove laptop from the selection
  selectedList.addEventListener("click", function (e) {
    if (e.target.closest(".remove-laptop")) {
      const listItem = e.target.closest("li");
      const laptopId = listItem.dataset.laptopId;

      // Remove the laptop from the selected list
      const index = selectedLaptops.indexOf(laptopId);
      if (index > -1) {
        selectedLaptops.splice(index, 1);
      }
      listItem.remove();

      // Update the laptop item
      const laptopItem = document.querySelector(
        `.laptop-item[data-laptop-id="${laptopId}"]`
      );
      if (laptopItem) {
        laptopItem.querySelector(".select-laptop i").className = "fas fa-plus";
        laptopItem.querySelector(".select-laptop").classList.remove("selected");
      }

      updateSummary();
    }
  });

  // Delete all laptops from the selection
  clearBtn.addEventListener("click", function () {
    selectedLaptops.length = 0;
    selectedList.innerHTML = "";

    document.querySelectorAll(".select-laptop").forEach((btn) => {
      btn.querySelector("i").className = "fas fa-plus";
      btn.classList.remove("selected");
    });

    updateSummary();
  });

  // Aggiorna il riepilogo
  function updateSummary() {
    const summaryContent = document.querySelector(".summary-content p");

    if (selectedLaptops.length > 0) {
      summaryContent.textContent = `${selectedLaptops.length} portatile/i selezionati`;
      confirmBtn.disabled = false;
    } else {
      summaryContent.textContent = "Nessun portatile selezionato";
      confirmBtn.disabled = true;
    }
  }

  // Imposta la data minima (oggi) per i campi data
  const today = new Date().toISOString().split("T")[0];
  document.getElementById("booking-date").min = today;
  document.getElementById("return-date").min = today;
});
