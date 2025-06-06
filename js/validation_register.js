/*
  ==============================================================
  ================= REGISTER VALIDATION SCRIPT =================
  ==============================================================
*/

document.addEventListener("DOMContentLoaded", () => {
  const today = new Date();
  const yyyy = today.getFullYear();
  const mm = String(today.getMonth() + 1).padStart(2, '0');
  const dd = String(today.getDate()).padStart(2, '0');
  const formattedToday = `${yyyy}-${mm}-${dd}`;

  // Initialize date picker
  initDatePicker('date-birth', 'date-birth-picker', '1945-01-01', formattedToday);

  // Initialize password visibility toggle and date picker
  togglePasswordVisibility();

  // Validate form on submission
  document
    .getElementById("register-form")
    .addEventListener("submit", function (e) {
      if (!validateForm()) {
        e.preventDefault();
      }
    });
});

// Toggle password visibility
function togglePasswordVisibility() {
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

// Validate the entire form
function validateForm() {
  let isValid = true;

  isValid &= !validateEmailInput();
  isValid &= !validateNameInput();
  isValid &= !validateSurnameInput();
  isValid &= !validatePasswordInput();
  isValid &= !validateConfirmPasswordInput();

  return isValid;
}

// Validate the email input field
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

    // Email verification with hunter API
    /*
    if (emailVerification()) {
      error = true;
    }
    */

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

// Verify the email using an external API
function emailVerification() {
  const email = document.getElementById("email").value;
  const apiKey = "9d067e6b3fd7bf4a201f509a991dda916ae10380";
  const verificationResult = document.getElementById("emailFeedback");
  let email_error = false;

  verificationResult.textContent = "Verifying email...";
  verificationResult.style.color = "var(--color-text-light)";

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
        email_error = true;
        verificationResult.textContent = "Error in verification response";
        verificationResult.style.color = "#fd5757";
      }
    })
    .catch((error) => {
      console.error("Error verifying email:", error);
      email_error = true;
      verificationResult.textContent = "Error verifying email";
      verificationResult.style.color = "#fd5757";
    });

  return email_error;
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

// Validate the password input field
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

// Validate the confirm password input field
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
