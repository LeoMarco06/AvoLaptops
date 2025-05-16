/*
  ==============================================================
  ================== ACCOUNT VALIDATION SCRIPT =================
  ==============================================================
*/

document.addEventListener("DOMContentLoaded", () => {

  // Validate form on submission
  document
    .getElementById("register-form")
    .addEventListener("submit", function (e) {
      if (!validateForm()) {
        e.preventDefault();
      }
    });
});

// Validate the entire form
function validateForm() {
  let isValid = true;

  isValid &= !validateNameInput();
  isValid &= !validateSurnameInput();
  isValid &= !validateCodFisInput();

  return isValid;
}

// Validate the name input field
function validateNameInput() {
  const nameInput = document.getElementById("name");
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

  nameInput.style.borderColor = error
    ? "#fd5757"
    : getComputedStyle(nameInput).getPropertyValue("--color-border");
  feedbackElement.style.display = error ? "block" : "none";
  feedbackElement.style.color = "#fd5757";

  return error;
}

// Validate the surname input field
function validateSurnameInput() {
  const surnameInput = document.getElementById("surname");
  const surnameValue = surnameInput.value.trim();
  const feedbackElement = document.getElementById("surnameFeedback");
  const surnameRegex = /^[A-Za-zÀ-ÖØ-öø-ÿ\s']+$/;
  let error = false;

  if (surnameValue === "") {
    error = true;
    feedbackElement.textContent = "Il cognome è obbligatorio";
  } else if (surnameValue.length < 3) {
    error = true;
    feedbackElement.textContent = "Il cognome deve contenere almeno 3 caratteri";
  } else if (!surnameRegex.test(surnameValue)) {
    error = true;
    feedbackElement.textContent =
      "Il cognome può contenere solo lettere e spazi";
  } else {
    feedbackElement.textContent = "";
  }

  surnameInput.style.borderColor = error
    ? "#fd5757"
    : getComputedStyle(surnameInput).getPropertyValue("--color-border");
  feedbackElement.style.display = error ? "block" : "none";
  feedbackElement.style.color = "#fd5757";

  return error;
}

// Validate the tax code input field
function validateCodFisInput() {
  const codFisInput = document.getElementById("cod-Fis");
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

  codFisInput.style.borderColor = error
    ? "#fd5757"
    : getComputedStyle(codFisInput).getPropertyValue("--color-border");
  feedbackElement.style.display = error ? "block" : "none";
  feedbackElement.style.color = "#fd5757";

  return error;
}