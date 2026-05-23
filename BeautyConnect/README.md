# BeautyConnect

BeautyConnect is a beauty salon booking and service marketplace built with:
- HTML
- CSS
- Bootstrap
- JavaScript
- PHP
- MySQL

## Project Structure

```text
BeautyConnect/
├── assets/
│   ├── css/style.css
│   └── js/main.js
├── config/db.php
├── database/beautyconnect.sql
├── index.php
├── book.php
├── submit_booking.php
├── bookings.php
└── PROJECT_DOCUMENTATION.md
```

## Setup Instructions

1. Create a local database using:
   - `BeautyConnect/database/beautyconnect.sql`
2. Configure environment variables (optional):
   - `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASS`
3. Place the `BeautyConnect` folder in your PHP server root (e.g. `htdocs` for XAMPP).
4. Open `http://localhost/BeautyConnect/index.php`.

## Main Features

- Salon marketplace homepage with service highlights
- Dynamic booking form with salon-based service filtering
- Booking submission and storage in MySQL
- Booking management view for submitted appointments
