function search(date, start_time, end_time) {
    const locker_container = document.getElementById("lockers-grid");

  var xmlhttp = new XMLHttpRequest();
  xmlhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {

    }
    else{
        alert("Error: " + this.statusText);
    }
  };
  xmlhttp.open("GET", "laptop_filter.php?date=" + str, true);
  xmlhttp.send();
}
