<!-- PHẦN TÌM KIẾM SẢN PHẨM -->
<?php
$conn = initConnection();
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
if (isset($_POST['keyword'])) {
    $keyword = $_POST['keyword'];
}
$sql_PRD = "SELECT products.id AS product_id, categories.id AS category_id, products.*, categories.* 
            FROM products, categories 
            WHERE products.danh_muc_id = categories.id 
            AND products.ten_san_pham LIKE '%" . $keyword . "%'";
$query_PRD = mysqli_query($conn, $sql_PRD);

// Lấy product có phân trang
$limit = 10;
$totalRecords = mysqli_num_rows($query_PRD); // số bản ghi có từ khóa tìm kiếm
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
$sql_PRD_paginated = "SELECT products.id AS product_id, categories.id AS category_id, products.*, categories.*, colors.ten AS color_name
                      FROM products
                      JOIN categories ON products.danh_muc_id = categories.id
                      LEFT JOIN colors ON products.colors = colors.id
                      WHERE products.ten_san_pham LIKE '%" . $keyword . "%' 
                      LIMIT $start, $limit";
$query_PRD_paginated = mysqli_query($conn, $sql_PRD_paginated);

$numberOfPrd = mysqli_num_rows($query_PRD_paginated);
?>

<div class="home-product">
    <h3 style="border-radius: 15px; padding: 10px; background: linear-gradient(100deg, rgb(3, 3, 3),#006eff);">Từ khóa tìm kiếm: <?php echo $keyword ?></h3>
    <div class="row sm-gutter">
        <!-- Grid->Row->Column -->
        <!-- Product item -->
        <?php
        while ($search = mysqli_fetch_assoc($query_PRD_paginated)) {
        ?>

            <div class="col l-2-4 m-4 c-6">
                <a class="home-product-item" href="index.php?page=product-details&id=<?php echo $search['product_id']; ?>">
                    <div class="home-product-item__img ">
                        <img src="assets/img/<?php echo $search['hinh_anh']; ?>">
                    </div>
                    <h4 class="home-product-item__name"> <?php echo $search['ten_san_pham']; ?></h4>
                    <div class="home-product-item__price">

                        <span class="home-product-item__price-current" style="text-align:center;"><?php echo number_format($search['gia'], 0, ',', '.'); ?>₫</span>

                    </div>
                    <div class="home-product-item__origin" style="font-weight:bold;">
                        <span class="home-product-item__brand" style="color:#FF8C00"><?php echo $search['ten']; ?></span>

                        <span class="home-product-item__origin-name" style="color:#00BFFF"><?php echo $search['color_name']; ?></span>
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
            <a href="index.php?page=search-result&keyword=<?php echo $keyword; ?>&current_page=<?php echo $prev; ?>" class="pagination-item__link">
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
        <li class="pagination-item <?php if ($i == $current_page) echo 'pagination-item--active active'; ?> ">
            <a href="index.php?page=search-result&keyword=<?php echo $keyword; ?>&current_page=<?php echo $i; ?>" class="pagination-item__link">
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
            <a href="index.php?page=search-result&keyword=<?php echo $keyword; ?>&current_page=<?php echo $next; ?>" class="pagination-item__link">
                <i class="pagination-item__icon fas fa-angle-right"></i>
            </a>
        </li>
    <?php
    }
    ?>
</ul>