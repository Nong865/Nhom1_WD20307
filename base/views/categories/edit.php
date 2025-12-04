<?php 
// File: views/categories/edit.php
// KHÔNG dùng ob_start() và KHÔNG include header/footer ở đây

// Biến $category, $message, $type được truyền từ Controller qua hàm render()
$title = 'Chỉnh sửa Danh mục: ' . htmlspecialchars($category['name']);
?>

<div class="container-fluid">
    <h3 class="mb-4"><?= $title ?></h3>
    
    <?php if (!empty($message)): ?>
        <div class="alert alert-<?= $type ?> alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($message) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Form Chỉnh sửa Danh mục</h5>
        </div>
        <div class="card-body">
            <form action="index.php?action=CategoryUpdate" method="POST" class="row g-3 align-items-center">
                
                <input type="hidden" name="id" value="<?= $category['id'] ?>">

                <div class="col-8">
                    <label for="name" class="visually-hidden">Tên Danh mục</label>
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        class="form-control" 
                        placeholder="Tên Danh mục" 
                        value="<?= htmlspecialchars($category['name']) ?>"
                        required
                    >
                </div>
                
                <div class="col-4">
                    <button type="submit" class="btn btn-success me-2">
                        Cập nhật
                    </button>
                    <a href="index.php?action=tourCategory" class="btn btn-secondary">
                        Hủy
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>