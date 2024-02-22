<?php
$account = isset($_SESSION['id']) ? $_SESSION['id'] : '';
if (isset($_GET['id'])) {
    $order_id = $_GET['id'];
    $conn = initConnection();
    $sql = "SELECT od.don_hang_id, od.san_pham_id, p.ten_san_pham, od.hinh_anh, od.so_luong, od.gia, od.tong_tien
        FROM order_details od
        JOIN products p ON od.san_pham_id = p.id
        WHERE od.don_hang_id = '$order_id'";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        $orderDetails = [];
        $totalAmount = 0; // Khởi tạo biến tổng tiền
        while ($row = mysqli_fetch_assoc($result)) {
            $orderDetails[] = $row;
            $totalAmount += $row['tong_tien']; // Tích luỹ tổng tiền
        }
    } else {
        echo "Lỗi khi tìm nạp dữ liệu: " . mysqli_error($conn);
    }
} else {
    echo "Không có ID đặt hàng được cung cấp.";
}
?>
<table style="width:100%; color:black; font-size:15px; font-weight:bold; text-align:center; border-collapse:collapse; background-color:white;  margin-bottom:30px;" border="1">
    <tr>
        <th style="padding:18px;">Đơn hàng ID</th>
        <th>Tên sản phẩm</th>
        <th>Hình ảnh</th>
        <th>Giá</th>
        <th>Số lượng</th>
        <th>Tổng tiền</th>
    </tr>
    <?php foreach ($orderDetails as $detail) { ?>
        <tr>
            <td style="padding:10px;"><?= $detail['don_hang_id'] ?></td>
            <td class="product-name"><?= $detail['ten_san_pham'] ?></td>

            <td style="width:120px; height:120px; margin:10px;">
                <img src="assets/img/<?php echo $detail['hinh_anh']; ?>" alt="" class="product-img-sp1">
            </td>
            <td><?php echo number_format($detail['gia'], 0, ',', '.'); ?> ₫</td>
            <td><?= $detail['so_luong'] ?></td>
            <td><?php echo number_format($detail['tong_tien'], 0, ',', '.'); ?> ₫</td>
        </tr>
    <?php } ?>
    
    <!-- Dòng tổng tiền -->
    <tr>
        <td colspan="6" style="padding:25px;">
              <p style="float:left; color:red ; font-size:15px">Tổng tiền: <?php echo number_format($totalAmount, 0, ',', '.'); ?> ₫</p>
        </td>
    </tr>
</table>
