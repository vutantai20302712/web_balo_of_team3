<!-- PHẦN THÂN TRANG KHÁCH HÀNG -->
<?php

include_once 'delete-customer.php';
//Thiết lập đến cơ sở dữ liệu
$conn = initConnection();
//Chuẩn bị câu truy vấn
$sqlAllCustomer = "SELECT * FROM customer";
// Thực hiện kết nối đến CSDL
$queryAllCustomer = mysqli_query($conn, $sqlAllCustomer);

/* XÓA SẢN PHẨM */

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $customerID = $_GET['id'];
    // Gọi hàm xóa danh mục
    deletecustomer($conn, $customerID);
}

 /* PHÂN TRANG */
 $limit = 5;
  //Tìm tổng số trang
 $sqlTotalRecords = "SELECT id FROM customer";
 $queryTotalRecords = mysqli_query($conn, $sqlTotalRecords);
 $TotalRecords = mysqli_num_rows($queryTotalRecords); //Tổng bản ghi
 $TotalPages = ceil($TotalRecords/ $limit); //Tổng số trang có
 //Bắt đầu tìm
 if(isset($_GET['current_page'])) {
    $current_page = $_GET['current_page'];
 }else {
    $current_page = 1; //Không có current_page gắn mặc định về trang 1
 }

 if($current_page < 1) {
    $current_page = 1;
 }

 if($current_page > $TotalPages && $TotalPages > 1) {
    $current_page = $TotalPages;
 }

 $start = ($current_page - 1) * $limit;

 $sqlAllCustomer = "SELECT * FROM customer LIMIT $start, $limit";
 $queryAllCustomer = mysqli_query($conn, $sqlAllCustomer);





/*TỰ ĐỘNG CẬP NHẬT ID KHI XÓA ĐI THEO THỨ TỰ TỪ BÉ ĐẾN LỚN*/

$sqlGetcustomer = "SELECT id FROM customer ORDER BY id ASC";

// Thực thi câu truy vấn
$queryGetcustomer = mysqli_query($conn, $sqlGetcustomer);

// Mảng chứa các ID danh mục
$customerds = [];

// Lặp qua các bản ghi và lưu các ID vào mảng
while ($row = mysqli_fetch_assoc($queryGetcustomer)) {
    $customerds[] = $row['id'];
}

// Cập nhật lại giá trị ID
$newId = 1;
foreach ($customerds as $customerd) {
    // Câu truy vấn cập nhật ID mới cho bản ghi
    $sqlUpdateId = "UPDATE customer SET id = $newId WHERE id = $customerd";

    // Thực thi câu truy vấn
    $queryUpdateId = mysqli_query($conn, $sqlUpdateId);

    $newId++;
}

// Đặt lại giá trị AUTO_INCREMENT cho bảng danh mục
$sqlResetAutoIncrement = "ALTER TABLE customer AUTO_INCREMENT = $newId";
$queryResetAutoIncrement = mysqli_query($conn, $sqlResetAutoIncrement);

/*END UPDATE ID*/


?>
<div class="col l-9">
    <div class="menu-left">
        <ul class="icon-and-title">
            <li class="icon-home">
                <a href="" class="breadcrumb">
                    <i class="fa-solid fa-user" style="margin-right: 10px;"></i>
                    Trang quản lí khách hàng
                </a>
            </li>
        </ul>
        <h1 class="page-header">Danh sách khách hàng </h1>

        <div class="list-member">
            <div class="add-member">
                <ul class="quanli-icon-title">
                    <li>
                        <a href="index.php?page=add-customer" class="icon-and-addmember">
                            <i class="fa-solid fa-plus"></i>
                            Thêm khách hàng
                        </a>
                    </li>
                </ul>
            </div>
            <div class="table-member">
                <table>
                    <thead>
                        <tr>
                            <th style>
                                <div class="use-member">ID</div>
                                <div class="member-cell"></div>
                            </th>
                            <th style>
                                <div class="use-member">Tên đăng nhập</div>
                                <div class="member-cell"></div>
                            </th>
                            <th style>
                                <div class="use-member">Email</div>
                                <div class="member-cell"></div>
                            </th>
                            <th style>
                                <div class="use-member">Mật Khẩu</div>
                                <div class="member-cell"></div>
                            </th>
                            <th style>
                                <div class="use-member">Họ tên</div>
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
                        if (mysqli_num_rows($queryAllCustomer) > 0) {
                            while ($customer = mysqli_fetch_assoc($queryAllCustomer)) { ?>
                                <tr>
                                    <td><?php echo $customer['id']; ?></td>
                                    <td><?php echo $customer['ten_dang_nhap']; ?></td>
                                    <td><?php echo $customer['email']; ?></td>
                                    <td>
                                        <?php echo $customer['mat_khau']  ?>
                                    </td>
                                    <td>
                                        <?php echo $customer['ho_ten'];  ?>
                                    </td>
                                    <td class="form-group" style>
                                        <a href="index.php?page=edit-customer&id=<?php echo $customer['id']; ?>" class="pencil-primary">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                                        <a href="index.php?page=customer&action=delete&id=<?php echo $customer['id']; ?>" class="gliphycon-remove" onclick="return confirmDelete();">
                                            <i class="fa-solid fa-circle-xmark"></i>
                                        </a>

                                    </td>
                                </tr>
                        <?php
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
                            echo '<li class="page-item"><a class="page-link" href="index.php?page=customer&current_page=' . $prev . '">«</a></li>';
                        }

                        ?>
                        <?php
                        for ($i = 1; $i <= $TotalPages; $i++) {
                        ?>
                            <li class="page-item <?php if ($i == $current_page) echo 'active'; ?>">
                                <a href="index.php?page=customer&current_page= <?php echo $i; ?>" class="page-link">
                                    <?php echo $i; ?>
                                </a>
                            </li>
                        <?php
                        }
                        ?>
                        <?php
                        if ($current_page < $TotalPages && $TotalPages > 1) {
                            $next = $current_page + 1;
                            echo '<li class="page-item"><a class="page-link" href="index.php?page=customer&current_page=' . $next . '">»</a></li>';
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
        return confirm("Bạn có chắc muốn xóa");
    }
</script>