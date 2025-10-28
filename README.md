# Blood Bank Management System 🩸

A comprehensive web-based Blood Bank Management System built with PHP and MySQL that simplifies the process of finding blood in emergencies.

## 📋 Project Overview

This system allows users to:
- Find blood in emergency situations
- Donate blood at their convenience
- Request blood from blood banks or individual donors
- Manage blood inventory across multiple blood banks
- Provide feedback and register complaints

## ✨ Features

### User Features
- **User Registration & Login**: Secure authentication for users and donors
- **Profile Management**: Update personal information and donor status
- **Blood Donation**: Schedule donations at nearby blood banks
- **Blood Ordering**: Request blood from blood banks or individual donors
- **Donation History**: Track all blood donation activities
- **Order History**: View all blood order requests
- **Feedback System**: Submit feedback and complaints to administrators

### Hospital Features
- **Hospital Registration & Login**: Separate authentication for hospitals
- **Hospital Profile**: Manage hospital information
- **Blood Ordering**: Request blood for patients
- **Order Management**: Track blood order history
- **Blood Inventory View**: Check available blood units across blood banks
- **Feedback System**: Send feedback to administrators

### Admin Features
- **Comprehensive Dashboard**: Overview of all system activities
- **User Management**: View and block/unblock users
- **Donor Management**: Monitor all registered donors
- **Hospital Management**: Manage hospital accounts
- **Blood Bank Management**: View all blood banks in the system
- **Donation Management**: Approve or reject donation requests
- **Order Management**: Process blood order requests
- **Feedback Management**: Respond to user and hospital feedback
- **Inventory Management**: Update blood inventory across blood banks

## 🛠️ Technology Stack

- **Frontend**: HTML5, CSS3, JavaScript
- **Backend**: PHP
- **Database**: MySQL
- **Server**: XAMPP (Apache, MySQL)

## 📁 Project Structure

```
blood-bank-management/
├── admin/                        # Admin panel pages
│   ├── dashboard.php
│   ├── manage_users.php
│   ├── manage_donors.php
│   ├── manage_hospitals.php
│   ├── manage_blood_banks.php
│   ├── manage_donations.php
│   ├── manage_orders.php
│   ├── manage_feedback.php
│   ├── blood_inventory.php
│   └── sidebar.php
├── user/                         # User dashboard pages
│   ├── dashboard.php
│   ├── profile.php
│   ├── donate_blood.php
│   ├── order_blood.php
│   ├── my_donations.php
│   ├── my_orders.php
│   ├── feedback.php
│   └── sidebar.php
├── hospital/                     # Hospital dashboard pages
│   ├── dashboard.php
│   ├── profile.php
│   ├── order_blood.php
│   ├── my_orders.php
│   ├── blood_inventory.php
│   ├── feedback.php
│   └── sidebar.php
├── config/                       # Configuration files
│   ├── db_connect.php
│   └── session.php
├── assets/                       # Static assets
│   └── css/
│       └── style.css
├── index.php                     # Landing page
├── login.php                     # Login page
├── register.php                  # Registration page
├── logout.php                    # Logout handler
├── blood_bank.sql                # Complete database with demo data
├── DEMO_CREDENTIALS.txt          # Quick reference for login
└── README.md                     # This file
```

## 🚀 Installation & Setup

### Prerequisites
- XAMPP (or any Apache + MySQL + PHP environment)
- Web browser
- Text editor (optional, for customization)

### Step-by-Step Installation

#### 1. Install XAMPP
- Download XAMPP from [https://www.apachefriends.org/](https://www.apachefriends.org/)
- Install XAMPP on your system
- Start Apache and MySQL from XAMPP Control Panel

#### 2. Download the Project
- Download or clone this project
- Extract the files to a folder (e.g., `blood-bank-management`)

#### 3. Move Project to XAMPP
- Copy the project folder to your XAMPP's `htdocs` directory
  - Windows: `C:\xampp\htdocs\`
  - Mac: `/Applications/XAMPP/htdocs/`
  - Linux: `/opt/lampp/htdocs/`

#### 4. Create Database

1. Open your web browser
2. Go to `http://localhost/phpmyadmin`
3. Click on "Import" tab from the top menu
4. Click "Choose File" and select `blood_bank.sql`
5. Click "Go" to import everything at once

This single file creates the database, tables, and includes all demo data!

#### 5. Configure Database Connection
The database configuration is already set in `config/db_connect.php`:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'blood_bank_db');
```

If your MySQL has a different username/password, update these values.

#### 6. Access the Application
Open your web browser and navigate to:
```
http://localhost/blood-bank-management/
```
Or if your folder is named `370-Project`:
```
http://localhost/370-Project/
```

## 🔐 Login Credentials

### Admin Account
- **Username**: `admin`
- **Password**: `admin123`

### Demo User Accounts
- **Email**: `samiha.haque@email.com` | **Password**: `password123` (Patient - AB+, Dhaka)
- **Email**: `farhan.kabir@email.com` | **Password**: `password123` (Donor - O-, Sylhet)
- **Email**: `ahmed.khan@email.com` | **Password**: `password123` (Donor - B+, Chittagong)
- **Email**: `isha.agerwal@email.com` | **Password**: `password123` (Patient - A+, Dhaka)

### Demo Hospital Accounts
- **Email**: `admin@dmch.gov.bd` | **Password**: `hospital123` (Dhaka Medical College)
- **Email**: `contact@cmch.gov.bd` | **Password**: `hospital123` (Chittagong Medical College)
- **Email**: `info@squarehospital.com` | **Password**: `hospital123` (Square Hospital Dhaka)

### Or Register New Account
You can also register a new user or hospital account through the registration page.

## 📖 How to Use

### For Users/Donors
1. **Register**: Click "Register" and select "User/Donor"
2. **Fill Details**: Enter your personal information
3. **Login**: Use your email and password to login
4. **Donate Blood**: Navigate to "Donate Blood" and select a blood bank
5. **Order Blood**: Go to "Order Blood" to request blood
6. **Track**: View your donation and order history

### For Hospitals
1. **Register**: Click "Register" and select "Hospital"
2. **Fill Details**: Enter hospital information and license number
3. **Login**: Use hospital email and password
4. **Order Blood**: Request blood for patients
5. **View Inventory**: Check available blood units
6. **Track Orders**: Monitor order status

### For Administrators
1. **Login**: Use admin credentials
2. **Dashboard**: View system statistics
3. **Manage**: Access various management pages from sidebar
4. **Approve**: Process donation and order requests
5. **Respond**: Handle user feedback and complaints

## 🩸 Blood Groups Supported
- A+
- A-
- B+
- B-
- AB+
- AB-
- O+
- O-

## 📊 Database Schema

### Main Tables
- `users` - User and donor information
- `hospitals` - Hospital accounts
- `admins` - Administrator accounts
- `blood_banks` - Blood bank locations
- `blood_inventory` - Blood stock management
- `blood_donations` - Donation records
- `blood_orders` - Blood order requests
- `feedback` - User and hospital feedback

## 🔒 Security Features
- Password encryption using MD5
- Session-based authentication
- SQL injection prevention
- User blocking functionality for admins
- Role-based access control

## 🎨 User Interface
- Modern and responsive design
- Mobile-friendly layout
- Intuitive navigation
- Color-coded status badges
- Clean and professional appearance

## 🐛 Troubleshooting

### Database Connection Error
- Verify XAMPP MySQL is running
- Check database credentials in `config/db_connect.php`
- Ensure database `blood_bank_db` exists

### Page Not Found (404)
- Check project folder is in `htdocs`
- Verify the URL path matches your folder name
- Ensure Apache is running in XAMPP

### Cannot Login
- Verify you imported the database correctly
- Check if admin account exists in `admins` table
- Clear browser cache and try again

### Blank Page
- Enable PHP error reporting
- Check PHP error logs in XAMPP
- Verify all files are uploaded correctly

## 📝 Additional Notes

### Database File

**blood_bank.sql** - Complete All-in-One Setup
- Creates database `blood_bank_db`
- Creates all 8 tables with proper relationships
- 1 default admin account (admin/admin123)
- 3 blood banks with full inventory (72 records covering all blood groups)
- 15 sample users (11 donors + 4 patients)
- 5 sample hospitals (real Bangladeshi hospitals)
- 15 blood donation records
- 14 blood order requests
- 9 feedback entries with admin responses
- **Everything you need in one file!**

### Password Security
For production use, consider upgrading from MD5 to more secure hashing algorithms like:
- `password_hash()` with bcrypt
- Argon2

### Customization
- Modify `assets/css/style.css` for styling changes
- Update database configuration as needed
- Add more blood banks through admin panel

## 🤝 Support
For issues or questions:
- Check the troubleshooting section
- Review the database schema
- Verify XAMPP configuration

## 📄 License
This project is created for educational purposes.

## 👥 User Roles Summary

| Role | Can Register | Needs Approval | Can Donate | Can Order | Can Manage |
|------|--------------|----------------|------------|-----------|------------|
| User/Donor | ✓ | ✗ | ✓ | ✓ | ✗ |
| Hospital | ✓ | ✗ | ✗ | ✓ | ✗ |
| Admin | ✗ | N/A | ✗ | ✗ | ✓ |

## 🎯 Key Functionalities

1. **Emergency Blood Finding**: Quickly locate available blood
2. **Donor Network**: Connect with registered donors
3. **Inventory Tracking**: Real-time blood availability
4. **Request Management**: Streamlined approval process
5. **User Feedback**: Two-way communication system

---

**Made with ❤️ for saving lives**

*Remember: Every blood donation can save up to 3 lives!*

