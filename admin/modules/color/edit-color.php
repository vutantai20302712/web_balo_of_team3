<?php
// Kết nối đến CSDL
$conn = initConnection();
if (isset($_GET['id'])) {  // Nếu 'id' của category tồn tại thì thực hiện sửa
    $id = $_GET['id'];
    /* HIỂN THỊ RA THÔNG TIN CỦA Màu sắc ĐANG SỬA */
    // Chuẩn bị câu truy vấn
    $sqlOldcolor = "SELECT * FROM colors WHERE id = $id";
    // Thực thi câu truy vấn
    $queryOldcolor = mysqli_query($conn, $sqlOldcolor);
    // Lấy dữ liệu
    if (mysqli_num_rows($queryOldcolor) > 0) {
        // Nếu tìm được bản ghi
        $resultOldcolor = mysqli_fetch_assoc($queryOldcolor);
    } else {
        // Nếu không tìm được bản ghi
        header("Location:index.php?page=color");
        exit(); // Thêm lệnh exit() để dừng thực thi script sau khi chuyển hướng
    }

    // Kiểm tra sự tồn tại của tên Màu sắc mới
    if (isset($_POST['sbm'])) {
        $cat_name = $_POST['ten']; // Lấy tên Màu sắc từ form gửi lên
        // Chuẩn bị câu truy vấn đến CSDL
        $sqlCheckExists = "SELECT * FROM colors WHERE ten = '$cat_name' AND id != $id";
        // Thực thi truy vấn đến CSDL
        $queryCheckExists = mysqli_query($conn, $sqlCheckExists);
        if (mysqli_num_rows($queryCheckExists) > 0) {
            $errorExists = '<div class="danger">Màu sắc đã tồn tại rồi!</div>';
        } else {
            // Thực hiện sửa (UPDATE)
            $sqlUpdatecolor = "UPDATE colors SET ten = '$cat_name' WHERE id = $id";
            $queryUpdatecolor = mysqli_query($conn, $sqlUpdatecolor);
            if ($queryUpdatecolor) {
                header_remove(); //Hàm xóa bất cứ tiêu đề nào đã được gửi trước đó
?>
                <meta http-equiv="refresh" content="0;index.php?page=color">; <!-- Sử dụng để làm mới và chuyển hướng sang trang color -->
<?php
            }
        }
    }
} else {
    // Nếu trên đường dẫn id của color không tồn tại
    header("Location:index.php?page=color");
    exit(); // Thêm lệnh exit() để dừng thực thi script sau khi chuyển hướng
}
?>
<div class="col l-9">
    <div class="menu-left">
        <ul class="icon-and-title">
            <li class="icon-home">
                <a href="" class="breadcrumb">
                    <i class="fa-solid fa-users" style="margin-right: 10px;"></i>
                    <?php echo 'Màu sắc ' . $resultOldcolor['id'] . ''; ?>
                </a>
            </li>
        </ul>
        <?php echo '<h1 class="page-header">Màu sắc ' . $resultOldcolor['id'] . '</h1>'; ?>
        <?php
        if (isset($errorExists)) {
            echo $errorExists;
        }
        ?>
        <form action="" role="form" method="post">
            <div class="form-group">
                <label>Tên Màu sắc:</label>
                <!-- Cho value giá trị để insert ra Màu sắc theo từng id của nó -->
                <input type="text" name="ten" required value="<?php echo htmlspecialchars($resultOldcolor['ten']); ?>" class="form-control" placeholder="Tên màu sắc...">
            </div>
            <button name="sbm" type="submit" class="btn-update">Cập Nhật</button>
            <button type="reset" class="btn-default">Làm mới</button>
        </form>
    </div>
</div>