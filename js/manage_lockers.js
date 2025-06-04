/*
  ==============================================================
  ================== LOCKER MANAGEMENT SCRIPT ==================
  ==============================================================
*/

document.addEventListener("DOMContentLoaded", () => {
  // Parse locker data and initialize the container
  const lockersData = JSON.parse(
    document.getElementById("lockers-data").textContent
  );
  const lockersContainer = document.getElementById("lockers-container");

  // Remove the locker data element after parsing
  document.body.removeChild(document.getElementById("lockers-data"));

  // Render all locker cards
  lockersData.forEach((locker) => {
    const lockerCard = createLockerCard(locker);
    lockersContainer.appendChild(lockerCard);
  });

  // Create a locker card element
  function createLockerCard(locker) {
    const card = document.createElement("div");
    card.className = "locker-card";
    card.dataset.lockerId = locker.lock_id;

    card.innerHTML = `
      <h3>Armadietto ${locker.lock_id}</h3>
      <p>Piano: ${locker.lock_floor}</p>
      <p>Classe: ${locker.lock_class}</p>
      <p>Responsabile: ${locker.lock_incharge}</p>
      <p>Capacità: ${locker.lock_capacity}</p>
      <button class="btn btn-danger" onclick="deleteLocker(${locker.lock_id})">Elimina</button>
    `;

    return card;
  }

  // Delete a locker by its ID
  window.deleteLocker = function (lockerId) {
    if (confirm("Sei sicuro di voler eliminare questo armadietto?")) {
      const xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          document.querySelector(`[data-locker-id="${lockerId}"]`).remove();
        } else if (this.readyState == 4) {
          console.error(
            "Errore durante l'eliminazione dell'armadietto:",
            this.responseText
          );
        }
      };
      xmlhttp.open(
        "DELETE",
        `./ajax/manage_lockers_api.php?lock_id=${lockerId}`,
        true
      );
      xmlhttp.send();
    }
  };

  // Handle the submission of the locker creation form
  document.getElementById("locker-form").addEventListener("submit", (e) => {
    e.preventDefault();

    const lockerClass = document.getElementById("locker-class").value;
    const lockerFloor = document.getElementById("locker-floor").value;
    const lockerIncharge = document.getElementById("locker-incharge").value;
    const lockerCapacity = document.getElementById("locker-capacity").value;

    const xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const newLocker = JSON.parse(this.responseText);
        lockersContainer.appendChild(createLockerCard(newLocker));
        closePopup();
      } else if (this.readyState == 4) {
        console.error(
          "Errore durante l'aggiunta dell'armadietto:",
          this.responseText
        );
      }
    };

    xmlhttp.open("POST", "./ajax/manage_lockers_api.php", true);
    xmlhttp.setRequestHeader(
      "Content-Type",
      "application/x-www-form-urlencoded"
    );
    xmlhttp.send(
      `lock_class=${encodeURIComponent(
        lockerClass
      )}&lock_floor=${encodeURIComponent(
        lockerFloor
      )}&lock_incharge=${encodeURIComponent(
        lockerIncharge
      )}&lock_capacity=${encodeURIComponent(lockerCapacity)}`
    );
  });

  // Implement live search functionality for lockers
  const noLockersMsg = document.querySelector(".no-lockers-message");
  document.getElementById("search-locker").addEventListener("input", (e) => {
    const searchTerm = e.target.value.toLowerCase();
    const lockerCards = lockersContainer.querySelectorAll(".locker-card");

    let visibleCount = 0;
    lockerCards.forEach((card) => {
      if (card.textContent.toLowerCase().includes(searchTerm)) {
        card.style.display = "block";
        visibleCount++;
      } else {
        card.style.display = "none";
      }
    });

    if (noLockersMsg) {
      noLockersMsg.style.display = visibleCount === 0 ? "flex" : "none";
    }
  });
});
