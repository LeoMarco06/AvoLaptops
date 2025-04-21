document.addEventListener('DOMContentLoaded', function() {
    // Filtro per stato prenotazione
    const filterTabs = document.querySelectorAll('.filter-tab');
    const bookingCards = document.querySelectorAll('.booking-card');
    
    filterTabs.forEach(tab => {
        tab.addEventListener('click', function() {
            // Aggiorna tab attivo
            filterTabs.forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            
            const status = this.dataset.status;
            
            // Filtra le prenotazioni
            bookingCards.forEach(card => {
                if(status === 'all' || card.classList.contains(status)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
            
            // Mostra/nascondi messaggio "nessuna prenotazione"
            updateNoBookingsMessage();
        });
    });
    
    // Ricerca prenotazioni
    const searchInput = document.getElementById('booking-search');
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        bookingCards.forEach(card => {
            const cardText = card.textContent.toLowerCase();
            const isVisible = cardText.includes(searchTerm);
            
            // Considera anche il filtro attivo
            const activeFilter = document.querySelector('.filter-tab.active').dataset.status;
            const matchesFilter = activeFilter === 'all' || card.classList.contains(activeFilter);
            
            card.style.display = (isVisible && matchesFilter) ? 'block' : 'none';
        });
        
        updateNoBookingsMessage();
    });
    
    // Aggiorna messaggio "nessuna prenotazione"
    function updateNoBookingsMessage() {
        const visibleCards = document.querySelectorAll('.booking-card[style="display: block"], .booking-card:not([style])');
        const noBookingsMsg = document.querySelector('.no-bookings-message');
        
        if(visibleCards.length === 0) {
            noBookingsMsg.style.display = 'flex';
        } else {
            noBookingsMsg.style.display = 'none';
        }
    }
    
    // Gestione annullamento prenotazione
    document.querySelectorAll('.cancel-booking').forEach(btn => {
        btn.addEventListener('click', function() {
            const bookingId = this.closest('.booking-card').dataset.bookingId;
            if(confirm(`Sei sicuro di voler annullare la prenotazione ${bookingId}?`)) {
                // Qui andrebbe la chiamata API per annullare
                this.closest('.booking-card').style.display = 'none';
                updateNoBookingsMessage();
                alert(`Prenotazione ${bookingId} annullata con successo`);
            }
        });
    });
    
    // Inizializza la vista
    updateNoBookingsMessage();
});