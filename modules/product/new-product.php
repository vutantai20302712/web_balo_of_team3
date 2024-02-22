<!-- PHẦN SẢN PHẨM MỚI -->
<?php

$conn = initConnection();
$sqlNewPRD = "SELECT p.id, p.ten_san_pham, p.gia, p.hinh_anh, p.tinh_trang, c.ten AS ten_danh_muc, s.ten AS ten_size, co.ten AS ten_color, th.ten AS ten_thuong_hieu
FROM products p
INNER JOIN categories c ON p.danh_muc_id = c.id
INNER JOIN sizes s ON p.sizes = s.id
INNER JOIN colors co ON p.colors = co.id
INNER JOIN trademark th ON p.thuong_hieu_id = th.id
WHERE san_pham_noi_bat = 0
ORDER BY p.id DESC 
 LIMIT 10";

$queryNewPRD = mysqli_query($conn, $sqlNewPRD);

?>

<div class="home-product">
    <h3 style="border-radius:15px; padding:10px; background: linear-gradient(100deg, rgb(0, 0, 0),#006eff);">Sản phẩm mới</h3>
    <div class="row sm-gutter">
        <!-- Grid->Row->Column -->
        <!-- Product item -->
        <?php
        while ($san_pham_moi = mysqli_fetch_assoc($queryNewPRD)) {
        ?>

            <div class="col l-2-4 m-4 c-6">
                <a class="home-product-item" href="index.php?page=product-details&id=<?php echo $san_pham_moi['id']; ?>">
                    <div class="home-product-item__img ">
                        <img src="assets/img/<?php echo $san_pham_moi['hinh_anh']; ?>">
                    </div>
                    <h4 class="home-product-item__name"> <?php echo $san_pham_moi['ten_san_pham']; ?></h4>
                    <div class="home-product-item__price">

                        <span class="home-product-item__price-current" style="text-align:center;"><?php echo number_format($san_pham_moi['gia'], 0, ',', '.'); ?>₫</span>

                    </div>
                    <div class="home-product-item__origin" style="font-weight:bold;">
                        <span class="home-product-item__brand" style="color:#FF8C00	"><?php echo $san_pham_moi['ten_danh_muc']; ?></span>

                        <span class="home-product-item__origin-name" style="color:#00BFFF"><?php echo $san_pham_moi['ten_color']  ?></span>
                    </div>
                </a>
            </div>
        <?php

        }
        ?>
    </div>
</div>