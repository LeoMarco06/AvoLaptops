document.addEventListener('DOMContentLoaded', function () {
    // Manage laptop selection
    const selectedLaptops = [];
    const selectedList = document.getElementById('selected-laptops');
    const confirmBtn = document.getElementById('confirm-booking');
    const clearBtn = document.getElementById('clear-selection');

    // Add laptop to the selection
    document.querySelectorAll('.select-laptop').forEach(btn => {
        btn.addEventListener('click', function () {
            const laptopItem = this.closest('.laptop-item');
            const laptopId = laptopItem.dataset.laptopId;
            const laptopName = laptopItem.querySelector('.laptop-info span').textContent;

            if (!selectedLaptops.includes(laptopId)) {
                selectedLaptops.push(laptopId);

                const listItem = document.createElement('li');
                listItem.dataset.laptopId = laptopId;
                listItem.innerHTML = `
                            <span>${laptopName}</span>
                            <button class="btn-icon remove-laptop">
                                <i class="fas fa-times"></i>
                            </button>
                        `;

                selectedList.appendChild(listItem);
                laptopItem.querySelector('.select-laptop i').className = 'fas fa-check';
                laptopItem.querySelector('.select-laptop').classList.add('selected');

                updateSummary();
            }
        });
    });

    // Rimuovi portatile dalla selezione
    selectedList.addEventListener('click', function (e) {
        if (e.target.closest('.remove-laptop')) {
            const listItem = e.target.closest('li');
            const laptopId = listItem.dataset.laptopId;

            // Rimuovi dalla lista
            const index = selectedLaptops.indexOf(laptopId);
            if (index > -1) {
                selectedLaptops.splice(index, 1);
            }
            listItem.remove();

            // Aggiorna lo stato nell'armadietto
            const laptopItem = document.querySelector(`.laptop-item[data-laptop-id="${laptopId}"]`);
            if (laptopItem) {
                laptopItem.querySelector('.select-laptop i').className = 'fas fa-plus';
                laptopItem.querySelector('.select-laptop').classList.remove('selected');
            }

            updateSummary();
        }
    });

    // Annulla tutta la selezione
    clearBtn.addEventListener('click', function () {
        selectedLaptops.length = 0;
        selectedList.innerHTML = '';

        document.querySelectorAll('.select-laptop').forEach(btn => {
            btn.querySelector('i').className = 'fas fa-plus';
            btn.classList.remove('selected');
        });

        updateSummary();
    });

    // Conferma prenotazione
    confirmBtn.addEventListener('click', function () {
        if (selectedLaptops.length > 0) {
            const bookingDate = document.getElementById('booking-date').value;
            const returnDate = document.getElementById('return-date').value;

            if (!bookingDate || !returnDate) {
                alert('Seleziona le date di prenotazione e restituzione');
                return;
            }

            // Qui andrebbe la logica per inviare la prenotazione al server
            alert(`Prenotazione confermata per ${selectedLaptops.length} portatile/i!\nDal ${bookingDate} al ${returnDate}`);

            // Reset dopo la conferma
            clearBtn.click();
        }
    });

    // Aggiorna il riepilogo
    function updateSummary() {
        const summaryContent = document.querySelector('.summary-content p');

        if (selectedLaptops.length > 0) {
            summaryContent.textContent = `${selectedLaptops.length} portatile/i selezionati`;
            confirmBtn.disabled = false;
        } else {
            summaryContent.textContent = 'Nessun portatile selezionato';
            confirmBtn.disabled = true;
        }
    }

    // Imposta la data minima (oggi) per i campi data
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('booking-date').min = today;
    document.getElementById('return-date').min = today;
});