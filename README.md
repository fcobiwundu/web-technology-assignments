# Web Technology Assignments

## 📌 Overview
This repository contains two web technology assignments developed for the **Student Union Shop at UCLan**. The assignments focus on **front-end** and **back-end** web development, implementing modern design principles, interactivity, and database management.

---

## 📂 Assignment 1: Frontend Web Application (40%)
**📅 Deadline:** 17th December 2024  
**📌 Technologies Used:** HTML, CSS, JavaScript  

**🌐 Description:**
- A fully responsive **front-end web application** for an online shop.
- Implements **interactive product displays** and a **shopping cart**.
- Uses **localStorage** to manage cart functionality.
- Pages included:
  - `index.html` → Homepage with a welcome message and embedded video.
  - `products.html` → Displays all available products.
  - `item.html` → Shows detailed information about a selected product.
  - `cart.html` → Displays the shopping cart (no checkout required).
- **No frameworks** (like Bootstrap) are used.

📌 **Features:**
✔️ Navigation menu for seamless browsing.  
✔️ Valid HTML & CSS following best practices.  
✔️ Session-based product selection (via JavaScript).  
✔️ Shopping cart with add/remove functionality.  
✔️ Mobile-friendly with CSS media queries.  
✔️ README file with detailed documentation.  
✔️ Video demo showcasing project functionality.  

---

## 📂 Assignment 2: Backend Web Application (60%)
**📅 Deadline:** 1st April 2025  
**📌 Technologies Used:** PHP, MySQL, HTML, CSS, JavaScript  
**🌐 Description:**
- Extends **Assignment 1** by integrating a **server-side backend** using PHP and MySQL.
- Enables **user authentication** and **database-driven content**.
- Implements a **login system** and a **product management system**.
- Uses PHP **sessions** for user authentication.

📌 **Features:**
✔️ MySQL database for storing users, products, and orders.  
✔️ User login system with secure password hashing (bcrypt).  
✔️ Dynamic product pages pulling data from the database.  
✔️ Shopping cart linked to **database sessions**.  
✔️ Secure user authentication and session management.  
✔️ Filtering and searching for products using SQL queries.  
✔️ Hosted on **Vesta server (vesta.uclan.ac.uk)**.  

---

## 🔧 Changes to Schema
1. 
1. **Added `category` column to `tbl_products`**  
   - Allows product categorization for better filtering.
   - Implemented with:  
     ```sql
     ALTER TABLE tbl_products ADD COLUMN category VARCHAR(50) NOT NULL;
     ```

2. **Modified `password` column in `tbl_users` for security**  
   - Now stores **hashed passwords** instead of plaintext.
   - Implemented with:  
     ```sql
     ALTER TABLE tbl_users MODIFY COLUMN password VARCHAR(255) NOT NULL;
     ```

3. **Added foreign key constraint to `tbl_orders`**  
   - Links orders to users for better tracking.
   - Implemented with:  
     ```sql
     ALTER TABLE tbl_orders ADD CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES tbl_users(id);
     ```
