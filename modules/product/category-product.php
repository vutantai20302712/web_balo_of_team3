<!-- PHẦN DANH MỤC CỦA SẢN PHẨM -->
<?php
// Khởi tạo kết nối CSDL
$conn = initConnection();

if (isset($_GET['id'])) {
    $cat_id = $_GET['id'];
    // Lấy thông tin danh mục
    $sqlCat = "SELECT * FROM categories WHERE id = $cat_id";
    $queryCat = mysqli_query($conn, $sqlCat);
    $resultCat = mysqli_fetch_assoc($queryCat);
    $ten = $resultCat['ten'];

    // Lấy product có phân trang
    $limit = 10;
    $sqlCatPrd = "SELECT co.ten AS ten_color FROM products p INNER JOIN colors co ON p.colors = co.id WHERE danh_muc_id = $cat_id ";

    $queryCatPrdTotal = mysqli_query($conn, $sqlCatPrd);
    $totalRecords = mysqli_num_rows($queryCatPrdTotal); // số bản ghi có id = $cat_id
    $totalPage = ceil($totalRecords / $limit); // Tổng số trang

    if (isset($_GET['current_page'])) {
        $current_page = $_GET['current_page'];
    } else {
        $current_page = 1;
    }

    if ($current_page < 1) {
        $current_page = 1;
    }
    if ($current_page > $totalPage && $totalPage > 1) {
        $current_page = $totalPage;
    }

    // Công thức dùng để phân trang
$start = ($current_page - 1) * $limit;
$sqlCatPrd = "SELECT p.*, co.ten AS ten_color 
              FROM products p 
              INNER JOIN colors co ON p.colors = co.id 
              WHERE p.danh_muc_id = $cat_id 
              ORDER BY p.id 
              LIMIT $start, $limit";
$queryCatPrd = mysqli_query($conn, $sqlCatPrd);
$numberOfPrd = mysqli_num_rows($queryCatPrd);

} else {
    header("location:index.php");
}
?>

<div class="home-product">
    <?php
    if ($numberOfPrd > 0) {
    ?>
        <h3 style="border-radius:15px; padding:10px; background: linear-gradient(100deg, rgb(3, 3, 3), #006eff);"><?php echo $ten; ?> hiện có: <?php echo $numberOfPrd; ?> sản phẩm</h3>
        <div class="row sm-gutter">
            <!-- Grid->Row->Column -->
            <!-- Product item -->
            <?php
            while ($noi_bat = mysqli_fetch_assoc($queryCatPrd)) {
            ?>

                <div class="col l-2-4 m-4 c-6">
                    <a class="home-product-item" href="index.php?page=product-details&id=<?php echo $noi_bat['id']; ?>">
                        <div class="home-product-item__img ">
                            <img src="assets/img/<?php echo $noi_bat['hinh_anh']; ?>">
                        </div>
                        <h4 class="home-product-item__name"> <?php echo $noi_bat['ten_san_pham']; ?></h4>
                        <div class="home-product-item__price">

                            <span class="home-product-item__price-current" style="text-align:center;"><?php echo number_format($noi_bat['gia'], 0, ',', '.'); ?>₫</span>

                        </div>
                        <div class="home-product-item__origin" style="font-weight:bold;">
                            <span class="home-product-item__brand" style="color:#FF8C00"><?php echo $ten; ?></span>
                            <span class="home-product-item__origin-name" style="color:#00BFFF"><?php echo $noi_bat['ten_color']; ?></span>
                        </div>
                    </a>
                </div>
            <?php
            }
            ?>
        </div>
</div>


<!-- PHÂN TRANG -->
<ul class="pagination home-product__pagination">

    <?php
        if ($current_page > 1) {
            $prev = $current_page - 1;
    ?>
        <li class="pagination-item ">
            <a href="index.php?page=category-product&id=<?php echo $cat_id; ?>&current_page=<?php echo $i; ?>" class="pagination-item__link">
                <i class="pagination-item__icon fas fa-angle-left"></i>
            </a>
        </li>
    <?php
        }
    ?>

    <!-- TRANG GIỮA  -->
    <?php
        for ($i = 1; $i <= $totalPage; $i++) {
    ?>
        <li class="pagination-item pagination-item--active <?php if ($i == $current_page) echo 'active'; ?> ">
            <a href="index.php?page=category-product&id=<?php echo $cat_id; ?>&current_page=<?php echo $i; ?>" class="pagination-item__link">
                <?php echo $i; ?>
            </a>
        </li>
    <?php
        }
    ?>
    <?php
        if ($current_page < $totalPage && $totalPage > 1) {
            $next = $current_page + 1;
    ?>
        <li class="pagination-item">
            <a href="index.php?page=category-product&id=<?php echo $cat_id; ?>&current_page=<?php echo $next; ?>" class="pagination-item__link">
                <i class="pagination-item__icon fas fa-angle-right"></i>
            </a>
        </li>
    <?php
        }
    ?>
</ul>
<?php
    } else {
        echo 'Không có sản phẩm nào';
    }
?>