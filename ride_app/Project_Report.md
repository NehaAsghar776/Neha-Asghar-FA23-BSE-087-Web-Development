# Project Report: RideShare Application

**Course:** Web Technologies  
**Project Name:** RideShare - Carpooling Platform  
**Student Name:** [Your Name Here]  
**Roll Number:** [Your Roll No Here]  
**Date:** [Current Date]

---

## 1. Introduction

### 1.1 Overview
RideShare is a modern, web-based carpooling application designed to facilitate peer-to-peer ride sharing. Inspired by platforms like InDrive and Uber, it connects car owners (drivers) who have empty seats with passengers traveling in the same direction. The platform aims to make daily commuting more affordable, convenient, and environmentally friendly by optimizing the use of private vehicles.

### 1.2 Problem Statement
With the rising cost of fuel and increasing traffic congestion, daily commuting has become a significant challenge for many. Public transport is often overcrowded or unavailable in specific areas, while private cabs can be expensive. There is a need for a solution that bridges the gap between affordable public transit and convenient private transport.

### 1.3 Solution
RideShare solves this problem by allowing drivers to offer rides on their planned routes and enabling passengers to book seats at a shared cost. This reduces the per-person travel cost, decreases the number of cars on the road, and fosters a community-based travel experience.

---

## 2. Scope of the Project

The scope of the RideShare project encompasses the development of a fully functional web application that manages the entire lifecycle of a ride-sharing experience.

### 2.1 Key Features
*   **User Management:** Secure registration and login system for users to act as both drivers and passengers.
*   **Ride Publishing:** Drivers can publish ride details including pickup/drop-off locations, date, time, available seats, and price.
*   **Ride Search:** Passengers can search for available rides using advanced filtering (location, date).
*   **Booking System:** Seamless booking process with instant confirmation and status tracking.
*   **Dashboard:** A centralized "My Bookings" area for users to track their travel history and ride statuses.
*   **Responsive UI:** A mobile-friendly interface ensuring accessibility across devices.

### 2.2 Target Audience
*   Daily commuters (students, office workers).
*   Inter-city travelers looking for affordable options.
*   Car owners looking to share fuel costs.

---

## 3. Functional Requirements

The system is built to fulfill the following functional requirements:

### 3.1 Authentication Module
*   **Register:** Users must be able to create an account with their name, email, and password.
*   **Login:** Secure access to the dashboard using email and password.
*   **Session Management:** Maintain user sessions to secure private routes.

### 3.2 Ride Management (Driver Side)
*   **Offer Ride:** A form to input ride details:
    *   Driver Name & Contact
    *   Car Model & Type (Economy, Comfort, Premium)
    *   Route (From/To)
    *   Seat Capacity & Price per Seat
*   **Data Persistence:** All offered rides must be stored in the database.

### 3.3 Search & Booking (Passenger Side)
*   **Search Interface:** Input fields for Pickup and Drop-off locations.
*   **Smart Search Algorithm:** The system should find rides matching the route, even with partial location matches (e.g., searching "Lahore" matches "Lahore Cantt").
*   **Booking Action:** Users can select a ride and confirm the booking.
*   **Status Updates:** Bookings should initially be "Pending" or "Confirmed" based on availability.

---

## 4. System Architecture & Technologies

The project follows the **MVC (Model-View-Controller)** architectural pattern, ensuring clean code separation and scalability.

### 4.1 Technology Stack
*   **Frontend:**
    *   **HTML5 & CSS3:** For structural layout and styling.
    *   **Bootstrap 5:** For responsive design and modern components.
    *   **JavaScript (ES6):** For dynamic interactions and AJAX requests.
*   **Backend:**
    *   **Laravel 10+:** A robust PHP framework for handling routing, controllers, and business logic.
*   **Database:**
    *   **MySQL:** Relational database management system.
*   **Tools:**
    *   **Composer:** PHP dependency manager.
    *   **Git:** Version control.

### 4.2 Database Schema
*   **Users Table:** Stores user credentials and profile info.
*   **Rides Table:** Stores ride details (`driver_name`, `route_from`, `route_to`, `price`, etc.).
*   **Bookings Table:** Links users to rides (`user_id`, `ride_id`, `status`).

---

## 5. Detailed Explanation of Modules

### 5.1 Ride Controller (`RideController.php`)
This controller manages the logic for rides.
*   **`store()` Function:** Validates the "Offer Ride" form data. It checks if required fields like `driver_name` and `price` are present. Upon validation, it uses the `Ride` model to create a new record in the database linked to the authenticated user.
*   **`index()` Function:** Handles the search functionality. It accepts `pickup` and `dropoff` query parameters. We implemented a "Loose Matching" algorithm using the SQL `LIKE` operator (`%keyword%`) to ensure users find relevant rides even if the spelling isn't exact.

### 5.2 Booking Controller (`BookingController.php`)
Manages the booking lifecycle.
*   **`store()` Function:** Receives booking details via an AJAX request. It validates the input and creates a new booking record with a status of 'confirmed'.
*   **`index()` Function:** Retrieves the history of bookings for the logged-in user to display on the "My Bookings" page.

### 5.3 Dynamic Frontend (`script.js`)
The application uses modern JavaScript to provide a smooth user experience without constant page reloads.
*   **Fetch API:** We replaced traditional form submissions with `fetch()` calls. This allows the page to send data to the backend (e.g., posting a ride) and receive a response (success/failure) without refreshing the browser.
*   **DOM Manipulation:** JavaScript dynamically updates the ride list and booking summary based on user actions.

---

## 6. Screenshots of the Project

*(Note: Please insert the actual screenshots of your running project in the spaces below before printing/submitting)*

### 6.1 Home Page
*Description: The landing page featuring a dynamic background image, navigation bar, and the primary "Search Ride" interface.*
<br>
[INSERT SCREENSHOT OF HOME PAGE HERE]
<br>
<br>

### 6.2 User Login/Register
*Description: Secure authentication forms allowing users to access the platform.*
<br>
[INSERT SCREENSHOT OF LOGIN PAGE HERE]
<br>
<br>

### 6.3 Offer a Ride (Form)
*Description: The interface where drivers input their trip details to publish a ride.*
<br>
[INSERT SCREENSHOT OF OFFER RIDE MODAL/FORM HERE]
<br>
<br>

### 6.4 Search Results
*Description: Displays the list of available rides fetched from the database based on the user's search criteria.*
<br>
[INSERT SCREENSHOT OF SEARCH RESULTS HERE]
<br>
<br>

### 6.5 Booking Confirmation
*Description: The success message and summary shown to the user after confirming a ride.*
<br>
[INSERT SCREENSHOT OF BOOKING SUCCESS TOAST/MODAL HERE]
<br>
<br>

### 6.6 My Bookings Dashboard
*Description: A personalized view for the user showing their booking history and status.*
<br>
[INSERT SCREENSHOT OF MY BOOKINGS PAGE HERE]
<br>
<br>

---

## 7. Conclusion

### 7.1 Summary
The RideShare project successfully implements a core carpooling system. It demonstrates the practical application of Full Stack Web Development concepts, including database design, backend API development with Laravel, and dynamic frontend integration.

### 7.2 Future Enhancements
*   **Real-time Chat:** Integrating a chat system for drivers and passengers to communicate.
*   **Map Integration:** Using Google Maps API to visualize routes.
*   **Payment Gateway:** Adding online payment options for secure transactions.

---
*End of Report*
