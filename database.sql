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

-- Truncate menu to update seed data
TRUNCATE TABLE menu;

-- Seed data for Chef Egg Menu
INSERT INTO menu (name, description, price, category, image_url) VALUES
-- Starter
('Vaghariyu', '(2 Eggs) Delicious traditional egg specialty', 100.00, 'Starter', 'https://images.unsplash.com/photo-1525351484163-7529414344d8?w=500&q=80'),
('Green Kofta', '(2 Eggs) Chef''s special green egg kofta in aromatic gravy', 170.00, 'Starter', 'https://images.unsplash.com/photo-1626777552726-4a6b54c97e46?w=500&q=80'),
('Boil Fry', '(2 Eggs) Crispy shallow fried boiled eggs with spices', 60.00, 'Starter', 'https://images.unsplash.com/photo-1598515214211-89d3c73ae83b?w=500&q=80'),
('Egg Masala Dhosa', '(3 Eggs) Fusion egg masala dosa with spicy topping', 150.00, 'Starter', 'https://images.unsplash.com/photo-1668236543090-82eba5ee5976?w=500&q=80'),
('Egg Chaap', '(5 Eggs) Rich and spicy egg chaap platter', 250.00, 'Starter', 'https://images.unsplash.com/photo-1565299585323-38d6b0865b47?w=500&q=80'),
('Egg Lasuni Tikka', '(3 Eggs) Garlic infused egg tikka roasted to perfection', 200.00, 'Starter', 'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?w=500&q=80'),
('Boil Masala Fry', '(3 Eggs) Boiled eggs fried in rich masala butter', 200.00, 'Starter', 'https://images.unsplash.com/photo-1582169296194-e4d644c48063?w=500&q=80'),
('Boil Cheese Egg', '(2 Eggs) Boiled eggs topped with melted cheese', 100.00, 'Starter', 'https://images.unsplash.com/photo-1563245372-f21724e3856d?w=500&q=80'),
('Sandwich', '(2 Eggs) Double egg stuffed toasted sandwich', 150.00, 'Starter', 'https://images.unsplash.com/photo-1528735602780-2552fd46c7af?w=500&q=80'),
('Egg Pani Puri', '(2 Eggs) Unique egg twist on classic pani puri', 100.00, 'Starter', 'https://images.unsplash.com/photo-1601050690597-df0568f70950?w=500&q=80'),
('Boil Lasun Tadka', '(2 Eggs) Boiled eggs with garlic tadka tempering', 150.00, 'Starter', 'https://images.unsplash.com/photo-1606471191009-63994c53433b?w=500&q=80'),
('Egg Mamna', '(4 Eggs) Special 4-egg spiced mamna dish', 280.00, 'Starter', 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=500&q=80'),
('Egg Special Platter', '(6 Eggs) Grand 6-egg special chef platter', 350.00, 'Starter', 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=500&q=80'),

-- Omelette
('Omelette', '(2 Eggs) Classic fluffy double egg omelette', 80.00, 'Omelette', 'https://images.unsplash.com/photo-1510693206972-df098062cb71?w=500&q=80'),
('Bombay Omelette', '(2 Eggs) Spicy Mumbai street style omelette', 80.00, 'Omelette', 'https://images.unsplash.com/photo-1569718212165-3a8278d5f624?w=500&q=80'),
('Lemon Mari', '(2 Eggs) Lemon and black pepper seasoned omelette', 90.00, 'Omelette', 'https://images.unsplash.com/photo-1525351484163-7529414344d8?w=500&q=80'),
('Latpat Omelette', '(3 Eggs) Juicy and gravy-loaded 3-egg omelette', 120.00, 'Omelette', 'https://images.unsplash.com/photo-1510693206972-df098062cb71?w=500&q=80'),
('Paper Cheese Omelette', '(2 Eggs) Ultra thin cheese filled omelette', 120.00, 'Omelette', 'https://images.unsplash.com/photo-1563245372-f21724e3856d?w=500&q=80'),
('Omelette Curry', '(3 Eggs) Omelette folded in rich spiced curry', 130.00, 'Omelette', 'https://images.unsplash.com/photo-1582169296194-e4d644c48063?w=500&q=80'),
('Cheese Classic Omelette', '(4 Eggs) 4-egg loaded classic cheese omelette', 180.00, 'Omelette', 'https://images.unsplash.com/photo-1563245372-f21724e3856d?w=500&q=80'),
('Cheese Chilli Omelette', '(3 Eggs) Spicy green chilli and cheese omelette', 150.00, 'Omelette', 'https://images.unsplash.com/photo-1510693206972-df098062cb71?w=500&q=80'),

-- Kheema And Gotala
('Egg Bhurji', '(2 Eggs) Authentic Indian scrambled eggs with spices', 100.00, 'Kheema And Gotala', 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=500&q=80'),
('Red Turkey', '(2 Eggs) Special red spice egg kheema', 100.00, 'Kheema And Gotala', 'https://images.unsplash.com/photo-1565299585323-38d6b0865b47?w=500&q=80'),
('Greenland Kheema', '(2 Eggs) Fresh green herb egg kheema', 120.00, 'Kheema And Gotala', 'https://images.unsplash.com/photo-1626777552726-4a6b54c97e46?w=500&q=80'),
('Rajwadi Kheema', '(2 Eggs) Royal Surti style egg kheema', 120.00, 'Kheema And Gotala', 'https://images.unsplash.com/photo-1582169296194-e4d644c48063?w=500&q=80'),
('Royal Gotala (Red)', '(4 Eggs) 4-egg rich red gravy gotala', 220.00, 'Kheema And Gotala', 'https://images.unsplash.com/photo-1601050690597-df0568f70950?w=500&q=80'),
('Greenland Gotala', '(4 Eggs) 4-egg green coriander mint gotala', 260.00, 'Kheema And Gotala', 'https://images.unsplash.com/photo-1626777552726-4a6b54c97e46?w=500&q=80'),
('Cheese Goti', '(4 Eggs) Melted cheese egg goti gravy', 250.00, 'Kheema And Gotala', 'https://images.unsplash.com/photo-1563245372-f21724e3856d?w=500&q=80'),
('Hyderabadi Gotala (Chef Special)', '(4 Eggs) Chef special Hyderabadi spiced 4-egg gotala', 260.00, 'Kheema And Gotala', 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=500&q=80'),

-- Egg Fry
('Regular Half Fry', '(2 Eggs) Classic sunny side up double egg fry', 100.00, 'Egg Fry', 'https://images.unsplash.com/photo-1525351484163-7529414344d8?w=500&q=80'),
('Mari Masala Fry', '(2 Eggs) Black pepper spiced half fry', 110.00, 'Egg Fry', 'https://images.unsplash.com/photo-1598515214211-89d3c73ae83b?w=500&q=80'),
('Boil Half Fry', '(3 Eggs) Hybrid boiled and sunny side up egg fry', 140.00, 'Egg Fry', 'https://images.unsplash.com/photo-1582169296194-e4d644c48063?w=500&q=80'),
('Tomato Half Fry', '(2 Eggs) Half fry prepared in fresh tangy tomato gravy', 120.00, 'Egg Fry', 'https://images.unsplash.com/photo-1565299585323-38d6b0865b47?w=500&q=80'),
('Lasan Fry', '(4 Eggs) Garlic loaded 4-egg fry special', 180.00, 'Egg Fry', 'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?w=500&q=80'),
('Locha Fry', '(3 Eggs) Surti locha style 3-egg fry', 160.00, 'Egg Fry', 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=500&q=80'),
('Australian Fry (Red)', '(3 Eggs) Australian style red masala egg fry', 200.00, 'Egg Fry', 'https://images.unsplash.com/photo-1601050690597-df0568f70950?w=500&q=80'),
('Australian Fry (Green)', '(3 Eggs) Australian style green herb egg fry', 220.00, 'Egg Fry', 'https://images.unsplash.com/photo-1626777552726-4a6b54c97e46?w=500&q=80'),
('German Fry', '(3 Eggs) German recipe egg fry', 180.00, 'Egg Fry', 'https://images.unsplash.com/photo-1525351484163-7529414344d8?w=500&q=80'),
('Mexican Fry', '(3 Eggs) Mexican spiced salsa egg fry', 200.00, 'Egg Fry', 'https://images.unsplash.com/photo-1565299585323-38d6b0865b47?w=500&q=80'),
('Russian Fry', '(4 Eggs) Creamy Russian sauce 4-egg fry', 230.00, 'Egg Fry', 'https://images.unsplash.com/photo-1582169296194-e4d644c48063?w=500&q=80'),
('New Zealand Fry', '(4 Eggs) Special New Zealand sauce egg fry', 240.00, 'Egg Fry', 'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?w=500&q=80'),
('Lapeti Fry', '(5 Eggs) 5-egg loaded lapeti fry roll', 250.00, 'Egg Fry', 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=500&q=80'),
('Zinga Fry', '(3 Eggs) Crispy zesty zinga egg fry', 230.00, 'Egg Fry', 'https://images.unsplash.com/photo-1598515214211-89d3c73ae83b?w=500&q=80'),
('Mysore Fry', '(3 Eggs) South Indian Mysore spice egg fry', 190.00, 'Egg Fry', 'https://images.unsplash.com/photo-1601050690597-df0568f70950?w=500&q=80'),
('Italian Chef Special', '(5 Eggs) Grand Italian 5-egg chef special fry', 280.00, 'Egg Fry', 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=500&q=80');
