<!-- PHẦN THÂN CHI TIẾT SẢN PHẨM -->
<?php
// Kết nối đến CSDL
$conn = initConnection();
// Lấy thông tin đơn hàng từ CSDL
$orderID = $_GET['orderID'];
$sqlOrder = "SELECT * FROM orders WHERE id = $orderID";
$queryOrder = mysqli_query($conn, $sqlOrder);
$order = mysqli_fetch_assoc($queryOrder);
$error = '';

// Lấy thông tin chi tiết đơn hàng từ CSDL
$sqlOrderDetails = "SELECT * FROM order_details WHERE don_hang_id = $orderID";
$resultOrderDetails = mysqli_query($conn, $sqlOrderDetails);

// Xử lí khi bấm nút "Cập Nhật"
if(isset($_POST['sbm'])) {
    $ten_nguoi_nhan = $_POST['ten_nguoi_nhan'];
    $so_dien_thoai = $_POST['so_dien_thoai_nguoi_nhan'];
    $email = $_POST['email_nguoi_nhan'];
    $dia_chi = $_POST['dia_chi_nguoi_nhan'];
    $trang_thai = $_POST['trang_thai'];
    $time = $_POST['created_at'];

    //Kiểm tra xem số điện thoại hoặc email đã tồn tại trong CSDL hay chưa
    $checkOrder = "SELECT * FROM orders WHERE (so_dien_thoai_nguoi_nhan ='$so_dien_thoai' OR email_nguoi_nhan = '$email') AND id <> $orderID";
    $checkResultOrder = mysqli_query($conn, $checkOrder);
    if(mysqli_num_rows($checkResultOrder) < 0) {
        //Email hoặc số điện thoại đã tồn tại
        $error = 'Email hoặc số điện thoại đã tồn tại';
        $_SESSION['error'] = $error;
    }else {
        //Tiến hành cập nhật thông tin 
        $updateOrder = "UPDATE orders SET ten_nguoi_nhan = '$ten_nguoi_nhan' ,  so_dien_thoai_nguoi_nhan = '$so_dien_thoai' , email_nguoi_nhan = '$email', dia_chi_nguoi_nhan ='$dia_chi' , trang_thai = '$trang_thai' , created_at = '$time' WHERE id = $orderID ";
        $upadateResultOrder = mysqli_query($conn, $updateOrder);

        if ($upadateResultOrder) {
            // Cập nhật thông tin khách hàng thành công 
            echo "Cập nhật thông tin khách đơn hàng công!";
            header_remove(); // Hàm xóa bất cứ tiêu đề nào đã được gửi trước đó
            ?>
                        <meta http-equiv="refresh" content="0;index.php?page=order">
            <?php
        } else {
            // Lỗi xảy ra 
            echo "Đã xảy ra lỗi:" .mysqli_error($conn);
        }
    }
}

?>


<div class="col l-9">
    <div class="menu-left">
    <ul class="icon-and-title">
            <li class="icon-home">
                <a href="" class="breadcrumb">
                    <i class="fa-solid fa-users" style="margin-right: 10px;"></i>
                    Trang chi tiết đơn hàng
                </a>
            </li>
        </ul>
        <h1 class="page-header">Đơn hàng của: <?php echo $order['ten_nguoi_nhan']; ?></h1>
        <?php
                    if (isset($_SESSION['error'])) {
                        echo '<div class="danger">' . $_SESSION['error'] . '</div>';
                        unset($_SESSION['error']);
                    }    
            ?>
        <form action="" role="form" method="post">
            <div class="form-group">
            
                <label>Tên người nhận:</label>
                <input name="ten_nguoi_nhan" type="text" required class="form-control" placeholder="" value="<?php echo $order['ten_nguoi_nhan']; ?>">
            </div>

            <div class="form-group">
                <label>Số điện thoại:</label>
                <input name="so_dien_thoai_nguoi_nhan" type="text" required class="form-control" placeholder="" value="<?php echo $order['so_dien_thoai_nguoi_nhan']; ?>">
            </div>

            <div class="form-group">
                <label>Email</label>
                <input name="email_nguoi_nhan" type="text" required class="form-control" placeholder="" value="<?php echo $order['email_nguoi_nhan']; ?>">
            </div>

            <div class="form-group">
                <label>Địa chỉ:</label>
                <input name="dia_chi_nguoi_nhan" type="text" required class="form-control" placeholder="" value="<?php echo $order['dia_chi_nguoi_nhan']; ?>">
            </div>

            <div class="form-group">
                <label>Trạng thái:</label>
                <select name="trang_thai" class="form-control">
                  
                    <option value="1" <?php if ($order['trang_thai'] == 1) echo "selected"; ?>>Chờ xác nhận</option>
                    <option value="2" <?php if ($order['trang_thai'] == 2) echo "selected"; ?>>Đã xác nhận</option>
                    <option value="3" <?php if ($order['trang_thai'] == 3) echo "selected"; ?>>Đang giao hàng</option>
                    <option value="4" <?php if ($order['trang_thai'] == 4) echo "selected"; ?>>Đã thanh toán</option>
                    <option value="5" <?php if ($order['trang_thai'] == 5) echo "selected"; ?>>Đã hủy</option>
                </select>
            </div>
            <div class="form-group">
                <label>Thời gian đặt hàng:</label>
                <input name="created_at" type="text" required class="form-control" placeholder="" value="<?php echo $order['created_at']; ?>">
            </div>
            <button type="submit" name="sbm" class="btn-sucess" style='float:right; margin:18px;'>Cập nhật</button>
        </form>


        <div class="table-member">
            <table>
                <thead>
                    <tr>
                        <th>
                            <div class="use-member">Đơn hàng số</div>
                            <div class="member-cell"></div>
                        </th>
                        <th>
                            <div class="use-member">Tên sản phẩm</div>
                            <div class="member-cell"></div>
                        </th>
                        <th>
                            <div class="use-member">Hình ảnh</div>
                            <div class="member-cell"></div>
                        </th>
                        <th>
                            <div class="use-member">Đơn giá</div>
                            <div class="member-cell"></div>
                        </th>
                        <th>
                            <div class="use-member">Số lượng</div>
                            <div class="member-cell"></div>
                        </th>
                        <th>
                            <div class="use-member">Thành tiền</div>
                            <div class="member-cell"></div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (mysqli_num_rows($resultOrderDetails) > 0) {
                        $tong_tien = 0;
                        while ($row = mysqli_fetch_assoc($resultOrderDetails)) {
                            $detailID = $row['don_hang_id'];
                            $sanPhamID = $row['san_pham_id'];
                            $sqlProduct = "SELECT * FROM products WHERE id = $sanPhamID";
                            $resultProduct = mysqli_query($conn, $sqlProduct);
                            $product = mysqli_fetch_assoc($resultProduct);
                            $gia_san_pham = $product['gia'];
                            $so_luong = $row['so_luong'];
                            $thanh_tien = $gia_san_pham * $so_luong;
                            $tong_tien += $thanh_tien;

                            // Hiển thị thông tin chi tiết đơn hàng
                            echo "<tr>";
                            echo "<td>$orderID</td>";
                            echo "<td class='product-name'>{$product['ten_san_pham']}</td>";
                            echo "<td>";
                            echo "<img src='../assets/img/" . $product['hinh_anh'] . "' alt='' width='90' height='120'>";
                            echo "</td>";
                            echo "<td>" . number_format($product['gia']) . " ₫</td>";
                            echo "<td>" . $row['so_luong'] . "</td>";
                            echo "<td>" . number_format($thanh_tien) . " ₫</td>";
                            echo "</tr>";
                        }
                        echo "<tr>";
                        echo "<td colspan='5' style='text-align: left; font-size: 15px ; padding:15px; color:red;'>Tổng tiền:</td>";
                        echo "<td>" . number_format($tong_tien) . " ₫</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    function confirmDelete() {
        return confirm("Bạn có chắc muốn xóa");
    }
</script>
