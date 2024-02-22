CREATE SCHEMA project_1_tantai;
USE  project_1_tantai;
CREATE TABLE users (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  ten_dang_nhap VARCHAR(50) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  mat_khau VARCHAR(50) NOT NULL,
  ho_ten VARCHAR(100),
  da_xoa TINYINT(1) DEFAULT 0,
  cap_do TINYINT(1) DEFAULT 2,
  inActive BOOLEAN,
  created_at TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE customer (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  ten_dang_nhap VARCHAR(50) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  mat_khau VARCHAR(50) NOT NULL,
  ho_ten VARCHAR(100),
  da_xoa TINYINT(1) DEFAULT 0,
  created_at TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE categories (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  ten VARCHAR(50) NOT NULL,
  da_xoa TINYINT(1) DEFAULT 0,
  created_at TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE trademark (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  ten VARCHAR(50) NOT NULL,
  da_xoa TINYINT(1) DEFAULT 0,
  created_at TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE colors (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  ten VARCHAR(50) NOT NULL,
  da_xoa TINYINT(1) DEFAULT 0,
  created_at TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE sizes (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  ten VARCHAR(50) NOT NULL,
  da_xoa TINYINT(1) DEFAULT 0,
  created_at TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE products (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  ten_san_pham VARCHAR(255) NOT NULL,
  gia DECIMAL(10,2) NOT NULL,
  so_luong INT(11),
  hinh_anh VARCHAR(255),
  san_pham_noi_bat TINYINT(1),
  mo_ta TEXT,
  chat_lieu VARCHAR(255),
  so_ngan VARCHAR(50),
  danh_muc_id INT(11),
  thuong_hieu_id INT(11),
  colors INT,
  sizes INT,
  tinh_trang TINYINT(1) DEFAULT 0,
  created_at TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (danh_muc_id) REFERENCES categories(id),
  FOREIGN KEY (thuong_hieu_id) REFERENCES trademark(id),
  FOREIGN KEY (sizes) REFERENCES sizes(id),
  FOREIGN KEY (colors) REFERENCES colors(id)
);

CREATE TABLE orders (
  id INT(11) AUTO_INCREMENT PRIMARY KEY,
  ten_nguoi_nhan VARCHAR(255) NOT NULL,
  dia_chi_nguoi_nhan VARCHAR(255) NOT NULL,
  email_nguoi_nhan VARCHAR(255) NOT NULL,
  so_dien_thoai_nguoi_nhan VARCHAR(11) NOT NULL,
  tong_tien DECIMAL(10,2) NOT NULL,
  khach_hang_id INT(11),
  nguoi_dung_id INT(11),
  trang_thai TINYINT(1) DEFAULT 0,
  created_at TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (khach_hang_id) REFERENCES customer(id),
  FOREIGN KEY (nguoi_dung_id) REFERENCES users(id)
);

CREATE TABLE order_details (
  don_hang_id INT(11),
  san_pham_id INT(11),
  gia DECIMAL(10,2) NOT NULL,
  so_luong INT(11) NOT NULL,
  PRIMARY KEY (don_hang_id, san_pham_id),
  FOREIGN KEY (don_hang_id) REFERENCES orders(id),
  FOREIGN KEY (san_pham_id) REFERENCES products(id)
);

ALTER TABLE customer
ADD COLUMN so_dien_thoai VARCHAR(20),
ADD COLUMN dia_chi VARCHAR(255);

ALTER TABLE orders
ADD COLUMN ma_don_hang VARCHAR(255);

ALTER TABLE order_details
ADD COLUMN hinh_anh VARCHAR(255),
ADD COLUMN tong_tien VARCHAR(255);

INSERT INTO users (ten_dang_nhap, email, mat_khau, ho_ten, cap_do, inActive, created_at)
VALUES ('vutai4420', 'vutai4420@gmail.com', '12345', 'Vu Tan Tai', 1, false, NOW());

