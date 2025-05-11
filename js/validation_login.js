/*
  ==============================================================
  ================= LOGIN VALIDATION SCRIPT ====================
  ==============================================================
*/

document.addEventListener("DOMContentLoaded", () => {
  // Initialize password visibility toggle
  togglePasswordVisibility();

  // Validate form on submission
  document
    .getElementById("login-form")
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
  isValid &= !validatePassword();

  return isValid;
}

// Validate the email input field
function validateEmailInput() {
  const emailInput = document.getElementById("email");
  const emailValue = emailInput.value;
  const feedbackEmail = document.getElementById("emailFeedback");
  const emailRegex = /[a-z0-9._%+\-]+@itisavogadro.it$/;
  const emailIcon = document.getElementById("email-icon");
  let colorBorder =
    getComputedStyle(emailInput).getPropertyValue("--color-border");
  let colorIcon =
    getComputedStyle(emailIcon).getPropertyValue("--color-text-light");
  let error = false;

  if (emailRegex.test(emailValue)) {
    emailInput.style.borderColor = colorBorder;
    emailIcon.style.color = colorIcon;
    feedbackEmail.style.display = "none";
    feedbackEmail.textContent = "";
    document.getElementById("verificationResult").style.display = "block";
    error = false;
  } else {
    emailInput.style.borderColor = "#fd5757";
    feedbackEmail.style.display = "block";
    feedbackEmail.style.color = "#fd5757";
    emailIcon.style.color = "#fd5757";
    feedbackEmail.textContent = "Inserisci una email valida.";
    document.getElementById("verificationResult").style.display = "none";
    error = true;
  }

  return error;
}

// Validate the password input field
function validatePassword() {
  const passwordInput = document.getElementById("password");
  const passwordValue = passwordInput.value;
  const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()\-_=+{};:,<.>])[A-Za-z\d!@#$%^&*()\-_=+{};:,<.>]{8,}$/;
  const feedbackPassword = document.getElementById("passwordFeedback");
  const passwordIcon = document.getElementById("password-icon");
  const colorBorder =
    getComputedStyle(passwordInput).getPropertyValue("--color-border");
  const colorIcon =
    getComputedStyle(passwordIcon).getPropertyValue("--color-text-light");

  if (passwordRegex.test(passwordValue)) {
    passwordInput.style.borderColor = colorBorder;
    passwordIcon.style.color = colorIcon;
    feedbackPassword.style.display = "none";
    feedbackPassword.textContent = "";
  } else {
    passwordInput.style.borderColor = "#fd5757";
    passwordIcon.style.display = "block";
    feedbackPassword.style.color = "#fd5757";
    passwordIcon.style.color = "#fd5757";
    feedbackPassword.textContent = "Inserisci una password valida.";
  }
}
