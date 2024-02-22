<?php
// Kết nối đến CSDL
$conn = initConnection();
if (isset($_GET['id'])) {  // Nếu 'id' của category tồn tại thì thực hiện sửa
    $id = $_GET['id'];
    /* HIỂN THỊ RA THÔNG TIN CỦA DANH MỤC ĐANG SỬA */
    // Chuẩn bị câu truy vấn
    $sqlOldCategory = "SELECT * FROM categories WHERE id = $id";
    // Thực thi câu truy vấn
    $queryOldCategory = mysqli_query($conn, $sqlOldCategory);
    // Lấy dữ liệu
    if (mysqli_num_rows($queryOldCategory) > 0) {
        // Nếu tìm được bản ghi
        $resultOldCategory = mysqli_fetch_assoc($queryOldCategory);
    } else {
        // Nếu không tìm được bản ghi
        header("Location:index.php?page=category");
        exit(); // Thêm lệnh exit() để dừng thực thi script sau khi chuyển hướng
    }

    // Kiểm tra sự tồn tại của tên danh mục mới
    if (isset($_POST['sbm'])) {
        $cat_name = $_POST['ten']; // Lấy tên danh mục từ form gửi lên
        // Chuẩn bị câu truy vấn đến CSDL
        $sqlCheckExists = "SELECT * FROM categories WHERE ten = '$cat_name' AND id != $id";
        // Thực thi truy vấn đến CSDL
        $queryCheckExists = mysqli_query($conn, $sqlCheckExists);
        if (mysqli_num_rows($queryCheckExists) > 0) {
            $errorExists = '<div class="danger">Danh mục đã tồn tại rồi!</div>';
        } else {
            // Thực hiện sửa (UPDATE)
            $sqlUpdateCategory = "UPDATE categories SET ten = '$cat_name' WHERE id = $id";
            $queryUpdateCategory = mysqli_query($conn, $sqlUpdateCategory);
            if ($queryUpdateCategory) {
                header_remove(); //Hàm xóa bất cứ tiêu đề nào đã được gửi trước đó
?>
                <meta http-equiv="refresh" content="0;index.php?page=category">; <!-- Sử dụng để làm mới và chuyển hướng sang trang category -->
<?php
            }
        }
    }
} else {
    // Nếu trên đường dẫn id của category không tồn tại
    header("Location:index.php?page=category");
    exit(); // Thêm lệnh exit() để dừng thực thi script sau khi chuyển hướng
}
?>
<div class="col l-9">
    <div class="menu-left">
        <ul class="icon-and-title">
            <li class="icon-home">
                <a href="" class="breadcrumb">
                    <i class="fa-solid fa-users" style="margin-right: 10px;"></i>
                    <?php echo 'Danh mục ' . $resultOldCategory['id'] . ''; ?>
                </a>
            </li>
        </ul>
        <?php echo '<h1 class="page-header">Danh mục ' . $resultOldCategory['id'] . '</h1>'; ?>
        <?php
        if (isset($errorExists)) {
            echo $errorExists;
        }
        ?>
        <form action="" role="form" method="post">
            <div class="form-group">
                <label>Tên danh mục:</label>
                <!-- Cho value giá trị để insert ra danh mục theo từng id của nó -->
                <input type="text" name="ten" required value="<?php echo htmlspecialchars($resultOldCategory['ten']); ?>" class="form-control" placeholder="Tên danh mục...">
            </div>
            <button name="sbm" type="submit" class="btn-update">Cập Nhật</button>
            <button type="reset" class="btn-default">Làm mới</button>
        </form>
    </div>
</div>