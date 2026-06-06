// Data structure for simulated ride results
const RIDE_DATA = [
    { id: 1, driver: "Ali Khan", rating: 4.8, trips: 120, car: "Suzuki Cultus", type: "economy", price: 650, estTime: "15 min" },
    { id: 2, driver: "Sara Ahmed", rating: 4.9, trips: 85, car: "Honda City", type: "comfort", price: 900, estTime: "12 min" },
    { id: 3, driver: "Usman Tariq", rating: 4.7, trips: 210, car: "Toyota Corolla", type: "comfort", price: 800, estTime: "10 min" },
    { id: 4, driver: "Zainab Malik", rating: 5.0, trips: 45, car: "Hyundai Elantra", type: "premium", price: 1200, estTime: "18 min" },
    { id: 5, driver: "Fahad Nawaz", rating: 4.6, trips: 15, car: "Suzuki Alto", type: "economy", price: 550, estTime: "20 min" },
    { id: 6, driver: "Aisha Irfan", rating: 4.9, trips: 155, car: "Honda Civic", type: "premium", price: 1100, estTime: "14 min" },
];

let currentRides = [...RIDE_DATA];
let selectedRide = null;

/**
 * Global function to switch between pages (SPA navigation).
 * @param {string} pageId - The ID of the page to show (e.g., 'home', 'book').
 */
function showPage(pageId) {
    // Hide all pages
    document.querySelectorAll('.page').forEach(page => {
        page.classList.remove('active');
    });

    // Show the target page
    const targetPage = document.getElementById(pageId);
    if (targetPage) {
        targetPage.classList.add('active');
        window.scrollTo(0, 0); // Scroll to top on page change
    }

    // Update active state in navbar
    document.querySelectorAll('.nav-link').forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('onclick').includes(`showPage('${pageId}')`)) {
            link.classList.add('active');
        }
    });

    // Reset Book Ride steps if navigating away from Book page
    if (pageId !== 'book') {
        resetBookingSteps();
    }
}

/**
 * Toggles between light and dark themes.
 */
function toggleTheme() {
    const body = document.body;
    const currentTheme = body.getAttribute('data-bs-theme');
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
    
    body.setAttribute('data-bs-theme', newTheme);
    localStorage.setItem('theme', newTheme); // Save preference

    // Update the icon
    const themeIcon = document.getElementById('themeIcon');
    themeIcon.className = newTheme === 'dark' ? 'fas fa-sun text-warning' : 'fas fa-moon text-white';
}

/**
 * Initializes the theme based on user preference or system default.
 */
function initializeTheme() {
    const savedTheme = localStorage.getItem('theme');
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    let initialTheme = 'light';

    if (savedTheme) {
        initialTheme = savedTheme;
    } else if (prefersDark) {
        initialTheme = 'dark';
    }

    document.body.setAttribute('data-bs-theme', initialTheme);
    const themeIcon = document.getElementById('themeIcon');
    themeIcon.className = initialTheme === 'dark' ? 'fas fa-sun text-warning' : 'fas fa-moon text-white';

    // Show the initial page
    showPage('home');
}

/**
 * Shows a Bootstrap toast notification.
 * @param {string} title - The title of the toast.
 * @param {string} message - The body message.
 * @param {string} type - The toast type ('success', 'danger', 'info').
 */
function showToast(title, message, type = 'info') {
    const toastContainer = document.getElementById('toastContainer');
    if (!toastContainer) return;
    
    const iconMap = {
        'success': 'fas fa-check-circle text-success',
        'danger': 'fas fa-exclamation-triangle text-danger',
        'info': 'fas fa-info-circle text-primary'
    };
    
    // Create the toast HTML dynamically
    const toastHtml = `
        <div class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body d-flex align-items-center">
                    <i class="${iconMap[type]} me-2"></i>
                    <strong>${title}:</strong> ${message}
                </div>
                <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    `;

    const wrapper = document.createElement('div');
    wrapper.innerHTML = toastHtml;
    const toastElement = wrapper.firstChild;
    
    // Custom styling for toast based on theme
    const isDark = document.body.getAttribute('data-bs-theme') === 'dark';
    if (isDark) {
        toastElement.style.backgroundColor = 'rgba(33, 37, 41, 0.9)';
        toastElement.classList.add('text-white');
        toastElement.querySelector('.btn-close').classList.add('btn-close-white');
    } else {
        toastElement.style.backgroundColor = 'rgba(255, 255, 255, 0.9)';
        toastElement.classList.add('text-dark');
    }

    toastContainer.appendChild(toastElement);

    const toastBootstrap = new bootstrap.Toast(toastElement, { delay: 5000 });
    toastBootstrap.show();

    // Clean up toast element after it hides
    toastElement.addEventListener('hidden.bs.toast', () => {
        toastElement.remove();
    });
}

// --- BOOK RIDE LOGIC ---

/**
 * Resets the booking steps to the initial state.
 */
function resetBookingSteps() {
    const step1 = document.getElementById('step1');
    const step2 = document.getElementById('step2');
    const step3 = document.getElementById('step3');
    const results = document.getElementById('rideResults');
    const filters = document.getElementById('filtersSection');
    const summary = document.getElementById('bookingSummary');

    if (step1) step1.classList.add('active');
    if (step2) step2.classList.remove('active');
    if (step3) step3.classList.remove('active');
    if (results) results.innerHTML = '';
    if (filters) filters.style.display = 'none';
    if (summary) summary.style.display = 'none';
    
    selectedRide = null;
    currentRides = [...RIDE_DATA];
}

/**
 * Updates the visual progress steps.
 * @param {number} step - The current step number (1, 2, or 3).
 */
function updateBookingSteps(step) {
    const step1 = document.getElementById('step1');
    const step2 = document.getElementById('step2');
    const step3 = document.getElementById('step3');

    if (step1) step1.classList.toggle('active', step >= 1);
    if (step2) step2.classList.toggle('active', step >= 2);
    if (step3) step3.classList.toggle('active', step >= 3);
}

/**
 * Generates the HTML for a single ride offer card.
 * @param {object} ride - The ride data object.
 * @returns {string} The HTML for the card.
 */
function createRideCard(ride) {
    const carIcon = ride.type === 'economy' ? 'fas fa-car' : 
                    ride.type === 'comfort' ? 'fas fa-car-side' : 'fas fa-taxi';
    const typeLabel = ride.type.charAt(0).toUpperCase() + ride.type.slice(1);
    const isSelected = selectedRide && selectedRide.id === ride.id ? 'selected' : '';

    return `
        <div class="card p-3 mb-3 ride-offer ${isSelected}" data-ride-id="${ride.id}" onclick="selectRide(${ride.id})">
            <div class="row align-items-center">
                <div class="col-md-5 d-flex align-items-center">
                    <i class="${carIcon} ride-offer-icon me-3 text-primary"></i>
                    <div>
                        <h6 class="mb-0">${ride.driver} <i class="fas fa-check-circle text-success ms-1" style="font-size:0.8rem;"></i></h6>
                        <small class="text-muted">${ride.car} (${typeLabel})</small>
                    </div>
                </div>
                <div class="col-md-3 text-center">
                    <span class="badge bg-warning text-dark"><i class="fas fa-star me-1"></i>${ride.rating}</span>
                    <small class="text-muted ms-2">${ride.trips}+ trips</small>
                </div>
                <div class="col-md-2 text-center text-muted">
                    <i class="fas fa-clock me-1"></i>${ride.estTime}
                </div>
                <div class="col-md-2 text-end">
                    <h5 class="mb-0 text-success">PKR ${ride.price}</h5>
                </div>
            </div>
        </div>
    `;
}

/**
 * Searches for rides based on the provided criteria
 * @param {string} pickup - Pickup location
 * @param {string} drop - Drop location
 * @param {string} date - Date of the ride
 * @param {string} time - Time of the ride
 */
function searchRides(pickup, drop, date, time) {
    if (!pickup || !drop) {
        showToast('Error', 'Please enter both pickup and drop locations', 'danger');
        return;
    }

    // Store the search parameters for later use
    window.currentSearch = { pickup, drop, date, time };
    
    // Show loading state
    const searchBtn = document.querySelector('#bookForm button[type="submit"]');
    if (searchBtn) {
        searchBtn.disabled = true;
        searchBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Searching...';
    }

    // Simulate API call delay
    setTimeout(() => {
        // Reset button state
        if (searchBtn) {
            searchBtn.disabled = false;
            searchBtn.innerHTML = '<i class="fas fa-search me-2"></i>Search Available Rides';
        }

        // In a real app, this would be an API call to your backend
        // For now, we'll use the static RIDE_DATA
        currentRides = [...RIDE_DATA];
        
        // Update the UI with results
        renderRides(currentRides);
        updateBookingSteps(2);
        
        // Show filters and summary sections
        const filters = document.getElementById('filtersSection');
        const summary = document.getElementById('bookingSummary');
        if (filters) filters.style.display = 'block';
        if (summary) summary.style.display = 'block';
        
        // Update summary with search details
        const summaryContent = document.getElementById('summaryContent');
        if (summaryContent) {
            summaryContent.innerHTML = `
                <p class="mb-1"><strong>Pickup:</strong> ${pickup}</p>
                <p class="mb-3"><strong>Drop:</strong> ${drop}</p>
                <hr>
                <p class="mb-1"><strong>Date/Time:</strong> ${date} @ ${time}</p>
                <p class="text-muted">Select a ride to see details</p>
            `;
        }
        
        // Scroll to results
        const rideResultsSection = document.getElementById('rideResults');
        if (rideResultsSection) {
            rideResultsSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
        
        showToast('Search Complete', `Found ${currentRides.length} available rides`, 'success');
    }, 1500);
}

/**
 * Renders the ride results to the UI.
 * @param {Array} rides - The list of ride objects to render.
 */
function renderRides(rides) {
    const results = document.getElementById('rideResults');
    if (!results) return;
    
    results.innerHTML = rides.length ? '' : `
        <div class="alert alert-warning">No rides found. Try different locations.</div>
    `;
    
    rides.forEach(ride => {
        results.innerHTML += createRideCard(ride);
    });
    
    // Scroll to results
    results.scrollIntoView({ behavior: 'smooth' });
}

/**
 * Handles the ride search form submission.
 * @param {Event} event - The form submission event.
 */
document.getElementById('bookForm').addEventListener('submit', function(event) {
    event.preventDefault();
    
    const pickup = document.getElementById('pickup').value;
    const drop = document.getElementById('drop').value;
    const date = document.getElementById('date').value;
    const time = document.getElementById('time').value;
    
    // Show loading state
    const searchBtn = event.target.querySelector('button[type="submit"]');
    const originalBtnText = searchBtn.innerHTML;
    searchBtn.disabled = true;
    searchBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Searching...';
    
    // Simulate API call
    setTimeout(() => {
        currentRides = [...RIDE_DATA]; // Reset to all rides
        renderRides(currentRides);
        searchBtn.disabled = false;
        searchBtn.innerHTML = originalBtnText;
        
        // Show results section
        document.getElementById('filtersSection').style.display = 'block';
        document.getElementById('bookingSummary').style.display = 'block';
        
        // Update summary
        const summary = document.getElementById('summaryContent');
        if (summary) {
            summary.innerHTML = `
                <p><strong>From:</strong> ${pickup}</p>
                <p><strong>To:</strong> ${drop}</p>
                <p><strong>When:</strong> ${date} at ${time}</p>
                <p class="text-muted">Select a ride to continue</p>
            `;
        }
    }, 1000);
});

/**
 * Selects a ride and updates the summary sidebar.
 * @param {number} rideId - The ID of the selected ride.
 */
function selectRide(rideId) {
    selectedRide = RIDE_DATA.find(r => r.id === rideId);

    // Update step
    updateBookingSteps(2);

    // Remove 'selected' class from all, add to current
    document.querySelectorAll('.ride-offer').forEach(card => {
        card.classList.remove('selected');
        if (parseInt(card.dataset.rideId) === rideId) {
            card.classList.add('selected');
        }
    });

    // Update summary
    const summaryContent = document.getElementById('summaryContent');
    const pickup = document.getElementById('pickup').value;
    const drop = document.getElementById('drop').value;
    const date = document.getElementById('date').value;
    const time = document.getElementById('time').value;

    if (summaryContent && selectedRide) {
        summaryContent.innerHTML = `
            <p class="mb-1"><strong>Pickup:</strong> ${pickup}</p>
            <p class="mb-3"><strong>Drop:</strong> ${drop}</p>
            <hr>
            <p class="mb-1"><strong>Date/Time:</strong> ${date} @ ${time}</p>
            <p class="mb-1"><strong>Driver:</strong> ${selectedRide.driver}</p>
            <p class="mb-1"><strong>Car:</strong> ${selectedRide.car}</p>
            <h4 class="mt-3 text-primary">Fare: PKR ${selectedRide.price}</h4>
            <small class="text-muted">You can negotiate this price directly with the driver via chat after confirmation.</small>
        `;
        showToast('Ride Selected', `You have selected ${selectedRide.driver}'s ride for PKR ${selectedRide.price}.`, 'success');
    }
}

/**
 * Filters the list of displayed rides.
 * @param {string} type - The car type to filter by.
 * @param {HTMLElement} element - The filter button element clicked.
 */
function filterRides(type, element) {
    // Update active filter pill style
    document.querySelectorAll('.filter-pill').forEach(pill => pill.classList.remove('active'));
    element.classList.add('active');

    // Filter logic
    if (type === 'all') {
        currentRides = [...RIDE_DATA];
    } else {
        currentRides = RIDE_DATA.filter(ride => ride.type === type);
    }
    renderRides(currentRides);
}

/**
 * Sorts the currently displayed rides.
 * @param {string} sortBy - The property to sort by.
 */
function sortRides(sortBy) {
    if (sortBy === 'price') {
        currentRides.sort((a, b) => a.price - b.price);
    } else if (sortBy === 'rating') {
        currentRides.sort((a, b) => b.rating - a.rating);
    } else if (sortBy === 'trips') {
        currentRides.sort((a, b) => b.trips - a.trips);
    }
    renderRides(currentRides);
}

/**
 * Final confirmation of the booking.
 */
function confirmBooking() {
    if (!selectedRide) {
        showToast('Error', 'Please select a ride before confirming.', 'danger');
        return;
    }

    const pickup = document.getElementById('pickup')?.value || '';
    const drop = document.getElementById('drop')?.value || '';
    const date = document.getElementById('date')?.value || '';
    const time = document.getElementById('time')?.value || '';
    const passengers = parseInt(document.getElementById('passengers')?.value || '1', 10);

    const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const confirmBtn = document.querySelector('#bookingSummary .btn');
    if (confirmBtn) {
        confirmBtn.disabled = true;
        confirmBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Confirming...';
    }

    fetch('/bookings', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrf || ''
        },
        body: JSON.stringify({
            pickup,
            dropoff: drop,
            date,
            time,
            passengers,
            fare: selectedRide.price,
            driver_name: selectedRide.driver,
            status: 'confirmed'
        })
    }).then(async (res) => {
        const isJson = res.headers.get('content-type')?.includes('application/json');
        if (res.status === 401) {
            showToast('Login Required', 'Please login to confirm your booking.', 'warning');
            return;
        }
        if (!res.ok) {
            const msg = isJson ? (await res.json()).message : 'Failed to confirm booking';
            showToast('Error', msg || 'Failed to confirm booking', 'danger');
            return;
        }
        const data = isJson ? await res.json() : {};

        const summaryContent = document.getElementById('summaryContent');
        if (summaryContent && selectedRide) {
            summaryContent.innerHTML = `
                <h4 class="text-success text-center my-4">Booking Confirmed!</h4>
                <p class="text-center">Your driver, **${selectedRide.driver}**, is on their way.</p>
                <p class="text-center">Fare: <strong class="text-primary">PKR ${selectedRide.price}</strong></p>
                <div class="alert alert-info text-center mt-3">Booking ID: ${data?.booking?.id ?? 'N/A'}</div>
            `;
        }
        updateBookingSteps(3);
        showToast('Booking Confirmed', `You are booked with ${selectedRide.driver}!`, 'success');
    }).catch(() => {
        showToast('Error', 'Network error while confirming booking.', 'danger');
    }).finally(() => {
        if (confirmBtn) {
            confirmBtn.disabled = false;
            confirmBtn.innerHTML = '<i class="fas fa-check me-2"></i>Confirm Booking';
        }
    });
}

// --- OFFER RIDE & CONTACT FORM LOGIC ---

const offerForm = document.getElementById('offerForm');
if (offerForm) {
    offerForm.addEventListener('submit', function(event) {
        event.preventDefault();
        const driverName = document.getElementById('driverName').value;
        const driverPhone = document.getElementById('driverPhone').value;
        const carModel = document.getElementById('carModel').value;
        const carType = document.getElementById('carType').value;
        const routeFrom = document.getElementById('routeFrom').value;
        const routeTo = document.getElementById('routeTo').value;
        const seats = parseInt(document.getElementById('seats').value || '1', 10);
        const price = parseFloat(document.getElementById('price').value || '0');
        const notes = document.getElementById('notes').value;
        const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        const submitBtn = offerForm.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Publishing...';
        }

        fetch('/rides', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrf || ''
            },
            body: JSON.stringify({
                driver_name: driverName,
                driver_phone: driverPhone,
                car_model: carModel,
                car_type: carType,
                route_from: routeFrom,
                route_to: routeTo,
                seats,
                price_per_seat: price,
                notes
            })
        }).then(async (res) => {
            const isJson = res.headers.get('content-type')?.includes('application/json');
            if (res.status === 401) {
                showToast('Login Required', 'Please login to publish a ride.', 'warning');
                return;
            }
            if (!res.ok) {
                const msg = isJson ? (await res.json()).message : 'Failed to publish ride';
                showToast('Error', msg || 'Failed to publish ride', 'danger');
                return;
            }
            const data = isJson ? await res.json() : {};
            showToast('Success', `Ride from ${routeFrom} to ${routeTo} published by **${driverName}**!`, 'success');
            offerForm.reset();
        }).catch(() => {
            showToast('Error', 'Network error while publishing ride.', 'danger');
        }).finally(() => {
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-plus me-2"></i>Publish Your Ride';
            }
        });
    });
}


const contactForm = document.getElementById('contactForm');
if (contactForm) {
    contactForm.addEventListener('submit', function(event) {
        event.preventDefault();
        
        showToast('Thank You', 'Your message has been received. We will get back to you soon!', 'info');
        event.target.reset();
    });
}

// --- INITIALIZATION ---
window.onload = initializeTheme;
