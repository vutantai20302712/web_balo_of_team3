<!-- PHẦN THÂN THÊM DANH MỤC -->
<?php
if (isset($_POST['sbm'])) {
    $conn = initConnection();
    $cat_name = $_POST['ten']; // Lấy tên danh mục từ form gửi lên
    // Chuẩn bị câu truy vấn đến CSDL
    $sqlExists = "SELECT * FROM categories WHERE ten = '$cat_name'";
    // Thực thi truy vấn đến CSDL
    $queryExists = mysqli_query($conn, $sqlExists);
    if (mysqli_num_rows($queryExists) > 0) {
        $error = '<div class="danger">Danh mục đã tồn tại rồi!</div>';
    } else {
        // Thực hiện (INSERT))
        $sqlInsert = "INSERT INTO categories(ten) VALUES ('$cat_name')";
        $queryInsert = mysqli_query($conn, $sqlInsert);

        header_remove(); //Hàm xóa bất cứ tiêu đề nào đã được gửi trước đó
?>
        <meta http-equiv="refresh" content="0;index.php?page=category"> ;<!-- Sử dụng để làm mới và chuyển hướng sang trang category -->
<?php
    }
}
closeConnection();
?>
<div class="col l-9">
    <div class="menu-left">
        <ul class="icon-and-title">
            <li class="icon-home">
                <a href="" class="breadcrumb">
                    <i class="fa-solid fa-folder-open" style="margin-right: 10px;"></i>
                    Thêm danh mục
                </a>
            </li>
        </ul>
        <h1 class="page-header"> Thêm danh mục </h1>
        <?php
        if (isset($error)) {
            echo $error;
        }
        ?>
        <form action="" role="form" method="post">
            <div class="form-group">
                <label>Tên danh mục:</label>
                <input name="ten" required class="form-control" placeholder="Tên danh mục..." style="background-color: rgb(217, 217, 217); color: rgb(154, 156, 156);">
            </div>
            <button name="sbm" type="submit" class="btn-sucess">Thêm mới</button>
            <button type="reset" class="btn-default">Làm mới</button>
        </form>
    </div>