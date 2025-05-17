# 📚 AvoLaptops

Sistema di gestione e prenotazione di laptop per scuole.

## 🔍 Scopo del progetto

AvoLaptops è una web application per la gestione delle prenotazioni di laptop in ambito scolastico. Fornisce:

- Prenotazioni e restituzioni con QR code
- Assegnazione laptop e armadietti
- Autenticazione utenti
- Area amministrativa per moderazione
- Statistiche dettagliate

## ✅ Casi d’uso principali

### Utente

- Login/registrazione
- Prenotazione laptop
- Visualizzazione e restituzione tramite QR code
- Cronologia prenotazioni

### Amministratore

- Gestione utenti, laptop e armadietti
- Gestione prenotazioni
- Accesso a statistiche

## 🔄 Flusso di prenotazione

### Utente

1. Login
2. Prenota laptop
3. Riceve QR code
4. Usa e restituisce laptop

### Admin

1. Login
2. Accede alla dashboard
3. Gestisce risorse e prenotazioni
4. Visualizza statistiche

## 📁 Struttura del progetto

```
AvoLaptops/
├── index.php
├── readme.md
├── css/                  # Stili
├── img/                  # Immagini
├── js/                   # Script JS
├── php/
│   ├── admin_pages/      # Gestione admin
│   ├── include/          # DB e funzioni
│   ├── reservation/      # Prenotazioni
│   ├── statistics/       # Statistiche
│   ├── user/             # Login e account
│   ├── page/             # Header, footer
└── sql/                  # Script SQL
```

## 🛠️ Tecnologie usate

- PHP 8+
- MySQL/MariaDB
- JavaScript
- HTML5, CSS3
- Librerie:
  - PHPQRCode
  - CanvasJS o Chart.js
  
## 🚀 Installazione locale

1. Clona o scarica la repo in `htdocs/`
2. Importa `sql/avolaptops.sql` nel DB
3. Configura `php/include/db_connect.php`
4. Avvia Apache e MySQL
5. Visita `http://localhost/AvoLaptops/`

## 📦 Dipendenze principali

| Libreria  | Scopo               | Posizione        |
| --------- | ------------------- | ---------------- |
| PHPQRCode | QR code             | php/include/     |
| CanvasJS  | Statistiche         | js/statistics.js |
| jsQR      | Lettura QR (webcam) | js/qr-reader.js  |

## 🔐 Autenticazione e autorizzazione

- Sessioni PHP
- Verifica ruolo utente per accesso alle pagine
- Redirect se non autorizzato

## 📲 QR code

- Generati alla creazione laptop
- Usati per prelievo
- Integrati con webcam o scanner

## 📊 Statistiche

- Prenotazioni per giorno/settimana
- Utenti attivi
- Stato laptop
- Visualizzazione con CanvasJS o Chart.js

---

> Realizzato per gestire in modo intelligente la tecnologia nella scuola 🏫
