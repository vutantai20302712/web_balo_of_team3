<?php
session_start();

if (!isset($_SESSION['login'])) {
    header("Location:login.php");
}
include_once "../config/db.php";

if (isset($_GET['page'])) {
    $page = strtolower($_GET['page']); 
} else {
    $page = ''; 
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
    <link rel="stylesheet" href="../assets/css/base.css">
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/grid.css">
    <link rel="stylesheet" href="../assets/css/responsive.css">
    <link rel="stylesheet" href="../assets/css/manager.css">
    <link rel="stylesheet" href="../assets/css/member.css">
    <link rel="stylesheet" href="../assets/css/add-member.css">
    <link rel="stylesheet" href="../assets/css/edit-member.css">
    <link rel="stylesheet" href="../assets/css/add-product.css">
    <link rel="stylesheet" href="../assets/css/product.css">
    <link rel="stylesheet" href="../assets/css/category.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="../assets/fonts/fontawesome-free-6.4.0-web/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;400;700&display=swap" rel="stylesheet">
    <title>PROJECT_TANTAI-(Administrator)</title>
    <style>
        .error {
            color: red;
            font-size: 14px;
            margin-top: 5px;
            font-weight: bold;
        }

        .auth-form_controls {
            margin-top: 30px;
            margin-bottom: 20px;
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

        form {
            margin-bottom: 20px;
        }

        .btn-sucess {
        background-color: blue;
        margin-left: 20px;
        padding: 15px;
        border: 1px solid #36a7d0;
        width: 100px;
        font-size: 15px;
        border-radius: 4px;
        font-weight: bold;
        color: #fff;
        }
       .btn-sucess:hover{
          background-color: rgb(5, 119, 250);
        }   
        
        .btn-default {
         background-color: red;
         margin-left: 20px;
         padding: 15px;
         border: 1px solid #f50f07;
         width: 100px;
         font-size: 15px;
         border-radius: 4px;
         font-weight: bold;
         margin-left: 3px;
         color: #fff;
        }         
        .btn-default:hover {
            background-color: rgb(248, 0, 0);
        }

        .details {
            list-style-type: none;
        }
        table {
            width:95%;
        }

        .details {
            padding-left: 0;
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
        .product-name {
         padding-left: 40px;
         white-space: nowrap;
         overflow: hidden;
         text-overflow: ellipsis;
         max-width: 250px; /* Độ dài tối đa bạn muốn hiển thị */
        }
    </style>
</head>

<body>
    <header class="header">
        <!-- LOGO SHOP -->
        <div class="header-logo hide-on-tablet ">
            <a href="index.php" class="header_logo-link">
                <img src="../assets/img/logo1.png" alt="Logo" class="header_logo-img">
            </a>
        </div>
        <div class="icon-login-logout">
            <a href="#" class="option-admin-logout-flie">

                <i class="icon-admin fa-solid fa-user-secret"></i>
                <div class="title-admin">
                    <span>Admin</span>
                </div>
                <i class="icon-admin-down fa-sharp fa-solid fa-caret-down"></i>

            </a>
            <ul class="option-admin" role="menu">
                <li class="option-of-admin-file" style="font-size: 17px; margin-top: 14px; margin-bottom:10px ; display:block">
                    <a href="">
                        <i class="icon-flie fa-solid fa-user-tie" style="margin-right:4px"></i>
                        <span>Hồ sơ</span>
                    </a>
                </li>
                <li class="option-of-admin-file" style="font-size: 17px; margin-bottom:14px;">
                    <a href="logout.php">
                        <i class="icon-logout fa-solid fa-circle-xmark" style="margin-right:3px"></i>
                        <span>Đăng xuất</span>
                    </a>
                </li>
            </ul>
        </div>
    </header>
    <div class="grid">
        <div class="row sm-gutter ">
            <div class="col l-3">
                <div class="menu-right">
                    <form role="search">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Search">
                        </div>
                    </form>
                    <ul class="nav menu">
                    <li <?php if ($page === '') echo 'class="active"'; ?>>
                            <a href="index.php">
                            <svg class="glyph stroked dashboard-dial">
                                    <use xlink:href="#stroked-dashboard-dial"></use>
                                </svg>
                                <i class="fa-solid fa-gauge" style="margin-right:8px"></i>
                                Dashboard
                            </a>
                        </li>
                        <li <?php if ($page === 'user') echo 'class="active"'; ?>>
                            <a href="index.php?page=user">
                                <svg class="glyph stroked male user">
                                    <use xlink:herf="#stroked-male-user"></use>
                                </svg>
                                <i class="fa-solid fa-person-military-pointing" style="margin-right:8px"></i>
                                Quản lí thành viên
                            </a>
                        </li>
                        <li <?php if ($page === 'category') echo 'class="active"'; ?>>
                            <a href="index.php?page=category">
                                <svg class="glyph stroked open folder">
                                    <use xlink:herf="#stroked-open-folder"></use>
                                </svg>
                                <i class="fa-solid fa-folder-open" style="margin-right:8px"></i>
                                Quản lí danh mục
                            </a>
                        </li>
                        <li <?php if ($page === 'color') echo 'class="active"'; ?>>
                            <a href="index.php?page=color">
                                <svg class="glyph stroked open folder">
                                    <use xlink:herf="#stroked-open-folder"></use>
                                </svg>
                                <i class="fa-solid fa-folder-open" style="margin-right:8px"></i>
                                Quản lí màu sắc
                            </a>
                        </li>
                        <li <?php if ($page === 'size') echo 'class="active"'; ?>>
                            <a href="index.php?page=size">
                                <svg class="glyph stroked open folder">
                                    <use xlink:herf="#stroked-open-folder"></use>
                                </svg>
                                <i class="fa-solid fa-folder-open" style="margin-right:8px"></i>
                                Quản lí kích thước
                            </a>
                        </li>
                        <li <?php if ($page === 'trademark') echo 'class="active"'; ?>>
                            <a href="index.php?page=trademark">
                                <svg class="glyph stroked open folder">
                                    <use xlink:herf="#stroked-open-folder"></use>
                                </svg>
                                <i class="fa-solid fa-folder-open" style="margin-right:8px"></i>
                                Quản lí thương hiệu
                            </a>
                        </li>
                        <li <?php if ($page === 'product') echo 'class="active"'; ?>>
                            <a href="index.php?page=product">
                                <svg class="glyph stroked bag ">
                                    <use xlink:herf="#stroked-bag"></use>
                                </svg>
                                <i class="fa-solid fa-bag-shopping" style="margin-right:8px"></i>
                                Quản lí sản phẩm
                            </a>
                        </li>
                        <li <?php if ($page === 'customer') echo 'class="active"'; ?>>
                            <a href="index.php?page=customer">
                                <svg class="glyph stroked two massege">
                                    <use xlink:herf="#stroked-two-massege"></use>
                                </svg>
                                <i class="fa-solid fa-user" style="margin-right:8px"></i>
                                Quản lí khách hàng
                            </a>
                        </li>
                        <li <?php if ($page === 'order') echo 'class="active"'; ?>>
                            <a href="index.php?page=order">
                                <svg class="glyph stroked chain">
                                    <use xlink:herf="#stroked-chain"></use>
                                </svg>
                                <i class="fa-solid fa-clipboard-list" style="margin-right:8px"></i>
                                Quản lí đơn hàng
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <?php
            if (isset($_GET['page'])) {
                $page = strtolower($_GET['page']); //chuyển sang kí tự thường
                switch ($page) {
                        // USER
                    case 'user':
                        include_once "modules/user/user.php";
                        break;
                    case 'edit-user':
                        include_once "modules/user/edit-user.php";
                        break;
                    case 'add-user':
                        include_once "modules/user/add-user.php";
                        break;
                    case 'add-user-process':
                        include_once "modules/user/add-user-process.php";
                        break;
                        // PRODUCT 
                    case 'product':
                        include_once "modules/product/product.php";
                        break;
                    case 'edit-product':
                        include_once "modules/product/edit-product.php";
                        break;
                    case 'add-product':
                        include_once "modules/product/add-product.php";
                        break;
                        //CATEGORY
                    case 'category':
                        include_once "modules/category/category.php";
                        break;
                    case 'edit-category':
                        include_once "modules/category/edit-category.php";
                        break;
                    case 'add-category':
                        include_once "modules/category/add-category.php";
                        break;
                        //CUSTOMER
                        case 'customer':
                            include_once "modules/customer/customer.php";
                            break;
                        case 'edit-customer':
                            include_once "modules/customer/edit-customer.php";
                            break;
                        case 'add-customer':
                            include_once "modules/customer/add-customer.php";
                            break;
                        //ORDER
                        case 'order':
                            include_once "modules/order/order.php";
                            break;
                        case 'edit-order':
                            include_once "modules/order/edit-order.php";
                            break;
                        case 'add-order':
                            include_once "modules/order/add-order.php";
                            break;
                        case 'order-details':
                            include_once "modules/order/order-details.php";
                            break;

                            //COLORS
                            case 'color':
                                include_once "modules/color/color.php";
                                break;
                            case 'edit-color':
                                include_once "modules/color/edit-color.php";
                                break;
                            case 'add-color':
                                include_once "modules/color/add-color.php";
                                break;

                        //SIZES
                            case 'size':
                                include_once "modules/size/size.php";
                                break;
                            case 'edit-size':
                                include_once "modules/size/edit-size.php";
                                break;
                            case 'add-size':
                                include_once "modules/size/add-size.php";
                                break;
                        //TRADEMARK
                        case 'trademark':
                            include_once "modules/trademark/trademark.php";
                            break;
                        case 'edit-trademark':
                            include_once "modules/trademark/edit-trademark.php";
                            break;
                        case 'add-trademark':
                            include_once "modules/trademark/add-trademark.php";
                            break;
                }
            } else {
                include_once "modules/admin.php";
            }
            ?>
        </div>
    </div>
</body>

</html>