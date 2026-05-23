# BeautyConnect Project Documentation

## 1. Project Overview

BeautyConnect is a beauty salon booking and service marketplace that allows customers to:
- Browse salons and services
- Book appointments online
- Store booking requests in a MySQL database

The system also includes a simple booking management page for reviewing submitted bookings.

## 2. Design and Development Process

### 2.1 Requirement Interpretation

The project required a web-based marketplace and booking platform using HTML, CSS, Bootstrap, JavaScript, PHP, and MySQL.  
Based on this, the application was split into:
- Frontend views for listing salons and making bookings
- Backend PHP processing for booking submission
- Relational MySQL schema for persistent data storage

### 2.2 System Architecture

- **Presentation Layer**: `index.php`, `book.php`, `bookings.php`
- **Styling Layer**: `assets/css/style.css` and Bootstrap
- **Interaction Layer**: `assets/js/main.js` for dynamic form behavior
- **Application Logic Layer**: `submit_booking.php`
- **Data Access Layer**: `config/db.php`
- **Database Layer**: `database/beautyconnect.sql`

### 2.3 Database Design

The schema was designed around four main entities:
- `salons` — marketplace businesses
- `services` — offered by each salon
- `customers` — booking users
- `bookings` — appointment records connecting customer, salon, and service

Foreign keys are used to preserve relational integrity.

### 2.4 Security and Data Handling

The implementation includes:
- PDO prepared statements for database queries
- Server-side input validation for all booking fields
- Output escaping with `htmlspecialchars` to prevent XSS
- Date validation to prevent past bookings

## 3. Development Procedures Followed

1. Define project structure and page responsibilities.
2. Design normalized SQL schema and insert seed data.
3. Build home page and salon cards.
4. Build booking form with frontend dynamic service filtering.
5. Implement secure booking submission using PHP + PDO.
6. Build booking list page to review records.
7. Validate PHP syntax and verify structure/documentation.

## 4. Features Implemented

- Home page with featured salons
- Service-based booking flow
- Customer upsert behavior by email
- Booking persistence and status tracking
- Booking management table
- Responsive UI with Bootstrap

## 5. Problems Encountered and Resolutions

### Problem 1: Service-to-salon mapping in booking form
- **Issue**: Users could choose unrelated services if all services were displayed together.
- **Resolution**: JavaScript-based filtering was implemented so service options update when a salon is selected.

### Problem 2: Duplicate customer records
- **Issue**: Repeated bookings by the same customer could create duplicate rows.
- **Resolution**: Customer lookup by email was added. Existing customer records are updated and reused.

### Problem 3: Data validation reliability
- **Issue**: Client-side validation alone is insufficient.
- **Resolution**: Robust server-side validation and database checks were implemented before insert operations.

## 6. How to Run the Project

1. Import `database/beautyconnect.sql` into MySQL.
2. Configure database credentials through environment variables if needed.
3. Host the `BeautyConnect` folder on a local PHP-enabled server.
4. Start from `index.php` and navigate through the application.
