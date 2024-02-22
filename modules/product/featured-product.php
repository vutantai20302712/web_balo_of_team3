<!-- PHẦN SẢN PHẨM NỔI BẬT -->
<?php

$conn = initConnection();
$sqlFeaturedPRD = "SELECT p.id, p.ten_san_pham, p.gia, p.hinh_anh, p.tinh_trang, c.ten AS ten_danh_muc, s.ten AS ten_size, co.ten AS ten_color, th.ten AS ten_thuong_hieu
                  FROM products p
                  INNER JOIN categories c ON p.danh_muc_id = c.id
                  INNER JOIN sizes s ON p.sizes = s.id
                  INNER JOIN colors co ON p.colors = co.id
                  INNER JOIN trademark th ON p.thuong_hieu_id = th.id
                  WHERE san_pham_noi_bat = 1
                  ORDER BY p.id DESC 
                   LIMIT 10";
$queryFeaturedPRD = mysqli_query($conn, $sqlFeaturedPRD);

?>

<div class="home-product">
    <h3 style=" border-radius:15px; padding:10px; background: linear-gradient(100deg, #006eff, rgb(0,0,0));">Sản phẩm nổi bật</h3>
    <div class="row sm-gutter">
        <!-- Grid->Row->Column -->
        <!-- Product item -->
        <?php
        while ($noi_bat = mysqli_fetch_assoc($queryFeaturedPRD)) {
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
                    <span class="home-product-item__brand" style="color:#FF8C00	"><?php echo $noi_bat['ten_danh_muc']; ?></span>

                        <span class="home-product-item__origin-name" style="color:#00BFFF"><?php echo $noi_bat['ten_color']  ?></span>
                    </div>
                </a>
            </div>
        <?php

        }
        ?>
    </div>
</div>