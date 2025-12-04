<?php 

$title = "Quản lý Danh mục Tour"; 
// Bắt đầu bộ đệm đầu ra để lưu HTML vào biến $content
?>

<div class="container-fluid">
    <h3 class="mb-4">Quản lý Danh mục Tour</h3>
    
    <?php if (!empty($message)): ?>
        <div class="alert alert-<?= $type ?> alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($message) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"> Thêm Danh mục Mới</h5>
        </div>
        <div class="card-body">
            <form action="index.php?action=CategoryStore" method="POST" class="row g-3 align-items-center">
                <div class="col-8">
                    <label for="name" class="visually-hidden">Tên Danh mục</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Ví dụ: Tour Quốc tế" required>
                </div>
                <div class="col-4">
                    <button type="submit" class="btn btn-success w-100">Thêm</button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="card shadow">
        <div class="card-header bg-light">
            <h5 class="mb-0">Danh sách Danh mục Hiện có (<?= count($categories ?? []) ?>)</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead>
                            <tr>
                                <th scope="col" style="width: 5%;">ID</th>
                                <th scope="col" style="width: 50%;">Tên Danh mục</th>
                                <th scope="col" style="width: 15%;">Số Tour</th> <th scope="col" style="width: 30%;">Hành động</th>
                            </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $category): ?>
                            <tr>
                                <th scope="row"><?= $category['id'] ?></th>
                                <td><?= htmlspecialchars($category['name']) ?></td>
                                
                                <td><?= $category['tour_count'] ?></td> 
                                
                                <td>
                                    <a href="index.php?action=editCategory&id=<?= $category['id'] ?>" class="btn btn-primary btn-sm me-2">
                                        <i class="fas fa-edit"></i> Sửa
                                    </a>
                                    <a href="index.php?action=deleteCategory&id=<?= $category['id'] ?>" 
                                       class="btn btn-danger btn-sm" 
                                       onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục này không?');">
                                        <i class="fas fa-trash-alt"></i> Xóa
                                    </a>
                                                
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?php 
?>