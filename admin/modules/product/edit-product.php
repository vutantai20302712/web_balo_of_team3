<?php

/** SỬA SẢN PHẨM */
$conn = initConnection();
if (isset($_GET['id'])) {
    $prd_id = $_GET['id'];
    //Lấy thông tin sản phẩm cũ
    $sqlEditProduct = "SELECT * FROM products WHERE id = $prd_id";
    $queryEditProduct = mysqli_query($conn, $sqlEditProduct);
    if (mysqli_num_rows($queryEditProduct) > 0) {
        $productTT = mysqli_fetch_assoc($queryEditProduct);
        //Sửa sản phẩm
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

            if (!empty($_FILES['hinh_anh']['name'])) { //nếu có sửa ảnh
                $file_name = $_FILES['hinh_anh']['name'];
                $tmp_name = $_FILES['hinh_anh']['tmp_name'];
                $desc_path = '../assets/img/' . $file_name;
                move_uploaded_file($tmp_name, $desc_path);
            } else {
                $file_name =  $productTT['hinh_anh']; //nếu không sửa ảnh
            }


            //Viết câu truy vấn update
            $sqlUpdateProduct = "UPDATE products SET                                     
                                    ten_san_pham = '$prd_name',
                                    gia = '$prd_price',
                                    danh_muc_id = '$cat_id', 
                                    tinh_trang = '$prd_status',
                                    mo_ta = '$prd_details',
                                    san_pham_noi_bat = '$prd_featured',
                                    hinh_anh =  '$file_name',  
                                    so_luong = '$so_luong',
                                    colors = '$color',
                                    sizes = '$size',
                                    so_ngan = '$so_ngan',
                                    chat_lieu = '$chat_lieu',
                                    thuong_hieu_id = '$thuonghieu'                       

                                    WHERE id = $prd_id";
            $queryUpdateProduct = mysqli_query($conn, $sqlUpdateProduct);
            if ($queryUpdateProduct) {
                echo "<script>alert('Sửa sản phẩm thành công!');</script>";
                header_remove(); //Hàm xóa bất cứ tiêu đề nào đã được gửi trước đó
             ?>
                <meta http-equiv="refresh" content="0;index.php?page=product"> ;<!-- Sử dụng để làm mới và chuyển hướng sang trang category -->
             <?php
            }
        }
    } else {
        echo "<script>alert('Không tìm thấy sản phẩm.');</script>";
        header("location:index.php?page=product");
    }
} else {
    echo "<script>alert('Không tìm thấy sản phẩm.');</script>";
    header("location:index.php?page=product");
}
?>
<div class="col l-9">
    <div class="menu-left">
        <ul class="icon-and-title">
            <li class="icon-home">
                <a href="" class="breadcrumb">
                    <i class="fa-solid fa-bag-shopping" style="margin-right: 10px;"></i>
                    <?php echo $productTT['ten_san_pham']; ?>
                </a>
            </li>
        </ul>


        <h1 class="page-header">Sản phẩm: <?php echo $productTT['id']; ?></h1>
        <div class="row sm-gutter">
            <div class="col l-6">
                <form action="" role="form" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Tên sản phẩm</label>
                        <input type="text" name="ten_san_pham" required class="form-control" value="<?php echo $productTT['ten_san_pham']; ?>" placeholder="">
                    </div>

                    <div class="form-group">
                        <label>Giá sản phẩm</label>
                        <input type="number" name="gia" required value="<?php echo $productTT['gia']; ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label>Số ngăn</label>
                        <input name="so_ngan" type="text" required value="<?php echo $productTT['so_ngan']; ?>" class="form-control" placeholder="">
                    </div>
                    <div class="form-group">
                        <label>Số lượng</label>
                        <input type="number" name="so_luong" required value="<?php echo $productTT['so_luong']; ?>" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                    <label>Màu sắc</label>
                    <?php
                    $sqlAllcolors = "SELECT * FROM colors ORDER BY id";
                    $queryAllcolors = mysqli_query($conn, $sqlAllcolors);
                    ?>
                    <select name="colors" class="form-control">
                        <?php
                        while ($row = mysqli_fetch_assoc($queryAllcolors)) {
                        ?>
                            <option <?php
                                    if ($productTT['colors'] == $row['id']) {
                                        echo 'selected';
                                    }
                                    ?> value=<?php echo $row['id']; ?>><?php echo $row['ten']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Kích Thước</label>
                    <?php
                    $sqlAllsizes = "SELECT * FROM sizes ORDER BY id";
                    $queryAllsizes = mysqli_query($conn, $sqlAllsizes);
                    ?>
                    <select name="sizes" class="form-control">
                        <?php
                        while ($row = mysqli_fetch_assoc($queryAllsizes)) {
                        ?>
                            <option <?php
                                    if ($productTT['sizes'] == $row['id']) {
                                        echo 'selected';
                                    }
                                    ?> value=<?php echo $row['id']; ?>><?php echo $row['ten']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Thương hiệu</label>
                    <?php
                    $sqlAlltrademark = "SELECT * FROM trademark ORDER BY id";
                    $queryAlltrademark = mysqli_query($conn, $sqlAlltrademark);
                    ?>
                    <select name="thuong_hieu_id" class="form-control">
                        <?php
                        while ($row = mysqli_fetch_assoc($queryAlltrademark)) {
                        ?>
                            <option <?php
                                    if ($productTT['thuong_hieu_id'] == $row['id']) {
                                        echo 'selected';
                                    }
                                    ?> value=<?php echo $row['id']; ?>><?php echo $row['ten']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                    <div class="form-group">
                        <label>Chất liệu</label>
                        <input name="chat_lieu" type="text" required value="<?php echo $productTT['chat_lieu']; ?>" class="form-control" placeholder="">
                    </div>
                  

            </div>
            <div class="col l-6">
                <div class="form-group">
                    <label>Ảnh sản phẩm</label>
                    <input name="hinh_anh" type="file" onchange="preview()" id="image-input">
                    <br>
                    <div>
                        <img src="../assets/img/<?php echo $productTT['hinh_anh']; ?>" id="prd_image" width="120px" height="150px">
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
                            <option <?php
                                    if ($productTT['danh_muc_id'] == $row['id']) {
                                        echo 'selected';
                                    }
                                    ?> value=<?php echo $row['id']; ?>><?php echo $row['ten']; ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label>Trạng thái</label>
                    <select name="tinh_trang" class="form-control">
                        <option <?php if ($productTT['tinh_trang'] == 1) {
                                    echo 'selected';
                                } ?> value=1>Còn hàng</option>
                        <option <?php if ($productTT['tinh_trang'] == 0) {
                                    echo 'selected';
                                } ?> value=0>Hết hàng</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Sản phẩm nổi bật</label>
                    <div class="checkbox">
                        <label>
                            <input name="san_pham_noi_bat" type="checkbox" <?php if ($productTT['san_pham_noi_bat'] == 1) {
                                                                                echo 'checked';
                                                                            } ?> value=1>Nổi bật
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label>Mô tả sản phẩm</label>
                    <textarea name="mo_ta" required class="form-control" rows="3"><?php echo $productTT['mo_ta']; ?></textarea>
                </div>
                <form action="">
                    <button type="submit" name="sbm" class="btn-sucess">Cập nhật</button>
                    <button type="reset" class="btn-default">Làm mới</button>
                </form>
            </div>
            </form>
            <!-- /.col-->
        </div><!-- /.row -->

    </div>
</div> <!--/.main-->

<script>
    function preview() {
        var fileInput = event.target;
        var image = document.getElementById('prd_image');
        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                image.src = e.target.result;
            };
            reader.readAsDataURL(fileInput.files[0]);
        } else {
            image.src = '../assets/img/Img_icon_and_logo/no_image.jpg';
        }
    }
</script>