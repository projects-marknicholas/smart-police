-- Database Creation
CREATE DATABASE IF NOT EXISTS smart_police_system;
USE smart_police_system;

-- Table: users
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `full_name` VARCHAR(100) NOT NULL,
  `age` INT(11) NOT NULL CHECK (`age` > 0),
  `address` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert example user data (hashed passwords should be used)
INSERT IGNORE INTO `users` (`id`, `username`, `password`, `email`, `full_name`, `age`, `address`, `created_at`) VALUES
(1, 'john_doe', 'hashed_password1', 'john.doe@example.com', 'John Doe', 28, '123 Main St, Los Baños, Laguna', NOW()),
(2, 'jane_smith', 'hashed_password2', 'jane.smith@example.com', 'Jane Smith', 30, '456 Maple Ave, Los Baños, Laguna', NOW());

-- Table: admins
CREATE TABLE IF NOT EXISTS `admins` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert admin data (passwords should be hashed in production)
INSERT IGNORE INTO `admins` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin'),  -- Plain text password (for demo purposes)
(2, 'user', 'user');     -- Plain text password (for demo purposes)

-- Table: incident_reports
CREATE TABLE IF NOT EXISTS `incident_reports` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `location` VARCHAR(255) NOT NULL,
  `incident_type` VARCHAR(255) NOT NULL,
  `incident_date` DATE NOT NULL,
  `incident_time` TIME NOT NULL,
  `latitude` DECIMAL(10, 6) NOT NULL,  
  `longitude` DECIMAL(10, 6) NOT NULL, 
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


-- Insert sample incident report data
INSERT IGNORE INTO `incident_reports` (`id`, `location`, `latitude`, `longitude`, `incident_type`, `incident_date`, `incident_time`, `created_at`) VALUES
(1, 'Barangay Anos, Los Baños, Laguna', 14.1753, 121.2434, 'Car Accident', '2024-10-14', '00:30:00', NOW()),
(2, 'Barangay Anos, Los Baños, Laguna', 14.1754, 121.2436, 'Fire Incident', '2024-10-15', '15:45:00', NOW()),
(3, 'Barangay Batong Malake, Los Baños, Laguna', 14.1657, 121.2480, 'Robbery', '2019-10-19', '02:16:00', NOW()),
(4, 'Barangay Anos, Los Baños, Laguna', 14.1752, 121.2432, 'Car Incident', '2020-07-29', '04:17:00', NOW()),
(5, 'Barangay Anos, Los Baños, Laguna', 14.1751, 121.2431, 'Robbery', '2020-10-18', '00:00:00', NOW()),
(6, 'Barangay Tuntungin, Los Baños, Laguna', 14.1680, 121.2475, 'Robbery', '2021-08-18', '04:06:00', NOW()),
(7, 'Barangay Maahas, Los Baños, Laguna', 14.1612, 121.2500, 'Homicide', '2021-10-18', '00:00:00', NOW()),
(8, 'Barangay Anos, Los Baños, Laguna', 14.1753, 121.2434, 'Homicide', '2024-10-26', '00:00:00', NOW()),
(9, 'Barangay Anos, Los Baños, Laguna', 14.1753, 121.2434, 'Homicide', '2024-10-19', '05:19:00', NOW()),
(10, 'Barangay Anos, Los Baños, Laguna', 14.1753, 121.2434, 'Car Incident', '2024-10-11', '00:00:00', NOW()),
(11, 'Barangay Anos, Los Baños, Laguna', 14.1753, 121.2434, 'Homicide', '2024-10-10', '16:24:00', NOW());

-- Table: police_reports
CREATE TABLE IF NOT EXISTS `police_reports` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `age` INT(11) NOT NULL CHECK (`age` > 0),
  `address` VARCHAR(255) NOT NULL,
  `offense` VARCHAR(255) NOT NULL,
  `date_of_case` DATE NOT NULL,
  `report_time` TIME NOT NULL,  -- Added time field for reporting time
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert sample police report data
INSERT IGNORE INTO `police_reports` (`id`, `name`, `age`, `address`, `offense`, `date_of_case`, `report_time`, `created_at`) VALUES
(1, 'Juan Dela Cruz', 30, '123 Barangay St.', 'Car Theft', '2024-06-21', '10:30:00', NOW()),
(2, 'Pedro Penduko', 24, 'Brgy. Anos', 'Robbery', '2024-10-18', '14:45:00', NOW()),
(3, 'San Juan', 25, 'Brgy. Anos', 'Robbery', '2024-10-12', '11:15:00', NOW()),
(4, 'Trtrtrtrtrtrtrtrt', 24, 'Brgy. Anos, Los Baños, Laguna', 'Robbery', '2024-10-26', '09:30:00', NOW()),
(5, 'Hahahaha', 20, 'Brgy. Maahas, Los Baños, Laguna', 'Homicide', '2024-06-26', '16:50:00', NOW()),
(6, 'Pena', 52, 'Brgy. Maahas, Los Baños, Laguna', 'Sexual Offenses', '2024-10-11', '13:20:00', NOW());

-- Table: barangay_locations
CREATE TABLE IF NOT EXISTS `barangay_locations` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `barangay_name` VARCHAR(50) NOT NULL,
    `latitude` DECIMAL(9,6) NOT NULL,
    `longitude` DECIMAL(9,6) NOT NULL,
    `officer_name` VARCHAR(50) NOT NULL
);

-- Insert barangay location data
INSERT INTO `barangay_locations` (barangay_name, latitude, longitude, officer_name) VALUES
('Anos', 14.1767, 121.2478, 'Officer A'),
('Bagong Silang', 14.1781, 121.2530, 'Officer B'),
('Bambang', 14.1799, 121.2417, 'Officer C'),
('Batong Malake', 14.1659, 121.2443, 'Officer D'),
('Baybayin', 14.1791, 121.2399, 'Officer E'),
('Bayog', 14.1554, 121.2421, 'Officer F'),
('Lalakay', 14.1724, 121.2497, 'Officer G'),
('Maahas', 14.1602, 121.2509, 'Officer H'),
('Malinta', 14.1521, 121.2412, 'Officer I'),
('Mayondon', 14.1836, 121.2342, 'Officer J'),
('Putho Tuntungin', 14.1674, 121.2465, 'Officer K'),
('San Antonio', 14.1808, 121.2306, 'Officer L'),
('Tadlak', 14.1845, 121.2272, 'Officer M'),
('Timugan', 14.1745, 121.2426, 'Officer N');

-- View: crime_statistics_view
-- Creates a dynamic view for crime statistics based on incident type
CREATE OR REPLACE VIEW `crime_statistics_view` AS
SELECT 
    `incident_type` AS `crime_type`,
    COUNT(*) AS `number_of_cases`,
    DATE_FORMAT(`incident_date`, '%Y') AS `year_recorded`
FROM `incident_reports`
GROUP BY `crime_type`, `year_recorded`
ORDER BY `year_recorded` DESC;

-- Set AUTO_INCREMENT values for tables
ALTER TABLE `admins` AUTO_INCREMENT = 3;  -- Updated based on the last inserted ID
ALTER TABLE `incident_reports` AUTO_INCREMENT = 12;  -- Based on the last inserted ID
ALTER TABLE `police_reports` AUTO_INCREMENT = 7;  -- Based on the last inserted ID
