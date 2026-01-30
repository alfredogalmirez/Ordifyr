🛒 Ordifyr

Ordifyr is a Laravel-based e-commerce web application built to practice and demonstrate real-world backend and full-stack development concepts such as product management, cart systems, file uploads, admin dashboards, and payment gateway integration (PH-first).

This project is developed as both a portfolio project for recruiters/employers and a personal learning project, with emphasis on clean logic, correct workflows, and scalable architecture.


🎯 Project Goals

Learn and implement real-world e-commerce flows

Understand backend concepts deeply (not just make things “work”)

Practice clean Laravel architecture and validation logic

Build a project suitable for junior developer portfolios


✨ Current Features

👤 User Side

User authentication (Laravel Breeze)

Browse product listings

View product details

Add products to cart

Update cart item quantities

Remove items from cart

View cart summary

Product images with graceful fallback (optional images)


🛠️ Admin Side

Admin dashboard

Product management:

Create products

Edit products

View product list

Product image upload

Stock management

Price handling using integer cents system (price_cents)

Separate admin layout using Blade components


📦 Product & Cart System

Cart linked to authenticated user

Cart items with quantity validation

Server-side total computation

Guard-clause based checkout validation

Stock-aware logic (preparation for checkout)

💳 Payment Gateway (In Progress)

PayMongo Checkout integration (PH-first)

Planned support for:

GCash

Maya

Order-based payment flow:

Create order (pending)

Redirect to PayMongo checkout

Confirm payment via webhooks

Secure payment confirmation (no trust on redirects)

Payment logic is being built backend-first to ensure correctness before UI integration.


🧠 Technical Highlights

Laravel 10+

Blade components (<x-layout>, <x-admin-layout>)

Tailwind CSS (CDN)

Eloquent relationships

Storage-based file uploads

Clean separation of concerns:

Cart logic

Order logic

Payment logic

Server-side validation and guard clauses

Integer-based money calculations (no floating-point issues)


🗂️ File Upload Handling

Product images are not stored in the database

Only relative file paths are saved

Files are stored in:

storage/app/public/products


🛡️ Security & Best Practices

Server-side validation for:

File uploads

Cart items and quantities

Price and total calculations

Payment confirmation via webhooks only

No sensitive keys exposed to frontend

Prepared for idempotent webhook handling

Uses integer-based pricing for accuracy



🧪 Development Notes

This project is actively developed

Features are implemented step-by-step with focus on understanding why things work

Backend logic is prioritized before UI polish

Payment gateway integration is intentionally learned and built incrementally


📌 Planned Features

Checkout page (order review)

PayMongo live integration

Order history for users

Admin order management

Email notifications

Inventory reservation logic

Multiple product images

International payments (future)


👨‍💻 Author

Ordifyr is developed by Alfredo Almirez
Built as a hands-on learning project focused on Laravel, backend architecture, and real-world e-commerce flows.
