

const body = document.querySelector('body');
const modeToggle = document.querySelector('.toggle-switch');
const modeText = document.querySelector('.mode-text');

const currentMode = localStorage.getItem('theme');
if (currentMode === 'dark') {
    body.classList.add('dark');
    modeText.innerText = "Light mode";
}

modeToggle.addEventListener("click", () => {
    body.classList.toggle("dark");
    if(body.classList.contains("dark")){
        modeText.innerText = "Light mode";
        localStorage.setItem('theme', 'dark');
    } else {
        modeText.innerText = "Dark mode";
        localStorage.setItem('theme', 'light');
    }
});