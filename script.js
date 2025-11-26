// This script handles the dark mode toggle and saves the preference to localStorage.

const body = document.querySelector('body');
const modeToggle = document.querySelector('.toggle-switch');
const modeText = document.querySelector('.mode-text');

// 1. Check if the user already selected a theme preference
const currentMode = localStorage.getItem('theme');

// 2. Apply the saved theme immediately on load
if (currentMode === 'dark') {
    body.classList.add('dark');
    modeText.innerText = "Light mode";
}

// 3. Listen for the click event on the toggle switch
modeToggle.addEventListener("click", () => {
    // Toggle the 'dark' class on the body
    body.classList.toggle("dark");

    // Update the text and save the preference
    if(body.classList.contains("dark")){
        modeText.innerText = "Light mode";
        localStorage.setItem('theme', 'dark');
    } else {
        modeText.innerText = "Dark mode";
        localStorage.setItem('theme', 'light');
    }
});