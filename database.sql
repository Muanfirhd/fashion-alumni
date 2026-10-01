-- =====================================================
-- FASHION ALUMNI ONE STOP CENTRE (FAOSC)
-- Fail: database.sql
-- Import terus ke phpMyAdmin
-- =====================================================

CREATE DATABASE IF NOT EXISTS fashion_alumni
  DEFAULT CHARACTER SET utf8mb4
  COLLATE utf8mb4_general_ci;

USE fashion_alumni;

-- -----------------------------------------------------
-- Table: admin
-- -----------------------------------------------------
DROP TABLE IF EXISTS admin;
CREATE TABLE admin (
  id INT(11) NOT NULL AUTO_INCREMENT,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Login default: username = admin, password = admin123
-- (password telah di-hash menggunakan password_hash())
INSERT INTO admin (username, password) VALUES
('admin', '$2y$12$0.Lq1pg29E4.Abmb9ydjyeFEVyoh8shpx5msvATHISyGPMkaeHwR.');

-- -----------------------------------------------------
-- Table: alumni
-- -----------------------------------------------------
DROP TABLE IF EXISTS alumni;
CREATE TABLE alumni (
  id INT(11) NOT NULL AUTO_INCREMENT,
  nama VARCHAR(100) NOT NULL,
  tahun_tamat YEAR NOT NULL,
  bidang VARCHAR(100) NOT NULL,
  pekerjaan VARCHAR(100) DEFAULT NULL,
  telefon VARCHAR(20) DEFAULT NULL,
  email VARCHAR(100) DEFAULT NULL,
  alamat TEXT DEFAULT NULL,
  gambar VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO alumni (nama, tahun_tamat, bidang, pekerjaan, telefon, email, alamat) VALUES
('Aina Sofea Rahman', 2022, 'Pereka Fesyen', 'Pereka Kanan, Atelier Aurora', '012-3456789', 'aina@example.com', 'Kuala Lumpur'),
('Muhammad Danish Hakim', 2021, 'Pengurusan Fesyen', 'Fashion Buyer, Voir Group', '013-9876543', 'danish@example.com', 'Shah Alam, Selangor'),
('Chloe Tan Mei Ling', 2023, 'Tekstil & Fabrik', 'Pereka Tekstil Freelance', '011-2233445', 'chloe@example.com', 'Georgetown, Pulau Pinang'),
('Nurul Izzati Bakar', 2020, 'Pereka Fesyen', 'Pengasas, IZZATI Couture', '019-5566778', 'izzati@example.com', 'Johor Bahru, Johor');

-- -----------------------------------------------------
-- Table: portfolio
-- -----------------------------------------------------
DROP TABLE IF EXISTS portfolio;
CREATE TABLE portfolio (
  id INT(11) NOT NULL AUTO_INCREMENT,
  nama_rekaan VARCHAR(150) NOT NULL,
  penerangan TEXT DEFAULT NULL,
  gambar VARCHAR(255) DEFAULT NULL,
  alumni_id INT(11) DEFAULT NULL,
  PRIMARY KEY (id),
  KEY fk_portfolio_alumni (alumni_id),
  CONSTRAINT fk_portfolio_alumni FOREIGN KEY (alumni_id)
    REFERENCES alumni (id) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO portfolio (nama_rekaan, penerangan, alumni_id) VALUES
('Koleksi Cahaya Senja', 'Koleksi busana malam yang diilhamkan warna senja, menggunakan fabrik satin dan songket moden.', 1),
('Urban Monochrome', 'Siri streetwear minimalis dengan palet hitam putih dan potongan oversized.', 2),
('Tenun Warisan', 'Eksplorasi tenun tradisional dalam siluet kontemporari untuk pasaran muda.', 3),
('Bridal Elegance 2024', 'Koleksi gaun pengantin eksklusif dengan butiran lace dan manik tangan.', 4);

-- -----------------------------------------------------
-- Table: kerjaya
-- -----------------------------------------------------
DROP TABLE IF EXISTS kerjaya;
CREATE TABLE kerjaya (
  id INT(11) NOT NULL AUTO_INCREMENT,
  jawatan VARCHAR(150) NOT NULL,
  syarikat VARCHAR(150) NOT NULL,
  lokasi VARCHAR(150) DEFAULT NULL,
  penerangan TEXT DEFAULT NULL,
  tarikh_post DATE NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO kerjaya (jawatan, syarikat, lokasi, penerangan, tarikh_post) VALUES
('Pereka Fesyen Junior', 'Zalora Malaysia', 'Kuala Lumpur', 'Membantu pasukan rekaan menghasilkan koleksi bermusim. Minima Diploma Fesyen.', CURDATE()),
('Fashion Stylist', 'H&M Malaysia', 'Mid Valley, Kuala Lumpur', 'Mengatur gaya untuk photoshoot dan visual merchandising cawangan.', CURDATE()),
('Pattern Maker', 'Bonia Corporation', 'Petaling Jaya, Selangor', 'Menghasilkan pola untuk koleksi pakaian wanita. Pengalaman 2 tahun diutamakan.', CURDATE());

-- -----------------------------------------------------
-- Table: event
-- -----------------------------------------------------
DROP TABLE IF EXISTS event;
CREATE TABLE event (
  id INT(11) NOT NULL AUTO_INCREMENT,
  nama_event VARCHAR(150) NOT NULL,
  tarikh DATE NOT NULL,
  lokasi VARCHAR(150) DEFAULT NULL,
  penerangan TEXT DEFAULT NULL,
  gambar VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO event (nama_event, tarikh, lokasi, penerangan) VALUES
('FAOSC Annual Fashion Gala 2026', '2026-11-20', 'Kuala Lumpur Convention Centre', 'Malam gala tahunan alumni dengan peragaan koleksi terbaik alumni.'),
('Alumni Networking Night', '2026-10-15', 'The Row, KL', 'Sesi santai menjalinkan hubungan antara alumni dan industri.'),
('Bengkel Draping Kreatif', '2026-12-05', 'Kolej Komuniti Kuala Lumpur', 'Bengkel hands-on teknik draping bersama pereka bertauliah.');

-- -----------------------------------------------------
-- Table: contact
-- -----------------------------------------------------
DROP TABLE IF EXISTS contact;
CREATE TABLE contact (
  id INT(11) NOT NULL AUTO_INCREMENT,
  nama VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL,
  mesej TEXT NOT NULL,
  tarikh DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
