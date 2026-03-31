<?php
// Kết nối cơ sở dữ liệu
include('config/dbcnn.php');
include('thanh/header.php');

// Lấy dữ liệu sản phẩm từ cơ sở dữ liệu
$query = "SELECT * FROM products";
$result = mysqli_query($conn, $query);

// Kiểm tra kết quả truy vấn
if (!$result) {
    die('Lỗi truy vấn: ' . mysqli_error($conn));
}
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Quản Lý Sản Phẩm</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Danh sách sản phẩm</li>
    </ol>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Danh Sách Sản Phẩm
                        <a href="add-product.php" class="btn btn-primary float-end">Thêm sản phẩm</a>
                    </h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Hình Ảnh</th>
                                <th>Tên Sản Phẩm</th>
                                <th>Mô Tả</th>
                                <th>Giá</th>
                                <th>Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($product = $result->fetch_assoc()): ?>
                                <tr>
                                    <!-- Cột ID -->
                                    <td><?php echo htmlspecialchars($product['id']); ?></td>
                                    
                                    <!-- Cột Hình ảnh -->
                                    <td>
                                        <?php 
                                            $image = $product['image'];
                                            // Kiểm tra xem ảnh có tồn tại và tạo đường dẫn cho ảnh
                                            $imagePath = !empty($image) ? '../img/products/' . (pathinfo($image, PATHINFO_EXTENSION) ? $image : $image . '.jpg') : 'img/products/default-image.jpg';
                                        ?>
                                        <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="Product Image" class="img-thumbnail" width="100" height="100">
                                    </td>
                                    
                                    <!-- Cột Tên sản phẩm -->
                                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                                    
                                    <!-- Cột Mô tả -->
                                    <td><?php echo htmlspecialchars($product['description']); ?></td>
                                    
                                    <!-- Cột Giá -->
                                    <td><?php echo number_format($product['price'], 0, ',', '.'); ?> đ</td>
                                    
                                    <!-- Cột Hành động -->
                                    <td>
                                        <a href="edit-product.php?id=<?php echo urlencode($product['id']); ?>" class="btn btn-warning btn-sm">Sửa</a>
                                        <a href="delete-product.php?id=<?php echo urlencode($product['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">Xóa</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('thanh/footer.php'); ?>
<?php include('thanh/script.php'); ?>
