let currentSlideIndex = 1;

function changeSlide(n) {
  showSlide((currentSlideIndex += n));
}

function currentSlide(n) {
  showSlide((currentSlideIndex = n));
}

function showSlide(n) {
  let slides = document.querySelectorAll(".slide");
  let dots = document.querySelectorAll(".dot");
  if (n > slides.length) {
    currentSlideIndex = 1;
  }
  if (n < 1) {
    currentSlideIndex = slides.length;
  }

  // Ẩn tất cả slide
  slides.forEach((slide) => (slide.style.display = "none"));

  // Ẩn tất cả dot
  dots.forEach((dot) => dot.classList.remove("active"));

  // Hiển thị slide hiện tại
  slides[currentSlideIndex - 1].style.display = "block";

  // Đánh dấu dot hiện tại
  dots[currentSlideIndex - 1].classList.add("active");
}

// Mặc định hiển thị slide đầu tiên
showSlide(currentSlideIndex);
