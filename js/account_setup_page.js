document.addEventListener("DOMContentLoaded", e => {
    const save_button = document.getElementById("save-button");
    const edit_button = document.getElementById("edit-button");
    const cancel_button = document.getElementById("cancel-button");
    const today = new Date();
    const yyyy = today.getFullYear();
    const mm = String(today.getMonth() + 1).padStart(2, '0');
    const dd = String(today.getDate()).padStart(2, '0');
    const formattedToday = `${yyyy}-${mm}-${dd}`;

    const originalValues = {
        email: document.getElementById("email").value || document.getElementById("email").textContent,
        name: document.getElementById("name").value || document.getElementById("name").textContent,
        surname: document.getElementById("surname").value || document.getElementById("surname").textContent,
        date_birth: document.getElementById("date-birth").value || document.getElementById("date-birth").textContent,
        cod_Fis: document.getElementById("cod-Fis").value || document.getElementById("cod-Fis").textContent
    };
    const inputs_content = [originalValues.email, originalValues.name, originalValues.surname, originalValues.date_birth, originalValues.cod_Fis];

    initDatePicker('date-birth', 'date-birth-picker', '1945-01-01', formattedToday);

    save_button.style.display = "none";
    cancel_button.style.display = "none";

    const all_inputs = document.querySelectorAll("input");
    all_inputs.forEach((input) => {
        input.setAttribute("disabled", "disabled");
    });

    edit_button.addEventListener("click", e => {
        edit_button.style.display = "none";
        cancel_button.style.display = "inline-block";
        save_button.style.display = "inline-block";

        const inputs = document.querySelectorAll("input");

        inputs.forEach((input) => {
            if (input.id != "email") {
                input.removeAttribute("disabled");
            }
            if (input.id == "date-birth") {
                input.setAttribute("readonly", "readonly");
            }
        });
    });

    cancel_button.addEventListener("click", e => {
        edit_button.style.display = "inline-block";
        cancel_button.style.display = "none";
        save_button.style.display = "none";

        const feedbacks = document.querySelectorAll(".feedback-message");
        const inputs = document.querySelectorAll("input");

        feedbacks.forEach((feedback) => {
            feedback.style.display = "none";
        });

        inputs.forEach((input) => {
            input.classList.remove("error");
            input.setAttribute("disabled", "disabled");
            input.value = originalValues[input.id.replace("-", "_")];
            console.log(input.id.replace("-", "_"));
        });
    });
});