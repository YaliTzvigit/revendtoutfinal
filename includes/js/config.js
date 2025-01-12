

/* script */


/* Animation FadeIn */       

document.addEventListener("DOMContentLoaded", () => {
    const elements = document.querySelectorAll(".fade");

    // Function to add animation class
    const addAnimation = (element, offsetY = 0) => {
        const elementPosition = element.getBoundingClientRect().top;
        const screenPosition = window.innerHeight - offsetY;

        if (elementPosition < screenPosition) {
            element.classList.add("show");
        }
    };

    // Trigger animations on scroll
    const handleScroll = () => {
        elements.forEach((element) => addAnimation(element, 100));
    };

    // Initial load
    handleScroll();

    // On scroll
    window.addEventListener("scroll", handleScroll);
});