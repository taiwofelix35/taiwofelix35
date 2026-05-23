CREATE DATABASE IF NOT EXISTS beautyconnect CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE beautyconnect;

DROP TABLE IF EXISTS bookings;
DROP TABLE IF EXISTS customers;
DROP TABLE IF EXISTS services;
DROP TABLE IF EXISTS salons;

CREATE TABLE salons (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    location VARCHAR(150) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    description TEXT NOT NULL,
    image_url VARCHAR(255) NOT NULL
);

CREATE TABLE services (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    salon_id INT UNSIGNED NOT NULL,
    name VARCHAR(120) NOT NULL,
    duration_minutes INT UNSIGNED NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    description TEXT,
    FOREIGN KEY (salon_id) REFERENCES salons(id) ON DELETE CASCADE
);

CREATE TABLE customers (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(120) NOT NULL,
    email VARCHAR(120) NOT NULL UNIQUE,
    phone VARCHAR(20) NOT NULL
);

CREATE TABLE bookings (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    customer_id INT UNSIGNED NOT NULL,
    salon_id INT UNSIGNED NOT NULL,
    service_id INT UNSIGNED NOT NULL,
    appointment_date DATE NOT NULL,
    appointment_time TIME NOT NULL,
    notes VARCHAR(500) NULL,
    status ENUM('Pending','Confirmed','Cancelled','Completed') NOT NULL DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE CASCADE,
    FOREIGN KEY (salon_id) REFERENCES salons(id) ON DELETE CASCADE,
    FOREIGN KEY (service_id) REFERENCES services(id) ON DELETE CASCADE
);

INSERT INTO salons (name, location, phone, description, image_url) VALUES
('Glow Studio', 'Ikeja, Lagos', '+234-800-123-4567', 'Modern beauty studio offering makeup, skincare, and bridal styling.', 'https://images.unsplash.com/photo-1560066984-138dadb4c035?auto=format&fit=crop&w=900&q=80'),
('Luxe Beauty Hub', 'Victoria Island, Lagos', '+234-800-987-6543', 'Premium salon specializing in haircare, lashes, and nails.', 'https://images.unsplash.com/photo-1522337660859-02fbefca4702?auto=format&fit=crop&w=900&q=80'),
('Radiance Spa', 'Abuja', '+234-800-444-1100', 'Relaxation and wellness space for facials, massages, and spa therapies.', 'https://images.unsplash.com/photo-1544161515-4ab6ce6db874?auto=format&fit=crop&w=900&q=80');

INSERT INTO services (salon_id, name, duration_minutes, price, description) VALUES
(1, 'Bridal Makeup', 120, 120.00, 'Complete bridal look with premium products.'),
(1, 'Express Facial', 45, 35.00, 'Quick rejuvenating facial treatment.'),
(2, 'Gel Manicure', 60, 25.00, 'Long-lasting gel polish manicure service.'),
(2, 'Lash Extension', 90, 80.00, 'Classic and volume lash extension options.'),
(3, 'Deep Tissue Massage', 60, 50.00, 'Targeted massage for muscle relaxation.'),
(3, 'Hydrating Facial', 60, 40.00, 'Hydration-focused facial for glowing skin.');
