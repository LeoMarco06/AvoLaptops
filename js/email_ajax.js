function checkExists(str) {
  const messageDiv = document.getElementById("emailFeedback");

  if (str == "") {
    messageDiv.style.display = "none";
    messageDiv.innerHTML = "";
    return;
  } else {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        if (this.response != "" && messageDiv.style.display == "none") {
          messageDiv.innerHTML = this.response;
          messageDiv.style.display = "block";
        } else if ((this.response != "") != messageDiv.innerText) {
          messageDiv.innerHTML = this.response;
        } else {
          messageDiv.innerHTML = this.response;
        }
      } else {
        if (messageDiv.style.display != "none") {
          messageDiv.style.display == "none";
        }
        if (messageDiv.innerText == this.response) {
          messageDiv.innerHTML = "";
        }
      }
    };
    xmlhttp.open("GET", "check_email.php?email=" + str, true);
    xmlhttp.send();
  }
}
