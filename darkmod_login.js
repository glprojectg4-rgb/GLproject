const body = document.querySelector("body");
const toggle = document.querySelector(".toggle-switch");
const modeText = document.querySelector(".mode-text");
const leftSide = document.querySelector(".left-side");
const heroWrapper = document.querySelector(".hero-wrapper");

// Preload images to avoid blank during animation
const darkImage = new Image();
darkImage.src = "Image/blood-donation-tampa-cardio.png";
const lightImage = new Image();
lightImage.src = "Image/blood-donor.png";

// On page load
window.addEventListener("load", () => {
    const hero = document.querySelector(".right-hero");
    hero.classList.add("loaded");
});
toggle.addEventListener("click", () => {
    const darkMode = body.classList.toggle("dark");
    modeText.innerText = darkMode ? "Light mode" : "Dark mode";

    // تغيير صورة البطل بسلاسة
    const oldHero = heroWrapper.querySelector(".right-hero");
    const newSrc = darkMode ? darkImage.src : lightImage.src;

    oldHero.style.transition = "opacity 0.8s ease";
    oldHero.style.opacity = 0; // اختفاء تدريجي

    setTimeout(() => {
        oldHero.src = newSrc; // تغيير الصورة
        oldHero.style.opacity = 1; // ظهور تدريجي
    }, 400);

    // حركة الجهة اليسرى بشكل صحيح
    leftSide.style.transition = "transform 0.8s ease";
    if (darkMode) {
        leftSide.style.transform = "translateX(20px)";
    } else {
        leftSide.style.transform = "translateX(0)";
    }
});

