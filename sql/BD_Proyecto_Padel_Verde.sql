-- Padel Verde - Corrected SQL dump (3 courts, roles: admin/user) with sample data
DROP DATABASE IF EXISTS padel_verde;
CREATE DATABASE padel_verde CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE padel_verde;

-- Table: roles (only admin and user)
CREATE TABLE roles (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50) NOT NULL
) ENGINE=InnoDB;

INSERT INTO roles (name) VALUES ('admin'), ('user');

-- Table: users (10 sample users)
CREATE TABLE users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(120) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  phone VARCHAR(30),
  level TINYINT UNSIGNED NOT NULL,
  role_id INT UNSIGNED NOT NULL,
  active TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE RESTRICT
) ENGINE=InnoDB;

INSERT INTO users (full_name, email, password_hash, phone, level, role_id) VALUES
('Admin Padel', 'admin@padelverde.local', '$2y$10$adminhashxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx', '600000001', 3, 1),
('Juan Pérez', 'juan.perez@example.com', '$2y$10$hashjuanxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx', '600000002', 1, 2),
('María López', 'maria.lopez@example.com', '$2y$10$hashmariaxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx', '600000003', 2, 2),
('Carlos García', 'carlos.garcia@example.com', '$2y$10$hashcarlosxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx', '600000004', 3, 2),
('Ana Martínez', 'ana.martinez@example.com', '$2y$10$hashanaxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx', '600000005', 4, 2),
('Lucía Fernández', 'lucia.fernandez@example.com', '$2y$10$hashluciaxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx', '600000006', 5, 2),
('Pedro Sánchez', 'pedro.sanchez@example.com', '$2y$10$hashpedroxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx', '600000007', 2, 2),
('Sofía Ruiz', 'sofia.ruiz@example.com', '$2y$10$hashsofiaxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx', '600000008', 3, 2),
('Diego Torres', 'diego.torres@example.com', '$2y$10$hashdiegoxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx', '600000009', 1, 2),
('Elena Gómez', 'elena.gomez@example.com', '$2y$10$hashelenaxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx', '600000010', 4, 2);

-- Table: courts (only 3 as specified)
CREATE TABLE courts (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(80) NOT NULL,
  description VARCHAR(255),
  max_players TINYINT UNSIGNED NOT NULL DEFAULT 4
) ENGINE=InnoDB;

INSERT INTO courts (name, description, max_players) VALUES
('Pista 1', 'Pista principal cubierta', 4),
('Pista 2', 'Pista exterior', 4),
('Pista 3', 'Pista entrenamiento', 4);

-- Table: reservations (sample, non-overlapping within each court)
CREATE TABLE reservations (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id INT UNSIGNED NOT NULL,
  court_id INT UNSIGNED NOT NULL,
  start_datetime DATETIME NOT NULL,
  duration_hours TINYINT UNSIGNED NOT NULL,
  status ENUM('confirmed','cancelled') NOT NULL DEFAULT 'confirmed',
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (court_id) REFERENCES courts(id) ON DELETE CASCADE,
  INDEX idx_court_start (court_id, start_datetime)
) ENGINE=InnoDB;

-- Distribute 12 reservations across the 3 courts, ensuring no overlaps per court
INSERT INTO reservations (user_id, court_id, start_datetime, duration_hours) VALUES
(2, 1, '2025-11-20 10:00:00', 1),
(3, 1, '2025-11-20 11:00:00', 1),
(4, 1, '2025-11-20 12:00:00', 1),
(5, 2, '2025-11-21 09:00:00', 2),
(6, 2, '2025-11-21 11:00:00', 1),
(7, 2, '2025-11-21 12:00:00', 1),
(8, 3, '2025-11-22 15:00:00', 2),
(9, 3, '2025-11-22 17:00:00', 1),
(10,3, '2025-11-23 09:00:00', 1),
(2, 1, '2025-11-24 08:00:00', 1),
(3, 2, '2025-11-24 10:00:00', 2),
(4, 3, '2025-11-24 12:00:00', 1);

-- Table: reservation_players (join table)
CREATE TABLE reservation_players (
  reservation_id INT UNSIGNED NOT NULL,
  user_id INT UNSIGNED NOT NULL,
  joined_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  is_owner TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (reservation_id, user_id),
  FOREIGN KEY (reservation_id) REFERENCES reservations(id) ON DELETE CASCADE,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Associate players (owner + participants) for the reservations
INSERT INTO reservation_players (reservation_id, user_id, is_owner) VALUES
(1, 2, 1),
(1, 3, 0),
(2, 3, 1),
(2, 4, 0),
(3, 4, 1),
(3, 2, 0),
(4, 5, 1),
(4, 6, 0),
(5, 6, 1),
(6, 7, 1),
(7, 8, 1),
(7, 9, 0),
(8, 9, 1),
(9,10,1),
(10,2,1),
(11,3,1),
(11,4,0),
(12,4,1);

-- Simple index example
CREATE INDEX idx_user_created ON users(created_at);

-- End of corrected script