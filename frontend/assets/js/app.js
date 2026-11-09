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

document.addEventListener('DOMContentLoaded', () => {
    const timeInput = document.getElementById('appointment_time');
    if (!timeInput) return;

    timeInput.addEventListener('change', function() {
        const time = this.value;
        if (!time) return;
        
        const hour = parseInt(time.split(':')[0]);
        if (hour < 9 || hour >= 20) {
            this.style.borderColor = '#c0392b';
            this.setCustomValidity('Клиника работает с 09:00 до 20:00');
            this.reportValidity();
        } else {
            this.style.borderColor = '#ccc';
            this.setCustomValidity('');
        }
    });
});