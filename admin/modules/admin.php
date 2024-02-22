<?php
// Thiet lap ket noi
$conn = initConnection();

// Truy vấn để lấy số lượng sản phẩm
$sqlProductCount = "SELECT COUNT(*) AS product_count FROM products";
$resultProductCount = mysqli_query($conn, $sqlProductCount);
$rowProductCount = mysqli_fetch_assoc($resultProductCount);
$productCount = $rowProductCount['product_count'];

//Truy vấn để lấy số lượng bình luận
$sqlCustomerCount = "SELECT COUNT(*) AS customer_count FROM customer";
$resultCustomerCount = mysqli_query($conn, $sqlCustomerCount);
$rowCustomerCount = mysqli_fetch_assoc($resultCustomerCount);
$CustomerCount = $rowCustomerCount['customer_count'];

// Truy vấn để lấy số lượng thành viên
$sqlUserCount = "SELECT COUNT(*) AS user_count FROM users";
$resultUserCount = mysqli_query($conn, $sqlUserCount);
$rowUserCount = mysqli_fetch_assoc($resultUserCount);
$userCount = $rowUserCount['user_count'];

//Truy vấn để lấy số lượng quảng cáo (giả sử bạn có một bảng 'ads')
$sqlOrderCount = "SELECT COUNT(*) AS orders_count FROM orders";
$resultOrderCount = mysqli_query($conn, $sqlOrderCount);
$rowOrderCount = mysqli_fetch_assoc($resultOrderCount);
$OrderCount = $rowOrderCount['orders_count'];
?>
<div class="col l-9">
    <div class="menu-left">
        <ul class="icon-and-title">
            <li class="icon-home">
                <a href="" class="breadcrumb">
                    <i class="fa-solid fa-house" style="margin-right: 10px;"></i>
                    Trang chủ quản trị
                </a>
            </li>
        </ul>
        <h1 class="page-header">Trang Chủ Quản Trị</h1>

        <div class="danhmuc-sanpham">
            <ul class="icon-sanpham-and-number">
                <li class="icon-number-product">
                    <a href="index.php?page=product" class="dieuhuong">
                        <i class="fa-solid fa-bag-shopping" style="font-size:60px"></i>
                        <span><?php echo $productCount; ?> Sản Phẩm</span>
                    </a>
                </li>
                <br>
                <li class="icon-number-comment">
                    <a href="index.php?page=customer" class="dieuhuong">
                        <i class="fa-solid fa-user" style="font-size:60px"></i>
                        <span><?php echo $CustomerCount;  ?> Khách hàng</span>
                    </a>
                </li>
                <br>
                <li class="icon-number-member">
                    <a href="index.php?page=user" class="dieuhuong">
                        <i class="fa-solid fa-person-military-pointing" style="font-size:60px"></i>
                        <span><?php echo $userCount; ?> Thành Viên</span>
                    </a>
                </li>
                <br>
                <li class="icon-number-ad">
                    <a href="index.php?page=order" class="dieuhuong">
                        <i class="fa-solid fa-clipboard-list" style="font-size:60px"></i>
                        <span> <?php echo $OrderCount; ?> Đơn hàng</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>