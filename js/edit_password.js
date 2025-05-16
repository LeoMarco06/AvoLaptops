/*
  ==============================================================
  ================= REGISTER VALIDATION SCRIPT =================
  ==============================================================
*/

document.addEventListener("DOMContentLoaded", () => {
    togglePasswordVisibility();

    document.getElementById("new-password").addEventListener("input", validateNewPasswordInput);
    document.getElementById("confirm-password").addEventListener("input", validateConfirmPasswordInput);

    document.getElementById("register-form").addEventListener("submit", function (e) {
        if (!validateForm()) {
            e.preventDefault();
        }
    });
});

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

function validateForm() {
    let isValid = true;
    isValid &= !validateNewPasswordInput();
    isValid &= !validateConfirmPasswordInput();
    return isValid;
}

function validateNewPasswordInput() {
    const passwordInput = document.getElementById("new-password");
    const passwordValue = passwordInput.value;
    const feedbackPassword = document.getElementById("newPasswordFeedback");
    const passwordIcon = document.getElementById("new-password-icon");
    const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()\-_=+{};:,<.>])[A-Za-z\d!@#$%^&*()\-_=+{};:,<.>]{8,}$/;
    let error = false;

    if (passwordRegex.test(passwordValue)) {
        if (passwordValue == document.getElementById("old-password").value) {
            passwordInput.style.borderColor = "#fd5757";
            passwordIcon.style.color = "#fd5757";
            feedbackPassword.style.display = "block";
            feedbackPassword.style.color = "#fd5757";
            feedbackPassword.textContent = "La password deve essere diversa da quella vecchia";
            error = true;
        }
        else {
            passwordInput.style.borderColor = getComputedStyle(passwordInput).getPropertyValue("--color-border");
            passwordIcon.style.color = getComputedStyle(passwordIcon).getPropertyValue("--color-text-light");
            feedbackPassword.style.display = "none";
            feedbackPassword.textContent = "";
        }
    } else {
        passwordInput.style.borderColor = "#fd5757";
        passwordIcon.style.color = "#fd5757";
        feedbackPassword.style.display = "block";
        feedbackPassword.style.color = "#fd5757";
        feedbackPassword.textContent = "La password deve contenere: 8+ caratteri, 1 maiuscola, 1 minuscola, 1 numero, 1 carattere speciale";
        error = true;
    }
    return error;
}

function validateConfirmPasswordInput() {
    const passwordInput = document.getElementById("new-password");
    const confirmInput = document.getElementById("confirm-password");
    const passwordValue = passwordInput.value;
    const confirmValue = confirmInput.value;
    const feedbackElement = document.getElementById("confirmPasswordFeedback");
    const confirmIcon = document.getElementById("confirm-password-icon");
    let error = false;

    if (confirmValue !== passwordValue || confirmValue === "") {
        confirmInput.style.borderColor = "#fd5757";
        confirmIcon.style.color = "#fd5757";
        feedbackElement.style.display = "block";
        feedbackElement.style.color = "#fd5757";
        feedbackElement.textContent = "Le password non coincidono";
        error = true;
    } else {
        confirmInput.style.borderColor = getComputedStyle(confirmInput).getPropertyValue("--color-border");
        confirmIcon.style.color = getComputedStyle(confirmIcon).getPropertyValue("--color-text-light");
        feedbackElement.style.display = "none";
        feedbackElement.textContent = "";
    }
    return error;
}
