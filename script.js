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