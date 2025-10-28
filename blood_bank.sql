-- ================================================================================
-- BLOOD BANK MANAGEMENT SYSTEM - COMPLETE DATABASE WITH DEMO DATA
-- ================================================================================
-- This file includes:
-- 1. Database creation
-- 2. All table structures
-- 3. Default admin account
-- 4. Sample blood banks
-- 5. Blood inventory
-- 6. Demo users, hospitals, donations, orders, and feedback
-- ================================================================================

-- Create Database
CREATE DATABASE IF NOT EXISTS blood_bank_db;
USE blood_bank_db;

-- ================================================================================
-- TABLE STRUCTURES
-- ================================================================================

-- Users Table (for donors and patients)
CREATE TABLE IF NOT EXISTS users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    blood_group VARCHAR(5) NOT NULL,
    gender ENUM('Male', 'Female', 'Other') NOT NULL,
    date_of_birth DATE NOT NULL,
    address TEXT NOT NULL,
    city VARCHAR(50) NOT NULL,
    state VARCHAR(50) NOT NULL,
    is_donor BOOLEAN DEFAULT FALSE,
    last_donation_date DATE,
    is_blocked BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Hospitals Table
CREATE TABLE IF NOT EXISTS hospitals (
    hospital_id INT AUTO_INCREMENT PRIMARY KEY,
    hospital_name VARCHAR(150) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    address TEXT NOT NULL,
    city VARCHAR(50) NOT NULL,
    state VARCHAR(50) NOT NULL,
    license_number VARCHAR(50) UNIQUE NOT NULL,
    is_blocked BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Admins Table
CREATE TABLE IF NOT EXISTS admins (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Blood Banks Table
CREATE TABLE IF NOT EXISTS blood_banks (
    blood_bank_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    address TEXT NOT NULL,
    city VARCHAR(50) NOT NULL,
    state VARCHAR(50) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Blood Inventory Table
CREATE TABLE IF NOT EXISTS blood_inventory (
    inventory_id INT AUTO_INCREMENT PRIMARY KEY,
    blood_bank_id INT NOT NULL,
    blood_group VARCHAR(5) NOT NULL,
    units_available INT DEFAULT 0,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (blood_bank_id) REFERENCES blood_banks(blood_bank_id) ON DELETE CASCADE
);

-- Blood Donations Table
CREATE TABLE IF NOT EXISTS blood_donations (
    donation_id INT AUTO_INCREMENT PRIMARY KEY,
    donor_id INT NOT NULL,
    blood_bank_id INT NOT NULL,
    blood_group VARCHAR(5) NOT NULL,
    units INT DEFAULT 1,
    donation_date DATE NOT NULL,
    status ENUM('Pending', 'Approved', 'Rejected') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (donor_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (blood_bank_id) REFERENCES blood_banks(blood_bank_id) ON DELETE CASCADE
);

-- Blood Orders Table
CREATE TABLE IF NOT EXISTS blood_orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    requester_type ENUM('User', 'Hospital') NOT NULL,
    requester_id INT NOT NULL,
    blood_group VARCHAR(5) NOT NULL,
    units INT NOT NULL,
    urgency ENUM('Low', 'Medium', 'High', 'Critical') DEFAULT 'Medium',
    source_type ENUM('BloodBank', 'Donor') NOT NULL,
    source_id INT NOT NULL,
    status ENUM('Pending', 'Approved', 'Rejected', 'Completed') DEFAULT 'Pending',
    order_date DATE NOT NULL,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Feedback Table
CREATE TABLE IF NOT EXISTS feedback (
    feedback_id INT AUTO_INCREMENT PRIMARY KEY,
    sender_type ENUM('User', 'Hospital') NOT NULL,
    sender_id INT NOT NULL,
    subject VARCHAR(200) NOT NULL,
    message TEXT NOT NULL,
    status ENUM('Pending', 'Reviewed', 'Resolved') DEFAULT 'Pending',
    admin_response TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ================================================================================
-- DEFAULT DATA (REQUIRED)
-- ================================================================================

-- Insert Default Admin Account
INSERT INTO admins (username, password, email) VALUES 
('admin', MD5('admin123'), 'admin@bloodbank.com');

-- Insert Sample Blood Banks
INSERT INTO blood_banks (name, address, city, state, phone, email) VALUES
('Dhaka Central Blood Bank', 'Sher-e-Bangla Nagar', 'Dhaka', 'Dhaka Division', '02-9122789', 'central@bloodbank.bd'),
('Chittagong Blood Transfusion Center', 'Agrabad Access Road', 'Chittagong', 'Chittagong Division', '031-2511234', 'chittagong@bloodbank.bd'),
('Sylhet Regional Blood Bank', 'Shahjalal Upashahar', 'Sylhet', 'Sylhet Division', '0821-725456', 'sylhet@bloodbank.bd');

-- Insert Sample Blood Inventory
INSERT INTO blood_inventory (blood_bank_id, blood_group, units_available) VALUES
(1, 'A+', 25), (1, 'A-', 10), (1, 'B+', 20), (1, 'B-', 8), 
(1, 'AB+', 15), (1, 'AB-', 5), (1, 'O+', 30), (1, 'O-', 12),
(2, 'A+', 18), (2, 'A-', 7), (2, 'B+', 22), (2, 'B-', 6),
(2, 'AB+', 12), (2, 'AB-', 4), (2, 'O+', 28), (2, 'O-', 10),
(3, 'A+', 20), (3, 'A-', 9), (3, 'B+', 16), (3, 'B-', 7),
(3, 'AB+', 11), (3, 'AB-', 3), (3, 'O+', 25), (3, 'O-', 8);

-- ================================================================================
-- DEMO DATA (OPTIONAL BUT RECOMMENDED)
-- ================================================================================

-- Insert Sample Users (Donors and Patients)
INSERT INTO users (full_name, email, password, phone, blood_group, gender, date_of_birth, address, city, state, is_donor, last_donation_date) VALUES
('Md. Rakibul Islam', 'rakib.islam@email.com', MD5('password123'), '01712345678', 'O+', 'Male', '1990-05-15', 'House 12, Road 5, Dhanmondi', 'Dhaka', 'Dhaka Division', 1, '2024-12-15'),
('Fatima Rahman', 'fatima.rahman@email.com', MD5('password123'), '01823456789', 'A+', 'Female', '1988-08-22', 'Flat 3B, Green View Apartments, Agrabad', 'Chittagong', 'Chittagong Division', 1, '2024-11-20'),
('Abdullah Al Mahmud', 'abdullah.mahmud@email.com', MD5('password123'), '01934567890', 'B+', 'Male', '1992-03-10', 'House 25, Shahjalal Upashahar', 'Sylhet', 'Sylhet Division', 1, '2025-01-05'),
('Nusrat Jahan', 'nusrat.jahan@email.com', MD5('password123'), '01645678901', 'AB+', 'Female', '1995-11-30', 'Plot 8, Sector 7, Uttara', 'Dhaka', 'Dhaka Division', 1, '2024-10-12'),
('Kamal Hossain', 'kamal.hossain@email.com', MD5('password123'), '01756789012', 'O-', 'Male', '1987-07-18', 'House 45, Kazir Dewri', 'Chittagong', 'Chittagong Division', 1, '2024-12-01'),
('Ayesha Siddika', 'ayesha.siddika@email.com', MD5('password123'), '01867890123', 'A-', 'Female', '1993-02-25', 'Flat 2A, Lalmatia Housing', 'Dhaka', 'Dhaka Division', 1, NULL),
('Tanvir Ahmed', 'tanvir.ahmed@email.com', MD5('password123'), '01978901234', 'B-', 'Male', '1991-09-14', 'House 18, Boalia', 'Rajshahi', 'Rajshahi Division', 1, '2024-11-15'),
('Sabrina Khatun', 'sabrina.khatun@email.com', MD5('password123'), '01589012345', 'AB-', 'Female', '1989-12-05', 'Flat 5C, Banani DOHS', 'Dhaka', 'Dhaka Division', 1, NULL),
('Sohel Rana', 'sohel.rana@email.com', MD5('password123'), '01690123456', 'O+', 'Male', '1994-04-20', 'House 7, Khan Jahan Ali Road', 'Khulna', 'Khulna Division', 0, NULL),
('Sharmin Akter', 'sharmin.akter@email.com', MD5('password123'), '01701234567', 'A+', 'Female', '1996-06-08', 'Flat 4D, Gulshan Avenue', 'Dhaka', 'Dhaka Division', 0, NULL),
('Mahmudul Hasan', 'mahmudul.hasan@email.com', MD5('password123'), '01812345678', 'B+', 'Male', '1985-01-30', 'House 33, Oxygen Mor', 'Chittagong', 'Chittagong Division', 1, '2024-09-25'),
('Taslima Begum', 'taslima.begum@email.com', MD5('password123'), '01923456789', 'AB+', 'Female', '1992-10-12', 'Plot 15, Mirpur DOHS', 'Dhaka', 'Dhaka Division', 0, NULL),
('Farhan Kabir', 'farhan.kabir@email.com', MD5('password123'), '01534567890', 'O-', 'Male', '1990-08-17', 'House 22, Zindabazar', 'Sylhet', 'Sylhet Division', 1, '2024-12-20'),
('Rumana Yasmin', 'rumana.yasmin@email.com', MD5('password123'), '01645678902', 'A-', 'Female', '1993-03-28', 'Flat 6A, Bashundhara R/A', 'Dhaka', 'Dhaka Division', 1, NULL),
('Imran Khan', 'imran.khan@email.com', MD5('password123'), '01756789013', 'B-', 'Male', '1988-11-09', 'House 11, Natun Bazar', 'Barisal', 'Barisal Division', 0, NULL);

-- Insert Sample Hospitals
INSERT INTO hospitals (hospital_name, email, password, phone, address, city, state, license_number) VALUES
('Dhaka Medical College Hospital', 'admin@dmch.gov.bd', MD5('hospital123'), '02-8626812', 'Secretariat Road, Ramna', 'Dhaka', 'Dhaka Division', 'DGHS-DH-2020-001'),
('Chittagong Medical College Hospital', 'contact@cmch.gov.bd', MD5('hospital123'), '031-2620231', 'Medical College Road, Panchlaish', 'Chittagong', 'Chittagong Division', 'DGHS-CH-2019-045'),
('Square Hospital Dhaka', 'info@squarehospital.com', MD5('hospital123'), '02-8159457', '18/F, Bir Uttam Qazi Nuruzzaman Sarak, Panthapath', 'Dhaka', 'Dhaka Division', 'DGHS-DH-2021-089'),
('Evercare Hospital Dhaka', 'emergency@evercarehospital.com', MD5('hospital123'), '10678', 'Plot 81, Block E, Bashundhara R/A', 'Dhaka', 'Dhaka Division', 'DGHS-DH-2018-123'),
('Popular Diagnostic Centre', 'admin@populardiagnostic.com', MD5('hospital123'), '09666710678', '2 English Road, Gandaria, Dhaka', 'Dhaka', 'Dhaka Division', 'DGHS-DH-2020-067');

-- Insert Sample Blood Donations
INSERT INTO blood_donations (donor_id, blood_bank_id, blood_group, units, donation_date, status) VALUES
(1, 1, 'O+', 1, '2024-12-15', 'Approved'),
(2, 2, 'A+', 1, '2024-11-20', 'Approved'),
(3, 3, 'B+', 1, '2025-01-05', 'Approved'),
(4, 1, 'AB+', 1, '2024-10-12', 'Approved'),
(5, 2, 'O-', 1, '2024-12-01', 'Approved'),
(6, 1, 'A-', 1, '2025-01-10', 'Pending'),
(7, 3, 'B-', 1, '2024-11-15', 'Approved'),
(8, 2, 'AB-', 1, '2025-01-08', 'Pending'),
(11, 1, 'B+', 1, '2024-09-25', 'Approved'),
(13, 3, 'O-', 1, '2024-12-20', 'Approved'),
(14, 2, 'A-', 1, '2025-01-12', 'Pending'),
(1, 2, 'O+', 1, '2024-08-10', 'Approved'),
(2, 1, 'A+', 1, '2024-07-05', 'Approved'),
(3, 3, 'B+', 1, '2024-09-18', 'Approved'),
(4, 2, 'AB+', 1, '2024-06-22', 'Approved');

-- Insert Sample Blood Orders from Users
INSERT INTO blood_orders (requester_type, requester_id, blood_group, units, urgency, source_type, source_id, order_date, notes, status) VALUES
('User', 9, 'O+', 2, 'High', 'BloodBank', 1, '2025-01-15', 'Need for emergency surgery', 'Approved'),
('User', 10, 'A+', 1, 'Medium', 'BloodBank', 2, '2025-01-14', 'Regular transfusion required', 'Pending'),
('User', 12, 'AB+', 1, 'Critical', 'BloodBank', 1, '2025-01-16', 'Urgent! Accident case', 'Approved'),
('User', 15, 'B-', 2, 'High', 'BloodBank', 3, '2025-01-13', 'Surgery scheduled tomorrow', 'Completed'),
('User', 9, 'O+', 1, 'Low', 'Donor', 1, '2025-01-12', 'For planned treatment', 'Rejected'),
('User', 10, 'A+', 2, 'Medium', 'Donor', 2, '2025-01-11', 'Requesting from compatible donor', 'Pending');

-- Insert Sample Blood Orders from Hospitals
INSERT INTO blood_orders (requester_type, requester_id, blood_group, units, urgency, source_type, source_id, order_date, notes, status) VALUES
('Hospital', 1, 'O-', 5, 'Critical', 'BloodBank', 1, '2025-01-16', 'Multiple trauma patients admitted', 'Approved'),
('Hospital', 2, 'A+', 3, 'High', 'BloodBank', 2, '2025-01-15', 'Thalassemia patients transfusion', 'Approved'),
('Hospital', 3, 'B+', 4, 'Medium', 'BloodBank', 3, '2025-01-14', 'Scheduled surgeries this week', 'Pending'),
('Hospital', 4, 'AB+', 2, 'High', 'BloodBank', 1, '2025-01-13', 'Cancer patients chemotherapy', 'Completed'),
('Hospital', 5, 'O+', 6, 'Critical', 'BloodBank', 2, '2025-01-16', 'Emergency department stock', 'Approved'),
('Hospital', 1, 'A-', 2, 'Medium', 'BloodBank', 1, '2025-01-12', 'ICU patients requirement', 'Completed'),
('Hospital', 2, 'B-', 1, 'Low', 'BloodBank', 3, '2025-01-11', 'Routine stock replenishment', 'Pending'),
('Hospital', 3, 'AB-', 1, 'High', 'BloodBank', 2, '2025-01-10', 'Rare blood type needed', 'Approved');

-- Insert Sample Feedback from Users
INSERT INTO feedback (sender_type, sender_id, subject, message, status, admin_response) VALUES
('User', 1, 'Great Service!', 'I had a wonderful experience donating blood. The staff was very professional and caring. Thank you for making it easy to save lives!', 'Resolved', 'Thank you for your positive feedback! We are glad you had a great experience. Your contribution helps save lives.'),
('User', 9, 'Website Navigation Issue', 'I found it difficult to locate the blood inventory page. Could you make it more prominent on the dashboard?', 'Reviewed', 'Thank you for your suggestion. We will consider improving the navigation in our next update.'),
('User', 10, 'Suggestion for Notification System', 'It would be great if we could receive email notifications when our blood order is approved or when someone needs our blood type urgently.', 'Pending', NULL),
('User', 12, 'Quick Response Appreciated', 'My blood order was processed very quickly during an emergency. I am grateful for the efficient system. Keep up the good work!', 'Resolved', 'We are happy we could help during your emergency. Thank you for your feedback!'),
('User', 15, 'Donor Certificate Request', 'Is it possible to get a digital donor certificate after each donation? It would be nice to have for our records.', 'Reviewed', 'Great suggestion! We are working on implementing digital certificates for donors.');

-- Insert Sample Feedback from Hospitals
INSERT INTO feedback (sender_type, sender_id, subject, message, status, admin_response) VALUES
('Hospital', 1, 'Excellent Blood Supply', 'The blood bank system has been very reliable. We receive timely responses to our requests and the quality is always maintained.', 'Resolved', 'Thank you for your continued partnership. We strive to maintain the highest standards.'),
('Hospital', 2, 'Request for Bulk Order Feature', 'We often need to order multiple blood types at once. A bulk order feature would save us time.', 'Reviewed', 'Thank you for the suggestion. We are evaluating the implementation of bulk ordering.'),
('Hospital', 3, 'Urgent Blood Request Process', 'During critical emergencies, the approval process could be faster. Perhaps a direct hotline for critical cases?', 'Pending', NULL),
('Hospital', 5, 'Inventory Update Frequency', 'Sometimes the inventory shown online is not updated in real-time. Could you improve the update frequency?', 'Reviewed', 'We are working on real-time inventory synchronization. Thank you for bringing this to our attention.');

-- ================================================================================
-- SUCCESS MESSAGE
-- ================================================================================

SELECT '================================================================================';
SELECT '✓ DATABASE SETUP COMPLETED SUCCESSFULLY!' as Status;
SELECT '================================================================================';
SELECT 'Database: blood_bank_db' as Info;
SELECT '8 tables created' as Info;
SELECT '1 admin account' as Info;
SELECT '3 blood banks with full inventory' as Info;
SELECT '15 demo users (11 donors)' as Info;
SELECT '5 demo hospitals' as Info;
SELECT '15 donation records' as Info;
SELECT '14 blood orders' as Info;
SELECT '9 feedback entries' as Info;
SELECT '================================================================================';
SELECT 'LOGIN CREDENTIALS:' as Info;
SELECT 'Admin: admin / admin123' as Credentials
UNION ALL SELECT 'User: rakib.islam@email.com / password123'
UNION ALL SELECT 'Hospital: admin@dmch.gov.bd / hospital123';
SELECT '================================================================================';
SELECT 'Access your project at: http://localhost/370-Project/' as Info;
SELECT '================================================================================';

