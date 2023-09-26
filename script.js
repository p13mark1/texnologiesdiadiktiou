// Accordion Functionality
document.addEventListener('DOMContentLoaded', () => {
  const accordions = document.querySelectorAll('.accordion');

  accordions.forEach((accordion) => {
    accordion.addEventListener('click', () => {
      accordion.classList.toggle('active');
    });
  });
});

// Dark Mode Functionality
function setTheme(theme) {
  document.body.className = theme;
  // Store theme preference in a cookie
  document.cookie = `theme=${theme}; path=/`;
}

// Check for theme preference in cookies
const storedTheme = document.cookie.replace(/(?:(?:^|.*;\s*)theme\s*=\s*([^;]*).*$)|^.*$/, '$1');
if (storedTheme === 'dark-mode') {
  setTheme('dark-mode');
}

// Toggle between light and dark theme on user click
document.addEventListener('DOMContentLoaded', () => {
  const themeToggle = document.querySelector('.theme-toggle');

  themeToggle.addEventListener('click', () => {
    const currentTheme = document.body.className;
    const newTheme = currentTheme === 'dark-mode' ? 'light-mode' : 'dark-mode';
    setTheme(newTheme);
  });
});
