# Alvca Matcha - E-Commerce & Restaurant Management System

## 📋 Project Overview

**Alvca Matcha** is a comprehensive web-based e-commerce and restaurant management system designed for a matcha product business. The system supports both **delivery orders** and **dine-in orders**, providing a seamless experience for customers while giving administrators full control over products, orders, deliveries, promotions, and customer reviews.

## 🎯 Project Purpose

This system was developed to:
- Enable customers to browse and purchase matcha products online with delivery service
- Support dine-in orders with table and location management
- Provide administrators with tools to manage inventory, orders, deliveries, and promotions
- Allow customers to leave reviews and ratings for products
- Track payment status for both delivery and dine-in orders
- Manage multiple restaurant locations (cabang) and tables

## 🏗️ System Architecture

### Technology Stack
- **Backend Framework**: Laravel 11 (PHP)
- **Frontend**: Blade Templates with Tailwind CSS
- **Database**: SQLite (can be configured for MySQL/PostgreSQL)
- **Authentication**: Laravel Breeze
- **Architecture Pattern**: MVC (Model-View-Controller)

### Key Features

#### For Customers (Users)
1. **Product Browsing**
   - View all available matcha products
   - See product details, prices, and stock availability
   - Filter products by category

2. **Delivery Orders (Keranjang)**
   - Add products to cart
   - Select delivery location (cabang)
   - Enter delivery address
   - Apply promo codes for discounts
   - Make payments with multiple payment methods
   - Track order and payment status

3. **Dine-In Orders**
   - Create orders directly from the orders page
   - Select restaurant location and table
   - View order history
   - Make payments for dine-in orders

4. **Reviews**
   - Leave ratings and comments for products
   - View other customers' reviews
   - Manage own reviews (edit/delete)

5. **Profile Management**
   - Update personal information
   - Change password
   - View account role

#### For Administrators
1. **Product Management**
   - Create, read, update, and delete products
   - Manage product stock
   - Upload product images
   - Assign products to categories and locations

2. **Order Management**
   - View all dine-in orders
   - Update order status (pending → proses → done)
   - Prevent order completion if payment is not completed
   - View order details and customer information

3. **Delivery Management**
   - View all delivery orders (keranjang items)
   - See customer delivery addresses
   - Track payment status for deliveries
   - Monitor delivery locations

4. **Promotion Management**
   - Create and manage promotional codes
   - Set discount percentages or fixed amounts
   - Define promotion validity periods
   - Set minimum purchase requirements

5. **System Overview**
   - Monitor all orders and deliveries
   - Track payment statuses
   - Manage multiple restaurant locations

## 📊 Database Structure

The system uses **12 main database tables**:

1. **users** - User accounts (customers and admins)
2. **menus** - Product catalog
3. **kategoris** - Product categories
4. **lokasi_tokos** - Restaurant branch locations
5. **mejas** - Tables for dine-in orders
6. **keranjangs** - Shopping cart items (delivery orders)
7. **alamats** - Customer delivery addresses
8. **orders** - Dine-in orders
9. **order_items** - Items in each dine-in order
10. **payments** - Payment records
11. **promos** - Promotional codes
12. **reviews** - Customer product reviews

## 🔄 Business Flow

### Delivery Order Flow
1. Customer browses products
2. Customer adds product to cart (selects location and enters address)
3. Stock is automatically reduced
4. Customer applies promo code (optional)
5. Customer makes payment
6. Payment status updates to "Dibayar"
7. Admin can view delivery with customer address

### Dine-In Order Flow
1. Customer selects product, quantity, location, and table
2. System checks stock availability and table availability
3. Order is created with "Belum Bayar" status
4. Stock is automatically reduced
5. Customer makes payment
6. Payment status updates to "Dibayar"
7. Admin updates order status (pending → proses → done)
8. Table is released when order is completed

## 🔐 Security Features

- **Role-based Access Control**: Separate user and admin roles
- **Authentication**: Laravel Breeze authentication system
- **Authorization**: Middleware protection for admin routes
- **CSRF Protection**: Built-in Laravel CSRF token protection
- **Input Validation**: Server-side validation for all user inputs

## 📱 User Interface

- **Responsive Design**: Works on desktop, tablet, and mobile devices
- **Modern UI**: Clean and intuitive interface using Tailwind CSS
- **User-Friendly Navigation**: Clear navigation for both users and admins
- **Real-time Feedback**: Success and error messages for user actions

## 🚀 Deployment

The system is designed to be deployed on:
- Local development environment (Laravel Herd, XAMPP, etc.)
- Production servers (shared hosting, VPS, cloud platforms)
- Database can be SQLite (development) or MySQL/PostgreSQL (production)

## 📈 Future Enhancements

Potential features for future development:
- Real-time order tracking
- Email notifications for order status
- Inventory alerts for low stock
- Sales reports and analytics
- Customer loyalty program
- Integration with payment gateways
- Mobile application

---

**Version**: 1.0  
**Last Updated**: November 2025  
**Developer**: Alvca Matcha Development Team




