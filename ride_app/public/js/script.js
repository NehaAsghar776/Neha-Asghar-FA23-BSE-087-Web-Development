// Theme Management
function initializeTheme() {
    const savedTheme = localStorage.getItem('theme') || 'light';
    document.body.setAttribute('data-bs-theme', savedTheme);
    const icon = document.getElementById('themeIcon');
    if (icon) icon.className = savedTheme === 'dark' ? 'fas fa-sun text-white' : 'fas fa-moon text-white';
}

function toggleTheme() {
    const current = document.body.getAttribute('data-bs-theme');
    const next = current === 'dark' ? 'light' : 'dark';
    document.body.setAttribute('data-bs-theme', next);
    localStorage.setItem('theme', next);
    const icon = document.getElementById('themeIcon');
    if (icon) icon.className = next === 'dark' ? 'fas fa-sun text-white' : 'fas fa-moon text-white';
}

// Page Navigation
function showPage(pageId) {
    document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
    const page = document.getElementById(pageId);
    if (page) page.classList.add('active');
    document.querySelectorAll('.nav-link').forEach(l => l.classList.remove('active'));
    window.scrollTo(0, 0);
}

// Toast Notification
function showToast(title, message, type = 'info') {
    const container = document.getElementById('toastContainer');
    if (!container) return;
    const toast = document.createElement('div');
    toast.className = `toast align-items-center text-bg-${type} border-0 show mb-2`;
    toast.setAttribute('role', 'alert');
    toast.innerHTML = `
        <div class="d-flex">
            <div class="toast-body"><strong>${title}:</strong> ${message}</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" onclick="this.closest('.toast').remove()"></button>
        </div>`;
    container.appendChild(toast);
    setTimeout(() => toast.remove(), 4000);
}

// Quick Search
function quickSearch() {
    const pickup = document.getElementById('quickPickup')?.value;
    const drop = document.getElementById('quickDrop')?.value;
    if (pickup) document.getElementById('pickup').value = pickup;
    if (drop) document.getElementById('drop').value = drop;
    showPage('book');
}

// Rides Data
let allRides = [];
let selectedRide = null;

function filterRides(type, btn) {
    document.querySelectorAll('.filter-pill').forEach(p => p.classList.remove('active'));
    if (btn) btn.classList.add('active');
    const cards = document.querySelectorAll('.ride-card');
    cards.forEach(card => {
        card.style.display = (type === 'all' || card.dataset.type === type) ? 'block' : 'none';
    });
}

function sortRides(by) {
    const container = document.getElementById('rideResults');
    const cards = Array.from(container.querySelectorAll('.ride-card'));
    cards.sort((a, b) => {
        if (by === 'price') return parseInt(a.dataset.price) - parseInt(b.dataset.price);
        if (by === 'rating') return parseFloat(b.dataset.rating) - parseFloat(a.dataset.rating);
        if (by === 'trips') return parseInt(b.dataset.trips) - parseInt(a.dataset.trips);
        return 0;
    });
    cards.forEach(c => container.appendChild(c));
}

function selectRide(ride) {
    selectedRide = ride;
    const summary = document.getElementById('bookingSummary');
    const content = document.getElementById('summaryContent');
    if (summary) summary.style.display = 'block';
    if (content) {
        content.innerHTML = `
            <div class="mb-3"><strong>Driver:</strong> ${ride.driver}</div>
            <div class="mb-3"><strong>Car:</strong> ${ride.car}</div>
            <div class="mb-3"><strong>Type:</strong> ${ride.type}</div>
            <div class="mb-3"><strong>Fare:</strong> PKR ${ride.price}</div>
            <div class="mb-3"><strong>Est. Time:</strong> ${ride.estTime}</div>`;
    }
    updateBookingSteps(2);
}

function updateBookingSteps(step) {
    for (let i = 1; i <= 3; i++) {
        const el = document.getElementById('step' + i);
        if (el) el.classList.toggle('active', i <= step);
    }
}

function renderRides(rides) {
    const container = document.getElementById('rideResults');
    const filtersSection = document.getElementById('filtersSection');
    if (!container) return;
    if (rides.length === 0) {
        container.innerHTML = '<div class="alert alert-info">No rides found. Try different locations.</div>';
        if (filtersSection) filtersSection.style.display = 'none';
        return;
    }
    if (filtersSection) filtersSection.style.display = 'block';
    container.innerHTML = rides.map(ride => `
        <div class="card ride-card p-4 mb-3" data-type="${ride.type}" data-price="${ride.price}" data-rating="${ride.rating}" data-trips="${ride.trips}">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h5 class="mb-1">${ride.driver}</h5>
                    <small class="text-muted">${ride.car} &bull; ${ride.type}</small>
                    <div class="mt-1">
                        <i class="fas fa-star text-warning"></i>
                        <span>${ride.rating}</span>
                        <span class="text-muted ms-2">${ride.trips} trips</span>
                    </div>
                    ${ride.notes ? `<p class="text-muted mt-2 mb-0"><small>${ride.notes}</small></p>` : ''}
                </div>
                <div class="text-end">
                    <div class="fs-4 fw-bold text-primary">PKR ${ride.price}</div>
                    <small class="text-muted">${ride.estTime}</small>
                    <div class="mt-2">
                        <button class="btn btn-sm btn-warning rounded-pill px-3" onclick='selectRide(${JSON.stringify(ride)})'>
                            <i class="fas fa-check me-1"></i>Select
                        </button>
                    </div>
                </div>
            </div>
        </div>`).join('');
}

// Book Form
const bookForm = document.getElementById('bookForm');
if (bookForm) {
    bookForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const pickup = document.getElementById('pickup').value;
        const drop = document.getElementById('drop').value;
        fetch(`/rides?pickup=${encodeURIComponent(pickup)}&dropoff=${encodeURIComponent(drop)}`, {
            headers: { 'Accept': 'application/json' }
        }).then(res => res.json()).then(data => {
            allRides = data;
            renderRides(data);
            updateBookingSteps(1);
        }).catch(() => {
            showToast('Error', 'Could not fetch rides.', 'danger');
        });
    });
}

// Confirm Booking
function confirmBooking() {
    if (!selectedRide) return;
    const pickup = document.getElementById('pickup').value;
    const drop = document.getElementById('drop').value;
    const date = document.getElementById('date').value;
    const time = document.getElementById('time').value;
    const passengers = document.getElementById('passengers').value;
    const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const confirmBtn = document.querySelector('#bookingSummary button');
    if (confirmBtn) {
        confirmBtn.disabled = true;
        confirmBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Confirming...';
    }
    fetch('/bookings', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf || '' },
        body: JSON.stringify({
            pickup, dropoff: drop, date, time, passengers,
            fare: selectedRide.price,
            driver_name: selectedRide.driver,
            ride_id: selectedRide.id,
            status: 'pending'
        })
    }).then(async res => {
        const isJson = res.headers.get('content-type')?.includes('application/json');
        const data = isJson ? await res.json() : {};
        const summaryContent = document.getElementById('summaryContent');
        if (summaryContent && selectedRide) {
            summaryContent.innerHTML = `
                <h4 class="text-success text-center my-4">Booking Confirmed!</h4>
                <p class="text-center">Your driver, ${selectedRide.driver}, is on their way.</p>
                <p class="text-center">Fare: <strong class="text-primary">PKR ${selectedRide.price}</strong></p>
                <div class="alert alert-info text-center mt-3">Booking ID: ${data?.booking?.id ?? 'N/A'}</div>`;
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

// Offer Ride Form
const offerForm = document.getElementById('offerForm');
if (offerForm) {
    offerForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        const submitBtn = offerForm.querySelector('button[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Publishing...';
        }
        fetch('/rides', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf || '' },
            body: JSON.stringify({
                driver_name: document.getElementById('driverName').value,
                driver_phone: document.getElementById('driverPhone').value,
                car_model: document.getElementById('carModel').value,
                car_type: document.getElementById('carType').value,
                route_from: document.getElementById('routeFrom').value,
                route_to: document.getElementById('routeTo').value,
                seats: parseInt(document.getElementById('seats').value || '1'),
                price_per_seat: parseFloat(document.getElementById('price').value || '0'),
                notes: document.getElementById('notes').value
            })
        }).then(async res => {
            const isJson = res.headers.get('content-type')?.includes('application/json');
            if (!res.ok) {
                const msg = isJson ? (await res.json()).message : 'Failed to publish ride';
                showToast('Error', msg || 'Failed to publish ride', 'danger');
                return;
            }
            showToast('Success', 'Ride published successfully!', 'success');
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

// Contact Form
function handleContactSubmit(event) {
    event.preventDefault();
    const name = document.getElementById('contactName')?.value;
    const email = document.getElementById('contactEmail')?.value;
    const message = document.getElementById('contactMessage')?.value;
    const subject = `RideShare Query from ${name}`;
    const body = `Name: ${name}\nEmail: ${email}\n\nMessage:\n${message}`;
    window.location.href = `mailto:support@rideshare.com?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(body)}`;
    showToast('Opening Email', 'Opening your default email client...', 'info');
    event.target.reset();
}
const contactForm = document.getElementById('contactForm');
if (contactForm) contactForm.addEventListener('submit', handleContactSubmit);

// AI Fare Estimator
function initAiFareEstimator() {
    const aiBtn = document.getElementById('aiFareBtn');
    const aiResult = document.getElementById('aiFareResult');
    if (!aiBtn) return;
    aiBtn.addEventListener('click', async function () {
        const pickup = document.getElementById('aiPickup').value;
        const dropoff = document.getElementById('aiDropoff').value;
        const carType = document.getElementById('aiCarType').value;
        const passengers = document.getElementById('aiPassengers').value;
        if (!pickup || !dropoff) {
            showToast('Error', 'Please enter pickup and dropoff locations.', 'danger');
            return;
        }
        aiBtn.disabled = true;
        aiBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Estimating...';
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        try {
            const res = await fetch('/ai/fare-estimate', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': token },
                body: JSON.stringify({ pickup, dropoff, car_type: carType, passengers })
            });
            const data = await res.json();
            if (data.success) {
                aiResult.innerHTML = `
                    <div class="alert alert-success mt-3">
                        <h5>🤖 AI Fare Estimate</h5>
                        <p><strong>Distance:</strong> ${data.distance_km} km</p>
                        <p><strong>Base Fare:</strong> Rs. ${data.breakdown.base_fare}</p>
                        <p><strong>Peak Surcharge:</strong> Rs. ${data.breakdown.peak_surcharge}</p>
                        <p><strong>Total Estimated Fare:</strong> <span class="fs-4 text-success">Rs. ${data.estimated_fare}</span></p>
                    </div>`;
            }
        } catch (e) {
            showToast('Error', 'AI estimation failed.', 'danger');
        } finally {
            aiBtn.disabled = false;
            aiBtn.innerHTML = '<i class="fas fa-robot me-2"></i>Estimate Fare';
        }
    });
}

// Initialize
window.onload = function() {
    initializeTheme();
    initAiFareEstimator();
};