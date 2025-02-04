// Get the toggle buttons and forms
const loginToggle = document.getElementById('loginToggle');
const signUpToggle = document.getElementById('signUpToggle');
const loginForm = document.getElementById('loginForm');
const signUpForm = document.getElementById('signUpForm');
const backToLogin = document.getElementById('backToLogin');

const loginBtn = document.getElementById('loginBtn');
const loginModal = document.getElementById('loginModal');
const closeModal = document.getElementById('closeModal');
// bar chart


// Function to show login form and hide sign-up
loginToggle.addEventListener('click', () => {
    loginForm.classList.add('active');
    signUpForm.classList.remove('active');
    loginToggle.classList.add('active');
    signUpToggle.classList.remove('active');
});

// Function to show sign-up form and hide login
signUpToggle.addEventListener('click', () => {
    signUpForm.classList.add('active');
    loginForm.classList.remove('active');
    signUpToggle.classList.add('active');
    loginToggle.classList.remove('active');
});

// Function to return to login form from sign-up
backToLogin.addEventListener('click', (e) => {
    e.preventDefault();
    loginForm.classList.add('active');
    signUpForm.classList.remove('active');
    loginToggle.classList.add('active');
    signUpToggle.classList.remove('active');
});

// Function for pop up after register
// Modal Functionality

loginBtn.addEventListener('click', () => {
    loginModal.style.display = 'flex';
});

closeModal.addEventListener('click', () => {
    loginModal.style.display = 'none';
});

window.addEventListener('click', (event) => {
    if (event.target === loginModal) {
        loginModal.style.display = 'none';
    }
});

// Bar Chart
const barCtx = document.getElementById('barChart').getContext('2d');
const barChart = new Chart(barCtx, {
    type: 'bar',
    data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June'],
        datasets: [{
            label: 'Sales',
            data: [10, 20, 30, 25, 40, 50],
            backgroundColor: [
                'rgba(255, 99, 132, 0.6)',
                'rgba(54, 162, 235, 0.6)',
                'rgba(75, 192, 192, 0.6)',
                'rgba(153, 102, 255, 0.6)',
                'rgba(255, 159, 64, 0.6)',
                'rgba(255, 206, 86, 0.6)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)',
                'rgba(255, 206, 86, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Line Graph
const lineCtx = document.getElementById('lineGraph').getContext('2d');
const lineGraph = new Chart(lineCtx, {
    type: 'line',
    data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June'],
        datasets: [{
            label: 'Revenue',
            data: [15, 25, 20, 35, 45, 60],
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 2,
            fill: true,
            tension: 0.3
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
// toggle for login
function togglePasswordVisibility() {
    const passwordInput = document.getElementById('password');
    const passwordIcon = document.getElementById('passwordIcon');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        passwordIcon.classList.remove('fa-eye');
        passwordIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        passwordIcon.classList.remove('fa-eye-slash');
        passwordIcon.classList.add('fa-eye');
    }
}
