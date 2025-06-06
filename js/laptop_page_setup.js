/*
  ==============================================================
  ================= LAPTOP PAGE SETUP FUNCTIONS ================
  ==============================================================
*/

document.addEventListener("DOMContentLoaded", function () {
  document.addEventListener("keydown", function (event) {
    if (event.key === "Escape") {
      closePopup();
    }
  });

  // Filter laptops based on search input
  const searchInput = document.getElementById("search-laptop");
  const noLaptopsMsg = document.querySelector(".no-laptops-message");
  searchInput.addEventListener("input", function () {
    const searchTerm = this.value.toLowerCase();
    const laptopCards = document.querySelectorAll(".laptop-item");

    let visibleCount = 0;
    laptopCards.forEach((card) => {
      const cardText = card.textContent.toLowerCase();
      const isVisible = cardText.includes(searchTerm);
      card.style.display = isVisible ? "block" : "none";
      if (isVisible) visibleCount++;
    });

    if (noLaptopsMsg) {
      noLaptopsMsg.style.display = visibleCount === 0 ? "flex" : "none";
    }
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
    const possibleStatuses = [
      "maintenance",
      "unavailable",
      "available",
      "charging",
    ];
    const statusClass = possibleStatuses[laptop.lap_status + 1];

    laptopItem.className = `laptop-item ${statusClass}`;
    laptopItem.dataset.laptopId = laptop.lap_id;
    laptopItem.innerHTML = `
      <div class="laptop-info">
        <div class="laptop-header">
        <div>
          <i class="fas fa-laptop"></i>
          <span>${laptop.lap_model}</span></div>
            <button type="button" id="open-qr-popup" class="btn btn-outline btn-small qr-btn" onclick='showQrPopup(${JSON.stringify(
              laptop
            )})'>
              <i class="fa-solid fa-qrcode"></i> <p>QR</p>
            </button>
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
      <option value="2" ${
        laptop.lap_status === 2 ? `selected` : ""
      }>In carica</option>
        </select>
        <button class="btn btn-danger">Elimina</button>
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
        `./ajax/manage_laptops_api.php?lap_id=${laptopId}&lap_status=${selectedValue}`,
        true
      );
      xmlhttp.send();
    });

    // Handle laptop deletion
    laptopItem.querySelector(".btn-danger").addEventListener("click", () => {
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
          `./ajax/manage_laptops_api.php?lap_id=${laptopId}`,
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
      2: "charging",
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

  let isValid = true;
  let formData = {};

  inputs.forEach((input) => {
    if (input.value.trim() !== "") {
      if (input.id === "laptop-name") {
        const regex = /^PC-\d+$/;
        if (!regex.test(input.value)) {
          isValid = false;
        }
      }
      formData[input.name] = input.value;
    }
  });

  if (!isValid) {
    alert(
      "Per favore, compila tutti i campi richiesti e nel formato corretto."
    );
    return;
  } else if (Object.keys(formData).length === 0) {
    return;
  }

  console.log("Form data:", formData);

  const xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function () {
    if (this.readyState == 4) {
      if (this.status == 200) {
        alert("Laptop aggiunto con successo!");
        window.location.reload();
      } else {
        alert("Errore durante l'aggiunta del laptop.");
        console.error(this.responseText);
      }
    }
  };
  xmlhttp.open("POST", "./ajax/manage_laptops_api.php", true);
  xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  // Build params string from formData
  const params = Object.keys(formData)
    .map(
      (key) => encodeURIComponent(key) + "=" + encodeURIComponent(formData[key])
    )
    .join("&");

  console.log("Sending data:", params);
  xmlhttp.send(params);
}

// Call validateForm after DOMContentLoaded
document.addEventListener("DOMContentLoaded", function () {
  // ...existing code...
  validateForm();
});
