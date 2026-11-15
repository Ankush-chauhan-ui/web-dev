const mobileMenuBtn = document.getElementById('mobileMenuBtn');
const navLinks = document.getElementById('navLinks');

if (mobileMenuBtn && navLinks) {
  mobileMenuBtn.addEventListener('click', function () {
    
    navLinks.classList.toggle('show');
  });

  const allNavLinks = navLinks.querySelectorAll('a');
  allNavLinks.forEach(function (link) {
    link.addEventListener('click', function () {
      navLinks.classList.remove('show');
    });
  });
}

function filterCourses(category) {
  
  const buttons = document.querySelectorAll('.filter-btn');
  buttons.forEach(function (btn) {
    btn.classList.remove('active');
  });

  
  if (event && event.target) {
    event.target.classList.add('active');
  }

  const cards = document.querySelectorAll('.course-card');
  cards.forEach(function (card) {
    const cardCategory = card.getAttribute('data-category');

    if (category === 'all' || cardCategory === category) {
      card.style.display = 'flex';
    } else {
      card.style.display = 'none';
    }
  });
}

function handleFormSubmit(event) {
  const phone = document.getElementById('studentPhone').value.trim();

 
  if (!/^[0-9]{10}$/.test(phone)) {
    event.preventDefault(); 
    showAlert('Please enter a valid 10-digit mobile number.', 'error');
  }
}

document.addEventListener('DOMContentLoaded', function () {
  const params = new URLSearchParams(window.location.search);
  const status = params.get('status');
  if (!status) return;

  const messages = {
    success: ['Thank you! Your enquiry has been received. Our admission cell will contact you soon.', 'success'],
    invalid: ['Some details were invalid. Please check the form and try again.', 'error'],
    error: ['Something went wrong on our side. Please try again later.', 'error']
  };

  if (messages[status]) {
    showAlert(messages[status][0], messages[status][1]);
  }

  history.replaceState(null, '', window.location.pathname + '#contact');
});

function showAlert(msg, type) {
  const alertBox = document.getElementById('formAlert');
  if (!alertBox) return;

  alertBox.textContent = msg;
  alertBox.className = 'form-alert ' + type;
  alertBox.style.display = 'block';

  setTimeout(function () {
    alertBox.style.display = 'none';
  }, 5000);
}