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

-- Seed data for Full Chef Egg Menu (Pages 1 - 6)
INSERT INTO menu (name, description, price, category, image_url) VALUES
-- 1. Starter
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

-- 2. Omelette
('Omelette', '(2 Eggs) Classic fluffy double egg omelette', 80.00, 'Omelette', 'https://images.unsplash.com/photo-1510693206972-df098062cb71?w=500&q=80'),
('Bombay Omelette', '(2 Eggs) Spicy Mumbai street style omelette', 80.00, 'Omelette', 'https://images.unsplash.com/photo-1569718212165-3a8278d5f624?w=500&q=80'),
('Lemon Mari', '(2 Eggs) Lemon and black pepper seasoned omelette', 90.00, 'Omelette', 'https://images.unsplash.com/photo-1525351484163-7529414344d8?w=500&q=80'),
('Latpat Omelette', '(3 Eggs) Juicy and gravy-loaded 3-egg omelette', 120.00, 'Omelette', 'https://images.unsplash.com/photo-1510693206972-df098062cb71?w=500&q=80'),
('Paper Cheese Omelette', '(2 Eggs) Ultra thin cheese filled omelette', 120.00, 'Omelette', 'https://images.unsplash.com/photo-1563245372-f21724e3856d?w=500&q=80'),
('Omelette Curry', '(3 Eggs) Omelette folded in rich spiced curry', 130.00, 'Omelette', 'https://images.unsplash.com/photo-1582169296194-e4d644c48063?w=500&q=80'),
('Cheese Classic Omelette', '(4 Eggs) 4-egg loaded classic cheese omelette', 180.00, 'Omelette', 'https://images.unsplash.com/photo-1563245372-f21724e3856d?w=500&q=80'),
('Cheese Chilli Omelette', '(3 Eggs) Spicy green chilli and cheese omelette', 150.00, 'Omelette', 'https://images.unsplash.com/photo-1510693206972-df098062cb71?w=500&q=80'),

-- 3. Kheema And Gotala
('Egg Bhurji', '(2 Eggs) Authentic Indian scrambled eggs with spices', 100.00, 'Kheema And Gotala', 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=500&q=80'),
('Red Turkey', '(2 Eggs) Special red spice egg kheema', 100.00, 'Kheema And Gotala', 'https://images.unsplash.com/photo-1565299585323-38d6b0865b47?w=500&q=80'),
('Greenland Kheema', '(2 Eggs) Fresh green herb egg kheema', 120.00, 'Kheema And Gotala', 'https://images.unsplash.com/photo-1626777552726-4a6b54c97e46?w=500&q=80'),
('Rajwadi Kheema', '(2 Eggs) Royal Surti style egg kheema', 120.00, 'Kheema And Gotala', 'https://images.unsplash.com/photo-1582169296194-e4d644c48063?w=500&q=80'),
('Royal Gotala (Red)', '(4 Eggs) 4-egg rich red gravy gotala', 220.00, 'Kheema And Gotala', 'https://images.unsplash.com/photo-1601050690597-df0568f70950?w=500&q=80'),
('Greenland Gotala', '(4 Eggs) 4-egg green coriander mint gotala', 260.00, 'Kheema And Gotala', 'https://images.unsplash.com/photo-1626777552726-4a6b54c97e46?w=500&q=80'),
('Cheese Goti', '(4 Eggs) Melted cheese egg goti gravy', 250.00, 'Kheema And Gotala', 'https://images.unsplash.com/photo-1563245372-f21724e3856d?w=500&q=80'),
('Hyderabadi Gotala (Chef Special)', '(4 Eggs) Chef special Hyderabadi spiced 4-egg gotala', 260.00, 'Kheema And Gotala', 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=500&q=80'),

-- 4. Egg Fry
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
('Italian Chef Special', '(5 Eggs) Grand Italian 5-egg chef special fry', 280.00, 'Egg Fry', 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=500&q=80'),

-- 5. Gravy
('Egg Curry', '(2 Eggs) Traditional rich tomato onion egg curry', 120.00, 'Gravy', 'https://images.unsplash.com/photo-1582169296194-e4d644c48063?w=500&q=80'),
('Egg Ravaiya', '(3 Eggs) Chef special stuffed egg ravaiya in thick gravy', 160.00, 'Gravy', 'https://images.unsplash.com/photo-1626777552726-4a6b54c97e46?w=500&q=80'),
('Boil Tikka', '(2 Eggs) Boiled tikka eggs simmered in spicy sauce', 120.00, 'Gravy', 'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?w=500&q=80'),
('Mix Tikka Masala', '(2 Eggs) Mixed egg tikka in rich butter masala', 170.00, 'Gravy', 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=500&q=80'),
('Lahori Special', '(3 Eggs) Authentic Lahori style 3-egg gravy', 200.00, 'Gravy', 'https://images.unsplash.com/photo-1601050690597-df0568f70950?w=500&q=80'),
('Lasagna', '(3 Eggs) Italian layered egg lasagna gravy', 180.00, 'Gravy', 'https://images.unsplash.com/photo-1563245372-f21724e3856d?w=500&q=80'),
('Tikhari', '(5 Eggs) Extra spicy 5-egg Surti tikhari gravy', 250.00, 'Gravy', 'https://images.unsplash.com/photo-1565299585323-38d6b0865b47?w=500&q=80'),
('Egg Paplet', '(4 Eggs) Signature 4-egg paplet shaped gravy dish', 250.00, 'Gravy', 'https://images.unsplash.com/photo-1626777552726-4a6b54c97e46?w=500&q=80'),
('Egg Patudi', '(4 Eggs) 4-egg patudi rolled in aromatic spices', 220.00, 'Gravy', 'https://images.unsplash.com/photo-1582169296194-e4d644c48063?w=500&q=80'),
('Egg Cheese Gravy', '(2 Eggs) Rich gravy loaded with melted cheese', 170.00, 'Gravy', 'https://images.unsplash.com/photo-1563245372-f21724e3856d?w=500&q=80'),
('Australian Gravy', '(2 Eggs) Australian special spiced egg gravy', 140.00, 'Gravy', 'https://images.unsplash.com/photo-1601050690597-df0568f70950?w=500&q=80'),
('Egg Patiyala', '(4 Eggs) Royal 4-egg Patiyala style gravy', 250.00, 'Gravy', 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=500&q=80'),
('Indian Egg', '(4 Eggs) Desi spiced 4-egg signature gravy', 250.00, 'Gravy', 'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?w=500&q=80'),
('Angur Rabdi', '(5 Eggs) Special 5-egg sweet and savory Angur Rabdi gravy', 250.00, 'Gravy', 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=500&q=80'),
('Cheese Kofta Gravy', '(3 Eggs) Soft egg cheese kofta balls in gravy', 190.00, 'Gravy', 'https://images.unsplash.com/photo-1626777552726-4a6b54c97e46?w=500&q=80'),

-- 6. Chef Egg Special
('Garib Rath', '(5 Eggs) 5-egg ultimate feast recipe', 250.00, 'Chef Egg Special', 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=500&q=80'),
('Maangur', '(5 Eggs) 5-egg rich spiced special', 250.00, 'Chef Egg Special', 'https://images.unsplash.com/photo-1582169296194-e4d644c48063?w=500&q=80'),
('Tiranga', '(5 Eggs) Tri-color layered 5-egg special', 250.00, 'Chef Egg Special', 'https://images.unsplash.com/photo-1626777552726-4a6b54c97e46?w=500&q=80'),
('Egg Bigg Boss', '(6 Eggs) Grand 6-egg Bigg Boss signature platter', 300.00, 'Chef Egg Special', 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=500&q=80'),
('Egg Makhamali', '(5 Eggs) Smooth and velvety 5-egg cream gravy', 250.00, 'Chef Egg Special', 'https://images.unsplash.com/photo-1563245372-f21724e3856d?w=500&q=80'),
('Egg Bahubali', '(6 Eggs) Mighty 6-egg Bahubali feast', 300.00, 'Chef Egg Special', 'https://images.unsplash.com/photo-1601050690597-df0568f70950?w=500&q=80'),
('Egg Dhamaka', '(7 Eggs) Explosive 7-egg chef supreme dhamaka', 350.00, 'Chef Egg Special', 'https://images.unsplash.com/photo-1565299585323-38d6b0865b47?w=500&q=80'),
('Egg Maharaja', '(6 Eggs) Royal 6-egg Maharaja preparation', 300.00, 'Chef Egg Special', 'https://images.unsplash.com/photo-1599487488170-d11ec9c172f0?w=500&q=80'),
('Egg Laziz', '(3 Eggs) Deliciously spiced 3-egg Laziz gravy', 250.00, 'Chef Egg Special', 'https://images.unsplash.com/photo-1582169296194-e4d644c48063?w=500&q=80'),
('Moglai', '(3 Eggs) Rich Mughlai style egg curry', 250.00, 'Chef Egg Special', 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=500&q=80'),
('Egg Kashmiri Tadka', '(5 Eggs) 5-egg Kashmiri saffron spice tadka', 300.00, 'Chef Egg Special', 'https://images.unsplash.com/photo-1601050690597-df0568f70950?w=500&q=80'),
('Egg Pahadi', '(5 Eggs) Mountain herb green 5-egg pahadi gravy', 320.00, 'Chef Egg Special', 'https://images.unsplash.com/photo-1626777552726-4a6b54c97e46?w=500&q=80'),
('Tufani', '(5 Eggs) Sizzling 5-egg tufani masala', 300.00, 'Chef Egg Special', 'https://images.unsplash.com/photo-1565299585323-38d6b0865b47?w=500&q=80'),
('Red & Green Cheese', '(4 Eggs) Dual red and green gravy with cheese', 250.00, 'Chef Egg Special', 'https://images.unsplash.com/photo-1563245372-f21724e3856d?w=500&q=80'),

-- 7. Rice
('Egg Dal Fry Tadka', '(3 Eggs) Lentil dal fry tempered with eggs', 150.00, 'Rice', 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=500&q=80'),
('Jira Rice', 'Aromatic cumin seasoned basmati rice', 120.00, 'Rice', 'https://images.unsplash.com/photo-1516684732162-798a0062be99?w=500&q=80'),
('Bhurji Dry Rice', '(2 Eggs) Egg bhurji tossed with fried rice', 220.00, 'Rice', 'https://images.unsplash.com/photo-1603133872878-684f208fb84b?w=500&q=80'),
('Chhoper Fry Rice', '(2 Eggs) Surti chhoper style egg fried rice', 240.00, 'Rice', 'https://images.unsplash.com/photo-1603133872878-684f208fb84b?w=500&q=80'),
('Egg Biryani', '(2 Eggs) Fragrant 2-egg spiced Dum Biryani', 250.00, 'Rice', 'https://images.unsplash.com/photo-1563379091339-03b21ab4a4f8?w=500&q=80'),
('Egg Hyderabadi Dum Biryani', '(4 Eggs) Authentic Hyderabadi 4-egg dum biryani', 300.00, 'Rice', 'https://images.unsplash.com/photo-1563379091339-03b21ab4a4f8?w=500&q=80'),
('Kashmiri Pulav', '(2 Eggs) Sweet and savory Kashmiri egg pulav with nuts', 250.00, 'Rice', 'https://images.unsplash.com/photo-1516684732162-798a0062be99?w=500&q=80'),
('Egg Dal Khichdi', '(3 Eggs) Comforting egg dal khichdi', 220.00, 'Rice', 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?w=500&q=80'),

-- 8. Add On's
('Fry Papad', 'Crispy fried papadum', 50.00, 'Add On''s', 'https://images.unsplash.com/photo-1601050690597-df0568f70950?w=500&q=80'),
('Rosted Papad', 'Oven roasted crunchy papadum', 30.00, 'Add On''s', 'https://images.unsplash.com/photo-1601050690597-df0568f70950?w=500&q=80'),
('Masala Papad', 'Crispy papad topped with onions, tomatoes & spices', 70.00, 'Add On''s', 'https://images.unsplash.com/photo-1601050690597-df0568f70950?w=500&q=80'),
('Cheese Masala Papad', 'Masala papad generously loaded with melted cheese', 100.00, 'Add On''s', 'https://images.unsplash.com/photo-1563245372-f21724e3856d?w=500&q=80'),
('Plain Buns', 'Freshly baked soft bread buns (2 pcs)', 20.00, 'Add On''s', 'https://images.unsplash.com/photo-1509440159596-0249088772ff?w=500&q=80'),
('Garlic Buns', 'Toasted garlic butter buns (2 pcs)', 30.00, 'Add On''s', 'https://images.unsplash.com/photo-1619535860434-ba1d8fa12536?w=500&q=80'),
('Chokha Na Puda', 'Traditional Gujarati rice flour puda', 20.00, 'Add On''s', 'https://images.unsplash.com/photo-1668236543090-82eba5ee5976?w=500&q=80'),
('Masala Puda', 'Spicy savory masala puda', 30.00, 'Add On''s', 'https://images.unsplash.com/photo-1668236543090-82eba5ee5976?w=500&q=80'),
('Chapati', 'Fresh hot whole wheat roti', 15.00, 'Add On''s', 'https://images.unsplash.com/photo-1626777552726-4a6b54c97e46?w=500&q=80'),
('Boil Salad', '(2 Eggs) Sliced boiled eggs with fresh garden greens', 50.00, 'Add On''s', 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=500&q=80'),
('Green Salad', 'Fresh onion, cucumber, tomato & lemon salad', 70.00, 'Add On''s', 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?w=500&q=80'),

-- 9. Colddrink
('Coke', 'Chilled Coca-Cola 330ml can', 30.00, 'Colddrink', 'https://images.unsplash.com/photo-1622483767028-3f66f32aef97?w=500&q=80'),
('Thumsup', 'Chilled Thums Up 330ml can', 30.00, 'Colddrink', 'https://images.unsplash.com/photo-1622483767028-3f66f32aef97?w=500&q=80'),
('Fanta', 'Chilled Fanta orange drink', 30.00, 'Colddrink', 'https://images.unsplash.com/photo-1624517452488-04869289c4ca?w=500&q=80'),
('Sprite', 'Chilled Sprite lemon lime drink', 30.00, 'Colddrink', 'https://images.unsplash.com/photo-1625772299848-391b6a87d7b3?w=500&q=80'),
('Maaza', 'Refreshing Maaza mango juice', 30.00, 'Colddrink', 'https://images.unsplash.com/photo-1551024709-8f23befc6f87?w=500&q=80'),
('Diet Coke', 'Zero sugar chilled Diet Coke', 50.00, 'Colddrink', 'https://images.unsplash.com/photo-1622483767028-3f66f32aef97?w=500&q=80'),
('Water Bottle', 'Packaged mineral water 1L', 20.00, 'Colddrink', 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?w=500&q=80');
