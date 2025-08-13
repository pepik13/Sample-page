document.addEventListener('DOMContentLoaded', () => {
  const slider = document.querySelector('.slider');
  if (!slider) return;
  const slides = slider.querySelector('.slides');
  const images = slides.querySelectorAll('img');
  let idx = 0;
  const update = () => { slides.style.transform = `translateX(-${idx * 100}%)`; };
  slider.querySelector('.prev').addEventListener('click', () => { idx = (idx - 1 + images.length) % images.length; update(); });
  slider.querySelector('.next').addEventListener('click', () => { idx = (idx + 1) % images.length; update(); });
  setInterval(() => { idx = (idx + 1) % images.length; update(); }, 5000);
});
