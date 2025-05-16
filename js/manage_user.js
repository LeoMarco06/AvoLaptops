/*
  ==============================================================
  ================= USER MANAGEMENT SCRIPT =====================
  ==============================================================
*/

document.addEventListener("DOMContentLoaded", function () {
  const today = new Date();
  const yyyy = today.getFullYear();
  const mm = String(today.getMonth() + 1).padStart(2, '0');
  const dd = String(today.getDate()).padStart(2, '0');
  const formattedToday = `${yyyy}-${mm}-${dd}`;

  // Initialize date picker and remove user data element
  document.body.removeChild(document.getElementById("users-data"));
  initDatePicker('date-birth', 'date-birth-picker', '1945-01-01', formattedToday);

  // Handle edit and cancel button actions
  document.getElementById("edit-btn").addEventListener("click", function () {
    toggleEditMode(true);
  });

  document.getElementById("cancel-btn").addEventListener("click", function () {
    toggleEditMode(false);
  });

  // Close Popup when clicking the esc button
  document.addEventListener("keydown", function (event) {
    if (event.key === "Escape") {
      closeUserPopup();
    }
  });

  // Validate form on submission
  document.addEventListener("submit", function (e) {
    if (!validateForm()) {
      e.preventDefault();
    } else {
      resetFeedbackStyles();
      const old_date = document.getElementById("date-birth").value;
      document.getElementById("date-birth").value = parseCustomDate(old_date);
    }
  });

  // Real-time search functionality for users
  const searchInput = document.getElementById("search-user");
  const userCards = document.querySelectorAll(".user-card");

  searchInput.addEventListener("input", function () {
    const searchTerm = searchInput.value.toLowerCase();
    userCards.forEach((card) => {
      const name = card.querySelector("h3").textContent.toLowerCase();
      card.style.display = name.includes(searchTerm) ? "block" : "none";
    });

    updateNoUsersMessage();
  });

  // Aggiorna subito il messaggio all'avvio
  updateNoUsersMessage();
});

function updateNoUsersMessage() {
  const userCards = document.querySelectorAll(".user-card");
  const visibleCards = Array.from(userCards).filter(
    (card) => card.style.display !== "none"
  );
  const noUsersMsg = document.querySelector(".no-users-message");

  if (!noUsersMsg) return;

  if (visibleCards.length === 0) {
    document.getElementById("users-container").style.display = "flex";
    noUsersMsg.style.display = "flex";
  } else {
    noUsersMsg.style.display = "none";
    document.getElementById("users-container").style.display = "grid";
  }
}

// Fetch and display user data in the popup
function viewUser(id) {
  openPopup();

  const xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const user = JSON.parse(this.responseText)[0];
      document.getElementById("user-name").value = user["u_name"];
      document.getElementById("user-surname").value = user["u_surname"];
      document.getElementById("user-codFis").value = user["u_cf"];
      document.getElementById("date-birth").value = formatDate(
        new Date("2001-01-01")
      );
      document
        .getElementById("user-role")
        .querySelectorAll("option")
        .forEach((option) => {
          if (option.value == user["u_role"]) {
            option.setAttribute("selected", "selected");
          } else {
            option.removeAttribute("selected");
          }
        });
    }
  };
  xmlhttp.open("GET", `./ajax/getUser_data.php?u_id=${id}`, true);
  xmlhttp.send();

  toggleEditMode(false);
}

// Confirm the user
function confirmUser(id) {
  const confirmation = confirm("Sei sicuro di voler confermare questo utente?");
  if (confirmation) {
    const xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        location.reload();
      }
    };
    xmlhttp.open("GET", `./ajax/confirm_user.php?u_id=${id}`, true);
    xmlhttp.send();
  }
}

// Enable or disable edit mode in the popup
function toggleEditMode(enable) {
  const inputs = document.querySelectorAll(
    "#popup-container input, #popup-container select"
  );
  inputs.forEach((input) => {
    input.disabled = !enable;
    if (enable) {
      input.setAttribute("required", "required");
    } else {
      input.removeAttribute("required");
    }
  });

  document.getElementById("edit-btn").style.display = enable
    ? "none"
    : "inline-block";
  document.getElementById("save-btn").style.display = enable
    ? "inline-block"
    : "none";
  document.getElementById("cancel-btn").style.display = enable
    ? "inline-block"
    : "none";
}

// Validate the form fields
function validateForm() {
  let isValid = true;

  isValid &= !validateNameInput();
  isValid &= !validateSurnameInput();
  isValid &= !validateCodFisInput();

  return isValid;
}

// Validate the name input field
function validateNameInput() {
  const nameInput = document.getElementById("user-name");
  const nameValue = nameInput.value.trim();
  const feedbackElement = document.getElementById("nameFeedback");
  const nameRegex = /^[A-Za-zÀ-ÖØ-öø-ÿ\s']+$/;
  let error = false;

  if (nameValue === "") {
    error = true;
    feedbackElement.textContent = "Il nome è obbligatorio";
  } else if (nameValue.length < 3) {
    error = true;
    feedbackElement.textContent = "Il nome deve contenere almeno 3 caratteri";
  } else if (!nameRegex.test(nameValue)) {
    error = true;
    feedbackElement.textContent = "Il nome può contenere solo lettere e spazi";
  } else {
    feedbackElement.textContent = "";
  }

  if (error) {
    feedbackElement.classList.add("error");
    nameInput.classList.add("input-error");
  } else {
    feedbackElement.textContent = "";
    feedbackElement.classList.remove("error");
    nameInput.classList.remove("input-error");
  }

  return error;
}

// Validate the surname input field
function validateSurnameInput() {
  const surnameInput = document.getElementById("user-surname"); // Updated ID
  const surnameValue = surnameInput.value.trim();
  const feedbackElement = document.getElementById("surnameFeedback");
  const surnameRegex = /^[A-Za-zÀ-ÖØ-öø-ÿ\s']+$/;
  let error = false;

  if (surnameValue === "") {
    error = true;
    feedbackElement.textContent = "Il cognome è obbligatorio";
  } else if (surnameValue.length < 3) {
    error = true;
    feedbackElement.textContent =
      "Il cognome deve contenere almeno 3 caratteri";
  } else if (!surnameRegex.test(surnameValue)) {
    error = true;
    feedbackElement.textContent =
      "Il cognome può contenere solo lettere e spazi";
  } else {
    feedbackElement.textContent = "";
  }

  if (error) {
    feedbackElement.classList.add("error");
    surnameInput.classList.add("input-error");
  } else {
    feedbackElement.textContent = "";
    feedbackElement.classList.remove("error");
    surnameInput.classList.remove("input-error");
  }

  return error;
}

// Validate the codFis input field
function validateCodFisInput() {
  const codFisInput = document.getElementById("user-codFis");
  const codFisValue = codFisInput.value.trim().toUpperCase();
  const feedbackElement = document.getElementById("codFisFeedback");
  const taxCodeRegex = /^[A-Z]{6}[0-9]{2}[A-Z][0-9]{2}[A-Z][0-9]{3}[A-Z]$/;
  let error = false;

  if (codFisValue === "") {
    error = true;
    feedbackElement.textContent = "Il codice fiscale è obbligatorio";
  } else if (codFisValue.length !== 16) {
    error = true;
    feedbackElement.textContent =
      "Il codice fiscale deve essere di 16 caratteri";
  } else if (!taxCodeRegex.test(codFisValue)) {
    error = true;
    feedbackElement.textContent = "Formato codice fiscale non valido";
  } else {
    feedbackElement.textContent = "";
  }

  if (error) {
    feedbackElement.classList.add("error");
    codFisInput.classList.add("input-error");
  } else {
    feedbackElement.textContent = "";
    feedbackElement.classList.remove("error");
    codFisInput.classList.remove("input-error");
  }

  return error;
}

// Reset feedback styles in the popup
function resetFeedbackStyles() {
  const feedbackElements = document.querySelectorAll(".feedback");
  feedbackElements.forEach((feedback) => {
    feedback.textContent = "";
    feedback.classList.remove("error");
  });

  const inputElements = document.querySelectorAll("#popup-container input");
  inputElements.forEach((input) => {
    input.classList.remove("input-error");
  });
}

// Delete a user by ID
function deleteUser(id) {
  const confirmation = confirm("Sei sicuro di voler eliminare questo utente?");
  if (confirmation) {
    const xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        alert(`Utente ${id} eliminato`);
        location.reload();
      }
    };
    xmlhttp.open("GET", `./ajax/delete_user.php?u_id=${id}`, true);
    xmlhttp.send();
  }
}

// Close user popup
function closeUserPopup() {
  resetFeedbackStyles();
  closePopup();
}
