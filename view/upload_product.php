<?php /** @var ProductController $controller */ ?>

<link rel="stylesheet" href="assets/css/upload_products.css">

<div class="upload-container">
    <h2><?php echo $controller->edit_mode ? "Edit Product" : "Upload New Product"; ?></h2>

    <?php if (!empty($controller->success)) : ?>
        <div class="alert success"><?php echo $controller->success; ?></div>
    <?php endif; ?>
    <?php if (!empty($controller->error)) : ?>
        <div class="alert error"><?php echo $controller->error; ?></div>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <label>Product Name</label>
        <input type="text" name="product_name" 
               value="<?php echo $controller->edit_mode ? htmlspecialchars($controller->product['product_name']) : ''; ?>" required>

        <label>Description</label>
        <textarea name="description" rows="4" required><?php echo $controller->edit_mode ? htmlspecialchars($controller->product['product_description']) : ''; ?></textarea>

        <div class="row">
            <div class="column">
                <label>Price</label>
                <input type="number" step="0.01" name="price" 
                       value="<?php echo $controller->edit_mode ? $controller->product['price'] : ''; ?>" required>
            </div>
            <div class="column">
                <label>Old Price (Optional)</label>
                <input type="number" step="0.01" name="old_price" 
                       value="<?php echo $controller->edit_mode ? $controller->product['old_price'] : ''; ?>">
            </div>
        </div>

        <label>Stock Quantity</label>
        <input type="number" name="stock_quantity" 
               value="<?php echo $controller->edit_mode ? $controller->product['stock_quantity'] : ''; ?>" required>

        <label>Select Category</label>
        <select name="category_id" required>
            <option value="">-- Choose category --</option>
            <?php foreach($controller->categories as $cat): ?>
                <option value="<?= $cat['category_id']; ?>" <?= ($controller->edit_mode && $cat['category_id'] == $controller->product['category_id']) ? 'selected' : ''; ?>>
                    <?= ucfirst($cat['category_name']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Upload Product Image</label>
        <input type="file" name="image" accept="image/*" <?= $controller->edit_mode ? '' : 'required'; ?>>

        <button type="submit" name="upload" class="upload-btn">
            <?php echo $controller->edit_mode ? "Update Product" : "Upload Product"; ?>
        </button>
    </form>
</div>
