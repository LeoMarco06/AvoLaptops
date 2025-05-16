function showQrPopup(laptop) {
    const qrData = {
        lap_id: laptop.lap_id,
        lap_name: laptop.lap_name,
        lap_locker: laptop.lap_locker,
        lap_model: laptop.lap_model
    };
    document.getElementById("popup-qr-title").textContent = "QR laptop - " + laptop.lap_id;
    document.getElementById('qr-popup-admin').style.display = 'block';
    document.getElementById('qr-code-admin').innerHTML = '';
    new QRCode(document.getElementById('qr-code-admin'), {
        text: JSON.stringify(qrData),
        width: 200,
        height: 200
    });
}
document.getElementById('close-qr-popup-admin').onclick = () => {
    document.getElementById('qr-popup-admin').style.display = 'none';
};

document.addEventListener("keydown", function (event) {
    if (event.key === "Escape") {
        document.getElementById('qr-popup-admin').style.display = 'none';
    }
});

document.getElementById('print-qr-btn').onclick = () => {
    const popup = document.getElementById('qr-popup-admin');
    const qr = document.getElementById('qr-code-admin').innerHTML;
    const json = document.getElementById('qr-json-admin').textContent;
    const win = window.open('', '', 'width=400,height=600');
    win.document.write('<html><head><title>QR Laptop</title></head><body>');
    win.document.write('<div style="width:100%; display:flex; justify-content:center;">' + qr + '</div>');
    win.document.write('<pre>' + json + '</pre>');
    win.document.write('</body></html>');
    win.document.close();
    win.print();
};