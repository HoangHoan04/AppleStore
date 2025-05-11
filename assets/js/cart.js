// select giữa phần chọn giao hàng tận nơi hay chọn nhận tại cửa hàng
document.addEventListener("DOMContentLoaded", function () {

  const buttonCheckOut = document.getElementById("checkout-btn");
  const buttonApplyDiscount = document.getElementById("apply-discount");
  if (buttonCheckOut) {
    buttonCheckOut.addEventListener("click", (event) => {
      const myModal = new bootstrap.Modal(
        document.getElementById("paymentModal")
      );
      myModal.show();
    });
  } else {
    console.warn("Không tìm thấy nút checkout-btn");
  }

  // Xử lý xác nhận thanh toán
  document
    .getElementById("confirm-payment-btn")
    .addEventListener("click", function () {
      // Lấy phương thức thanh toán được chọn
      const paymentMethod = document.querySelector(
        'input[name="payment-method"]:checked'
      ).id;
      const note = document.getElementById("note-shipping-home");
      const selectedOption = document.getElementById("discount-code").selectedOptions[0];
      const discountId = parseInt(selectedOption.getAttribute("data-discount-id")) || null;
      const deliveryMethod = document.querySelector('input[name="delivery-method"]:checked').value;

      let citySelect, districtSelect, wardSelect, address;

      if (deliveryMethod == "2") {
          citySelect = document.getElementById("city-store").value;
          districtSelect = document.getElementById("district-store").value;
          wardSelect = document.getElementById("ward-store").value;
          address = document.getElementById("fill-address-store").value;
      } else {
          citySelect = document.getElementById("city").value;
          districtSelect = document.getElementById("district").value;
          wardSelect = document.getElementById("ward").value;
          address = document.getElementById("fill-address").value;
      }


      if(!citySelect || !districtSelect || !wardSelect || !address) {
        alert('Vui lòng nhập đầy đủ thông tin!')
        return;
      }

      const subtotal = parseFloat(
        document
          .getElementById("subtotal")
          .innerText.replace("đ", "")
          .replace(/\./g, "")
      );
      let methodValue = 1; // Mặc định tiền mặt

      if (paymentMethod === "banking") methodValue = 2;
      else if (paymentMethod === "momo") methodValue = 3;

      // Ví dụ dữ liệu bạn lấy từ form
      const data = {
        paymentMethod: methodValue,
        userName: document.getElementById("user-name").value,
        userPhone: document.getElementById("user-phone").value,
        userEmail: document.getElementById("user-email").value,
        note: note.value ? note.value : "no note",
        discountId: discountId,
        cartItems: JSON.parse(localStorage.getItem("cart") || "[]"), // lấy giỏ hàng từ localStorage
        orderPrice: subtotal,
        orderCity: citySelect,
        orderDistrict: districtSelect,
        orderWard: wardSelect,
        orderAddress: address,
        orderMethod: parseInt(deliveryMethod)
      };

      fetch("./functions/ordercode.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(data), // Chuyển đổi data thành JSON
      })
        .then((res) => res.json())
        .then((res) => {
          if (res.success) {
            alert("Đặt hàng thành công!");
            // Xóa giỏ hàng hoặc chuyển trang
            localStorage.removeItem("cart");
            location.reload();
          } else {
            alert("Lỗi: " + res.message);
          }
        });
    });

  document
    .getElementById("apply-discount")
    .addEventListener("click", function () {
      const discountPercentage = parseFloat(
        document.getElementById("discount-code").value
      ); // Lấy tỷ lệ giảm giá từ dropdown
      const subtotal = parseFloat(
        document
          .getElementById("subtotal")
          .innerText.replace("đ", "")
          .replace(/\./g, "")
      );
      
      let discountMessage = document.getElementById("discount-message");

      // Kiểm tra xem giá trị tỷ lệ giảm giá có hợp lệ không
      if (discountPercentage > 0) {
        const discountAmount = subtotal * (discountPercentage / 100); // Tính số tiền giảm giá
        const newTotal = subtotal - discountAmount; // Tính tổng mới sau khi giảm giá

        // Cập nhật tổng tiền và số tiền giảm
        document.getElementById("total-price").innerText =
          newTotal.toLocaleString("vi-VN") + "đ";
        discountMessage.innerText =
          "Mã giảm giá đã được áp dụng! Bạn đã tiết kiệm " +
          discountAmount.toLocaleString("vi-VN") +
          " VND.";
        discountMessage.classList.remove("text-danger");
        discountMessage.classList.add("text-success");

      } else {
        // Thông báo mã giảm giá không hợp lệ
        discountMessage.innerText = "Mã giảm giá không hợp lệ.";
        discountMessage.classList.remove("text-success");
        discountMessage.classList.add("text-danger");

        // Ẩn phần giảm giá nếu không hợp lệ
        discountAmountElement.style.display = "none";
      }
    });

  // Lấy giỏ hàng từ localStorage
  const cart = JSON.parse(localStorage.getItem("cart")) || [];
  const cartItemsContainer = document.getElementById("cart-items");
  const subtotalElement = document.getElementById("subtotal");
  const totalPriceElement = document.getElementById("total-price");

  let subtotal = 0; // Tính toán tổng tạm tính

  if(cart.length == 0) {
    buttonCheckOut.setAttribute('disabled', 'true');
    buttonApplyDiscount.setAttribute('disabled', 'true');
  }

  // Hiển thị sản phẩm trong giỏ hàng
  cart.forEach((item) => {
    // Thực hiện truy vấn Ajax để lấy thông tin sản phẩm từ DB
    fetch(`./functions/get_product_info.php?variantId=${item.productVariantId}`)
      .then((response) => {
        if (!response.ok) {
          throw new Error("Network response was not ok " + response.statusText);
        }
        return response.json();
      })
      .then((data) => {
        if (data.error) {
          console.error(data.error);
          return;
        }

        const li = document.createElement("li");
        li.className =
          "list-group-item d-flex justify-content-between align-items-center";

        const productImage = `<img src="./images/${data.productVariantImage}" alt="${data.productName}" class="img-fluid" style="max-width: 70px;">`;
        const productInfo = `
                  <div class="product-info ms-3" style="width:50%">
                      <div class="product-name mb-2">
                          <span>${data.productName}</span>
                      </div>
                      <div class="product-attributes">
                          <span>Màu: ${data.color}</span>
                      </div>
                      <div class="product-attributes">
                          <span>Dung lượng: ${data.storage}</span>
                      </div>
                  </div>`;

        const productPrice = `
          <div class="product-price text-success d-flex flex-column align-items-end">
            <span class="selling-price ">Đơn giá: ${formatCurrency(
              data.price
            )}</span>
          </div>`;

        const quantityControl = `
          <div class="quantity-control d-flex align-items-center m-2 me-4">
            <button class="btn btn-danger btn-sm decrease-quantity" data-variant-id="${data.productVariantId}">-</button>
            <input class="form-control form-control-sm quantity mx-2" value="${item.quantity}" min="1" style="width: 50px; text-align: center;" readonly>
            <button class="btn btn-success btn-sm increase-quantity" data-variant-id="${data.productVariantId}">+</button>
          </div>`;

        const productTotalPrice = `
          <div class="product-total-price text-success d-flex flex-column align-items-end">
            <span class="total-price " data-variant-price="${
              data.price
            }" data-variant-id="${data.productVariantId}">
              Tổng giá: ${formatCurrency(data.price * item.quantity)}
            </span>
          </div>`;

        const productDelete = `<button class="btn btn-outline-danger btn-sm delete-product" data-variant-id="${data.productVariantId}">Xóa</button>`;

        li.innerHTML = `${productImage}${productInfo}${productPrice}${quantityControl}${productTotalPrice}${productDelete}`;
        cartItemsContainer.appendChild(li);

        // Cộng dồn vào subtotal
        subtotal += data.price * item.quantity; // Nhân với số lượng
      })
      .then(() => {
        // Cập nhật subtotal và total price
        subtotalElement.textContent = formatCurrency(subtotal);
        totalPriceElement.textContent = formatCurrency(subtotal);
      })
      .catch((error) => {
        console.error(
          "There has been a problem with your fetch operation:",
          error
        );
      });
  });

  // Thêm sự kiện cho các nút tăng và giảm số lượng
  cartItemsContainer.addEventListener("click", function (event) {
    if (event.target.classList.contains("increase-quantity")) {
      const variantId = event.target.getAttribute("data-variant-id");
      const quantityInput =
        event.target.parentElement.querySelector(".quantity");
      let quantity = parseInt(quantityInput.value);
      quantity++;
      quantityInput.value = quantity;

      // Cập nhật giỏ hàng trong localStorage
      updateCart(variantId, quantity);
      updateSubtotal(); // Cập nhật subtotal sau khi thay đổi số lượng
      updateProductTotalPrice(variantId, quantity); // Cập nhật tổng giá cho sản phẩm
    } else if (event.target.classList.contains("decrease-quantity")) {
      const variantId = event.target.getAttribute("data-variant-id");
      const quantityInput =
        event.target.parentElement.querySelector(".quantity");
      let quantity = parseInt(quantityInput.value);
      if (quantity > 1) {
        quantity--;
        quantityInput.value = quantity;

        // Cập nhật giỏ hàng trong localStorage
        updateCart(variantId, quantity);
        updateSubtotal(); // Cập nhật subtotal sau khi thay đổi số lượng
        updateProductTotalPrice(variantId, quantity); // Cập nhật tổng giá cho sản phẩm
      }
    } else if (event.target.classList.contains("delete-product")) {
      // Xóa sản phẩm trong json và reload lại trang
      const variantId = event.target.getAttribute("data-variant-id");
      // Xóa sản phẩm trong giỏ hàng
      deleteProductFromCart(variantId);
      location.reload(); // Tải lại trang
    }
  });
});

// Hàm xóa sản phẩm khỏi giỏ hàng
function deleteProductFromCart(variantId) {
  // Lấy giỏ hàng từ localStorage
  let cartItems = JSON.parse(localStorage.getItem("cart") || "[]");

  // Tìm chỉ mục sản phẩm cần xóa
  const itemIndex = cartItems.findIndex(
    (item) => item.productVariantId == variantId
  );
  // Nếu tìm thấy sản phẩm, xóa nó
  if (itemIndex > -1) {
    cartItems.splice(itemIndex, 1); // Xóa sản phẩm khỏi mảng
    localStorage.setItem("cart", JSON.stringify(cartItems)); // Cập nhật giỏ hàng trong localStorage
  }
}

// Hàm cập nhật subtotal và tổng giá
function updateSubtotal() {
  let newSubtotal = 0;
  const subtotalElement = document.getElementById("subtotal");
  const totalPriceElement = document.getElementById("total-price");
  const cart = JSON.parse(localStorage.getItem("cart")) || [];

  cart.forEach((item) => {
      newSubtotal += item.price * item.quantity; // Cộng dồn giá mới
      // Cập nhật hiển thị tổng tiền
      subtotalElement.textContent = formatCurrency(newSubtotal);
      totalPriceElement.textContent = formatCurrency(newSubtotal);
  })    
}

// Hàm cập nhật tổng giá cho sản phẩm
function updateProductTotalPrice(variantId, quantity) {
  const totalPriceElement = document.querySelector(
    `.total-price[data-variant-id='${variantId}']`
  );
  if (totalPriceElement) {
    const price = parseFloat(
      totalPriceElement.getAttribute("data-variant-price")
    ); // Thay đổi dòng này để lấy giá đúng
    const newTotalPrice = price * quantity;
    totalPriceElement.textContent = `Tổng giá: ${formatCurrency(
      newTotalPrice
    )}`;
  }
}

// Hàm cập nhật giỏ hàng trong localStorage
function updateCart(variantId, quantity) {
  const cart = JSON.parse(localStorage.getItem("cart")) || [];
  const itemIndex = cart.findIndex(
    (item) => item.productVariantId == variantId
  );
  if (itemIndex > -1) {
    cart[itemIndex].quantity = quantity; // Cập nhật số lượng
  }
  localStorage.setItem("cart", JSON.stringify(cart)); // Lưu giỏ hàng
}

// Hàm định dạng số tiền
function formatCurrency(amount) {
  const roundedAmount = Math.round(amount);
  return roundedAmount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + "đ";
}
