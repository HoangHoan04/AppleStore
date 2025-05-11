// ============================================ MESSAGE TOAST ====================================================
document.addEventListener("DOMContentLoaded", function () {
  const alertMessage = document.getElementById("alert-message");

  if (alertMessage) {
    // Tự động ẩn thông báo sau 4 giây
    setTimeout(() => {
      alertMessage.style.display = "none";
    }, 4000);
  }

  // Đóng thông báo khi nhấn nút
  document.addEventListener("click", function (event) {
    if (event.target.classList.contains("close")) {
      const parentAlert = event.target.closest("#alert-message");
      if (parentAlert) {
        parentAlert.style.display = "none";
        script;
      }
    }
  });
});
// =============================================== PREVIEW IMAGE ADD/EDIT CATEGORY ========================================
document
  .getElementById("categoryImage")
  .addEventListener("change", function (event) {
    const file = event.target.files[0];
    const preview = document.getElementById("image-category-preview");

    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        preview.src = e.target.result;
      };
      reader.readAsDataURL(file);
    }
  });

document
  .getElementById("categoryLogo")
  .addEventListener("change", function (event) {
    const file = event.target.files[0];
    const preview = document.getElementById("logo-category-preview");

    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        preview.src = e.target.result;
      };
      reader.readAsDataURL(file);
    }
  });
document.getElementById("categoryName").addEventListener("keyup", function () {
  document.getElementById("categorySlug").value = convertToSlug(
    document.getElementById("categoryName").value
  );
});

// =============================================== PREVIEW IMAGE ADD/EDIT SLIDER ========================================
document
  .getElementById("sliderImage")
  .addEventListener("change", function (event) {
    const file = event.target.files[0];
    const preview = document.getElementById("image-slider-preview");

    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        preview.src = e.target.result;
      };
      reader.readAsDataURL(file);
    }
  });

// =============================================== PREVIEW IMAGE EDIT BLOG ========================================
document
  .getElementById("blogImage")
  .addEventListener("change", function (event) {
    const file = event.target.files[0];
    const preview = document.getElementById("image-blog-preview");

    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        preview.src = e.target.result;
      };
      reader.readAsDataURL(file);
    }
  });

document.getElementById("blogTitle").addEventListener("keyup", function () {
  document.getElementById("blogSlug").value = convertToSlug(
    document.getElementById("blogTitle").value
  );
});

tinymce.init({
  selector: "#myTextarea",
});
// =============================================== PREVIEW IMAGE ADD CATEGORY ========================================

// =============================================== PREVIEW IMAGE ADD CATEGORY ========================================

// =============================================== PREVIEW IMAGE ADD CATEGORY ========================================

// =============================================== PREVIEW IMAGE ADD CATEGORY ========================================

// =============================================== PREVIEW IMAGE ADD CATEGORY ========================================

// =============================================== PREVIEW IMAGE ADD CATEGORY ========================================

// =============================================== PREVIEW IMAGE ADD CATEGORY ========================================

// =============================================== PREVIEW IMAGE ADD CATEGORY ========================================
