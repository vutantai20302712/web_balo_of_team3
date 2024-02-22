<?php
// Kết nối đến CSDL
$conn = initConnection();
if (isset($_GET['id'])) {  // Nếu 'id' của size tồn tại thì thực hiện sửa
    $id = $_GET['id'];
    /* HIỂN THỊ RA THÔNG TIN CỦA DANH MỤC ĐANG SỬA */
    // Chuẩn bị câu truy vấn
    $sqlOldsize = "SELECT * FROM sizes WHERE id = $id";
    // Thực thi câu truy vấn
    $queryOldsize = mysqli_query($conn, $sqlOldsize);
    // Lấy dữ liệu
    if (mysqli_num_rows($queryOldsize) > 0) {
        // Nếu tìm được bản ghi
        $resultOldsize = mysqli_fetch_assoc($queryOldsize);
    } else {
        // Nếu không tìm được bản ghi
        header("Location:index.php?page=size");
        exit(); // Thêm lệnh exit() để dừng thực thi script sau khi chuyển hướng
    }

    // Kiểm tra sự tồn tại của tên danh mục mới
    if (isset($_POST['sbm'])) {
        $cat_name = $_POST['ten']; // Lấy tên danh mục từ form gửi lên
        // Chuẩn bị câu truy vấn đến CSDL
        $sqlCheckExists = "SELECT * FROM sizes WHERE ten = '$cat_name' AND id != $id";
        // Thực thi truy vấn đến CSDL
        $queryCheckExists = mysqli_query($conn, $sqlCheckExists);
        if (mysqli_num_rows($queryCheckExists) > 0) {
            $errorExists = '<div class="danger">Danh mục đã tồn tại rồi!</div>';
        } else {
            // Thực hiện sửa (UPDATE)
            $sqlUpdatesize = "UPDATE sizes SET ten = '$cat_name' WHERE id = $id";
            $queryUpdatesize = mysqli_query($conn, $sqlUpdatesize);
            if ($queryUpdatesize) {
                header_remove(); //Hàm xóa bất cứ tiêu đề nào đã được gửi trước đó
?>
                <meta http-equiv="refresh" content="0;index.php?page=size">; <!-- Sử dụng để làm mới và chuyển hướng sang trang size -->
<?php
            }
        }
    }
} else {
    // Nếu trên đường dẫn id của size không tồn tại
    header("Location:index.php?page=size");
    exit(); // Thêm lệnh exit() để dừng thực thi script sau khi chuyển hướng
}
?>
<div class="col l-9">
    <div class="menu-left">
        <ul class="icon-and-title">
            <li class="icon-home">
                <a href="" class="breadcrumb">
                    <i class="fa-solid fa-users" style="margin-right: 10px;"></i>
                    <?php echo 'Danh mục ' . $resultOldsize['id'] . ''; ?>
                </a>
            </li>
        </ul>
        <?php echo '<h1 class="page-header">Danh mục ' . $resultOldsize['id'] . '</h1>'; ?>
        <?php
        if (isset($errorExists)) {
            echo $errorExists;
        }
        ?>
        <form action="" role="form" method="post">
            <div class="form-group">
                <label>Tên kích thước:</label>
                <!-- Cho value giá trị để insert ra danh mục theo từng id của nó -->
                <input type="text" name="ten" required value="<?php echo htmlspecialchars($resultOldsize['ten']); ?>" class="form-control" placeholder="Tên kích thước...">
            </div>
            <button name="sbm" type="submit" class="btn-update">Cập Nhật</button>
            <button type="reset" class="btn-default">Làm mới</button>
        </form>
    </div>
</div>