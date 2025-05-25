document.addEventListener("DOMContentLoaded", function () {
    const popup = document.getElementById('qr-popup');
    const openBtn = document.getElementById('open-qr-popup');
    const closeBtn = document.getElementById('close-qr-popup');
    const resultContainer = document.getElementById("qr-result");
    const qr_screen = document.getElementById("qr-screen");
    const qr_reader = document.getElementById("qr-reader");



    let qrReader;
    let scannerIsRunning = false;

    openBtn.addEventListener('click', () => {
        popup.style.display = 'block';
        qr_screen.style.display = 'none';
        qr_reader.style.display = "block";
        qr_screen.innerHTML = "";
        resultContainer.innerHTML = "Inquadra il codice qr presente sul pc e conferma la selezione premendo sul pulsante \"conferma\".";

        qrReader = new Html5Qrcode("qr-reader");

        qrReader.start(
            { facingMode: "environment" },
            { fps: 20, qrbox: 350 },
            async (decodedText) => {
                let data;
                try {
                    data = JSON.parse(decodedText);
                } catch (e) {
                    resultContainer.innerHTML = "QR non valido!";
                    return;
                }
                const videoElement = document.querySelector("#qr-reader video");
                if (videoElement) {
                    const canvas = document.createElement("canvas");
                    canvas.width = videoElement.videoWidth;
                    canvas.height = videoElement.videoHeight;
                    const ctx = canvas.getContext("2d");
                    ctx.drawImage(videoElement, 0, 0, canvas.width, canvas.height);
                    const img = document.createElement("img");
                    img.src = canvas.toDataURL("image/png");
                    img.alt = "QR catturato";
                    img.style.maxWidth = "100%";
                    resultContainer.innerHTML = `<p>PC selezionato: ${data.lap_name}</p>
                                             <p>Armadietto: ${data.lap_locker}</p>
                                             <p>Modello: ${data.lap_model}</p>
                                             <button id="add-to-cart-btn" class="btn btn-primary btn-small">Aggiungi al carrello</button>`;
                    qr_screen.innerHTML = "";
                    qr_reader.style.display = "none";
                    qr_screen.style.display = "block";
                    qr_screen.appendChild(img);
                    qr_reader.style.display = "none";
                    qr_screen.style.display = "block";
                }

                document.getElementById('add-to-cart-btn').onclick = function () {
                    addLaptopToCart(data.lap_id);
                    closeScanner();
                };

                scannerIsRunning = false;
                await qrReader.stop();
                await qrReader.clear();
            }
        ).then(() => {
            scannerIsRunning = true;
        }).catch(err => console.error(err));
    });

    closeBtn.addEventListener('click', () => {
        closeScanner();
    });

    document.addEventListener("keydown", function (event) {
        if (event.key === "Escape") {
            closeScanner();
        }
    });

    function closeScanner() {
        qr_screen.style.display = 'none';
        popup.style.display = 'none';
        qr_reader.style.display = "none";
        resultContainer.innerHTML = "Inquadra il codice qr presente sul pc e conferma la selezione premendo sul pulsante \"conferma\".";
        if (qrReader && scannerIsRunning) {
            qrReader.stop().then(() => {
                return qrReader.clear();
            }).catch(err => console.error(err)).finally(() => {
                scannerIsRunning = false;
            });
        }
    }

    function addLaptopToCart(lap_id) {
        selectLaptopById(lap_id);
    }
});
