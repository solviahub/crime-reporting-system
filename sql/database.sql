-- database.sql
CREATE DATABASE IF NOT EXISTS crime_reporting_system;
USE crime_reporting_system;

-- Users table
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100),
    phone VARCHAR(20),
    role ENUM('user', 'admin', 'super_admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Crime reports table
CREATE TABLE crime_reports (
    id INT PRIMARY KEY AUTO_INCREMENT,
    report_id VARCHAR(20) UNIQUE NOT NULL,
    user_id INT NULL,
    name VARCHAR(100),
    email VARCHAR(100),
    crime_type VARCHAR(50) NOT NULL,
    description TEXT NOT NULL,
    location VARCHAR(255) NOT NULL,
    latitude DECIMAL(10, 8),
    longitude DECIMAL(11, 8),
    incident_date DATE NOT NULL,
    incident_time TIME NOT NULL,
    image_path VARCHAR(255),
    status ENUM('pending', 'under_investigation', 'resolved') DEFAULT 'pending',
    is_anonymous TINYINT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_report_id (report_id),
    INDEX idx_status (status),
    INDEX idx_crime_type (crime_type)
);

-- SOS emergencies table
CREATE TABLE sos_emergencies (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NULL,
    name VARCHAR(100),
    phone VARCHAR(20),
    location VARCHAR(255),
    latitude DECIMAL(10, 8),
    longitude DECIMAL(11, 8),
    status ENUM('active', 'responded', 'resolved') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Report comments/updates table
CREATE TABLE report_updates (
    id INT PRIMARY KEY AUTO_INCREMENT,
    report_id INT NOT NULL,
    admin_id INT NOT NULL,
    comment TEXT,
    old_status VARCHAR(50),
    new_status VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (report_id) REFERENCES crime_reports(id) ON DELETE CASCADE,
    FOREIGN KEY (admin_id) REFERENCES users(id)
);

-- Notifications table
CREATE TABLE notifications (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NULL,
    report_id INT NULL,
    title VARCHAR(255),
    message TEXT,
    is_read TINYINT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (report_id) REFERENCES crime_reports(id) ON DELETE CASCADE
);

-- Insert default admin user (password: admin123)
INSERT INTO users (username, email, password, full_name, role) 
VALUES ('admin', 'admin@crimesystem.com', '$2y$10$YourHashedPasswordHere', 'System Administrator', 'super_admin');