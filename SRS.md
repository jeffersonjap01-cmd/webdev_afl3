# Software Requirements Specification (SRS)
## Alvca Matcha E-Commerce & Restaurant Management System

**Version**: 1.0  
**Date**: November 2025  
**Document Status**: Final

---

## 1. Introduction

### 1.1 Purpose
This document specifies the requirements for the Alvca Matcha E-Commerce & Restaurant Management System. It describes the functional and non-functional requirements, system architecture, and design constraints.

### 1.2 Scope
The system provides a complete solution for managing a matcha product business with both e-commerce (delivery) and restaurant (dine-in) functionalities. It serves two main user types: customers and administrators.

### 1.3 Definitions, Acronyms, and Abbreviations
- **SRS**: Software Requirements Specification
- **MVC**: Model-View-Controller
- **CRUD**: Create, Read, Update, Delete
- **ERD**: Entity Relationship Diagram
- **API**: Application Programming Interface
- **UI**: User Interface
- **UX**: User Experience

### 1.4 References
- Laravel Framework Documentation
- Laravel Breeze Documentation
- Tailwind CSS Documentation

### 1.5 Overview
This document is organized into sections covering:
- Overall Description
- System Features
- External Interface Requirements
- System Constraints
- Database Requirements

---

## 2. Overall Description

### 2.1 Product Perspective
The system is a standalone web application built with Laravel framework, providing:
- Web-based user interface
- Database-driven content management
- Role-based access control
- Payment processing capabilities

### 2.2 Product Functions
The system provides the following major functions:
1. User authentication and authorization
2. Product catalog management
3. Shopping cart (delivery orders)
4. Dine-in order management
5. Payment processing
6. Promotion management
7. Review and rating system
8. Administrative dashboard

### 2.3 User Classes and Characteristics

#### 2.3.1 Customers (Users)
- **Characteristics**: General public, varying technical skills
- **Responsibilities**: Browse products, place orders, make payments, leave reviews
- **Access Level**: Limited to customer features

#### 2.3.2 Administrators
- **Characteristics**: Business owners/staff, technical knowledge
- **Responsibilities**: Manage products, orders, deliveries, promotions, view reports
- **Access Level**: Full system access

### 2.4 Operating Environment
- **Server**: PHP 8.1+ with Laravel 11
- **Database**: SQLite (development) / MySQL/PostgreSQL (production)
- **Web Server**: Apache/Nginx
- **Browser Support**: Modern browsers (Chrome, Firefox, Safari, Edge)

### 2.5 Design and Implementation Constraints
- Must use Laravel framework
- Must follow MVC architecture pattern
- Database must be relational
- Must be responsive (mobile-friendly)
- Must support multiple restaurant locations

### 2.6 Assumptions and Dependencies
- Users have internet connection
- Users have modern web browsers
- Server has PHP 8.1+ installed
- Database server is available
- File storage is available for product images

---

## 3. System Features

### 3.1 User Authentication and Authorization

#### 3.1.1 User Registration
- **Priority**: High
- **Description**: New users can create accounts
- **Inputs**: Name, email, password
- **Outputs**: User account created, email verification (optional)
- **Preconditions**: None
- **Postconditions**: User can log in

#### 3.1.2 User Login
- **Priority**: High
- **Description**: Users authenticate with email and password
- **Inputs**: Email, password
- **Outputs**: Session created, user redirected to appropriate dashboard
- **Preconditions**: User account exists
- **Postconditions**: User is logged in

#### 3.1.3 Role-Based Access Control
- **Priority**: High
- **Description**: System distinguishes between 'user' and 'admin' roles
- **Inputs**: User role from database
- **Outputs**: Appropriate UI and features based on role
- **Preconditions**: User is logged in
- **Postconditions**: User sees role-appropriate interface

### 3.2 Product Management

#### 3.2.1 Product Catalog Display
- **Priority**: High
- **Description**: Customers can view all available products
- **Inputs**: None (public access)
- **Outputs**: List of products with images, names, descriptions, prices, stock
- **Preconditions**: Products exist in database
- **Postconditions**: None

#### 3.2.2 Product Creation (Admin)
- **Priority**: High
- **Description**: Admins can add new products
- **Inputs**: Name, description, price, image, stock, category, location
- **Outputs**: New product saved to database
- **Preconditions**: User is admin, logged in
- **Postconditions**: Product appears in catalog

#### 3.2.3 Product Update (Admin)
- **Priority**: High
- **Description**: Admins can modify existing products
- **Inputs**: Product ID, updated fields
- **Outputs**: Product updated in database
- **Preconditions**: User is admin, product exists
- **Postconditions**: Changes reflected in catalog

#### 3.2.4 Product Deletion (Admin)
- **Priority**: Medium
- **Description**: Admins can remove products
- **Inputs**: Product ID
- **Outputs**: Product removed from database
- **Preconditions**: User is admin, product exists
- **Postconditions**: Product no longer visible

#### 3.2.5 Stock Management (Admin)
- **Priority**: High
- **Description**: Admins can update product stock
- **Inputs**: Product ID, new stock quantity
- **Outputs**: Stock updated in database
- **Preconditions**: User is admin, product exists
- **Postconditions**: Stock reflects new quantity

### 3.3 Shopping Cart (Delivery Orders)

#### 3.3.1 Add to Cart
- **Priority**: High
- **Description**: Customers add products to cart for delivery
- **Inputs**: Product ID, quantity, location, delivery address
- **Outputs**: Item added to cart, stock reduced
- **Preconditions**: User is logged in, product has stock, stock >= quantity
- **Postconditions**: Item in cart, stock decreased

#### 3.3.2 View Cart
- **Priority**: High
- **Description**: Customers view their cart items
- **Inputs**: User ID
- **Outputs**: List of cart items with details
- **Preconditions**: User is logged in
- **Postconditions**: None

#### 3.3.3 Update Cart Item
- **Priority**: Medium
- **Description**: Customers can change quantity of items
- **Inputs**: Cart item ID, new quantity
- **Outputs**: Quantity updated, stock adjusted
- **Preconditions**: User is logged in, item exists, sufficient stock
- **Postconditions**: Cart updated, stock adjusted

#### 3.3.4 Remove from Cart
- **Priority**: Medium
- **Description**: Customers can remove items from cart
- **Inputs**: Cart item ID
- **Outputs**: Item removed, stock returned (if unpaid)
- **Preconditions**: User is logged in, item exists
- **Postconditions**: Item removed, stock returned if unpaid

### 3.4 Dine-In Orders

#### 3.4.1 Create Dine-In Order
- **Priority**: High
- **Description**: Customers create orders for dine-in
- **Inputs**: Product ID, quantity, location ID, table ID
- **Outputs**: Order created, stock reduced, table marked as used
- **Preconditions**: User is logged in, product has stock, table is available
- **Postconditions**: Order created, stock decreased, table occupied

#### 3.4.2 View Orders
- **Priority**: High
- **Description**: Customers view their order history
- **Inputs**: User ID
- **Outputs**: List of orders with status
- **Preconditions**: User is logged in
- **Postconditions**: None

#### 3.4.3 Admin Order Management
- **Priority**: High
- **Description**: Admins view and manage all orders
- **Inputs**: None (admin access)
- **Outputs**: List of all orders
- **Preconditions**: User is admin
- **Postconditions**: None

#### 3.4.4 Update Order Status (Admin)
- **Priority**: High
- **Description**: Admins change order status
- **Inputs**: Order ID, new status
- **Outputs**: Order status updated
- **Preconditions**: User is admin, order exists, payment completed (for 'done' status)
- **Postconditions**: Status updated, table released if 'done'

### 3.5 Payment Processing

#### 3.5.1 Cart Payment
- **Priority**: High
- **Description**: Customers pay for cart items
- **Inputs**: Payment method, payment proof, notes, promo code (optional)
- **Outputs**: Payment recorded, cart status updated to 'Dibayar', promo applied
- **Preconditions**: User is logged in, cart has items, promo code valid (if provided)
- **Postconditions**: Payment recorded, status updated, promo deleted if used

#### 3.5.2 Order Payment
- **Priority**: High
- **Description**: Customers pay for dine-in orders
- **Inputs**: Order ID, payment method, payment proof, notes, promo code (optional)
- **Outputs**: Payment recorded, order status updated to 'Dibayar', promo applied
- **Preconditions**: User is logged in, order exists, promo code valid (if provided)
- **Postconditions**: Payment recorded, status updated, promo deleted if used

### 3.6 Promotion Management

#### 3.6.1 Create Promo (Admin)
- **Priority**: Medium
- **Description**: Admins create promotional codes
- **Inputs**: Name, code, discount type (percentage/fixed), amount, dates, status
- **Outputs**: Promo saved to database
- **Preconditions**: User is admin
- **Postconditions**: Promo available for use

#### 3.6.2 Apply Promo Code
- **Priority**: Medium
- **Description**: Customers apply promo codes for discounts
- **Inputs**: Promo code
- **Outputs**: Discount applied, total updated
- **Preconditions**: Promo code exists, is active, within validity period
- **Postconditions**: Discount applied, promo deleted after use

#### 3.6.3 Manage Promos (Admin)
- **Priority**: Medium
- **Description**: Admins can view, edit, and delete promos
- **Inputs**: Promo ID, updated fields (for edit)
- **Outputs**: Promo list/updated/deleted
- **Preconditions**: User is admin
- **Postconditions**: Promos managed

### 3.7 Review System

#### 3.7.1 Create Review
- **Priority**: Medium
- **Description**: Customers leave reviews for products
- **Inputs**: Product ID, rating (1-5), comment
- **Outputs**: Review saved to database
- **Preconditions**: User is logged in, not admin, product exists
- **Postconditions**: Review visible to all users

#### 3.7.2 View Reviews
- **Priority**: Medium
- **Description**: All users can view product reviews
- **Inputs**: None (public)
- **Outputs**: List of reviews with ratings and comments
- **Preconditions**: Reviews exist
- **Postconditions**: None

#### 3.7.3 Manage Own Reviews
- **Priority**: Low
- **Description**: Customers can edit/delete their own reviews
- **Inputs**: Review ID, updated fields (for edit)
- **Outputs**: Review updated/deleted
- **Preconditions**: User is logged in, owns the review, not admin
- **Postconditions**: Review updated/deleted

### 3.8 Delivery Management (Admin)

#### 3.8.1 View Deliveries
- **Priority**: High
- **Description**: Admins view all delivery orders
- **Inputs**: None (admin access)
- **Outputs**: List of all cart items with customer addresses
- **Preconditions**: User is admin
- **Postconditions**: None

#### 3.8.2 View Delivery Address
- **Priority**: High
- **Description**: Admins see customer delivery addresses
- **Inputs**: Delivery ID
- **Outputs**: Full address details (street, city, province, postal code, phone)
- **Preconditions**: User is admin, delivery exists
- **Postconditions**: None

### 3.9 Location and Table Management

#### 3.9.1 Location Management
- **Priority**: High
- **Description**: System supports multiple restaurant locations
- **Inputs**: Location name, address, phone (via seeders/admin)
- **Outputs**: Locations available for selection
- **Preconditions**: Locations exist in database
- **Postconditions**: None

#### 3.9.2 Table Management
- **Priority**: High
- **Description**: System manages tables for dine-in orders
- **Inputs**: Table number, location ID, status
- **Outputs**: Tables available/occupied
- **Preconditions**: Tables exist in database
- **Postconditions**: Table status updated based on orders

---

## 4. External Interface Requirements

### 4.1 User Interfaces
- **Web Interface**: Responsive design using Tailwind CSS
- **Admin Dashboard**: Separate interface for administrators
- **Mobile Support**: Responsive layout for mobile devices

### 4.2 Hardware Interfaces
- Standard web server hardware
- Database server
- File storage for product images

### 4.3 Software Interfaces
- **Laravel Framework**: PHP 8.1+
- **Database**: SQLite/MySQL/PostgreSQL
- **Web Server**: Apache/Nginx
- **Browser**: Modern web browsers

### 4.4 Communication Interfaces
- HTTP/HTTPS protocol
- Standard web protocols

---

## 5. System Constraints

### 5.1 Performance Requirements
- Page load time: < 3 seconds
- Database queries: Optimized with eager loading
- Concurrent users: Support at least 100 concurrent users

### 5.2 Security Requirements
- Password encryption (bcrypt)
- CSRF protection
- SQL injection prevention (Eloquent ORM)
- XSS protection (Blade templating)
- Role-based access control

### 5.3 Reliability Requirements
- System uptime: 99% availability
- Data backup: Regular database backups
- Error handling: Graceful error messages

### 5.4 Usability Requirements
- Intuitive navigation
- Clear error messages
- Responsive design
- Accessible to users with varying technical skills

---

## 6. Database Requirements

### 6.1 Database Schema
The system requires 12 main tables:
1. users
2. menus
3. kategoris
4. lokasi_tokos
5. mejas
6. keranjangs
7. alamats
8. orders
9. order_items
10. payments
11. promos
12. reviews

### 6.2 Data Integrity
- Foreign key constraints
- Cascade deletes where appropriate
- Nullable fields for optional data
- Default values for required fields

### 6.3 Data Relationships
- One-to-many relationships (user → orders, menu → reviews)
- Many-to-many relationships (orders → order_items)
- Foreign key relationships for data integrity

---

## 7. Non-Functional Requirements

### 7.1 Scalability
- Database can handle growing number of products and orders
- Code structure allows for feature additions

### 7.2 Maintainability
- Clean code structure following MVC pattern
- Comprehensive documentation
- Modular design

### 7.3 Portability
- Works on various operating systems (Windows, Linux, macOS)
- Database-agnostic (supports multiple database systems)

---

## 8. Appendices

### 8.1 Glossary
- **Keranjang**: Shopping cart (Indonesian)
- **Cabang**: Branch/location (Indonesian)
- **Meja**: Table (Indonesian)
- **Alamat**: Address (Indonesian)

### 8.2 Change History
- Version 1.0 (November 2025): Initial release

---

**Document End**

