<!-- PHẦN THÂN CỦA TRANG THÀNH VIÊN -->
<?php
// Thiết lập kết nối đến CSDL
include_once 'delete-user.php';
$conn = initConnection();
// Chuẩn bị câu truy vấn
$sqlALLUser = "SELECT * FROM users";
// Thực hiện kết nối đến CSDL
// Bao gồm 2 tham số: Biến kết nối và câu truy vấn
$queryAllUser = mysqli_query($conn, $sqlALLUser);

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $userID = $_GET['id'];
    // Gọi hàm xóa danh mục
    deleteUser($conn, $userID);
}


/* PHÂN TRANG */
$limit = 5;
//Tìm tổng số trang
$sqlTotalRecords = "SELECT id FROM users";
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

$sqlALLUser = "SELECT * FROM users LIMIT $start, $limit";
$queryALLUser = mysqli_query($conn, $sqlALLUser);

/*TỰ ĐỘNG CẬP NHẬT ID KHI XÓA ĐI THEO THỨ TỰ TỪ BÉ ĐẾN LỚN*/
$sqlGetusers = "SELECT id FROM users ORDER BY id ASC";
// Thực thi câu truy vấn
$queryGetusers = mysqli_query($conn, $sqlGetusers);

// Mảng chứa các ID danh mục
$userIds = [];

// Lặp qua các bản ghi và lưu các ID vào mảng
while ($row = mysqli_fetch_assoc($queryGetusers)) {
    $userIds[] = $row['id'];
}
// Cập nhật lại giá trị ID
$newId = 1;
foreach ($userIds as $userId) {
    // Câu truy vấn cập nhật ID mới cho bản ghi
    $sqlUpdateId = "UPDATE users SET id = $newId WHERE id = $userId";

    // Thực thi câu truy vấn
    $queryUpdateId = mysqli_query($conn, $sqlUpdateId);

    $newId++;
}
// Đặt lại giá trị AUTO_INCREMENT cho bảng danh mục
$sqlResetAutoIncrement = "ALTER TABLE users AUTO_INCREMENT = $newId";
$queryResetAutoIncrement = mysqli_query($conn, $sqlResetAutoIncrement);
/*END UPDATE ID*/
?>
<div class="col l-9">
    <div class="menu-left">
        <ul class="icon-and-title">
            <li class="icon-home">
                <a href="" class="breadcrumb">
                    <i class="fa-solid fa-users" style="margin-right: 10px;"></i>
                    Trang quản lí thành viên
                </a>
            </li>
        </ul>
        <h1 class="page-header">Danh sách thành viên </h1>

        <div class="list-member">
            <a href="index.php?page=add-user" class="icon-and-addmember" width="auto">
                <div class="add-member">

                    <ul class="quanli-icon-title">
                        <li>
                            <i class="fa-solid fa-plus"></i>
                            Thêm thành viên
                        </li>
                    </ul>

                </div>
            </a>
            <div class="table-member">
                <table>
                    <thead>
                        <tr>
                            <th style>
                                <div class="use-member">ID</div>
                                <div class="member-cell"></div>
                            </th>
                            <th style>
                                <div class="use-member">Họ tên</div>
                                <div class="member-cell"></div>
                            </th>
                            <th style>
                                <div class="use-member">Email</div>
                                <div class="member-cell"></div>
                            </th>
                            <th style>
                                <div class="use-member">Quyền</div>
                                <div class="member-cell"></div>
                            </th>
                            <th style>
                                <div class="use-member">Trạng thái</div>
                                <div class="member-cell"></div>
                            </th>
                            <th style>
                                <div class="use-member">Hành động</div>
                                <div class="member-cell"></div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        if ($TotalRecords > 0) {
                            $index = 1; // Biến đếm để hiển thị số thứ tự của thành viên trên trang

                            while ($user = mysqli_fetch_assoc($queryALLUser)) {
                        ?>
                                <tr>
                                    <td><?php echo $user['id']; ?></td>
                                    <td><?php echo $user['ho_ten']; ?></td>
                                    <td><?php echo $user['email']; ?></td>
                                    <td>
                                        <?php
                                        if ($user['cap_do'] == 1) {
                                            echo '<span class="power-admin">Admin</span>';
                                        } else {
                                            echo '<span class="power-member">Member</span>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($user['inActive'] == 0) {
                                            echo '<span class="power-admin">Kích hoạt</span>';
                                        } else {
                                            echo '<span class="power-member">Ngưng kích hoạt</span>';
                                        }
                                        ?>
                                    </td>
                                    <td class="form-group">
                                        <a href="index.php?page=edit-user&id=<?php echo $user['id']; ?>" class="pencil-primary">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                                        <a href="index.php?page=user&action=delete&id=<?php echo $user['id']; ?>" class="gliphycon-remove" onclick="return confirmDelete();">
                                            <i class="fa-solid fa-circle-xmark"></i>
                                        </a>
                                    </td>
                                </tr>
                        <?php
                                $index++;
                            }
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
                            echo '<li class="page-item"><a class="page-link" href="index.php?page=user&current_page=' . $prev . '">«</a></li>';
                        }
                        ?>
                        <?php
                        for ($i = 1; $i <= $TotalPages; $i++) {
                        ?>
                            <li class="page-item <?php if ($i == $current_page) echo 'active'; ?>">
                                <a href="index.php?page=user&current_page= <?php echo $i; ?>" class="page-link">
                                    <?php echo $i; ?>
                                </a>
                            </li>
                        <?php
                        }
                        ?>
                        <?php
                        if ($current_page < $TotalPages && $TotalPages > 1) {
                            $next = $current_page + 1;
                            echo '<li class="page-item"><a class="page-link" href="index.php?page=user&current_page=' . $next . '">»</a></li>';
                        }
                        ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<script>
    function confirmDelete() {
        return confirm("Bạn có chắc chắn muốn xóa");
    }
</script>