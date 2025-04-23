document.addEventListener('DOMContentLoaded', function() {
    const filterTabs = document.querySelectorAll('.filter-tab');
    const bookingCards = document.querySelectorAll('.booking-card');
    
    filterTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Update active tab
            filterTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            const status = this.dataset.status;
            
            // Filter booking cards based on status
            bookingCards.forEach(card => {
                if(status === 'all' || card.classList.contains(status)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
            
            updateNoBookingsMessage();
        });
    });
    
    // Research reservations
    const searchInput = document.getElementById('booking-search');
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        bookingCards.forEach(card => {
            const cardText = card.textContent.toLowerCase();
            const isVisible = cardText.includes(searchTerm);
            
            const activeFilter = document.querySelector('.filter-tab.active').dataset.status;
            const matchesFilter = activeFilter === 'all' || card.classList.contains(activeFilter);
            
            card.style.display = (isVisible && matchesFilter) ? 'block' : 'none';
        });
        
        updateNoBookingsMessage();
    });
    
    // Update message "nessuna prenotazione"
    function updateNoBookingsMessage() {
        const visibleCards = document.querySelectorAll('.booking-card[style="display: block"], .booking-card:not([style])');
        const noBookingsMsg = document.querySelector('.no-bookings-message');
        
        if(visibleCards.length === 0) {
            noBookingsMsg.style.display = 'flex';
        } else {
            noBookingsMsg.style.display = 'none';
        }
    }
    
    // Manage booking actions
    document.querySelectorAll('.cancel-booking').forEach(btn => {
        btn.addEventListener('click', function() {
            // ======== SUBMIT AJAX REQUEST TO CANCEL BOOKING WITH PHP ======== //
        });
    });
    
    updateNoBookingsMessage();
});