<<<<<<< HEAD
/*
  ==============================================================
  ================= LAPTOP PAGE SETUP FUNCTIONS ================
  ==============================================================
*/

document.addEventListener("DOMContentLoaded", function () {
  // Filter laptops based on search input
  const searchInput = document.getElementById("search-laptop");
  searchInput.addEventListener("input", function () {
    const searchTerm = this.value.toLowerCase();
    const laptopCards = document.querySelectorAll(".laptop-item");

    laptopCards.forEach((card) => {
      const cardText = card.textContent.toLowerCase();
      const isVisible = cardText.includes(searchTerm);
      card.style.display = isVisible ? "block" : "none";
    });
    console.log("Search term:", searchTerm);
  });

  // Load laptops from the initial data
  const response = JSON.parse(
    document.getElementById("laptops-data").textContent
  );
  const lap_container = document.getElementById("laptops-container");

  response.forEach((laptop) => {
    lap_container.appendChild(createLaptopCard(laptop));
  });

  // Populate locker and model dropdowns for the popup
  const lockerSelect = document.getElementById("laptop-locker");
  const modelSelect = document.getElementById("laptop-model");
  const lockerResponse = JSON.parse(
    document.getElementById("lockers-data").textContent
  );
  const modelResponse = JSON.parse(
    document.getElementById("models-data").textContent
  );

  lockerResponse.forEach((locker) => {
    const option = document.createElement("option");
    option.value = locker.lock_id;
    option.textContent = `Armadietto ${locker.lock_id} - ${locker.lock_class}`;
    lockerSelect.appendChild(option);
  });

  modelResponse.forEach((model) => {
    const option = document.createElement("option");
    option.value = model.mod_id;
    option.textContent = `${model.mod_name} (${model.mod_ram} GB RAM, ${model.mod_memory} GB)`;
    modelSelect.appendChild(option);
  });

  // Create a laptop card element
  function createLaptopCard(laptop) {
    const laptopItem = document.createElement("div");
    const possibleStatuses = ["maintenance", "available", "unavailable"];
    const statusClass = possibleStatuses[laptop.lap_status + 1];

    laptopItem.className = `laptop-item ${statusClass}`;
    laptopItem.dataset.laptopId = laptop.lap_id;
    laptopItem.innerHTML = `
      <div class="laptop-info">
        <div class="laptop-header">
          <i class="fas fa-laptop"></i>
          <span>${laptop.lap_model}</span>
        </div>
        <p>Armadietto: ${laptop.lock_id}</p>
        <p>Numero: ${laptop.lap_name}</p>
        <p>RAM: ${laptop.lap_ram} GB</p>
        <p>Memoria interna: ${laptop.lap_memory} GB</p>
      </div>
      <div class="buttons-container" style="display: flex; flex-direction: column; gap: 10px;">
        <select>
          <option value="0" ${
            laptop.lap_status === 0 ? `selected` : ""
          }>Disponibile</option>
          <option value="1" ${
            laptop.lap_status === 1 ? `selected` : ""
          }>Non disponibile</option>
          <option value="-1" ${
            laptop.lap_status === -1 ? `selected` : ""
          }>Manutenzione</option>
        </select>
        <button class="btn btn-primary">Elimina</button>
      </div>
    `;

    // Handle status change
    laptopItem.querySelector("select").addEventListener("change", (e) => {
      const selectedValue = e.target.value;
      const laptopId = laptopItem.dataset.laptopId;

      const xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          console.log("Laptop status updated:", laptopId, selectedValue);
          updateLaptopStatus(laptopId, selectedValue);
        }
      };
      xmlhttp.open(
        "PUT",
        `manage_laptops_api.php?lap_id=${laptopId}&lap_status=${selectedValue}`,
        true
      );
      xmlhttp.send();
    });

    // Handle laptop deletion
    laptopItem.querySelector("button").addEventListener("click", () => {
      const laptopId = laptopItem.dataset.laptopId;
      const confirmation = confirm(
        "Sei sicuro di voler eliminare questo laptop?"
      );

      if (confirmation) {
        const xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200) {
            laptopItem.remove();
            console.log(
              "Laptop eliminato con successo:",
              laptopId,
              this.responseText
            );
          } else if (this.readyState == 4) {
            console.error(
              "Errore durante l'eliminazione del laptop:",
              this.responseText
            );
          }
        };
        xmlhttp.open(
          "DELETE",
          `manage_laptops_api.php?lap_id=${laptopId}`,
          true
        );
        xmlhttp.send();
      }
    });

    return laptopItem;
  }

  // Update the status of a laptop card
  function updateLaptopStatus(laptopId, status) {
    const statusMap = {
      0: "available",
      1: "unavailable",
      "-1": "maintenance",
    };
    const statusClass = statusMap[status];

    const laptopCard = document.querySelector(
      `.laptop-item[data-laptop-id="${laptopId}"]`
    );
    if (laptopCard) {
      laptopCard.className = `laptop-item ${statusClass}`;
    }
  }

  // Remove data elements from the DOM after parsing
  document.body.removeChild(document.getElementById("lockers-data"));
  document.body.removeChild(document.getElementById("models-data"));
  document.body.removeChild(document.getElementById("laptops-data"));
});

function validateForm() {
  const form = document.getElementById("laptop-form");
  const inputs = form.querySelectorAll("input, select");

  document.getElementById("laptop-form").addEventListener("submit", (e) => {
    let isValid = true;
    inputs.forEach((input) => {
      if (input.id === "laptop-name") {
        const regex = /^PC-\d+$/;
        if (!regex.test(input.value)) {
          isValid = false;
        }
      }
    });
    if (!isValid) {
      e.preventDefault();
      alert(
        "Per favore, compila tutti i campi richiesti e nel formato corretto."
      );
    }
  });
}
=======
document.addEventListener("DOMContentLoaded", function () {
  // Research laptops
  const searchInput = document.getElementById("search-laptop");
  searchInput.addEventListener("input", function () {
    const searchTerm = this.value.toLowerCase();
    const laptopCards = document.querySelectorAll(".laptop-item");

    laptopCards.forEach((card) => {
      const cardText = card.textContent.toLowerCase();
      const isVisible = cardText.includes(searchTerm);
      card.style.display = isVisible ? "block" : "none";
    });
    console.log("Search term:", searchTerm);
  });

  // Loading of the laptops at the beginning
  const response = JSON.parse(
    document.getElementById("laptops-data").textContent
  );
  const lap_container = document.getElementById("laptops-container");

  response.forEach((laptop) => {
    lap_container.appendChild(createLaptopCard(laptop));
  });

  // Loading of the lockers and models for the popup
  const lockerSelect = document.getElementById("laptop-locker");
  const modelSelect = document.getElementById("laptop-model");
  const lockerResponse = JSON.parse(
    document.getElementById("lockers-data").textContent
  );
  const modelResponse = JSON.parse(
    document.getElementById("models-data").textContent
  );

  lockerResponse.forEach((locker) => {
    const option = document.createElement("option");
    option.value = locker.lock_id;
    option.textContent = `Armadietto ${locker.lock_id} - ${locker.lock_class}`;
    lockerSelect.appendChild(option);
  });

  modelResponse.forEach((model) => {
    const option = document.createElement("option");
    option.value = model.mod_id;
    option.textContent = `${model.mod_name} (${model.mod_ram} GB RAM, ${model.mod_memory} GB)`;
    modelSelect.appendChild(option);
  });

  function createLaptopCard(laptop) {
    const laptopItem = document.createElement("div");
    const possibleStatuses = ["maintenance", "unavailable", "available"];
    const statusNames = ["Maintenance", "Unavailable", "Available"];
    const statusClass = possibleStatuses[laptop.lap_status + 1];

    laptopItem.className = `laptop-item ${statusClass}`;
    laptopItem.dataset.laptopId = laptop.lap_id;
    laptopItem.innerHTML = `
                    <div class="laptop-info">
                        <div class="laptop-header">
                            <i class="fas fa-laptop"></i>
                            <span>${laptop.lap_model}</span>
                        </div>
                        <p>Armadietto: ${laptop.lock_id} (${laptop.lock_class})</p>
                        <p>Numero: ${laptop.lap_name}</p>
                        <p>RAM: ${laptop.lap_ram} GB</p>
                        <p>Memoria interna: ${laptop.lap_memory} GB</p>
                    </div>
                    <div class="buttons-container" style="display: flex; flex-direction: column; gap: 10px;">
                        <select name="" id="">
                            <option value="1" ${
                              laptop.lap_status === 1 ? `selected` : ""
                            }>Disponibile</option>
                            <option value="0" ${
                              laptop.lap_status === 0 ? `selected` : ""
                            }>Non disponibile</option>
                            <option value="-1" ${
                              laptop.lap_status === -1 ? `selected` : ""
                            }>Manutenzione</option>
                        </select>
                        <button class="btn btn-primary">
                            Elimina
                        </button>
                    </div>
        `;
    laptopItem.querySelector("select").addEventListener("change", (e) => {
      const selectedValue = e.target.value;
      const laptopId = laptopItem.dataset.laptopId;

      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          console.log("Laptop status updated:", laptopId, selectedValue);
          updateLaptopStatus(laptopId, selectedValue);
        }
      };
      xmlhttp.open(
        "PUT",
        "manage_laptops_api.php?lap_id=" +
          laptopId +
          "&lap_status=" +
          selectedValue,
        true
      );
      xmlhttp.send();
    });

    laptopItem.querySelector("button").addEventListener("click", () => {
      const laptopId = laptopItem.dataset.laptopId;
      const confirmation = confirm(
        "Sei sicuro di voler eliminare questo laptop?"
      );

      if (confirmation) {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200) {
            laptopItem.remove();
            console.log(
              "Laptop eliminato con successo:",
              laptopId,
              this.responseText
            );
          } else if (this.readyState == 4) {
            console.error(
              "Errore durante l'eliminazione del laptop:",
              this.responseText
            );
          }
        };
        xmlhttp.open(
          "DELETE",
          `manage_laptops_api.php?lap_id=${laptopId}`,
          true
        );
        xmlhttp.send();
      }
    });

    return laptopItem;
  }

  function updateLaptopStatus(laptopId, status) {
    const statusMap = {
      0: "available",
      1: "unavailable",
      "-1": "maintenance",
    };
    const statusClass = statusMap[status];

    const laptopCard = document.querySelector(
      `.laptop-item[data-laptop-id="${laptopId}"]`
    );
    if (laptopCard) {
      laptopCard.className = `laptop-item ${statusClass}`;
    }
  }
});

function openPopup() {
  const popup = document.getElementById("popup-container");
  const obscured = document.getElementById("obscure-bg");
  const inputs = popup.querySelectorAll("input, select");

  inputs.forEach((input) => {
    input.setAttribute("required", "required");
    input.removeAttribute("disabled");
    input.value = "";
  });

  popup.classList.add("show");
  obscured.classList.add("show");
}

function closePopup() {
  const popup = document.getElementById("popup-container");
  const obscured = document.getElementById("obscure-bg");
  const inputs = popup.querySelectorAll("input, select");

  inputs.forEach((input) => {
    input.removeAttribute("required");
    input.setAttribute("disabled", "disabled");
    input.value = "";
  });

  popup.classList.remove("show");
  obscured.classList.remove("show");
}

function validateForm() {
  const form = document.getElementById("laptop-form");
  const inputs = form.querySelectorAll("input, select");

  document.getElementById("laptop-form").addEventListener("submit", (e) => {
    let isValid = true;
    inputs.forEach((input) => {
      if (input.id === "laptop-name") {
        const regex = /^PC-\d+$/;
        if (!regex.test(input.value)) {
          isValid = false;
        }
      }
    });
    if (!isValid) {
      e.preventDefault();
      alert(
        "Per favore, compila tutti i campi richiesti e nel formato corretto."
      );
    }
  });
}
>>>>>>> origin/Backend_logic
