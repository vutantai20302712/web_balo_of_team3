<?php
$account = $_GET['id'] ?? '';
if (isset($_SESSION['id'])) {
    $account = $_SESSION['id'];
}
$conn = initConnection();
$sql = "SELECT * FROM orders WHERE khach_hang_id = '$account' ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
$orders = []; // Khởi tạo mảng đơn hàng
while ($row = mysqli_fetch_assoc($result)) {
    $orders[] = $row;
}

$statusMapping = array(
    1 => "<div class='power-member'> Chờ xác nhận</div>",
    2 => "<div class='power-confirm'>Đã xác nhận</div>",
    3 => "<div class='power-nothing'> Đang giao hàng</div>",
    4 => "<div class='power-payment'>Đã thanh toán</div>",
    5 => "<div class='power-admin'>Đã hủy</div>",
);
?>

<table style="width:100%; color:black; font-size:15px ;font-weight:bold ; text-align:center; border-collapse:collapse; background-color:white; margin-bottom:30px;" border="1">
    <tr>
        <th style="padding:18px;">ID đơn hàng</th>
        <th>Ngày mua</th>
        <th>Tình trạng</th>
        <th>Chi tiết</th>
        <th>Hành động</th>
    </tr>
    <?php foreach ($orders as $order) { ?>
        <tr>
            <td style="padding:18px;"><?= $order['id'] ?></td>
            <td><?= $order['created_at'] ?></td>
            <td><?= $statusMapping[$order['trang_thai']] ?></td>
            <td><a href="index.php?page=thong_tin-order&id=<?= $order['id'] ?>" class="pencil-primary" style="text-decoration:none"><i class='fa-solid fa-circle-info'></i></a></td>
            <td>
                <?php
                if ($order['trang_thai'] == 1 || $order['trang_thai'] == 2) {
                    echo "<a href='modules/cart/cancel-order.php?id=" . $order['id'] . "' onclick='return confirmDelete();'><i class='fa-solid fa-trash-can' style='color:red'></i></a>";
                }
                ?>
            </td>
        </tr>
    <?php } ?>
</table>

<script>
    function confirmDelete() {
        return confirm("Bạn có chắc muốn hủy đơn hàng này?");
    }
</script>