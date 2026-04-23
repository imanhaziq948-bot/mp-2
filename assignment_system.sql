CREATE DATABASE IF NOT EXISTS assignment_system;
USE assignment_system;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'student') DEFAULT 'student'
);

CREATE TABLE assignments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT
);

CREATE TABLE submissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    assignment_id INT,
    file_name VARCHAR(255) NOT NULL,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (assignment_id) REFERENCES assignments(id)
);

-- Default Admin Account (Password: admin123)
INSERT INTO users (name, email, password, role) VALUES 
('System Admin', 'admin@mail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Sample Assignments for AJAX testing
INSERT INTO assignments (title, description) VALUES 
('PHP Mini Project 1', 'Basics of PHP'),
('Database Design', 'ERD and Normalization'),
('Bootstrap Layouts', 'Responsive Web Design');
