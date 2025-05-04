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
