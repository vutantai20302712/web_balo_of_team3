<!-- PHẦN THÂN THÊM thương hiệu -->
<?php
if (isset($_POST['sbm'])) {
    $conn = initConnection();
    $trademark_name = $_POST['ten']; // Lấy tên thương hiệu từ form gửi lên
    // Chuẩn bị câu truy vấn đến CSDL
    $sqlExists = "SELECT * FROM trademark WHERE ten = '$trademark_name'";
    // Thực thi truy vấn đến CSDL
    $queryExists = mysqli_query($conn, $sqlExists);
    if (mysqli_num_rows($queryExists) > 0) {
        $error = '<div class="danger">Thương hiệu đã tồn tại rồi!</div>';
    } else {
        // Thực hiện (INSERT))
        $sqlInsert = "INSERT INTO trademark(ten) VALUES ('$trademark_name')";
        $queryInsert = mysqli_query($conn, $sqlInsert);

        header_remove(); //Hàm xóa bất cứ tiêu đề nào đã được gửi trước đó
?>
        <meta http-equiv="refresh" content="0;index.php?page=trademark"> ;<!-- Sử dụng để làm mới và chuyển hướng sang trang category -->
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
                    Thêm thương hiệu
                </a>
            </li>
        </ul>
        <h1 class="page-header"> Thêm thương hiệu </h1>
        <?php
        if (isset($error)) {
            echo $error;
        }
        ?>
        <form action="" role="form" method="post">
            <div class="form-group">
                <label>Tên thương hiệu:</label>
                <input name="ten" required class="form-control" placeholder="Tên thương hiệu..." style="background-color: rgb(217, 217, 217); color: rgb(154, 156, 156);">
            </div>
            <button name="sbm" type="submit" class="btn-sucess">Thêm mới</button>
            <button type="reset" class="btn-default">Làm mới</button>
        </form>
    </div>