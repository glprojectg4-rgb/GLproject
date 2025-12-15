const body = document.querySelector("body");
const toggle = document.querySelector(".toggle-switch");
const modeText = document.querySelector(".mode-text");
const leftSide = document.querySelector(".left-side");
const heroWrapper = document.querySelector(".hero-wrapper");


const darkImage = new Image();
darkImage.src = "Image/blood-donation-tampa-cardio.png";
const lightImage = new Image();
lightImage.src = "Image/blood-donor.png";


window.addEventListener("load", () => {
    const hero = document.querySelector(".right-hero");
    hero.classList.add("loaded");
});
toggle.addEventListener("click", () => {
    const darkMode = body.classList.toggle("dark");
    modeText.innerText = darkMode ? "Light mode" : "Dark mode";

    const oldHero = heroWrapper.querySelector(".right-hero");
    const newSrc = darkMode ? darkImage.src : lightImage.src;

    oldHero.style.transition = "opacity 0.8s ease";
    oldHero.style.opacity = 0;

    setTimeout(() => {
        oldHero.src = newSrc;
        oldHero.style.opacity = 1;
    }, 400);

    leftSide.style.transition = "transform 0.8s ease";
    if (darkMode) {
        leftSide.style.transform = "translateX(20px)";
    } else {
        leftSide.style.transform = "translateX(0)";
    }
});

