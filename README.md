Ordifyr

Ordifyr is a Laravel-based e-commerce web application built to practice and demonstrate real-world web development concepts such as authentication, cart management, product administration, file uploads, and payment gateway integration (PH-first).

The project is designed with clean architecture, scalable logic, and practical workflows similar to real production systems.

✨ Features
👤 User Side

User authentication (Laravel Breeze)

Browse products

View product details

Add items to cart

Update item quantities

Remove items from cart

View cart summary

Image-based product listings


🛠️ Admin Side

Admin dashboard

Create, edit, and list products

Product image upload (stored in storage/app/public)

Stock management

Price handling using cents-based system (safe money handling)


📦 Product Management

Image upload with validation

Optional product images (nullable)

Placeholder UI for products without images

Stock availability indicators

Price stored as price_cents (integer)


💳 Payment (In Progress)

PayMongo Checkout integration (PH-first)

GCash / Maya support (planned)

Order-based payment flow:

Create order (pending)

Redirect to PayMongo checkout

Confirm payment via webhooks

Secure webhook verification

Payment status handling (pending, paid, failed)


🧠 Technical Highlights

Laravel 10+

Blade components (<x-layout>, <x-admin-layout>)

Tailwind CSS (CDN)

Eloquent relationships

Storage-based file uploads (storage/app/public)

Clean separation of:

Cart logic

Order logic

Payment logic

Guard-clause driven checkout validation

Server-side total computation (no trust on client data)
