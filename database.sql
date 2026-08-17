CREATE DATABASE IF NOT EXISTS food_order_db;
USE food_order_db;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS menu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    category VARCHAR(100) NOT NULL,
    image_url VARCHAR(255),
    is_available TINYINT DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    items JSON,
    total_amount DECIMAL(10,2) NOT NULL,
    status ENUM('pending', 'confirmed', 'preparing', 'delivered', 'cancelled') DEFAULT 'pending',
    delivery_address TEXT,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Seed data for menu
INSERT INTO menu (name, description, price, category, image_url) VALUES
('Bruschetta', 'Toasted bread with garlic, tomatoes, and basil.', 6.99, 'Starters', 'https://images.unsplash.com/photo-1572695157366-5e585ab2b69f?w=500&q=80'),
('Garlic Bread', 'Crispy oven-baked bread with garlic butter.', 4.99, 'Starters', 'https://images.unsplash.com/photo-1619535860434-ba1d8fa12536?w=500&q=80'),
('Stuffed Mushrooms', 'Mushrooms stuffed with cheese and herbs.', 7.50, 'Starters', 'https://images.unsplash.com/photo-1618331578330-22cdd4b5dbba?w=500&q=80'),
('Margherita Pizza', 'Classic pizza with fresh mozzarella and basil.', 12.99, 'Main Course', 'https://images.unsplash.com/photo-1574071318508-1cdbab80d002?w=500&q=80'),
('Spaghetti Carbonara', 'Creamy pasta with pancetta and parmesan.', 14.50, 'Main Course', 'https://images.unsplash.com/photo-1612874742237-6526221588e3?w=500&q=80'),
('Grilled Salmon', 'Fresh salmon fillet with lemon butter sauce.', 18.99, 'Main Course', 'https://images.unsplash.com/photo-1485921325833-c519f76c4927?w=500&q=80'),
('Steak Frites', 'Grilled steak served with crispy french fries.', 22.50, 'Main Course', 'https://images.unsplash.com/photo-1600891964092-4316c288032e?w=500&q=80'),
('Coca-Cola', 'Chilled 330ml can.', 1.99, 'Drinks', 'https://images.unsplash.com/photo-1622483767028-3f66f32aef97?w=500&q=80'),
('Lemonade', 'Freshly squeezed homemade lemonade.', 3.50, 'Drinks', 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?w=500&q=80'),
('Iced Tea', 'Refreshing peach iced tea.', 2.99, 'Drinks', 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=500&q=80'),
('Tiramisu', 'Classic Italian coffee-flavored dessert.', 6.50, 'Desserts', 'https://images.unsplash.com/photo-1571115177098-24ec42ed204d?w=500&q=80'),
('Cheesecake', 'New York style cheesecake with strawberry glaze.', 7.00, 'Desserts', 'https://images.unsplash.com/photo-1533134242443-d4fd215305ad?w=500&q=80');
