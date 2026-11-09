document.addEventListener('DOMContentLoaded', () => {
  const slidesContainer = document.getElementById('slides');
  if (!slidesContainer) return; 

  const slides = document.querySelectorAll('.slides img');
  const prevBtn = document.getElementById('prevBtn');
  const nextBtn = document.getElementById('nextBtn');
  let currentIndex = 0;
  const totalSlides = slides.length;
  let autoPlayInterval;

  function goToSlide(index) {
    if (index < 0) currentIndex = totalSlides - 1;
    else if (index >= totalSlides) currentIndex = 0;
    else currentIndex = index;
    
    slidesContainer.style.transform = `translateX(-${currentIndex * 100}%)`;
  }

  function startAutoPlay() {
    autoPlayInterval = setInterval(() => {
      goToSlide(currentIndex + 1);
    }, 3000);
  }

  function resetAutoPlay() {
    clearInterval(autoPlayInterval);
    startAutoPlay();
  }

  nextBtn.addEventListener('click', () => { goToSlide(currentIndex + 1); resetAutoPlay(); });
  prevBtn.addEventListener('click', () => { goToSlide(currentIndex - 1); resetAutoPlay(); });

  startAutoPlay();
});