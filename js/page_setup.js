// Core DOM elements
const html = document.documentElement;
const nav = document.querySelector('.main-nav');
const menuToggle = document.querySelector('.mobile-menu-toggle');
const themeToggle = document.getElementById('theme-toggle');
const backToTopBtn = document.getElementById('back-to-top');

// Initialize on DOM load
document.addEventListener('DOMContentLoaded', () => {
  initMobileMenu();
  initThemeSwitcher();
  initSmoothScroll();
  initScrollAnimations();
  initBackToTop();
  const loader = document.querySelector('.page-loader');
  loader.classList.remove('hidden');
});

// Mobile menu toggle
function initMobileMenu() {
  menuToggle.addEventListener('click', () => nav.classList.toggle('active'));
  
  document.querySelectorAll('.main-nav a').forEach(link => {
    link.addEventListener('click', () => {
      if (window.innerWidth <= 768) nav.classList.remove('active');
    });
  });

  window.addEventListener('resize', () => {
    if (window.innerWidth > 768) nav.classList.remove('active');
  });
}

// Theme switcher with localStorage support
function initThemeSwitcher() {
  const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
  const savedTheme = localStorage.getItem('theme') || (prefersDark ? 'dark' : 'light');
  
  html.setAttribute('data-theme', savedTheme);
  updateThemeIcon();

  themeToggle.addEventListener('click', () => {
    const newTheme = html.getAttribute('data-theme') === 'light' ? 'dark' : 'light';
    html.setAttribute('data-theme', newTheme);
    localStorage.setItem('theme', newTheme);
    updateThemeIcon();
  });
}

function updateThemeIcon() {
  const icon = themeToggle.querySelector('i');
  const isDark = html.getAttribute('data-theme') === 'dark';
  icon.classList.toggle('fa-moon', !isDark);
  icon.classList.toggle('fa-sun', isDark);
}

// Smooth scroll for anchor links
function initSmoothScroll() {
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', (e) => {
      e.preventDefault();
      const target = document.querySelector(anchor.getAttribute('href'));
      if (target) {
        window.scrollTo({
          top: target.offsetTop - 80,
          behavior: 'smooth'
        });
      }
    });
  });
}

// Scroll animations with IntersectionObserver
function initScrollAnimations() {
  const animatedElements = document.querySelectorAll(
    '.feature-item, .product-card, .banner-content, .banner-image, .section-header, .cta-content'
  );

  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    animatedElements.forEach(el => {
      el.style.opacity = '1';
      el.style.transform = 'none';
    });
    return;
  }
}

// Back to top button
function initBackToTop() {
  window.addEventListener('scroll', () => {
    backToTopBtn.classList.toggle('visible', window.pageYOffset > 300);
  });

  backToTopBtn.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
}

// Page loader
window.addEventListener('load', () => {
  const loader = document.querySelector('.page-loader');
  loader.classList.add('hidden');
});