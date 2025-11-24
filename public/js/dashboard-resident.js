// Dashboard Resident page JavaScript

document.addEventListener('DOMContentLoaded', function() {
    // Logout button functionality
    const logoutButton = document.querySelector('.logout-button');
    if (logoutButton) {
        logoutButton.addEventListener('click', function() {
            if (confirm('Are you sure you want to logout?')) {
                // Redirect to logout or clear session
                window.location.href = '/logout';
            }
        });
    }

    // Navigation button clicks
    const navButtons = document.querySelectorAll('.nav-button');
    navButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            // Remove active class from all buttons
            navButtons.forEach(btn => btn.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');
        });
    });

    // Hero button functionality
    const submitRequestBtn = document.querySelector('.hero-button.primary');
    if (submitRequestBtn) {
        submitRequestBtn.addEventListener('click', function() {
            window.location.href = '/submit-request';
        });
    }

    const learnMoreBtn = document.querySelector('.hero-button.secondary');
    if (learnMoreBtn) {
        learnMoreBtn.addEventListener('click', function() {
            // Add learn more functionality
            alert('Learn more about Smart Neighborhood System');
        });
    }

    // View All button in Recent Activity
    const viewAllButton = document.querySelector('.view-all-button');
    if (viewAllButton) {
        viewAllButton.addEventListener('click', function() {
            window.location.href = '/my-requests';
        });
    }

    // Contact Support button
    const helpButton = document.querySelector('.help-button');
    if (helpButton) {
        helpButton.addEventListener('click', function() {
            window.location.href = '/support';
        });
    }

    // Quick action cards
    const actionCards = document.querySelectorAll('.action-card');
    actionCards.forEach(card => {
        card.addEventListener('click', function() {
            const title = this.querySelector('.action-title').textContent;
            if (title.includes('Submit')) {
                window.location.href = '/submit-request';
            } else if (title.includes('View My Requests')) {
                window.location.href = '/my-requests';
            } else if (title.includes('Dashboard')) {
                window.location.href = '/dashboard/resident';
            }
        });
    });
});

