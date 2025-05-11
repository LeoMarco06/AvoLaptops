/*
  ==============================================================
  ================== EMAIL VALIDATION FUNCTION =================
  ==============================================================
*/

// Check if the email exists in the database
function checkExists(str) {
  const messageDiv = document.getElementById("emailFeedback");

  // Handle empty input
  if (str == "") {
    messageDiv.style.display = "none";
    messageDiv.innerHTML = "";
    return;
  }

  // Create and configure the XMLHttpRequest
  const xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      // Display the response message if available
      if (this.response != "" && messageDiv.style.display == "none") {
        messageDiv.innerHTML = this.response;
        messageDiv.style.display = "block";
        messageDiv.classList.add("error");
      } else if ((this.response != "") != messageDiv.innerText) {
        messageDiv.innerHTML = this.response;
      } else {
        messageDiv.innerHTML = this.response;
      }
    } else {
      messageDiv.classList.remove("error");
      // Hide the message if no response or error occurs
      if (messageDiv.style.display != "none") {
        messageDiv.style.display = "none";
      }
      if (messageDiv.innerText == this.response) {
        messageDiv.innerHTML = "";
      }
    }
  };

  // Send the request to the server
  xmlhttp.open("GET", "check_email.php?email=" + str, true);
  xmlhttp.send();
}
