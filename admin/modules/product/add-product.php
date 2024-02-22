<?php
$conn = initConnection();
if (isset($_POST['sbm'])) {
    $prd_name = $_POST['ten_san_pham'];
    $prd_price = $_POST['gia'];
    $cat_id = $_POST['danh_muc_id'];
    $prd_status = $_POST['tinh_trang'];
    $prd_details = $_POST['mo_ta'];
    $so_luong = $_POST['so_luong'];
    $color = $_POST['colors'];
    $size = $_POST['sizes'];
    $so_ngan = $_POST['so_ngan'];
    $chat_lieu = $_POST['chat_lieu'];
    $thuonghieu = $_POST['thuong_hieu_id'];

    if (isset($_POST['san_pham_noi_bat'])) {
        $prd_featured = 1;
    } else {
        $prd_featured = 0;
    }

    if (!empty($_FILES['hinh_anh']['name'])) { // Kiểm tra nếu có tệp hình ảnh được tải lên
        $file_name = $_FILES['hinh_anh']['name'];
        $tmp_name = $_FILES['hinh_anh']['tmp_name'];
        $desc_path = '../assets/img/' . $file_name;
        move_uploaded_file($tmp_name, $desc_path);
    } else {
        $file_name = 'no_image.jpg'; // Nếu không có ảnh được tải lên, sử dụng ảnh mặc định
    }

    // Kiểm tra trùng tên sản phẩm
    $sqlExists = "SELECT * FROM products WHERE ten_san_pham = '$prd_name'";
    $queryExists = mysqli_query($conn, $sqlExists);

    if (mysqli_num_rows($queryExists) > 0) {
        $error = '<div class="danger">Tên sản phẩm đã tồn tại rồi!</div>';
    } else {
        $sqlInsertProduct = "INSERT INTO products (ten_san_pham, gia, danh_muc_id, tinh_trang, mo_ta, san_pham_noi_bat, hinh_anh , so_luong , colors , sizes, so_ngan , chat_lieu , thuong_hieu_id)
                         VALUES ('$prd_name', '$prd_price', '$cat_id', '$prd_status', '$prd_details', '$prd_featured', '$file_name' ,'$so_luong','$color','$size' ,'$so_ngan','$chat_lieu','$thuonghieu')";
        $queryInsertProduct = mysqli_query($conn, $sqlInsertProduct);
        if ($queryInsertProduct) {
            echo "<script>alert('Thêm mới sản phẩm thành công!');</script>";
            header_remove(); // Hàm xóa bất cứ tiêu đề nào đã được gửi trước đó
?>
            <meta http-equiv="refresh" content="0;index.php?page=product"> <!-- Sử dụng để làm mới và chuyển hướng sang trang category -->
<?php
        } else {
            echo "<script>alert('Thêm mới sản phẩm thất bại.');</script>";
            header("location:index.php?page=product");
        }
    }
}

?>

<div class="col l-9">
    <div class="menu-left">
        <ul class="icon-and-title">
            <liclass="icon-home">
                <a href="" class="breadcrumb">
                    <i class="fa-solid fa-bag-shopping" style="margin-right: 10px;"></i>
                    Trang thêm sản phẩm
                </a>
                </li>
        </ul>
        <h1 class="page-header">Thêm sản phẩm</h1>
        <div class="row sm-gutter">
            <div class="col l-6">
                <form action="" role="form" method="post" enctype="multipart/form-data">
                    <?php
                    if (isset($error)) {
                        echo $error;
                    }
                    ?>
                    <div class="form-group">
                        <label>Tên sản phẩm</label>
                        <input name="ten_san_pham" required class="form-control" placeholder="">
                    </div>
                    <div class="form-group">
                        <label>Giá sản phẩm</label>
                        <input name="gia" type="number" min="0" required class="form-control" placeholder="">
                    </div>
                    <div class="form-group">
                    <label>Màu sắc</label>
                    <?php
                    $sqlAllColors = "SELECT * FROM colors ORDER BY id";
                    $queryAllColors = mysqli_query($conn, $sqlAllColors);
                    ?>
                    <select name="colors" class="form-control">
                        <?php
                        while ($row = mysqli_fetch_assoc($queryAllColors)) {
                        ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo $row['ten']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                        <label>Số Ngăn</label>
                        <input name="so_ngan" type="number" min="0" required class="form-control" placeholder="">
                    </div>
                    <div class="form-group">
                        <label>Số lượng</label>
                        <input name="so_luong" type="number" min="0" required class="form-control" placeholder="">
                    </div>
                <div class="form-group">
                    <label>Kích thước</label>
                    <?php
                    $sqlAllSizes = "SELECT * FROM sizes ORDER BY id";
                    $queryAllSizes = mysqli_query($conn, $sqlAllSizes);
                    ?>
                    <select name="sizes" class="form-control">
                        <?php
                        while ($row = mysqli_fetch_assoc($queryAllSizes)) {
                        ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo $row['ten']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Thương Hiệu</label>
                    <?php
                    $sqlAllTrademark = "SELECT * FROM trademark ORDER BY id";
                    $queryAllTrademark = mysqli_query($conn, $sqlAllTrademark);
                    ?>
                    <select name="thuong_hieu_id" class="form-control">
                        <?php
                        while ($row = mysqli_fetch_assoc($queryAllTrademark)) {
                        ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo $row['ten']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                    <div class="form-group">
                        <label>Chất Liệu</label>
                        <input name="chat_lieu" type="text" required class="form-control" placeholder="">
                    </div>
                   
            </div>
            <div class="col l-6">
                <div class="form-group">
                    <label>Ảnh sản phẩm</label>
                    <input type="file" required name="hinh_anh" onchange="preview()">
                    <br>
                    <div>
                        <img src="../assets/img/Img_icon_and_logo/no_image.jpg" alt="" id="hinh_anh" width="120px" height="150px">
                    </div>
                </div>
                <div class="form-group">
                    <label>Danh mục</label>
                    <?php
                    $sqlAllCategories = "SELECT * FROM categories ORDER BY id";
                    $queryAllCategories = mysqli_query($conn, $sqlAllCategories);
                    ?>
                    <select name="danh_muc_id" class="form-control">
                        <?php
                        while ($row = mysqli_fetch_assoc($queryAllCategories)) {
                        ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo $row['ten']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Trạng thái</label>
                    <select name="tinh_trang" class="form-control">
                        <option value="1">Còn hàng</option>
                        <option value="0">Hết hàng</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Sản phẩm nổi bật</label>
                    <div class="checkbox">
                        <label>
                            <input name="san_pham_noi_bat" type="checkbox" value="1">
                            Nổi bật
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label>Mô tả sản phẩm</label>
                    <textarea name="mo_ta" class="form-control" rows="3"></textarea>
                </div>
                <button name="sbm" type="submit" class="btn-sucess">Thêm mới</button>
                <button type="reset" class="btn-default">Làm mới</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function preview() {
        hinh_anh.src=URL.createObjectURL(event.target.files[0]);
    }
</script>