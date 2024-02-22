    <?php
    session_start();
    // unset($_SESSION['dang-ky-thanh-vien']);
    include_once "config/db.php";
    ob_start();
    ?>
    <?php
    if (isset($_GET['dang_xuat']) && $_GET['dang_xuat'] == 1) {
        unset($_SESSION['dang-ky-thanh-vien']);
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
        <link rel="stylesheet" href="./assets/css/base.css">
        <link rel="stylesheet" href="./assets/css/main.css">
        <link rel="stylesheet" href="./assets/css/grid.css">
        <link rel="stylesheet" href="./assets/css/responsive.css">
        <link rel="stylesheet" href="./assets/css/cart.css">
        <link rel="stylesheet" href="./assets/css/product.css">
        <link rel="stylesheet" href="./assets/css/payment.css">
        <link rel="stylesheet" href="./assets/css/success.css">


        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="stylesheet" href="./assets/fonts/fontawesome-free-6.4.0-web/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;400;700&display=swap" rel="stylesheet">

        <style>
            .header_logo-img {
            width: 100px;
            color: var(--white-color);
            margin-top: -25px;
            }
            .home-product-item__sale-off::after {
                width: 0;
            }
            .home-product h3 {
                font-size: 18px;
                text-transform: uppercase;
                text-align: center;
                color: #fff;
                display: block;
                position: relative;
                margin-bottom: 20px;
            }

            .home-product h3::after {
                content: "";
                display: block;
                width: 350px;
                height: 1px;
                background-color: #fff;
                position: absolute;
                top: 50%;
                right: 0;
            }

            .home-product h3::before {
                content: "";
                display: block;
                width: 350px;
                height: 1px;
                background-color: #fff;
                position: absolute;
                top: 50%;
                left: 0;
            }

            .home-product-item__img {
                padding-top: 10%;
                background-repeat: no-repeat;
                background-size: contain;
                background-position: top center;
                border-top-left-radius: 2px;
                border-top-right-radius: 2px;
                background-color: white;
                text-align: center !important;
            }

            .home-product-item__img img {
                width: 180px;
                height: 180px;
            }

            .home-product-item__price {
                font-weight: bold;
                display: flex;
                justify-content: center;
            }

            .sku {
                font-weight: bold;
                color: orange;
                font-size: 25px;
            }

            .product_summary-item .yellow-ribbon {
                white-space: nowrap;
                /* Không xuống dòng */
                margin-right: 10px;
                /* Khoảng cách giữa các phần tử */
            }

            .new-cart-quantity input {
                width: 43px;
                height: 35px;
            }

            .box-add-new-address-cart {
                width: auto;
                padding: 32px;
                border: 1px solid #e1e1e1;
                border-radius: 6px;
                -webkit-box-pack: center;
                -ms-flex-pack: center;
                justify-content: center;
                margin-bottom: 30px;
                display: none;
            }

            .dang-nhap {
                display: block;
                text-decoration: none;
                color: red;
                font-size: 17px;
                font-weight: bold;
                padding: 11px;
                background-color: #fff;
                border-radius: 4px;
                width: 210px;
                margin-left: 100px;

            }

            .header_search form {
                display: flex;
                align-items: center;
            }

            .header_search input[type="text"],
            .header_search input[type="submit"] {
                display: inline-block;
                vertical-align: middle;
                margin-right: 10px;
            }

            .header_cart-icon-list::before {
                display: none;
            }

            .danger {
                color: red;
                font-size: 20px;
                font-weight: bold;
                margin-bottom: 15px;
                margin-left: 15px;
                border: 1px solid red;
                padding: 15px;
                display: inline-block;

            }

            .product-name {
                padding-left: 30px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                max-width: 300px;
                /* Độ dài tối đa bạn muốn hiển thị */
            }

            .pencil-primary {
                padding: 5px 10px;
                background-color: red;
                border-radius: 3px;
                color: #fff;
                font-weight: 700;
                margin-right: 3px;
            }

            .power-nothing {
                padding: 5px 10px;
                background-color: green;
                border-radius: 3px;
                color: #fff;
                font-weight: 700;
            }

            .power-confirm {
                padding: 5px 10px;
                background-color: black;
                border-radius: 3px;
                color: #fff;
                font-weight: 700;
            }

            .power-payment {
                padding: 5px 10px;
                background-color: orange;
                border-radius: 3px;
                color: #fff;
                font-weight: 700;
            }

            .power-admin {
                padding: 5px 10px;
                background-color: red;
                border-radius: 3px;
                color: #fff;
                font-weight: 700;
            }

            .power-member {
                padding: 5px 10px;
                background-color: blue;
                border-radius: 3px;
                color: #fff;
                font-weight: 700;
            }

            .header {
                height: var(--header-height);
                background-image: linear-gradient(0, #0b0b0b, #797070, #0c0c0c);
            }
            .header-cart-notice {
             position: absolute;
             padding: 1px 7px;
             font-size: 1.4rem;
             line-height: 1.4rem;
             border-radius: 10px;
             color: white;
             background-color: #006eff;
             margin-left: -15px;
            }
            .category_heading {
                background-color:#006eff ;
            }   
            .footer {
             border-top:4px solid #006eff;
            } 
            .price_new {
                background: linear-gradient(100deg, #006eff, rgb(0,0,0));
            }     
            .buy-now {
                background: linear-gradient(100deg, rgb(0,0,0) ,#006eff);
            }
        </style>

    </head>

    <body>
        <!-- Block Element Modifier -->
        <div class="app">
            <header class="header">
                <div class="grid wide">
                    <nav class="header__navbar hide-on-mobile-tablet">
                        <ul class="header__navbar-list">
                            <li class="header__navbar-item  header__navbar-item--has-op  header__navbar-item--separate">
                                <strong>TEAM 3</strong>

                                <!-- HEADER ONE PIECE -->
                                <div class="header_op">
                                    <img src="./assets/img/Img_icon_and_logo/One_piece.png" alt="Warning Logo" class="header__op-img">
                                </div>
                                <i class="header__navbar-icon fa-brands fa-dev"></i>
                            </li>
                            <li class="header__navbar-item">
                                <span class="header__navbar-title--no-pointer">Kết
                                    nối</span>
                                <a href="Not-Update" class="header__navbar-icon-link">
                                    <i class="header__navbar-icon far fa-message"></i>
                                </a>

                                <a href="0326196160" class="header__navbar-icon-link">
                                    <i class="header__navbar-icon fa-solid fa-phone"></i>

                                </a>
                            </li>
                        </ul>

                        <ul class="header__navbar-list">
                            <li class="header__navbar-item">
                                <i class="header__navbar-icon fa-regular fa-circle-question"></i>
                                <a href class="header__navbar-item-link">Trợ
                                    giúp</a>
                            </li>
                            <li class="header__navbar-item header_navbar-user">
                                <img src="./assets/img/Img_icon_and_logo/sanji.jpg" alt="image_login" class="header_navbar-user-img">
                                <span class="header_navbar-user-name">

                                    <?php
                                    if (isset($_SESSION['dang-ky-thanh-vien'])) {
                                        echo '<span style="color:red">' . $_SESSION['dang-ky-thanh-vien'] . '</span>';
                                    } else {
                                        echo 'Đăng nhập';
                                    }
                                    ?>

                                </span>

                                <ul class="header__navbar-user-menu">
                                    <?php
                                    if (isset($_SESSION['dang-ky-thanh-vien'])) {
                                    }

                                    ?>
                                    <?php
                                    if (isset($_SESSION['dang-ky-thanh-vien'])) {
                                    ?>
                                        <li class="header__navbar-user-item">
                                            <a href="index.php?page=lich_su_mua">Đơn mua</a>
                                        </li>
                                    <?php
                                    } else {
                                    ?>

                                    <?php

                                    }
                                    ?>
                                    <?php
                                    if (isset($_SESSION['dang-ky-thanh-vien'])) {
                                    ?>
                                        <li class="header__navbar-user-item header__navbar-user-item--separate">
                                            <a href="index.php?dang_xuat=1">Đăng xuất</a>
                                        </li>
                                    <?php
                                    } else {
                                    ?>
                                        <li class="header__navbar-user-item header__navbar-user-item--separate">
                                            <a href="index.php?page=dang-ky-thanh-vien">Đăng ký</a>
                                        </li>
                                    <?php
                                    }
                                    ?>

                                </ul>
                            </li>
                        </ul>
                    </nav>

                    <!-- HEADER WITH SEARCH -->
                    <div class="header-with-search">
                        <label for="mobile-search-checkbox" class="header__mobile-search">
                            <i class="fa-solid fa-magnifying-glass header__mobile-search-icon"></i>
                        </label>
                        <div class="header-logo hide-on-tablet ">
                            <a href="index.php" class="header_logo-link">
                                <img src="./assets/img/logo1.png" alt="Logo" class="header_logo-img">
                            </a>
                        </div>

                        <input type="checkbox" hidden id="mobile-search-checkbox" class="header_search-checkbox">
                        <div class="header_search" style="display:inline-block;">
                            <form action="index.php?page=search-result" method="POST">
                                <input type="text" placeholder="Tìm kiếm sản phẩm..." name="keyword" style="margin:0">
                                <input type="submit" name="search-result" value="Tìm kiếm" style="color:white; background-color:black; border:none; margin:0;">
                            </form>
                        </div>

                        <!-- CART -->
                        <div class="header_cart">
                            <a href="index.php?page=cart">
                                <div class="header_cart-wrap">
                                    <i class="header_cart-icon fa-solid fa-cart-shopping"></i>
                                    <?php
                                    // Kiểm tra giỏ hàng
                                    if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
                                        // Lấy số lượng sản phẩm trong giỏ hàng
                                        $cartItemCount = count($_SESSION['cart']);
                                        echo '<span class="header-cart-notice">' . $cartItemCount . '</span>';
                                    } else {
                                        // Giỏ hàng rỗng
                                        echo '<span class="header-cart-notice">0</span>';
                                        echo '<div class="header_cart-icon-list">';
                                        echo '<img src="assets/img/empty-cart.png" class="header-cart-nocart">';
                                        echo '<span class="header_cart-list-no-cart-msg">Chưa có sản phẩm</span>';
                                        echo '</div>';
                                    }
                                    ?>
                                </div>
                            </a>
                        </div>
                    </div>

                </div>
            </header>

            <!-- SLIDER -->

            <div class="app__container">
                <div class="grid wide">
                    <div class="row sm-gutter app__content">
                        <div class="col l-2 m-0 c-0">
                            <nav class="category">
                                <h3 class="category_heading">
                                    <i class="category_heading-icon fa-solid fa-list"></i>
                                    Danh mục
                                </h3>
                                <?php
                                $conn = initConnection();
                                $sqlCATE = "SELECT * FROM categories ORDER BY id";
                                $queryCATE = mysqli_query($conn, $sqlCATE);
                                ?>

                                <ul class="category-list">
                                    <?php
                                    while ($category = mysqli_fetch_assoc($queryCATE)) {
                                    ?>
                                        <li class="category-item ">
                                            <i class="category-item--laptop fa-solid fa-balo"></i>
                                            <a href="index.php?page=category-product&id=<?php echo $category['id']; ?>" class="category-item_link"><?php echo $category['ten']  ?></a>

                                        </li>
                                    <?php
                                    }
                                    ?>


                                </ul>
                            </nav>
                        </div>

                        <div class="col l-10 m-12 c-12">
                            <nav class="mobile-category">
                                <ul class="mobile-category-list">
                                    <li class="mobile-category-item">
                                        <a href="" class="mobile-category-link">Laptop</a>
                                    </li>
                                    <li class="mobile-category-item">
                                        <a href="" class="mobile-category-link">PC-Máy tính để bàn</a>
                                    </li>
                                    <li class="mobile-category-item">
                                        <a href="" class="mobile-category-link">Linh kiện</a>
                                    </li>
                                    <li class="mobile-category-item">
                                        <a href="" class="mobile-category-link">Phụ kiện</a>
                                    </li>
                                    <li class="mobile-category-item">
                                        <a href="" class="mobile-category-link">Thanh lí giá tốt </a>
                                    </li>
                                    <li class="mobile-category-item">
                                        <a href="" class="mobile-category-link">Sửa chữa-Bảo hành</a>
                                    </li>
                                    <li class="mobile-category-item">
                                        <a href="" class="mobile-category-link">Laptop</a>
                                    </li>
                                    <li class="mobile-category-item">
                                        <a href="" class="mobile-category-link">PC-Máy tính để bàn</a>
                                    </li>
                                    <li class="mobile-category-item">
                                        <a href="" class="mobile-category-link">Linh kiện</a>
                                    </li>
                                    <li class="mobile-category-item">
                                        <a href="" class="mobile-category-link">Phụ kiện</a>
                                    </li>
                                    <li class="mobile-category-item">
                                        <a href="" class="mobile-category-link">Thanh lí giá tốt </a>
                                    </li>
                                    <li class="mobile-category-item">
                                        <a href="" class="mobile-category-link">Sửa chữa-Bảo hành</a>
                                    </li>
                                </ul>
                            </nav>


                            <!-- CONTENT PRODUCT SHOW -->
                            <?php
                            if (isset($_GET['page'])) {
                                $page = $_GET['page'];
                                switch ($page) {
                                        // PHẦN SẨN PHẨM
                                    case 'category-product':
                                        include_once "modules/product/category-product.php";
                                        break;
                                    case 'product-details':
                                        include_once "modules/product/product-details.php";
                                        break;
                                    case 'search-result':
                                        include_once "modules/product/search-result.php";
                                        break;

                                        // PHẦN GIỎ HÀNG    
                                    case 'cart':
                                        include_once "modules/cart/cart.php";
                                        break;
                                    case 'success':
                                        include_once "modules/cart/success.php";
                                        break;

                                    case 'dang-ky-thanh-vien':
                                        include_once "modules/cart/dang-ky-thanh-vien.php";
                                        break;
                                    case 'dang-nhap':
                                        include_once "modules/cart/dang-nhap.php";
                                        break;
                                    case 'lich_su_mua':
                                        include_once "modules/cart/lich_su_mua.php";
                                        break;
                                    case 'thong_tin-order':
                                        include_once "modules/cart/thong_tin-order.php";
                                        break;
                                    case 'cancel-order':
                                        include_once "modules/cart/cancel-order.php";
                                        break;
                                }
                            } else {
                                include_once "modules/product/featured-product.php";
                                include_once "modules/product/new-product.php";
                            }

                            ?>

                        </div>
                    </div>
                    <div class="grid__full-width product__show">
                        <div class="grid__column-12">

                        </div>
                    </div>
                </div>
            </div>

            <footer class="footer">
                <div class="grid wide footer_content">
                    <div class="row">
                        <div class="col l-2-4 m-4 c-6">
                            <h3 class="footer__heading">Chăm sóc khách hàng</h3>
                            <ul class="footer__list">
                                <li class="footer-item">
                                    <a href="" class="footer-item__link">Trung tâm hỗ trợ</a>

                                </li>
                                <li class="footer-item">

                                    <a href="" class="footer-item__link">Vũ Tấn Tài MAIL</a>

                                </li>
                                <li class="footer-item">

                                    <a href="" class="footer-item__link">Hướng dẫn mua hàng</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col l-2-4 m-4 c-6">
                            <h3 class="footer__heading">Giới thiệu</h3>
                            <ul class="footer__list">
                                <li class="footer-item">
                                    <a href="" class="footer-item__link">Giới thiệu</a>

                                </li>
                                <li class="footer-item">

                                    <a href="" class="footer-item__link">Tuyển dụng</a>

                                </li>
                                <li class="footer-item">

                                    <a href="" class="footer-item__link">Điều khoản</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col l-2-4 m-4 c-6">
                            <h3 class="footer__heading">Theo dõi</h3>
                            <ul class="footer__list">
                                <li class="footer-item">
                                    <a href="" class="footer-item__link">
                                        <i class="footer-item__icon fa-brands fa-facebook"></i>
                                        Facebook
                                    </a>

                                </li>
                                <li class="footer-item">

                                    <a href="" class="footer-item__link">
                                        <i class="footer-item__icon fa-solid fa-phone"></i>
                                        Hotline: 0326196160
                                    </a>

                                </li>
                                <li class="footer-item">

                                    <a href="" class="footer-item__link">
                                        <i class="footer-item__icon fa-brands fa-line"></i>
                                        Line
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="col l-2-4 m-4 c-6">
                            <h3 class="footer__heading">Danh mục</h3>
                            <ul class="footer__list">
                                <li class="footer-item">
                                    <a href="" class="footer-item__link">Laptop mới giá rẻ</a>

                                </li>
                                <li class="footer-item">

                                    <a href="" class="footer-item__link">Phụ kiện chính hãng</a>

                                </li>
                                <li class="footer-item">

                                    <a href="" class="footer-item__link">Bảo hành uy tín</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col l-2-4 m-4 c-6">
                            <h3 class="footer__heading">Vào cửa hàng trên ứng dụng</h3>
                            <div class="footer__download">
                                <img src="./assets/img/IMG_down_app_QR/Qr_code.png" alt="" class="footer__img-qrcode">
                                <div class="footer__download-apps">
                                    <a href="" class="footer__download-app-link">
                                        <img src="./assets/img/IMG_down_app_QR/both.png" alt="" class="footer-both__apps">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="footer__bottom">
                    <div class="grid wide">
                        <p class="footer__text">2023 - Bản quyền thuộc về <strong>VŨ TẤN TÀI</strong></p>
                    </div>
                </div>
            </footer>
        </div>
        </div>

    </body>

    </html>