<?php
include("./includes/header.php");

$isLoggedIn = isset($_SESSION['user_id']);
if (!isset($_GET['productId']) || !is_numeric($_GET['productId'])) {
    die("Sản phẩm không hợp lệ.");
}
$productId = (int) $_GET['productId'];
$productQuery = "SELECT * FROM products WHERE productId = ?";
$stmt = $conn->prepare($productQuery);
$stmt->bind_param("i", $productId);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();

if (!$product) {
    die("Sản phẩm không tồn tại.");
}

$variantQuery = "
    SELECT 
        pv.productVariantId, 
        pv.productVariantImage, 
        pv.price, 
        MAX(CASE WHEN a.attributeName = 'Giá gốc' THEN pva.attributeValue ELSE NULL END) AS originPrice,
        GROUP_CONCAT(DISTINCT CASE 
            WHEN pva.attributeValue REGEXP '^[0-9]+(GB|TB|H|W)$' THEN pva.attributeValue 
            ELSE NULL 
        END ORDER BY pva.attributeValue SEPARATOR ', ') AS storage,
        GROUP_CONCAT(DISTINCT CASE 
            WHEN pva.attributeValue REGEXP '^[a-zA-Z]+$' THEN pva.attributeValue 
            ELSE NULL 
        END ORDER BY pva.attributeValue SEPARATOR ', ') AS color,
        GROUP_CONCAT(DISTINCT CASE 
            WHEN a.attributeName = 'Ảnh phụ' THEN pva.attributeValue 
            ELSE NULL 
        END ORDER BY pva.attributeValue SEPARATOR ', ') AS subImages
    FROM productvariants pv
    JOIN productvariantattributes pva ON pv.productVariantId = pva.productVariantId
    JOIN attributes a ON pva.attributeId = a.attributeId
    WHERE pv.productId = ? AND pv.productVariantStatus = 1
    GROUP BY pv.productVariantId
    ORDER BY CAST(SUBSTRING_INDEX(GROUP_CONCAT(pva.attributeValue ORDER BY pva.attributeValue SEPARATOR ','), ',', 1) AS UNSIGNED) ASC
";
$stmt = $conn->prepare($variantQuery);
$stmt->bind_param("i", $productId);
$stmt->execute();
$variants = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$defaultVariant = $variants[0] ?? null;
if (!$defaultVariant) {
    die("Không tìm thấy biến thể.");
}

?>

<div class="product-detail-container">
    <div class="product-image">
        <img id="main-product-image" src="./images/<?= htmlspecialchars($defaultVariant['productVariantImage']) ?>"
            alt="Ảnh sản phẩm" class="main-product-image">
        <div class="product-thumbnails" id="thumbnail-container">
            <?php foreach (explode(', ', $defaultVariant['subImages']) as $subImage): ?>
                <img src="./images/<?= htmlspecialchars($subImage) ?>" alt="Ảnh sản phẩm phụ" class="thumbnail-image"
                    data-image="./images/<?= htmlspecialchars($subImage) ?>">
            <?php endforeach; ?>
        </div>
    </div>

    <div class="product-info">
        <h1 class="fw-bold"><?= htmlspecialchars($product['productName']) ?></h1>
        <p>Giá:
            <span id="origin-price" style="text-decoration: line-through; color: gray;">
                <?= number_format($defaultVariant['originPrice'], 0, ',', '.') . '₫'; ?>
            </span>
            <span id="product-price" style="color: red; font-weight: bold;">
                <?= number_format($defaultVariant['price'], 0, ',', '.') . '₫'; ?>
            </span>
        </p>

        <div class="product-attributes">
            <span class="fw-bold">Dung lượng:</span>
            <ul class="variant-list" id="storage-options">
                <?php
                // Tạo mảng lưu trữ các biến thể dung lượng và màu sắc
                $storageVariants = [];

                // Lặp qua các biến thể để nhóm theo dung lượng và màu sắc
                foreach ($variants as $variant) {
                    $storage = $variant['storage'];
                    $color = $variant['color'];

                    if (!isset($storageVariants[$storage])) {
                        $storageVariants[$storage] = [
                            'variantId' => $variant['productVariantId'],
                            'price' => $variant['price'],
                            'originPrice' => $variant['originPrice'],
                            'defaultImage' => $variant['productVariantImage'],
                            'subImages' => $variant['subImages'],
                            'colors' => []
                        ];
                    }

                    $storageVariants[$storage]['colors'][$color] = [
                        'variantId' => $variant['productVariantId'],
                        'image' => $variant['productVariantImage'],
                        'subImages' => $variant['subImages']
                    ];
                }

                // Sắp xếp các dung lượng theo thứ tự tăng dần và hiển thị chúng
                uksort($storageVariants, function ($a, $b) {
                    // Đảm bảo "1T" luôn lớn nhất
                    if ($a === "1TB")
                        return 1;
                    if ($b === "1TB")
                        return -1;

                    // Nếu không phải "1T", so sánh như bình thường
                    return (int) filter_var($a, FILTER_SANITIZE_NUMBER_INT) - (int) filter_var($b, FILTER_SANITIZE_NUMBER_INT);
                });


                // Lặp qua các dung lượng và hiển thị chúng
                foreach ($storageVariants as $storage => $data):
                    ?>
                    <li class="variant-option" data-variant-id="<?= $data['variantId'] ?>"
                        data-price="<?= number_format($data['price'], 0, ',', '.') . '₫'; ?>"
                        data-origin-price="<?= number_format($data['originPrice'], 0, ',', '.') . '₫'; ?>"
                        data-default-image="./images/<?= htmlspecialchars($data['defaultImage']) ?>"
                        data-sub-images="<?= htmlspecialchars($data['subImages']) ?>"
                        data-storage="<?= htmlspecialchars($storage) ?>" data-colors='<?= json_encode($data["colors"]) ?>'>
                        <?= htmlspecialchars($storage) ?>
                    </li>
                <?php endforeach; ?>
            </ul>

            <span class="fw-bold">Màu sắc:</span>
            <ul class="variant-list" id="color-options"></ul>
        </div>

        <button class="add-to-cart">Thêm vào giỏ hàng</button>
        <div class="mt-4">
            <p class="fw-bold mb-0">Mô tả: </p>
            <p style="text-align: justify;"><?= $product['description'] ?></p>
        </div>
    </div>
</div>



<?php include("./includes/footer.php"); ?>


<style>
    .product-detail-container {
        display: flex;
        justify-content: space-between;
        margin: 20px;
    }

    .product-image {
        width: 40%;
        position: relative;
    }

    .main-product-image {
        width: 100%;
        max-height: 550px;
    }

    .product-thumbnails {
        display: flex;
        margin: 10px 40px 10px 40px;
        gap: 10px;
        justify-content: flex-start;
        height: 100px;
        overflow-x: auto;
        padding: 10px 0;
        gap: 10px;
    }

    .thumbnail-image {
        object-fit: cover;
        cursor: pointer;
        border-radius: 4px;
        border: solid black 1px;
        width: 100px;
        transition: transform 0.3s ease, border 0.3s ease;
    }

    .thumbnail-image:hover {
        transform: scale(1.1);
        border-color: #007bff;
    }

    .main-image-thumbnail {
        width: 80px;
        height: 80px;
        object-fit: cover;
        cursor: pointer;
        border: 1px solid #ddd;
        border-radius: 4px;
        transition: transform 0.3s ease, border 0.3s ease;
    }

    .main-image-thumbnail:hover {
        transform: scale(1.1);
        border-color: #007bff;
    }

    /* Phần thông tin sản phẩm */
    .product-info {
        width: 55%;
        /* Chiếm 35% chiều rộng */
        padding-left: 20px;
    }

    /* Tiêu đề sản phẩm */
    .product-info h1 {
        font-size: 28px;
        margin-bottom: 15px;
        color: #333;
    }

    /* Thông tin sản phẩm */
    .product-attributes {
        margin-bottom: 20px;
    }

    .product-attributes h3 {
        font-size: 20px;
        margin-bottom: 10px;
        color: #555;
    }

    .product-attributes {
        margin-top: 10px;
    }

    .variant-list {
        list-style: none;
        display: flex;
        gap: 10px;
        padding: 0;
    }

    .variant-option {
        padding: 10px 15px;
        border: 2px solid #ccc;
        border-radius: 20px;
        /* Bo tròn góc */
        cursor: pointer;
        font-size: 16px;
        font-weight: bold;
        transition: all 0.3s ease;
        background-color: #f9f9f9;
    }

    .variant-option:hover {
        background-color: #e0e0e0;
        border-color: #007bff;
    }

    .variant-option.selected {
        background-color: #007bff;
        color: white;
        border-color: #0056b3;
    }


    .product-attributes ul {
        list-style-type: none;
        padding: 0;
    }

    .product-attributes li {
        font-size: 16px;
        margin-bottom: 8px;
        color: #777;
    }

    /* Nút thêm vào giỏ hàng */
    .add-to-cart {
        padding: 12px 20px;
        font-size: 18px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .add-to-cart:hover {
        background-color: #0056b3;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Lấy tất cả các ảnh thu nhỏ
        const thumbnailImages = document.querySelectorAll('.thumbnail-image');
        const mainImage = document.getElementById('main-product-image');

        // Thêm sự kiện click vào các ảnh thu nhỏ
        thumbnailImages.forEach(thumbnail => {
            thumbnail.addEventListener('click', function () {
                // Khi nhấn vào ảnh thu nhỏ, thay đổi ảnh chính
                const newImageSrc = this.src;
                mainImage.src = newImageSrc; // Cập nhật ảnh chính
            });
        });

        // Thêm sự kiện click vào ảnh chính dưới ảnh thu nhỏ
        const mainImageThumbnail = document.querySelector('.main-image-thumbnail');
        if (mainImageThumbnail) {
            mainImageThumbnail.addEventListener('click', function () {
                // Khi nhấn vào ảnh chính dưới ảnh thu nhỏ, hiện lại ảnh chính ban đầu
                const initialImageSrc = './images/<?= htmlspecialchars($product['productVariantImage']) ?>';
                mainImage.src = initialImageSrc; // Hiển thị ảnh chính ban đầu
            });
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let selectedStorage = null;
        let selectedColor = null;
        let storageData = {};

        function updateProductDetails(image, subImages) {
            console.log("Cập nhật ảnh:", image);
            document.getElementById('main-product-image').src = image;

            const subImageArray = subImages.split(', ');
            const thumbnailContainer = document.getElementById('thumbnail-container');
            thumbnailContainer.innerHTML = '';

            subImageArray.forEach(image => {
                const imgElement = document.createElement('img');
                imgElement.src = `./images/${image}`;
                imgElement.classList.add('thumbnail');
                imgElement.addEventListener('click', function () {
                    document.getElementById('main-product-image').src = this.src;
                });
                thumbnailContainer.appendChild(imgElement);
            });
        }

        function selectStorage(storageItem) {
            selectedStorage = storageItem.dataset.storage;
            selectedColor = null;
            document.querySelectorAll('#storage-options .variant-option').forEach(i => i.classList.remove(
                'selected'));
            storageItem.classList.add('selected');

            // Lấy danh sách màu từ storage
            storageData = JSON.parse(storageItem.dataset.colors);
            const colorList = document.getElementById('color-options');
            colorList.innerHTML = '';

            Object.keys(storageData).forEach((color, index) => {
                const colorItem = document.createElement('li');
                colorItem.classList.add('variant-option');
                colorItem.textContent = color;
                colorItem.dataset.color = color;

                colorItem.addEventListener('click', function () {
                    selectedColor = this.dataset.color;
                    document.querySelectorAll('#color-options .variant-option').forEach(i => i
                        .classList.remove('selected'));
                    this.classList.add('selected');

                    // Cập nhật ảnh theo màu đã chọn
                    const variant = storageData[selectedColor];
                    updateProductDetails(`./images/${variant.image}`, variant.subImages);

                    // Cập nhật giá
                    const selectedVariantItem = document.querySelector(
                        `#storage-options .variant-option[data-variant-id="${variant.variantId}"]`
                    );
                    if (selectedVariantItem) {
                        const newPrice = selectedVariantItem.dataset.price;
                        const newOriginPrice = selectedVariantItem.dataset['originPrice'];

                        document.getElementById('product-price').textContent = newPrice;
                        document.getElementById('origin-price').textContent = newOriginPrice;
                    }
                });

                colorList.appendChild(colorItem);

                // Auto chọn màu đầu tiên
                if (index === 0) {
                    colorItem.click();
                }
            });
        }

        // Xử lý chọn dung lượng
        document.querySelectorAll('#storage-options .variant-option').forEach(item => {
            item.addEventListener('click', function () {
                selectStorage(this);
            });
        });

        // Auto chọn biến thể đầu tiên
        const firstStorageOption = document.querySelector('#storage-options .variant-option');
        if (firstStorageOption) {
            selectStorage(firstStorageOption);
        }

        // Thêm vào giỏ hàng
        document.querySelector('.add-to-cart').addEventListener('click', function () {
            const authUser = <?php echo json_encode($_SESSION['auth_user'] ?? []); ?>;

            // Kiểm tra rỗng đúng cách:
            if (!authUser || Object.keys(authUser).length === 0) {
                window.location.href = './login.php';
                return;
            }

            const selectedVariant = document.querySelector('#storage-options .variant-option.selected');
            if (selectedVariant) {
                const productVariantId = parseInt(selectedVariant.dataset.variantId);
                const productImage = selectedVariant.dataset.defaultImage;
                const productPriceString = selectedVariant.dataset.price;

                // Chuyển đổi giá
                const productPrice = parseFloat(productPriceString.replace(/[^\d]/g, '').replace(/,/g,
                    '')); // Xóa tất cả ký tự không phải số

                // Tạo đối tượng sản phẩm
                const cartItem = {
                    productVariantId: productVariantId,
                    quantity: 1, // Mặc định số lượng là 1
                    price: productPrice,
                    image: productImage,
                };

                // Lấy giỏ hàng từ localStorage
                const cart = JSON.parse(localStorage.getItem('cart')) || [];

                // Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng hay chưa
                const existingItemIndex = cart.findIndex(item => item.productVariantId ===
                    productVariantId);
                if (existingItemIndex > -1) {
                    // Nếu tồn tại, chỉ cần tăng số lượng
                    cart[existingItemIndex].quantity++;
                } else {
                    // Nếu không tồn tại, thêm sản phẩm vào giỏ hàng
                    cart.push(cartItem);
                }

                // Lưu giỏ hàng vào localStorage
                localStorage.setItem('cart', JSON.stringify(cart));
                alert('Sản phẩm đã được thêm vào giỏ hàng!');
            } else {
                alert('Vui lòng chọn dung lượng trước khi thêm vào giỏ hàng.');
            }
        });
    });
</script>