document.addEventListener('DOMContentLoaded', function() {
    const themeToggle = document.getElementById('themeToggle');
    const icon = themeToggle.querySelector('i');
    const darkThemeLink = document.createElement('link');
    
    // Set up dark theme stylesheet link
    darkThemeLink.rel = 'stylesheet';
    darkThemeLink.href = 'dark-theme.css';
    darkThemeLink.disabled = true;

    // Add dark theme stylesheet to document head
    document.head.appendChild(darkThemeLink);

    // Check for saved theme preference
    const darkMode = localStorage.getItem('darkMode') === 'true';

    // Apply saved theme on page load
    if (darkMode) {
        document.body.classList.add('dark-theme');
        darkThemeLink.disabled = false;
        icon.classList.replace('fa-sun', 'fa-moon');
    }

    // Toggle theme on button click
    themeToggle.addEventListener('click', () => {
        // Toggle body class
        document.body.classList.toggle('dark-theme');
        
        // Toggle stylesheet
        darkThemeLink.disabled = !darkThemeLink.disabled;

        // Update the icon
        const isDark = document.body.classList.contains('dark-theme');
        icon.classList.replace(isDark ? 'fa-sun' : 'fa-moon', isDark ? 'fa-moon' : 'fa-sun');

        // Save preference
        localStorage.setItem('darkMode', isDark);

        // Add animation to icon
        icon.style.animation = 'rotate 0.5s ease';
        setTimeout(() => icon.style.animation = '', 500);
    });
});

// Add rotate animation
const style = document.createElement('style');
style.textContent = `
    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
`;
document.head.appendChild(style);
