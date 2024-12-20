// SlideShow
let currentIndex = 0;

function showSlides() {
    const slides = document.querySelectorAll('.slide');

    slides.forEach(slide => slide.classList.remove('active'));

    slides[currentIndex].classList.add('active');

    currentIndex = (currentIndex + 1) % slides.length;
}

// Mostra o primeiro slide e alterna a cada 5 segundos
showSlides();
setInterval(showSlides, 5000);
