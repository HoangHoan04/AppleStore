<?php
include("../admin/includes/header.php");
?>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h4>Thêm biến thể sản phẩm</h4>

                    </div>
                    <div class="card-body">
                        <form action="code.php" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="productId">Sản phẩm</label>
                                    <?php
                                    $productId = $_GET['productId'];
                                    $query = "SELECT productName FROM products WHERE productId=$productId";
                                    $result = mysqli_query($conn, $query);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<input type='text' name='productName' id='productName' class='form-control' value='{$row['productName']}' step='0.001'
                                        required readOnly>";
                                    }
                                    echo "<input type='hidden' name='productId' value='{$productId}'>";
                                    ?>
                                </div>
                                <div class="col-md-12">
                                    <label for="price">Giá biến thể</label>
                                    <input type="number" name="price" id="price" class="form-control" step="0.001"
                                        required>
                                </div>
                                <div class="col-md-12">
                                    <label for="productVariantImage">Ảnh chính</label>
                                    <input type="file" accept="image/*" name="productVariantImage"
                                        id="productVariantImage" class="form-control" required>
                                </div>
                            </div>
                            <a href="javascript:void(0);" id="addAttributeBtn" class="btn btn-success">
                                <i class="fa-solid fa-circle-plus"></i>
                                <span class="ml-1">Thêm thuộc tính</span>
                            </a>
                            <div id="attributeContainer" class="mt-3">
                                <div class="row attribute-row">
                                    <div class="col-md-12">
                                        <label>Thuộc tính</label>
                                        <select id="attributeSelection" name="attributeValueId[]"
                                            class="form-control attribute-select" required>
                                            <option value="">-- Chọn thuộc tính --</option>
                                            <?php
                                            $query = "SELECT attributeId, attributeName FROM attributes";
                                            $result = mysqli_query($conn, $query);
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo "<option value='{$row['attributeId']}' data-name='{$row['attributeName']}'>{$row['attributeName']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <label>Giá trị</label>
                                        <input type="text" name="attributeValue[]" class="form-control attribute-value"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mt-3">
                                <p id="add_product_variant_warning"
                                    style="font-weight: bold; color: var(--red); width: 100%; text-align: center"></p>
                            </div>
                            <div class="col-md-12 mt-3">
                                <button type="submit" class="btn btn-success" name="add_product_variant_btn">
                                    <i class="fa-solid fa-circle-plus"></i> Thêm biến thể
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const addButton = document.getElementById("addAttributeBtn");
        const attributesContainer = document.getElementById("attributeContainer");
        const attributeRow = document.querySelector(".attribute-row");
        const imageAttributes = ["Ảnh phụ"];

        updateAttributeEvents(attributeRow);

        addButton.addEventListener("click", function () {
            const newRow = document.querySelector(".attribute-row").cloneNode(true);
            attributesContainer.appendChild(newRow);
            updateAttributeEvents(newRow);
        });

        function updateAttributeEvents(row) {
            const selectElement = row.querySelector(".attribute-select");
            const valueInput = row.querySelector(".attribute-value");
            valueInput.type = "text";
            valueInput.value = "";
            valueInput.name = "attributeValue[]";
            valueInput.removeAttribute("accept");
            selectElement.name = "attributeValueId[]";

            selectElement.addEventListener("change", function () {
                const selectElements = document.querySelectorAll(".attribute-select");
                const add_product_variant_warning = document.getElementById("add_product_variant_warning");
                const selectedOption = selectElement.options[selectElement.selectedIndex].text;

                // Tạo danh sách các option đã chọn (không tính chính select hiện tại)
                let selectedValues = new Set();
                selectElements.forEach(el => {
                    if (el !== selectElement && el.value) {
                        selectedValues.add(el.value);
                    }
                });

                // Kiểm tra nếu giá trị đã tồn tại
                if (selectedValues.has(selectElement.value) && !imageAttributes.includes(selectedOption)) {
                    add_product_variant_warning.innerText = `Thuộc tính "${selectedOption}" đã được chọn.`;
                    selectElement.value = ""; // Đặt lại giá trị rỗng
                    return;
                } else {
                    add_product_variant_warning.innerText = "";
                }

                // Kiểm tra nếu là ảnh thì chuyển input thành file
                if (imageAttributes.includes(selectedOption)) {
                    valueInput.type = "file";
                    valueInput.name = "attributeFile[]";
                    valueInput.accept = "image/*";
                    selectElement.name = "attributeFileId[]";
                } else {
                    valueInput.type = "text";
                    valueInput.name = "attributeValue[]";
                    valueInput.removeAttribute("accept");
                    selectElement.name = "attributeValueId[]";
                }
            });
        }
    });

</script>
<?php include("../admin/includes/footer.php"); ?>