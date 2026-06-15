PartyPass SL

A high-performance, centralized lifestyle, event-ticketing, and vendor platform purpose-built for the Sierra Leonean ecosystem. PartyPass SL bridges the gap between verified event planners/lifestyle vendors and attendees, offering bulletproof local mobile money payment routing and instantaneous digital ticket verification.

System Architecture & Scope

The ecosystem is partitioned strictly into three functional system layers driven by database-level access rules:

System Admin (Admin Nexus): Features full system observability, event manager approvals, and financial overview metrics.
Event Planners & Vendors: Allows verified users to create events, set localized pricing in Leones (SLE), orchestrate dynamic performer rosters (up to 15 special guests), and track ticket revenues.
Buyers (Attendees): Allows general users to instantly discover events, complete quick mobile checkouts, and manage active event passes with secure QR barcodes.
Tech Stack & Key Engines

Backend Core: PHP 8.x (Stateful Native Session Engine)
Database Engine: MariaDB / MySQL (Object-oriented mapping via PHP Data Objects - PDO)
Frontend Interface: HTML5, CSS3, Tailwind CSS UI Utilities
Payment Gateway: Monime Space Checkout API Integration
The State Continuity & Session Recovery Loop

A common point of failure when interfacing local sessions with external payment checkouts is the loss of cross-domain browser cookie headers. PartyPass SL overcomes this architectural issue using an explicit lookup mechanism:

Pre-checkout Lock: checkout.php intercepts the form action and inserts an immutable record into the tickets table with a pending state and an alphanumeric sequence token before communicating with the API.
Parameters Handoff: buy_ticket.php converts values into currency units and transmits them to Monime, embedding the unique token data inside the success callback redirect link.
Session Auto-Injection: When returning to payment_success.php, if the user's session cookie was cleared by the browser, the page reads the token parameter from the URL, performs a secure relational database query, and injects the proper configuration elements ($_SESSION['user_id'], $_SESSION['role_id']) back into memory before generating the UI layout header.
Database Schema Summary

users

user_id (INT, PK, AI)
role_id (INT) — 1 = Admin, 2 = Buyer, 3 = Planner/Vendor
full_name / email / phone (VARCHAR)
password_hash (VARCHAR) — Secured via PASSWORD_DEFAULT blowfish hashing
is_verified (TINYINT) — Default 1 for buyers; 0 for planners/vendors until manual admin review
tickets

ticket_id (INT, PK, AI)
event_id (INT, FK)
user_id (INT, FK)
ticket_type (VARCHAR) — e.g., Regular, VIP, VVIP
ticket_code (VARCHAR, Unique) — Alphanumeric validation string (e.g., TIX-92F7BDC2)
status (VARCHAR) — pending during initialization; flips to valid on payment return
Quick Installation Guide

1. Environment Setup

Clone this repository to your local web server development directory (e.g., XAMPP htdocs or WampServer www):

git clone [https://github.com/edwardmusa-pixel/GROUP-4(https://github.com/edwardmusa-pixel/GROUP-4)
