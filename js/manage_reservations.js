/*
  ==============================================================
  ================= RESERVATION MANAGEMENT SCRIPT ==============
  ==============================================================
*/

document.addEventListener("DOMContentLoaded", function () {
  // Handle filter tab clicks
  const filterTabs = document.querySelectorAll(".filter-tab");
  const bookingCards = document.querySelectorAll(".booking-card");

  filterTabs.forEach((tab) => {
    tab.addEventListener("click", function () {
      // Update active tab styling
      filterTabs.forEach((t) => t.classList.remove("active"));
      this.classList.add("active");

      const status = this.dataset.status;

      // Filter booking cards based on selected status
      bookingCards.forEach((card) => {
        if (status === "all" || card.classList.contains(status)) {
          card.style.display = "block";
        } else {
          card.style.display = "none";
        }
      });

      updateNoBookingsMessage();
    });
  });

  // Handle search input for reservations
  const searchInput = document.getElementById("booking-search");
  const bookingsPage = document.getElementById("bookings_page");

  if (bookingsPage) {
    searchInput.addEventListener("input", function () {
      const searchTerm = this.value.toLowerCase();
      const activeTab = document.querySelector(".filter-tab.active");
      const activeStatus = activeTab ? activeTab.dataset.status : "all";

      bookingCards.forEach((card) => {
        const matchesStatus =
          activeStatus === "all" || card.classList.contains(activeStatus);

        const cardTitle = card.querySelector("h3")
          ? card.querySelector("h3").textContent.toLowerCase()
          : "";
        const isVisible = matchesStatus && cardTitle.includes(searchTerm);

        card.style.display = isVisible ? "block" : "none";
      });

      updateNoBookingsMessage();
    });
  } else {
    searchInput.addEventListener("input", function () {
      const searchTerm = this.value.toLowerCase();

      bookingCards.forEach((card) => {
        const cardTitle = card.querySelector("h3")
          ? card.querySelector("h3").textContent.toLowerCase()
          : "";
        const isVisible = cardTitle.includes(searchTerm);

        card.style.display = isVisible ? "block" : "none";
      });

      updateNoBookingsMessage();
    });
  }

  // Update visibility of "no bookings" message
  function updateNoBookingsMessage() {
    const visibleCards = Array.from(bookingCards).filter(
      (card) => card.style.display !== "none"
    );
    const noBookingsMsg = document.querySelector(".no-bookings-message");

    // Rimuovi la classe no-hover da tutte le card
    bookingCards.forEach((card) => card.classList.remove("no-hover"));

    // Aggiungi la classe solo alla prima visibile
    if (visibleCards.length > 0) {
      visibleCards[0].classList.add("no-hover");
      noBookingsMsg.style.display = "none";
    } else {
      noBookingsMsg.style.display = "flex";
    }
  }

  // Handle booking cancellation actions
  document.querySelectorAll(".cancel-booking").forEach((btn) => {
    btn.addEventListener("click", function () {
      // AJAX call to cancel the booking
      const bookingId = btn.dataset.id;
      console.log(`Cancel booking with ID: ${bookingId}`);

      if (!confirm("Are you sure you want to cancel this booking?")) {
        return;
      }
      /// Perform AJAX request to filter laptops
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          alert("Prenotazione annullata con successo.");
          window.location.reload();
        } else if (this.readyState == 4) {
          alert("Error: " + this.statusText);
        }
      };

      xmlhttp.open(
        "GET",
        "../include/functions/cancel_reservation.php?id=" + bookingId,
        true
      );
      xmlhttp.send();
    });

  });

  if (document.querySelectorAll(".delete-booking").length > 0) {
    const deleteButtons = document.querySelectorAll(".delete-booking");
    deleteButtons.forEach((btn) => {
      btn.addEventListener("click", function () {
        // AJAX call to delete the booking
        const bookingId = btn.dataset.id;
        console.log(`Delete booking with ID: ${bookingId}`);

        if (!confirm("Are you sure you want to delete this booking?")) {
          return;
        }
        /// Perform AJAX request to filter laptops
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200) {
            alert("Prenotazione eliminata con successo.");
            window.location.reload();
          } else if (this.readyState == 4) {
            alert("Error: " + this.statusText);
          }
        };

        xmlhttp.open(
          "GET",
          "../include/functions/delete_reservation.php?id=" + bookingId,
          true
        );
        xmlhttp.send();
      });
    });
  };

  // Initialize the "no bookings" message visibility
  updateNoBookingsMessage();
});