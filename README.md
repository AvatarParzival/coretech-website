# CoreTech Innovations – Dynamic Website  
![XAMPP Compatible](https://img.shields.io/badge/XAMPP-Compatible-brightgreen)
![PHP Version](https://img.shields.io/badge/PHP-7.4%2B-blue)
![MySQL Ready](https://img.shields.io/badge/MySQL-5.7%2B-orange)

A full-stack **PHP + MySQL** website with **HTML + TailwindCSS frontend** and a secure admin panel.  
The project provides a professional company website where all content (hero text, services, portfolio, team, stats, contact info, and socials) can be managed dynamically through the backend.  

---
## 📑 Table of Contents  
- [✨ Features](#-features)  
- [🛠 Tech Stack](#-tech-stack)  
- [📂 Project Folder Structure](#-project-folder-structure)  
- [⚡ Setup Instructions](#-setup-instructions)  
- [🚀 Deployed Version](#-deployed-version)  
- [🔒 Security Features](#-security-features)  
- [🤝 Contributing](#-contributing)  
- [📜 License](#-license)  

---

## ✨ Features  

### 🖥 Frontend (User Website)  
- Dynamic hero section (headline & subheadline)  
- About & methodology sections  
- Services, portfolio, and team pages (editable via admin)  
- Stats section with counters  
- Contact form with database storage  
- Social media links in footer  

### 🔑 Admin Panel  
- Secure login with hashed passwords & old password verification  
- Manage services, portfolio projects, and team members  
- Update site stats and contact information  
- Change hero text & social media links dynamically  
- View contact form messages (newest first)  

---

## 🛠 Tech Stack  
- **Frontend**: HTML5, TailwindCSS (utility-first CSS), JavaScript  
- **Backend**: PHP (MySQLi + Prepared Statements)  
- **Database**: MySQL  
- **Security**: Password hashing, role-based access, SQL injection prevention  

---

## 📂 Project Folder Structure  

```
coretech-website/
│
├── admin/                     # Admin panel
│   ├── dashboard.php          # Admin dashboard
│   ├── services.php           # Manage services
│   ├── portfolio.php          # Manage portfolio
│   ├── team.php               # Manage team members
│   ├── stats.php              # Manage site stats
│   ├── contact_info.php       # Manage contact info
│   ├── site_settings.php      # Manage socials & hero text
│   ├── messages.php           # View contact form messages
│   ├── settings.php           # Admin settings (profile/password)
│   ├── login.php              # Admin login
│   ├── register.php           # Admin register (with invite code)
│   ├── logout.php             # Logout
│   └── assets/                # Admin-specific CSS/JS (if any)
│
├── assets/                    # Frontend assets
│   ├── css/                   # Custom styles (if needed)
│   ├── js/                    # Custom scripts (if needed)
│   └── images/                # Static images
│
├── includes/                  # Common include files
│   ├── db.php                 # Database connection
│   └── auth.php               # Auth check (only allow admins)
│
├── index.php                  # Homepage (frontend)
├── coretech.sql               # Database schema file
└── README.md                  # Project documentation
```

---

## ⚡ Setup Instructions  

### 🔹 Local Deployment with XAMPP  

1. Download and install the latest version:  
[https://www.apachefriends.org/download.html](https://www.apachefriends.org/download.html)

2. Clone the repository or you can download as ZIP as well:  
   ```bash
   git clone https://github.com/AvatarParzival/coretech-website
   cd coretech-website
   ```

3. Place the project inside the `htdocs` folder of XAMPP:  
   ```bash
   C:/xampp/htdocs/coretech-website
   ```

4. Start **Apache** and **MySQL** from XAMPP Control Panel.  

5. Create a database in MySQL:  
   ```sql
   CREATE DATABASE coretech;
   USE coretech;
   -- Import the provided SQL file (coretech.sql) into this database
   ```

6. Update `includes/db.php` with your MySQL credentials (default: `root` / no password).  

7. Access the site in your browser:  
   - **Frontend** → [http://localhost/coretech-website/](http://localhost/coretech-website/)  
   - **Admin Panel** → [http://localhost/coretech-website/admin/](http://localhost/coretech-website/admin/)  

---

## 🚀 Deployed Version  

This project is designed for **local deployment** using **XAMPP**.  
If you want to deploy online:  
- Use **cPanel / shared hosting** (upload project + DB).  
- Or containerize with **Docker** (Apache + PHP + MySQL).  

(Node.js is not used here — project is PHP-based.)  

---

## 🔒 Security Features  

- **Password Hashing** → All admin passwords are stored securely using PHP’s `password_hash()` and verified with `password_verify()`.  
- **Old Password Verification** → When changing a password, the admin must first provide the current one for verification.  
- **Role-Based Access** → Only users with the role `admin` can access the backend panel.  
- **SQL Injection Prevention** → All queries use **prepared statements** with parameter binding.  
- **Session-Based Authentication** → Admin authentication is handled via PHP sessions.  
- **Input Validation** → Form inputs are validated and sanitized before storing in the database.  
- **Restricted File Uploads** → Only specific file types (images) are allowed for team/portfolio uploads.  
- **Logout Mechanism** → Secure logout to destroy sessions and prevent reuse.  

---

## 🤝 Contributing  

Contributions are welcome! 🎉  

1. **Fork** the repository  
2. **Create** a new feature branch (`git checkout -b feature/YourFeature`)  
3. **Commit** your changes (`git commit -m 'Add new feature'`)  
4. **Push** to your branch (`git push origin feature/YourFeature`)  
5. **Open a Pull Request**  

Please make sure your code follows best practices and includes proper documentation.  

---

## 📜 License  
This project is licensed under the MIT License.  
