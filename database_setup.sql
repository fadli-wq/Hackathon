-- Table for product categories
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(100) NOT NULL
);

-- Table for products
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    product_name VARCHAR(100) NOT NULL,
    product_description TEXT,
    product_image VARCHAR(255),
    product_price DECIMAL(10, 2),
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    user_id INT NOT NULL,
    quantity INT DEFAULT 1,
    total_price DECIMAL(10, 2) NOT NULL,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert example categories
INSERT INTO categories (category_name) VALUES
('Sayuran Segar'), 
('Buah-buahan'), 
('Tanaman Herbal dan Obat'),
('Produk Olahan'),
('Produk Pertanian'),
('Produk Khas Lokal');

-- Insert example products
INSERT INTO products (category_id, product_name, product_description, product_image, product_price) VALUES
(1, 'Bayam Segar', 'Sayur bayam segar dari petani lokal.', 'bayam.jpeg', 15000),
<<<<<<< HEAD
(1, 'Kangkung', 'Sayur kangkung kaya vitamin.', 'image2.jpg', 12000),
(2, 'Apel Manis', 'Apel manis dan segar langsung dari kebun.', 'image3.jpg', 20000),
(2, 'Jeruk Lokal', 'Jeruk segar dengan kandungan vitamin C tinggi.', 'image4.jpg', 18000),
(3, 'Jahe Merah', 'Tanaman herbal jahe merah kaya manfaat.', 'image5.jpg', 25000);
=======
(1, 'Kangkung', 'Sayur kangkung kaya vitamin.', 'kangkung.jpg', 12000),
(2, 'Apel Manis', 'Apel manis dan segar langsung dari kebun.', 'apel.jpg', 20000),
(2, 'Jeruk Lokal', 'Jeruk segar dengan kandungan vitamin C tinggi.', 'jeruk.jpg', 18000),
(3, 'Jahe Merah', 'Tanaman herbal jahe merah kaya manfaat.', 'jahe_merah.jpg', 25000);
(3, 'Kunyit', 'Tanaman herbal dengan sejuta kesehatan.', 'kunyit.jpg', 8000),
(4, 'Keripik Singkong', 'Camilan renyah yang terbuat dari irisan tipis singkong.', 'keripik.jpg', 15000),
(4, 'Bayam Goreng', 'Camilan yang enak dan sehat.', 'bayam_goreng.jpeg', 15000),
(5, 'Beras', 'Beras khas desa Leuwimalang.', 'beras.jpg', 18000),
(5, 'Gandum', 'Gandum yang kaya akan karbohidrat.', 'gandum.jpg', 17000);
(6, 'Kelodan Prima', 'Cemilan satu ini memiliki rasa gurih dan empuk.', 'kelodan.jpeg', 15000),
(6, 'Kue Gelong', 'Kue kering yang cocok untuk cemilan sehari-sehari.', 'kue_gelong.jpeg', 15000),
>>>>>>> 736578a8a1cf30a1023c36fb19c5f68a504f23e6
