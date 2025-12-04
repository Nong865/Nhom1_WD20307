<h3>Sửa Album Tour #<?= $tour_id ?></h3>

<form method="POST">

<table class="table table-bordered">
    <tr>
        <th>Ảnh</th>
        <th>Caption</th>
        <th>Xóa</th>
    </tr>

    <?php foreach($album as $a): ?>
    <tr>
        <td width="200">
            <img src="<?= $a['image_path'] ?>" class="img-fluid border">
        </td>

        <td>
            <input type="text" name="caption[<?= $a['id'] ?>]"
                   value="<?= $a['caption'] ?>" class="form-control">
        </td>

        <td>
            <a href="index.php?action=editAlbum&tour_id=<?= $tour_id ?>&delete_id=<?= $a['id'] ?>"
               onclick="return confirm('Xóa ảnh này?')"
               class="btn btn-danger btn-sm">
                Xóa
            </a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<button name="update_caption" class="btn btn-success">Lưu caption</button>

</form>

<hr>

<h4>Thêm ảnh mới vào album:</h4>

<form method="POST" enctype="multipart/form-data">

    <input type="file" name="new_images[]" multiple class="form-control mb-3">

    <label>Caption cho ảnh mới:</label>
    <div id="newCaptions"></div>

    <button class="btn btn-primary mt-3">Thêm ảnh</button>

</form>

<script>
document.querySelector("input[name='new_images[]']").addEventListener("change", function () {
    let box = document.getElementById("newCaptions");
    box.innerHTML = "";

    [...this.files].forEach((file, i) => {
        box.innerHTML += `
            <input class="form-control mb-2" 
                   name="new_caption[${i}]" 
                   placeholder="Caption: ${file.name}">
        `;
    });
});
</script>
