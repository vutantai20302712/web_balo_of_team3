<?php
// Kết nối đến CSDL
include_once 'delete-order.php';
$conn = initConnection();

// Truy vấn dữ liệu đơn hàng
$sqlALLO = "SELECT * FROM orders";
// Thực hiện kết nối đến CSDL
$queryALLO = mysqli_query($conn, $sqlALLO);

/* XÓA đơn hàng */

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $orderID = $_GET['id'];
    // Gọi hàm xóa danh mục
    deleteorder($conn, $orderID);
}

/* PHÂN TRANG */
$limit = 5;
//Tìm tổng số trang
$sqlTotalRecords = "SELECT id FROM orders";
$queryTotalRecords = mysqli_query($conn, $sqlTotalRecords);
$TotalRecords = mysqli_num_rows($queryTotalRecords); //Tổng bản ghi
$TotalPages = ceil($TotalRecords / $limit); //Tổng số trang có
//Bắt đầu tìm
if (isset($_GET['current_page'])) {
    $current_page = $_GET['current_page'];
} else {
    $current_page = 1; //Không có current_page gắn mặc định về trang 1
}

if ($current_page < 1) {
    $current_page = 1;
}

if ($current_page > $TotalPages && $TotalPages > 1) {
    $current_page = $TotalPages;
}

$start = ($current_page - 1) * $limit;

$sqlALLO = "SELECT * FROM orders LIMIT $start, $limit";
$queryALLO = mysqli_query($conn, $sqlALLO);

?>

<div class="col l-9">
    <div class="menu-left">
        <ul class="icon-and-title">
            <li class="icon-home">
                <a href="" class="breadcrumb">
                    <i class="fa-solid fa-users" style="margin-right: 10px;"></i>
                    Trang quản lí Đơn hàng
                </a>
            </li>
        </ul>
        <h1 class="page-header">Danh sách đơn hàng </h1>

        <div class="list-member">
            <div class="add-member">
                <ul class="quanli-icon-title">
                    <li>
                        <a href="index.php?page=add-order" class="icon-and-addmember">
                            <i class="fa-solid fa-plus"></i>
                            Thêm đơn hàng mới
                        </a>
                    </li>
                </ul>
            </div>
            <div class="table-member">
                <table>
                    <thead>
                        <tr>
                            <th>
                                <div class="use-member">ID</div>
                                <div class="member-cell"></div>
                            </th>
                            <th>
                                <div class="use-member">Tên người nhận</div>
                                <div class="member-cell"></div>
                            </th>
                            <th>
                                <div class="use-member">Số điện thoại</div>
                                <div class="member-cell"></div>
                            </th>
                            <th>
                                <div class="use-member">Email</div>
                                <div class="member-cell"></div>
                            </th>
                            <th>
                                <div class="use-member">Địa chỉ</div>
                                <div class="member-cell"></div>
                            </th>
                            <th>
                                <div class="use-member">Trạng thái</div>
                                <div class="member-cell"></div>
                            </th>

                            <th>
                                <div class="use-member">Ngày đặt</div>
                                <div class="member-cell"></div>
                            </th>
                            <th>
                                <div class="use-member">Khách hàng ID</div>
                                <div class="member-cell"></div>
                            </th>
                            <!-- <th>
                                <div class="use-member">Người dùng ID</div>
                                <div class="member-cell"></div>
                            </th> -->
                            <th>
                                <div class="use-member">Hành động</div>
                                <div class="member-cell"></div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($queryALLO) > 0) {
                            while ($row = mysqli_fetch_assoc($queryALLO)) {
                                $orderID = $row['id'];
                                $tenNguoiNhan = $row['ten_nguoi_nhan'];
                                $soDienThoai = $row['so_dien_thoai_nguoi_nhan'];
                                $email = $row['email_nguoi_nhan'];
                                $diaChi = $row['dia_chi_nguoi_nhan'];
                                $trangThai = $row['trang_thai'];
                                $ngayDat = $row['created_at'];
                                $khachHangID = $row['khach_hang_id'];
                                // $nguoiDungID = $row['nguoi_dung_id'];


                                // Truy vấn dữ liệu từ bảng USER

                                // Chuyển số thành chữ      
                                $trangThaiMapping = [
                                   
                                    1 => "<div class='power-member'> Chờ xác nhận</div>",
                                    2 => "<div class='power-confirm'>Đã xác nhận</div>",
                                    3 => "<div class='power-nothing'> Đang giao hàng</div>",
                                    4 => "<div class='power-payment'>Đã thanh toán</div>",
                                    5 => "<div class='power-admin'>Đã hủy</div>",
                                    // Default nếu không có giá của trạng thái                              
                                ];

                                echo "<tr>";
                                echo "<td>$orderID</td>";
                                echo "<td>$tenNguoiNhan</td>";
                                echo "<td>$soDienThoai</td>";
                                echo "<td>$email</td>";
                                echo "<td>$diaChi</td>";
                                echo "<td>". ($trangThaiMapping[$trangThai] ?? ($trangThaiMapping[1] ?? '')) . "</td>";
                                echo "<td>$ngayDat</td>";
                                echo "<td>$khachHangID</td>";
                                // echo "<td>$nguoiDungID</td>";

                                echo "<td class='form-group'>";
                                echo "<a href='index.php?page=order-details&orderID=$orderID' class='pencil-primary'>";
                                echo "<i class='fa-solid fa-circle-info'></i>";
                                echo "</a>";
                                echo "<a href='index.php?page=order&action=delete&id=$orderID' onclick='return confirmDelete();' class='gliphycon-remove'> ";
                                echo "<i class='fa-solid fa-circle-xmark'></i>";
                                echo "</a>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='10'>Không có đơn hàng.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="panel-footer">
                <nav>
                    <ul class="pagination">
                        <?php
                        if ($current_page > 1) {
                            $prev = $current_page - 1;
                            echo '<li class="page-item"><a class="page-link" href="index.php?page=order&current_page=' . $prev . '">«</a></li>';
                        }

                        ?>
                        <?php
                        for ($i = 1; $i <= $TotalPages; $i++) {
                        ?>
                            <li class="page-item <?php if ($i == $current_page) echo 'active'; ?>">
                                <a href="index.php?page=order&current_page= <?php echo $i; ?>" class="page-link">
                                    <?php echo $i; ?>
                                </a>
                            </li>
                        <?php
                        }
                        ?>
                        <?php
                        if ($current_page < $TotalPages && $TotalPages > 1) {
                            $next = $current_page + 1;
                            echo '<li class="page-item"><a class="page-link" href="index.php?page=order&current_page=' . $next . '">»</a></li>';
                        }
                        ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<?php
// Đóng kết nối CSDL
mysqli_close($conn);
?>

<script>
    function confirmDelete() {
        return confirm("Bạn có chắc muốn xóa ĐƠN HÀNG này");
    }
</script>