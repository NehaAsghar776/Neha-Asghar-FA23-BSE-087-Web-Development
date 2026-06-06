<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>RideShare - Your Ride, Your Price</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('js/script.js') }}" defer></script>
</head>
<body data-bs-theme="light">
  <nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
      <a class="navbar-brand" href="#" onclick="showPage('home')">
        <i class="fas fa-car-side me-2"></i>RideShare
      </a>
      <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <i class="fas fa-bars text-white"></i>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto align-items-center">
          <li class="nav-item"><a class="nav-link active" href="#" onclick="showPage('home')">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="#" onclick="showPage('book')">Book Ride</a></li>
          <li class="nav-item"><a class="nav-link" href="#" onclick="showPage('offer')">Offer Ride</a></li>
          <li class="nav-item"><a class="nav-link" href="#" onclick="showPage('ai')">AI Fare</a></li>
          <li class="nav-item"><a class="nav-link" href="#" onclick="showPage('about')">About</a></li>
          <li class="nav-item"><a class="nav-link" href="#" onclick="showPage('contact')">Contact</a></li>
          <li class="nav-item ms-2">
            <div class="theme-toggle" onclick="toggleTheme()">
              <i class="fas fa-moon text-white" id="themeIcon"></i>
            </div>
          </li>
          @auth
          <li class="nav-item ms-3"><span class="nav-link">{{ auth()->user()->name }}</span></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('bookings.index') }}">My Bookings</a></li>
          <li class="nav-item">
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button class="nav-link btn btn-link p-0">Logout</button>
            </form>
          </li>
          @endauth
          @guest
          <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
          @endguest
        </ul>
      </div>
    </div>
  </nav>

  <div class="toast-container" id="toastContainer"></div>

  <div id="home" class="page active">
    <section class="hero text-white">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-6">
            <span class="badge-verified mb-3">
              <i class="fas fa-shield-alt me-1"></i>Trusted Platform
            </span>
            <h1 class="mb-4">Your Ride,<br>Your Price</h1>
            <p class="hero-subtitle mb-4">Connect with verified drivers, negotiate your fare, and travel safely. Join thousands of happy riders today.</p>
            <div class="d-flex gap-3 flex-wrap">
              <button class="btn-glow" onclick="showPage('book')"><i class="fas fa-search me-2"></i>Find a Ride</button>
              <button class="btn-outline-glow" onclick="showPage('offer')"><i class="fas fa-car me-2"></i>Become a Driver</button>
            </div>
            <div class="d-flex gap-4 mt-5">
              <div><h3 class="mb-0">50K+</h3><small class="opacity-75">Happy Riders</small></div>
              <div><h3 class="mb-0">10K+</h3><small class="opacity-75">Drivers</small></div>
              <div><h3 class="mb-0">4.9</h3><small class="opacity-75">App Rating</small></div>
            </div>
          </div>
          <div class="col-lg-6 d-none d-lg-block">
            <div class="glass-card">
              <h5 class="mb-4"><i class="fas fa-bolt text-warning me-2"></i>Quick Book</h5>
              <div class="input-wrapper mb-3">
                <i class="fas fa-map-marker-alt input-icon text-success"></i>
                <input type="text" class="form-control search-input" id="quickPickup" placeholder="Pickup location">
              </div>
              <div class="input-wrapper mb-3">
                <i class="fas fa-flag-checkered input-icon text-danger"></i>
                <input type="text" class="form-control search-input" id="quickDrop" placeholder="Drop location">
              </div>
              <button class="btn-glow w-100" onclick="quickSearch()"><i class="fas fa-search me-2"></i>Search Rides</button>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="section">
      <div class="container">
        <div class="text-center mb-5">
          <h2 class="section-title">Why Choose RideShare?</h2>
          <p class="section-subtitle">Experience the future of ride-sharing</p>
        </div>
        <div class="row g-4">
          <div class="col-md-4">
            <div class="card h-100 feature-box">
              <div class="feature-icon"><i class="fas fa-hand-holding-usd"></i></div>
              <h5>Name Your Price</h5>
              <p class="text-muted">Set your own fare or negotiate with drivers. You're always in control.</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card h-100 feature-box">
              <div class="feature-icon"><i class="fas fa-shield-alt"></i></div>
              <h5>Verified Drivers</h5>
              <p class="text-muted">All drivers undergo background checks. Track your ride in real-time.</p>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card h-100 feature-box">
              <div class="feature-icon"><i class="fas fa-clock"></i></div>
              <h5>24/7 Availability</h5>
              <p class="text-muted">Rides available round the clock. We've got you covered anytime.</p>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <div id="book" class="page">
    <div class="page-spacer"></div>
    <section class="section pt-4">
      <div class="container">
        <div class="steps mb-4">
          <div class="step active" id="step1"><div class="step-number">1</div><span>Search</span></div>
          <div class="step-line"></div>
          <div class="step" id="step2"><div class="step-number">2</div><span>Select</span></div>
          <div class="step-line"></div>
          <div class="step" id="step3"><div class="step-number">3</div><span>Confirm</span></div>
        </div>
        <div class="row g-4">
          <div class="col-lg-8">
            <div class="card p-4 mb-4">
              <h5 class="mb-4"><i class="fas fa-search-location text-primary me-2"></i>Find Your Ride</h5>
              <form id="bookForm">
                <div class="row g-3">
                  <div class="col-md-6">
                    <label class="form-label fw-500">Pickup Location</label>
                    <div class="input-wrapper">
                      <i class="fas fa-map-marker-alt input-icon text-success"></i>
                      <input type="text" class="form-control search-input" id="pickup" placeholder="Enter pickup point" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-500">Drop Location</label>
                    <div class="input-wrapper">
                      <i class="fas fa-flag-checkered input-icon text-danger"></i>
                      <input type="text" class="form-control search-input" id="drop" placeholder="Enter destination" required>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label fw-500">Date</label>
                    <div class="input-wrapper">
                      <i class="fas fa-calendar input-icon"></i>
                      <input type="date" class="form-control search-input" id="date" required>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label fw-500">Time</label>
                    <div class="input-wrapper">
                      <i class="fas fa-clock input-icon"></i>
                      <input type="time" class="form-control search-input" id="time" required>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label fw-500">Passengers</label>
                    <div class="input-wrapper">
                      <i class="fas fa-users input-icon"></i>
                      <select class="form-control search-input" id="passengers">
                        <option value="1">1 Passenger</option>
                        <option value="2">2 Passengers</option>
                        <option value="3">3 Passengers</option>
                        <option value="4">4 Passengers</option>
                      </select>
                    </div>
                  </div>
                </div>
                <button type="submit" class="btn-glow w-100 mt-4"><i class="fas fa-search me-2"></i>Search Available Rides</button>
              </form>
            </div>
            <div id="filtersSection" class="mb-4" style="display:none;">
              <div class="d-flex gap-2 flex-wrap align-items-center">
                <span class="text-muted me-2"><i class="fas fa-filter me-1"></i>Filter:</span>
                <button class="filter-pill active" onclick="filterRides('all', this)">All</button>
                <button class="filter-pill" onclick="filterRides('economy', this)">Economy</button>
                <button class="filter-pill" onclick="filterRides('comfort', this)">Comfort</button>
                <button class="filter-pill" onclick="filterRides('premium', this)">Premium</button>
                <div class="ms-auto">
                  <select class="form-select form-select-sm rounded-pill" onchange="sortRides(this.value)">
                    <option value="price">Sort by Price</option>
                    <option value="rating">Sort by Rating</option>
                    <option value="trips">Sort by Experience</option>
                  </select>
                </div>
              </div>
            </div>
            <div id="rideResults"></div>
          </div>
          <div class="col-lg-4">
            <div class="booking-summary" id="bookingSummary" style="display:none;">
              <h5 class="mb-4"><i class="fas fa-receipt me-2"></i>Booking Summary</h5>
              <div id="summaryContent"></div>
              <button class="btn btn-light w-100 mt-3 fw-600" onclick="confirmBooking()"><i class="fas fa-check me-2"></i>Confirm Booking</button>
            </div>
            <div class="card p-4 mt-4">
              <h6 class="mb-3"><i class="fas fa-shield-alt text-success me-2"></i>Safety First</h6>
              <ul class="list-unstyled mb-0 safety-list">
                <li><i class="fas fa-check text-success me-2"></i>Verified drivers</li>
                <li><i class="fas fa-check text-success me-2"></i>Live ride tracking</li>
                <li><i class="fas fa-check text-success me-2"></i>24/7 support</li>
                <li><i class="fas fa-check text-success me-2"></i>Secure payments</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <div id="offer" class="page">
    <div class="page-spacer"></div>
    <section class="section pt-4">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <div class="text-center mb-5">
              <h2 class="section-title">Become a Driver</h2>
              <p class="section-subtitle">Earn money by sharing your ride with others</p>
            </div>
            <div class="card p-4 p-md-5">
              <form id="offerForm">
                <div class="row g-4">
                  <div class="col-md-6">
                    <label class="form-label fw-500">Your Name</label>
                    <div class="input-wrapper">
                      <i class="fas fa-user input-icon"></i>
                      <input type="text" class="form-control search-input" id="driverName" placeholder="Full name" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-500">Phone Number</label>
                    <div class="input-wrapper">
                      <i class="fas fa-phone input-icon"></i>
                      <input type="tel" class="form-control search-input" id="driverPhone" placeholder="+92 300 1234567" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-500">Car Model</label>
                    <div class="input-wrapper">
                      <i class="fas fa-car input-icon"></i>
                      <input type="text" class="form-control search-input" id="carModel" placeholder="e.g., Honda Civic 2020" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-500">Car Type</label>
                    <div class="input-wrapper">
                      <i class="fas fa-tags input-icon"></i>
                      <select class="form-control search-input" id="carType">
                        <option value="economy">Economy</option>
                        <option value="comfort">Comfort</option>
                        <option value="premium">Premium</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-500">From</label>
                    <div class="input-wrapper">
                      <i class="fas fa-map-marker-alt input-icon text-success"></i>
                      <input type="text" class="form-control search-input" id="routeFrom" placeholder="Starting point" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-500">To</label>
                    <div class="input-wrapper">
                      <i class="fas fa-flag-checkered input-icon text-danger"></i>
                      <input type="text" class="form-control search-input" id="routeTo" placeholder="Destination" required>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-500">Available Seats</label>
                    <div class="input-wrapper">
                      <i class="fas fa-chair input-icon"></i>
                      <select class="form-control search-input" id="seats">
                        <option>1</option><option>2</option><option>3</option><option selected>4</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label fw-500">Price per Seat (PKR)</label>
                    <div class="input-wrapper">
                      <i class="fas fa-money-bill input-icon"></i>
                      <input type="number" class="form-control search-input" id="price" placeholder="Enter fare" required>
                    </div>
                  </div>
                  <div class="col-12">
                    <label class="form-label fw-500">Additional Notes</label>
                    <textarea class="form-control search-input" id="notes" rows="3" placeholder="AC available, music, pet-friendly, etc."></textarea>
                  </div>
                  <div class="col-12">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="termsCheck" required>
                      <label class="form-check-label" for="termsCheck">I agree to the <a href="#" class="text-primary">Terms & Conditions</a></label>
                    </div>
                  </div>
                </div>
                <button type="submit" class="btn-glow w-100 mt-4"><i class="fas fa-plus me-2"></i>Publish Your Ride</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- AI FARE ESTIMATOR PAGE -->
  <div id="ai" class="page">
    <div class="page-spacer"></div>
    <section class="section pt-4">
      <div class="container">
        <div class="text-center mb-5">
          <h2 class="section-title">🤖 AI Fare Estimator</h2>
          <p class="section-subtitle">Let AI estimate your ride fare instantly based on route and car type</p>
        </div>
        <div class="row justify-content-center">
          <div class="col-lg-7">
            <div class="card p-4 p-md-5">
              <div class="mb-3">
                <label class="form-label fw-500">Pickup Location</label>
                <div class="input-wrapper">
                  <i class="fas fa-map-marker-alt input-icon text-success"></i>
                  <input type="text" id="aiPickup" class="form-control search-input" placeholder="e.g. Lahore">
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label fw-500">Dropoff Location</label>
                <div class="input-wrapper">
                  <i class="fas fa-flag-checkered input-icon text-danger"></i>
                  <input type="text" id="aiDropoff" class="form-control search-input" placeholder="e.g. Islamabad">
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label fw-500">Car Type</label>
                <div class="input-wrapper">
                  <i class="fas fa-tags input-icon"></i>
                  <select id="aiCarType" class="form-control search-input">
                    <option value="economy">Economy</option>
                    <option value="comfort">Comfort</option>
                    <option value="premium">Premium</option>
                  </select>
                </div>
              </div>
              <div class="mb-4">
                <label class="form-label fw-500">Passengers</label>
                <div class="input-wrapper">
                  <i class="fas fa-users input-icon"></i>
                  <input type="number" id="aiPassengers" class="form-control search-input" value="1" min="1" max="6">
                </div>
              </div>
              <button id="aiFareBtn" class="btn-glow w-100">
                <i class="fas fa-robot me-2"></i>Estimate Fare
              </button>
              <div id="aiFareResult" class="mt-4"></div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <div id="about" class="page">
    <div class="page-spacer"></div>
    <section class="section pt-5">
      <div class="container">
        <div class="row align-items-center mb-5">
          <div class="col-lg-6 mb-4 mb-lg-0">
            <span class="badge-verified mb-3">About Us</span>
            <h2 class="section-title">Connecting Riders & Drivers Since 2020</h2>
            <p class="text-muted mb-4">RideShare is an InDrive-style ride-sharing platform created for learning purposes. We believe in empowering both riders and drivers by letting them negotiate fair prices.</p>
            <p class="text-muted mb-4">Our platform connects thousands of daily commuters with verified drivers, making travel more affordable, convenient, and sustainable.</p>
            <div class="d-flex gap-3">
              <button class="btn-glow" onclick="showPage('book')">Book a Ride</button>
              <button class="btn btn-outline-secondary rounded-pill px-4" onclick="showPage('contact')">Contact Us</button>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="row g-3">
              <div class="col-6"><div class="card stat-box"><div class="stat-number">50K+</div><p class="text-muted mb-0">Happy Riders</p></div></div>
              <div class="col-6"><div class="card stat-box"><div class="stat-number">10K+</div><p class="text-muted mb-0">Verified Drivers</p></div></div>
              <div class="col-6"><div class="card stat-box"><div class="stat-number">100K+</div><p class="text-muted mb-0">Rides Completed</p></div></div>
              <div class="col-6"><div class="card stat-box"><div class="stat-number">4.9</div><p class="text-muted mb-0">Average Rating</p></div></div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <div id="contact" class="page">
    <div class="page-spacer"></div>
    <section class="section pt-5">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-8">
            <div class="text-center mb-5">
              <h2 class="section-title">Get In Touch</h2>
              <p class="section-subtitle">We're here to help! Send us a message.</p>
            </div>
            <div class="card p-4 p-md-5">
              <form id="contactForm">
                <div class="row g-3">
                  <div class="col-md-6">
                    <input type="text" id="contactName" class="form-control search-input" placeholder="Your Name" required>
                  </div>
                  <div class="col-md-6">
                    <input type="email" id="contactEmail" class="form-control search-input" placeholder="Your Email" required>
                  </div>
                  <div class="col-12">
                    <input type="text" class="form-control search-input" placeholder="Subject" required>
                  </div>
                  <div class="col-12">
                    <textarea id="contactMessage" class="form-control search-input" rows="5" placeholder="Your Message" required></textarea>
                  </div>
                </div>
                <button type="submit" class="btn-glow w-100 mt-4"><i class="fas fa-paper-plane me-2"></i>Send Message</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <footer class="py-4 mt-5">
    <div class="container text-center text-muted">
      <p class="mb-2">&copy; 2025 RideShare. All rights reserved.</p>
      <div class="d-flex justify-content-center gap-3 social-icons">
        <a href="#" class="text-muted"><i class="fab fa-facebook-f"></i></a>
        <a href="#" class="text-muted"><i class="fab fa-twitter"></i></a>
        <a href="#" class="text-muted"><i class="fab fa-instagram"></i></a>
        <a href="#" class="text-muted"><i class="fab fa-linkedin-in"></i></a>
      </div>
    </div>
  </footer>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      if (typeof initializeTheme === 'function') initializeTheme();
      if (typeof initAiFareEstimator === 'function') initAiFareEstimator();
    });
  </script>
</body>
</html>