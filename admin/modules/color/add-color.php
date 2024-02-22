<!-- PHẦN THÂN THÊM Màu sắc -->
<?php
if (isset($_POST['sbm'])) {
    $conn = initConnection();
    $color_name = $_POST['ten']; // Lấy tên Màu sắc từ form gửi lên
    // Chuẩn bị câu truy vấn đến CSDL
    $sqlExists = "SELECT * FROM colors WHERE ten = '$color_name'";
    // Thực thi truy vấn đến CSDL
    $queryExists = mysqli_query($conn, $sqlExists);
    if (mysqli_num_rows($queryExists) > 0) {
        $error = '<div class="danger">Màu sắc đã tồn tại rồi!</div>';
    } else {
        // Thực hiện (INSERT))
        $sqlInsert = "INSERT INTO colors(ten) VALUES ('$color_name')";
        $queryInsert = mysqli_query($conn, $sqlInsert);

        header_remove(); //Hàm xóa bất cứ tiêu đề nào đã được gửi trước đó
?>
        <meta http-equiv="refresh" content="0;index.php?page=color"> ;<!-- Sử dụng để làm mới và chuyển hướng sang trang category -->
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
                    Thêm màu mới
                </a>
            </li>
        </ul>
        <h1 class="page-header"> Thêm Màu Sắc </h1>
        <?php
        if (isset($error)) {
            echo $error;
        }
        ?>
        <form action="" role="form" method="post">
            <div class="form-group">
                <label>Tên màu sắc:</label>
                <input name="ten" required class="form-control" placeholder="Tên màu sắc..." style="background-color: rgb(217, 217, 217); color: rgb(154, 156, 156);">
            </div>
            <button name="sbm" type="submit" class="btn-sucess">Thêm mới</button>
            <button type="reset" class="btn-default">Làm mới</button>
        </form>
    </div>