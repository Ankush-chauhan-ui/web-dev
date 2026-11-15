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