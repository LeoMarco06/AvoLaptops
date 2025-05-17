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

    if (visibleCards.length === 0) {
      noBookingsMsg.style.display = "flex";
    } else {
      noBookingsMsg.style.display = "none";
    }
  }

  // Handle booking cancellation actions
  document.querySelectorAll(".cancel-booking").forEach((btn) => {
    btn.addEventListener("click", function () {
      // AJAX call to cancel the booking
    });
  });

  // Initialize the "no bookings" message visibility
  updateNoBookingsMessage();
});
