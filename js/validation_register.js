document.addEventListener("DOMContentLoaded", () => {
  togglePasswordVisibility();

  document
    .getElementById("register-form")
    .addEventListener("submit", function (e) {
      if (!validateForm()) {
        e.preventDefault();
      }
    });
});

function togglePasswordVisibility() {
  // Toggle password visibility
  document.querySelectorAll(".password-toggle").forEach((button) => {
    button.addEventListener("click", function () {
      const input = this.parentElement.querySelector("input");
      const icon = this.querySelector("i");

      if (input.type === "password") {
        input.type = "text";
        icon.classList.replace("fa-eye", "fa-eye-slash");
      } else {
        input.type = "password";
        icon.classList.replace("fa-eye-slash", "fa-eye");
      }
    });
  });
}

function validateForm() {
  let isValid = true;

  isValid &= !validateEmailInput();
  isValid &= !validateNameInput();
  isValid &= !validateSurnameInput();
  isValid &= !validateCodFisInput();
  isValid &= !validatePasswordInput();
  isValid &= !validateConfirmPasswordInput();

  return isValid;
}

function validateEmailInput() {
  const emailInput = document.getElementById("email");
  const emailValue = emailInput.value;
  const feedbackElement = document.getElementById("emailFeedback");
  const emailRegex = /[a-z0-9._%+\-]+@(?:studenti\.)?itisavogadro\.it$/;
  const emailIcon = document.getElementById("email-icon");
  const colorBorder =
    getComputedStyle(emailInput).getPropertyValue("--color-border");
  const colorIcon =
    getComputedStyle(emailIcon).getPropertyValue("--color-text-light");
  let error = false;

  if (emailRegex.test(emailValue)) {
    emailInput.style.borderColor = colorBorder;
    emailIcon.style.color = colorIcon;
    feedbackElement.style.display = "block";
    feedbackElement.textContent = "";
    if (emailVerification()) {
      error = true;
    }
  } else {
    emailInput.style.borderColor = "#fd5757";
    feedbackElement.style.display = "block";
    feedbackElement.style.color = "#fd5757";
    emailIcon.style.color = "#fd5757";
    feedbackElement.textContent =
      "Inserisci un indirizzo email valido del dominio itisavogadro";
    error = true;
  }

  return error;
}

function emailVerification() {
  const email = document.getElementById("email").value;
  const apiKey = "9d067e6b3fd7bf4a201f509a991dda916ae10380";
  const verificationResult = document.getElementById("emailFeedback");
  let email_error = false;

  // Show loading state
  verificationResult.textContent = "Verifying email...";
  verificationResult.style.color = "var(--color-text-light)";

  // Hunter.io API endpoint
  const url = `https://api.hunter.io/v2/email-verifier?email=${encodeURIComponent(
    email
  )}&api_key=${apiKey}`;

  fetch(url)
    .then((response) => {
      if (!response.ok) {
        throw new Error("Network response was not ok");
      }
      return response.json();
    })
    .then((data) => {
      if (data.data && data.data.status) {
        const status = data.data.status;
        let message = "";
        let color = "";

        switch (status) {
          case "valid":
            message = "✓ Email is valid and exists";
            color = "#4CAF50";
            email_error = false;
            break;
          case "invalid":
            message = "✗ Email does not exist";
            color = "#fd5757";
            email_error = true;
            break;
        }

        verificationResult.textContent = message;
        verificationResult.style.color = color;
      } else {
        verificationResult.textContent = "Error in verification response";
        verificationResult.style.color = "#fd5757";
      }
    })
    .catch((error) => {
      console.error("Error verifying email:", error);
      verificationResult.textContent = "Error verifying email";
      verificationResult.style.color = "#fd5757";
    });

  return email_error;
}

function validateNameInput() {
  const nameInput = document.getElementById("name");
  const nameValue = nameInput.value.trim();
  const feedbackElement = document.getElementById("nameFeedback");
  const nameRegex = /^[A-Za-zÀ-ÖØ-öø-ÿ\s']+$/;
  let error = false;

  if (nameValue === "") {
    error = true;
    feedbackElement.textContent = "Il nome è obbligatorio";
  } else if (!nameRegex.test(nameValue)) {
    error = true;
    feedbackElement.textContent = "Il nome può contenere solo lettere e spazi";
  } else {
    feedbackElement.textContent = "";
  }

  // Applica stili in base all'errore
  nameInput.style.borderColor = error
    ? "#fd5757"
    : getComputedStyle(nameInput).getPropertyValue("--color-border");
  feedbackElement.style.display = error ? "block" : "none";
  feedbackElement.style.color = "#fd5757";

  return error;
}

function validateSurnameInput() {
  const surnameInput = document.getElementById("surname");
  const surnameValue = surnameInput.value.trim();
  const feedbackElement = document.getElementById("surnameFeedback");
  const surnameRegex = /^[A-Za-zÀ-ÖØ-öø-ÿ\s']+$/;
  let error = false;

  if (surnameValue === "") {
    error = true;
    feedbackElement.textContent = "Il cognome è obbligatorio";
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

function validateCodFisInput() {
  const codFisInput = document.getElementById("codFis");
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

function validatePasswordInput() {
  const passwordInput = document.getElementById("password");
  const passwordValue = passwordInput.value;
  const feedbackPassword = document.getElementById("passwordFeedback");
  const passwordIcon = document.getElementById("password-icon");
  const passwordRegex =
    /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()\-_=+{};:,<.>])[A-Za-z\d!@#$%^&*()\-_=+{};:,<.>]{8,}$/;
  let error = false;

  if (passwordRegex.test(passwordValue)) {
    passwordInput.style.borderColor =
      getComputedStyle(passwordInput).getPropertyValue("--color-border");
    passwordIcon.style.color =
      getComputedStyle(passwordIcon).getPropertyValue("--color-text-light");
    feedbackPassword.style.display = "none";
    feedbackPassword.textContent = "";
  } else {
    passwordInput.style.borderColor = "#fd5757";
    passwordIcon.style.color = "#fd5757";
    feedbackPassword.style.display = "block";
    feedbackPassword.style.color = "#fd5757";
    feedbackPassword.textContent =
      "La password deve contenere: 8+ caratteri, 1 maiuscola, 1 minuscola, 1 numero, 1 carattere speciale";
    error = true;
  }

  return error;
}

function validateConfirmPasswordInput() {
  const passwordInput = document.getElementById("password");
  const confirmInput = document.getElementById("confirm-password");
  const passwordValue = passwordInput.value;
  const confirmValue = confirmInput.value;
  const feedbackElement = document.getElementById("confirmPasswordFeedback");
  const confirmIcon = document.getElementById("confirm-password-icon");
  let error = false;

  if (confirmValue !== passwordValue) {
    confirmInput.style.borderColor = "#fd5757";
    confirmIcon.style.color = "#fd5757";
    feedbackElement.style.display = "block";
    feedbackElement.style.color = "#fd5757";
    feedbackElement.textContent = "Le password non coincidono";
    error = true;
  } else {
    confirmInput.style.borderColor =
      getComputedStyle(confirmInput).getPropertyValue("--color-border");
    confirmIcon.style.color =
      getComputedStyle(confirmIcon).getPropertyValue("--color-text-light");
    feedbackElement.style.display = "none";
    feedbackElement.textContent = "";
  }

  return error;
}
