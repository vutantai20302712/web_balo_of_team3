<!-- PHẦN THÂN CỦA TRANG SẢN PHẨM -->
<?php
//thiết lập biến kết nối đến CSDL
include_once 'delete-product.php';
$conn = initConnection();

/* XÓA SẢN PHẨM */

if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
    $productID = $_GET['id'];
    // Gọi hàm xóa danh mục
    deleteproduct($conn, $productID);
}


/* PHÂN TRANG */
$limit = 5;
//Tìm tổng số trang
$sqlTotalREcords = "SELECT id FROM  products";
$queryTotalRecords = mysqli_query($conn, $sqlTotalREcords);
$TotalRecords = mysqli_num_rows($queryTotalRecords); //Tổng số bản ghi trong bảng product
$TotalPages = ceil($TotalRecords / $limit); //Tổng số trang có được
//Tìm $start?
if (isset($_GET['current_page'])) {
    $current_page = $_GET['current_page'];
} else {
    $current_page = 1; // nếu không có current_page trên url thì gắn mặc định về trang 1.
}

if ($current_page < 1) {
    $current_page = 1;
}

if ($current_page > $TotalPages && $TotalPages > 1) {
    $current_page = $TotalPages;
}

$start = ($current_page - 1) * $limit;
//Chuẩn bị câu truy vấn
$sqlAllProducts = "SELECT p.id, p.ten_san_pham, p.gia, p.hinh_anh, p.tinh_trang, c.ten AS ten_danh_muc, s.ten AS ten_size, co.ten AS ten_color, th.ten AS ten_thuong_hieu
                  FROM products p
                  INNER JOIN categories c ON p.danh_muc_id = c.id
                  INNER JOIN sizes s ON p.sizes = s.id
                  INNER JOIN colors co ON p.colors = co.id
                  INNER JOIN trademark th ON p.thuong_hieu_id = th.id
                  ORDER BY p.id
                  LIMIT $start,$limit";


//Thực hiện truy vấn
$queryAllProduct = mysqli_query($conn, $sqlAllProducts);


/*TỰ ĐỘNG CẬP NHẬT ID KHI XÓA ĐI THEO THỨ TỰ TỪ BÉ ĐẾN LỚN*/

$sqlGetproducts = "SELECT id FROM products ORDER BY id ASC";

// Thực thi câu truy vấn
$queryGetproducts = mysqli_query($conn, $sqlGetproducts);

// Mảng chứa các ID danh mục
$productIds = [];

// Lặp qua các bản ghi và lưu các ID vào mảng
while ($row = mysqli_fetch_assoc($queryGetproducts)) {
    $productIds[] = $row['id'];
}

// Cập nhật lại giá trị ID
$newId = 1;
foreach ($productIds as $productId) {
    // Câu truy vấn cập nhật ID mới cho bản ghi
    $sqlUpdateId = "UPDATE products SET id = $newId WHERE id = $productId";

    // Thực thi câu truy vấn
    $queryUpdateId = mysqli_query($conn, $sqlUpdateId);

    $newId++;
}

// Đặt lại giá trị AUTO_INCREMENT cho bảng danh mục
$sqlResetAutoIncrement = "ALTER TABLE products AUTO_INCREMENT = $newId";
$queryResetAutoIncrement = mysqli_query($conn, $sqlResetAutoIncrement);

/*END UPDATE ID*/

?>

<div class="col l-9">
    <div class="menu-left">
        <ul class="icon-and-title">
            <li class="icon-home">
                <a href="" class="breadcrumb">
                    <i class="fa-solid fa-bag-shopping" style="margin-right: 10px;"></i>
                    Trang quản lí sản phẩm
                </a>
            </li>
        </ul>
        <h1 class="page-header">Danh sách sản phẩm </h1>

        <div class="list-member">
            <div class="add-member">
                <ul class="quanli-icon-title">
                    <li>
                        <a href="index.php?page=add-product" class="icon-and-addmember">
                            <i class="fa-solid fa-plus"></i>
                            Thêm sản phẩm
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
                                <div class="use-member">Tên sản phẩm</div>
                                <div class="member-cell"></div>
                            </th>
                            <th style>
                                <div class="use-member">Giá</div>
                                <div class="member-cell"></div>
                            </th>
                            <th style>
                                <div class="use-member">Ảnh sản phẩm</div>
                                <div class="member-cell"></div>
                            </th>
                            <th style>
                                <div class="use-member">Trạng thái</div>
                                <div class="member-cell"></div>
                            </th>
                            <th style>
                                <div class="use-member">Danh mục</div>
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
                        if (mysqli_num_rows($queryAllProduct) > 0) {
                            while ($product = mysqli_fetch_assoc($queryAllProduct)) {
                        ?>
                                <tr>
                                    <td>
                                        <?php echo $product['id']; ?>
                                    </td>
                                    <td>
                                        <div class="product-name"> <?php echo $product['ten_san_pham']; ?> </div>
                                    </td>
                                    <td>
                                        <?php echo number_format($product['gia'], 0, ',', '.');  ?> ₫
                                    </td>
                                    <td id="product-img" style="text-align: center">
                                        <img width="90" height="120" src="../assets/img/<?php echo $product['hinh_anh']; ?>" />
                                    </td>
                                    <td>
                                        <?php
                                        if ($product['tinh_trang'] == 1) {
                                            echo ' <span class="power-member">Còn hàng</span>';
                                        } else {
                                            echo ' <span class="power-admin">Hết hàng</span>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php echo $product['ten_danh_muc']; ?>
                                    </td>
                                    <td class="form-group" style>
                                        <a href="index.php?page=edit-product&id=<?php echo $product['id']; ?>" class="pencil-primary">
                                            <i class="fa-solid fa-pencil"></i>
                                        </a>
                                        <a href="index.php?page=product&action=delete&id=<?php echo $product['id']; ?>" class="gliphycon-remove" onclick="return confirmDelete();">
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
                            echo '<li class="page-item"><a class="page-link" href="index.php?page=product&current_page=' . $prev . '">«</a></li>';
                        }

                        ?>
                        <?php
                        for ($i = 1; $i <= $TotalPages; $i++) {
                        ?>
                            <li class="page-item <?php if ($i == $current_page) echo 'active'; ?>">
                                <a href="index.php?page=product&current_page= <?php echo $i; ?>" class="page-link">
                                    <?php echo $i; ?>
                                </a>
                            </li>
                        <?php
                        }
                        ?>
                        <?php
                        if ($current_page < $TotalPages && $TotalPages > 1) {
                            $next = $current_page + 1;
                            echo '<li class="page-item"><a class="page-link" href="index.php?page=product&current_page=' . $next . '">»</a></li>';
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