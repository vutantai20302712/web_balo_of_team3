<?php
// Kết nối đến CSDL
$conn = initConnection();
if (isset($_GET['id'])) {  // Nếu 'id' của trademark tồn tại thì thực hiện sửa
    $id = $_GET['id'];
    /* HIỂN THỊ RA THÔNG TIN CỦA Thương hiệu ĐANG SỬA */
    // Chuẩn bị câu truy vấn
    $sqlOldtrademark = "SELECT * FROM trademark WHERE id = $id";
    // Thực thi câu truy vấn
    $queryOldtrademark = mysqli_query($conn, $sqlOldtrademark);
    // Lấy dữ liệu
    if (mysqli_num_rows($queryOldtrademark) > 0) {
        // Nếu tìm được bản ghi
        $resultOldtrademark = mysqli_fetch_assoc($queryOldtrademark);
    } else {
        // Nếu không tìm được bản ghi
        header("Location:index.php?page=trademark");
        exit(); // Thêm lệnh exit() để dừng thực thi script sau khi chuyển hướng
    }

    // Kiểm tra sự tồn tại của tên Thương hiệu mới
    if (isset($_POST['sbm'])) {
        $cat_name = $_POST['ten']; // Lấy tên Thương hiệu từ form gửi lên
        // Chuẩn bị câu truy vấn đến CSDL
        $sqlCheckExists = "SELECT * FROM trademark WHERE ten = '$cat_name' AND id != $id";
        // Thực thi truy vấn đến CSDL
        $queryCheckExists = mysqli_query($conn, $sqlCheckExists);
        if (mysqli_num_rows($queryCheckExists) > 0) {
            $errorExists = '<div class="danger">Thương hiệu đã tồn tại rồi!</div>';
        } else {
            // Thực hiện sửa (UPDATE)
            $sqlUpdatetrademark = "UPDATE trademark SET ten = '$cat_name' WHERE id = $id";
            $queryUpdatetrademark = mysqli_query($conn, $sqlUpdatetrademark);
            if ($queryUpdatetrademark) {
                header_remove(); //Hàm xóa bất cứ tiêu đề nào đã được gửi trước đó
?>
                <meta http-equiv="refresh" content="0;index.php?page=trademark">; <!-- Sử dụng để làm mới và chuyển hướng sang trang trademark -->
<?php
            }
        }
    }
} else {
    // Nếu trên đường dẫn id của trademark không tồn tại
    header("Location:index.php?page=trademark");
    exit(); // Thêm lệnh exit() để dừng thực thi script sau khi chuyển hướng
}
?>
<div class="col l-9">
    <div class="menu-left">
        <ul class="icon-and-title">
            <li class="icon-home">
                <a href="" class="breadcrumb">
                    <i class="fa-solid fa-users" style="margin-right: 10px;"></i>
                    <?php echo 'Thương hiệu ' . $resultOldtrademark['id'] . ''; ?>
                </a>
            </li>
        </ul>
        <?php echo '<h1 class="page-header">Thương hiệu ' . $resultOldtrademark['id'] . '</h1>'; ?>
        <?php
        if (isset($errorExists)) {
            echo $errorExists;
        }
        ?>
        <form action="" role="form" method="post">
            <div class="form-group">
                <label>Tên Thương hiệu:</label>
                <!-- Cho value giá trị để insert ra Thương hiệu theo từng id của nó -->
                <input type="text" name="ten" required value="<?php echo htmlspecialchars($resultOldtrademark['ten']); ?>" class="form-control" placeholder="Tên Thương hiệu...">
            </div>
            <button name="sbm" type="submit" class="btn-update">Cập Nhật</button>
            <button type="reset" class="btn-default">Làm mới</button>
        </form>
    </div>
</div>