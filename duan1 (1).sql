-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th10 22, 2025 lúc 07:49 AM
-- Phiên bản máy phục vụ: 8.4.3
-- Phiên bản PHP: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `duan1`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bookings`
--

CREATE TABLE `bookings` (
  `id` int NOT NULL,
  `tour_id` int NOT NULL,
  `user_id` int NOT NULL,
  `seats` int DEFAULT '1',
  `total_price` decimal(12,2) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'booked',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `bookings`
--

INSERT INTO `bookings` (`id`, `tour_id`, `user_id`, `seats`, `total_price`, `status`, `created_at`) VALUES
(1, 1, 1, 2, 5000000.00, 'booked', '2025-11-12 12:16:40');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hdv_nhom`
--

CREATE TABLE `hdv_nhom` (
  `hdv_id` int NOT NULL,
  `nhom_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `hdv_nhom`
--

INSERT INTO `hdv_nhom` (`hdv_id`, `nhom_id`) VALUES
(1, 1),
(4, 1),
(6, 1),
(1, 2),
(3, 2),
(5, 2),
(14, 2),
(15, 2),
(16, 2),
(2, 3),
(14, 3),
(15, 3),
(16, 3),
(5, 4),
(16, 4),
(3, 5);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `huong_dan_vien`
--

CREATE TABLE `huong_dan_vien` (
  `id` int NOT NULL,
  `ho_ten` varchar(255) NOT NULL,
  `ngay_sinh` date DEFAULT NULL,
  `anh` varchar(255) DEFAULT NULL,
  `so_dien_thoai` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `chung_chi` text,
  `ngon_ngu` varchar(255) DEFAULT NULL,
  `nam_kinh_nghiem` int DEFAULT NULL,
  `lich_su_tour` json DEFAULT NULL,
  `danh_gia` float DEFAULT NULL,
  `suc_khoe` varchar(50) DEFAULT NULL,
  `ghi_chu` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `huong_dan_vien`
--

INSERT INTO `huong_dan_vien` (`id`, `ho_ten`, `ngay_sinh`, `anh`, `so_dien_thoai`, `email`, `chung_chi`, `ngon_ngu`, `nam_kinh_nghiem`, `lich_su_tour`, `danh_gia`, `suc_khoe`, `ghi_chu`) VALUES
(1, 'Nguyen Van A1', '1985-03-12', '1763401857_Screenshot 2025-11-17 020102.png', '0901234567', 'a.nguyen@gmail.com', 'HDV nội địa', 'Tiếng Anh, Tiếng Pháp', 10, '[{\"tour_id\": 1, \"ten_tour\": \"Hà Nội 3N2Đ\"}, {\"tour_id\": 2, \"ten_tour\": \"Đà Nẵng 4N3Đ\"}]', 4.5, 'Khỏe', ''),
(2, 'Tran Thi B', '1990-07-22', '1763401836_Screenshot 2025-11-17 020102.png', '0912345678', 'b.tran@gmail.com', 'HDV chuyên tuyến Bắc', 'Tiếng Anh', 5, '[{\"tour_id\": 3, \"ten_tour\": \"Hạ Long 2N1Đ\"}]', 4, 'Khỏe', ''),
(3, 'Le Van A2', '1982-11-05', '1763401827_Screenshot 2025-11-17 020102.png', '0987654321', 'c.le@gmail.com', 'HDV chuyên khách đoàn', 'Tiếng Anh, Tiếng Trung', 12, '[{\"tour_id\": 4, \"ten_tour\": \"Sapa 3N2Đ\"}, {\"tour_id\": 5, \"ten_tour\": \"Hà Giang 4N3Đ\"}]', 4.8, 'Khỏe', '23'),
(4, 'Pham Thi D', '1995-01-15', 'anh4.jpg', '0978123456', 'd.pham@gmail.com', 'HDV nội địa', 'Tiếng Việt', 3, '[{\"tour_id\": 6, \"ten_tour\": \"Huế 2N1Đ\"}]', 3.9, 'Khỏe', ''),
(5, 'Hoang Van E', '1988-05-30', 'anh5.jpg', '0967123456', 'e.hoang@gmail.com', 'HDV quốc tế', 'Tiếng Anh, Tiếng Nhật', 8, '[{\"tour_id\": 7, \"ten_tour\": \"Phú Quốc 4N3Đ\"}, {\"tour_id\": 8, \"ten_tour\": \"Nha Trang 3N2Đ\"}]', 4.7, 'Khỏe', ''),
(6, 'Le Thi F', '1992-08-12', 'anh6.jpg', '0932123456', 'f.le@gmail.com', 'HDV nội địa', 'Tiếng Việt, Tiếng Anh', 6, '[{\"tour_id\": 9, \"ten_tour\": \"Đà Lạt 3N2Đ\"}]', 4.2, 'Khỏe', ''),
(14, 'Nguyen Van ưe', '2025-11-14', '1763402164_mat2.gif', '0987654321', 'a.nguyen@gmail.com', 'HDV nội địa', 'Tiếng Anh, Tiếng Trung', 4, NULL, 1.5, 'Khỏe', ''),
(15, 'Nguyen Van ưe', '2025-11-26', '1763402357_Screenshot 2025-11-17 020102.png', '0901234567', 'a.nguyen@gmail.com', 'HDV nội địa', 'Tiếng Anh, Tiếng Hàn', 8, NULL, 1.3, 'Khỏe', ''),
(16, 'Nguyen Van ưe', '2025-11-26', NULL, '0901234567', 'a.nguyen@gmail.com', 'HDV nội địa', 'Tiếng Anh, Tiếng Hàn', 8, NULL, 1.3, 'Khỏe', '');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `nhom_hdv`
--

CREATE TABLE `nhom_hdv` (
  `id` int NOT NULL,
  `ten_nhom` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `nhom_hdv`
--

INSERT INTO `nhom_hdv` (`id`, `ten_nhom`) VALUES
(1, 'Nội địa'),
(2, 'Quốc tế'),
(3, 'Chuyên tuyến Bắc'),
(4, 'Chuyên tuyến Nam'),
(5, 'Chuyên khách đoàn');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `partners`
--

CREATE TABLE `partners` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `type_id` int DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `description` text,
  `capacity` int DEFAULT NULL,
  `service_history` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `partners`
--

INSERT INTO `partners` (`id`, `name`, `type_id`, `address`, `phone`, `email`, `description`, `capacity`, `service_history`, `created_at`) VALUES
(1, 'Khách sạn SeaView', 1, '123 Đường Biển, Đà Nẵng', '0901234567', 'seaview@example.com', 'Khách sạn 4 sao, view biển', 2000, 'Đã phục vụ 20 tour', '2025-11-22 13:45:07'),
(2, 'Công ty Vận tải Xanh', 3, '456 Đường Nội bộ, Hà Nội', '0912345678', 'vantaixanh@example.com', 'Dịch vụ xe đưa đón chất lượng cao', NULL, 'Đã phục vụ 20 tour', '2025-11-22 13:45:07'),
(3, 'Nhà hàng Mai Vàng', 2, '78 Lê Lợi, Đà Nẵng', '0987654321', 'maivang@example.com', 'Nhà hàng phục vụ món Á', 80, 'Đã phục vụ 30 tour', '2025-11-22 13:52:43'),
(4, 'Công ty Visa Global', 4, '12 Trần Hưng Đạo, TP.HCM', '0909876543', 'globalvisa@example.com', 'Cung cấp dịch vụ làm visa', NULL, 'Đã phục vụ 100 khách', '2025-11-22 13:52:43'),
(5, 'Khách sạn Sunrise', 1, '56 Võ Văn Kiệt, Nha Trang', '0911223344', 'sunrise@example.com', 'Khách sạn 3 sao', 120, 'Đã phục vụ 25 tour', '2025-11-22 13:52:43'),
(6, 'Công ty Bảo hiểm An Bình', 5, '34 Hai Bà Trưng, Hà Nội', '0905566778', 'anbinh@example.com', 'Bảo hiểm du lịch', NULL, 'Đã phục vụ 50 tour', '2025-11-22 13:52:43'),
(7, 'Nhà hàng Ngọc Sương', 2, '23 Phan Đình Phùng, Huế', '0911445566', 'ngocsuong@example.com', 'Nhà hàng hải sản', 60, 'Đã phục vụ 20 tour', '2025-11-22 13:52:43'),
(8, 'Công ty Vận tải Minh Đức', 3, '89 Lý Thường Kiệt, TP.HCM', '0902233445', 'minhduc@example.com', 'Vận tải hành khách', 40, 'Đã phục vụ 10 tour', '2025-11-22 13:52:43'),
(9, 'Khách sạn Diamond', 1, '12 Trần Phú, Đà Lạt', '0913334455', 'diamond@example.com', 'Khách sạn 4 sao', 90, 'Đã phục vụ 15 tour', '2025-11-22 13:52:43'),
(10, 'Công ty Du lịch Happy Travel', 3, '67 Nguyễn Huệ, Nha Trang', '0907788990', 'happytravel@example.com', 'Cung cấp dịch vụ tour trọn gói', NULL, 'Đã phục vụ 60 tour', '2025-11-22 13:52:43');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `partner_services`
--

CREATE TABLE `partner_services` (
  `id` int NOT NULL,
  `partner_id` int NOT NULL,
  `service_name` varchar(255) DEFAULT NULL,
  `tour_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `partner_services`
--

INSERT INTO `partner_services` (`id`, `partner_id`, `service_name`, `tour_name`) VALUES
(1, 1, 'Lưu trú', 'Tour Đà Nẵng 3N2Đ'),
(2, 2, 'Vận chuyển', 'Tour Hà Nội - Sapa 2N1Đ');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `partner_types`
--

CREATE TABLE `partner_types` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `partner_types`
--

INSERT INTO `partner_types` (`id`, `name`) VALUES
(1, 'Khách sạn'),
(2, 'Nhà hàng'),
(3, 'Vận chuyển'),
(4, 'Visa'),
(5, 'Bảo hiểm');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `photos`
--

CREATE TABLE `photos` (
  `id` int NOT NULL,
  `tour_id` int NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `caption` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `photos`
--

INSERT INTO `photos` (`id`, `tour_id`, `image_path`, `caption`, `created_at`) VALUES
(1, 3, 'public/uploads/album_hanoi_1.jpg', 'Góc nhìn Hà Nội 1', '2025-11-15 13:50:13'),
(2, 3, 'public/uploads/album_hanoi_2.jpg', 'Góc nhìn Hà Nội 2', '2025-11-15 13:50:13'),
(3, 2, '', '', '2025-11-18 14:13:31'),
(4, 1, '', '', '2025-11-18 14:13:35'),
(5, 7, '', '', '2025-11-18 14:13:41');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `roles`
--

CREATE TABLE `roles` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'ADMIN'),
(2, 'GUIDE');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `staff`
--

CREATE TABLE `staff` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `staff`
--

INSERT INTO `staff` (`id`, `name`, `created_at`) VALUES
(1, 'Nguyễn Văn A - Điều hành', '2025-11-14 18:02:38'),
(2, 'Trần Thị B - Trợ lý tour', '2025-11-14 18:02:38'),
(3, 'Nguyễn Văn A - Điều hành', '2025-11-14 18:03:08'),
(4, 'Trần Thị B - Trợ lý tour', '2025-11-14 18:03:08');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `suppliers`
--

CREATE TABLE `suppliers` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `type_id` int DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `description` text,
  `capacity` text,
  `service_history` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `suppliers`
--

INSERT INTO `suppliers` (`id`, `name`, `created_at`, `type_id`, `address`, `phone`, `email`, `description`, `capacity`, `service_history`) VALUES
(1, 'Khách sạn SeaView', '2025-11-14 18:03:08', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'Công ty Vận tải Xanh', '2025-11-14 18:03:08', NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `supplier_types`
--

CREATE TABLE `supplier_types` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tours`
--

CREATE TABLE `tours` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` bigint NOT NULL,
  `description` text,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `staff_id` int DEFAULT NULL,
  `supplier_id` int DEFAULT NULL,
  `main_image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `tours`
--

INSERT INTO `tours` (`id`, `name`, `price`, `description`, `start_date`, `end_date`, `created_at`, `staff_id`, `supplier_id`, `main_image`) VALUES
(1, 'Hà Nội - Hạ Long 2 ngày', 2500000, 'Tham quan Hạ Long, chèo thuyền và thưởng thức hải sảnnnn', '2025-12-01', '2025-12-02', '2025-11-12 12:16:40', 1, 2, NULL),
(2, 'Đà Nẵng - Hội An 3 ngày', 3200000, 'Thăm các điểm nổi tiếng: Bà Nà, Cầu Vàng, Hội An cổ.', '2025-12-05', '2025-12-07', '2025-11-12 12:16:40', NULL, NULL, 'assets/uploads/tour_img_691bf024e191e.jpg'),
(3, 'Bùi Nhật Long', 120000, 'hiiii', '2025-01-12', '2025-01-15', '2025-11-14 11:18:06', NULL, NULL, 'assets/uploads/tour_img_691bf03570827.jpg'),
(7, 'Bùi Nhật Long', 11111, 'ok', '2025-02-12', '2025-01-15', '2025-11-15 06:56:20', 1, 1, 'public/uploads/tour_img_6918241430639.jpg'),
(8, 'phú quốc 3 ngày 2 đêm', 19999999, 'đã cọc', '2025-01-15', '2025-01-18', '2025-11-15 07:20:42', 2, 2, 'public/uploads/tour_img_691829cac8b62.jpg'),
(9, 'cô tô 4 3 ngày 2 đêm', 18888888, 'đã ck', '2025-01-23', '2025-01-27', '2025-11-15 07:58:25', 3, 1, 'public/uploads/tour_img_691832a1b3f52.jpg'),
(11, 'duc anh', 1333333333, '', '2025-11-12', '2025-11-29', '2025-11-18 03:36:07', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int DEFAULT '2',
  `full_name` varchar(200) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role_id`, `full_name`, `created_at`) VALUES
(1, 'admin', '$2y$10$w9lQJ2q8E3fYH8m1fTqvWeJf7KqKqv3C1ZQk3o1r9gq9o9VQx8bqK', 1, 'Administrator', '2025-11-12 12:16:40'),
(2, 'guide', '$2y$10$4q7eKp9uVf2N2z0Qh6sYfeuP9d1r9tZ2Wq3p1s5J8k2L0mN4b3c7e', 2, 'Hướng dẫn viên', '2025-11-12 12:16:40');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tour_id` (`tour_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `hdv_nhom`
--
ALTER TABLE `hdv_nhom`
  ADD PRIMARY KEY (`hdv_id`,`nhom_id`),
  ADD KEY `nhom_id` (`nhom_id`);

--
-- Chỉ mục cho bảng `huong_dan_vien`
--
ALTER TABLE `huong_dan_vien`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `nhom_hdv`
--
ALTER TABLE `nhom_hdv`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `partners`
--
ALTER TABLE `partners`
  ADD PRIMARY KEY (`id`),
  ADD KEY `type_id` (`type_id`);

--
-- Chỉ mục cho bảng `partner_services`
--
ALTER TABLE `partner_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `partner_id` (`partner_id`);

--
-- Chỉ mục cho bảng `partner_types`
--
ALTER TABLE `partner_types`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tour_id` (`tour_id`);

--
-- Chỉ mục cho bảng `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `supplier_types`
--
ALTER TABLE `supplier_types`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `tours`
--
ALTER TABLE `tours`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `huong_dan_vien`
--
ALTER TABLE `huong_dan_vien`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `nhom_hdv`
--
ALTER TABLE `nhom_hdv`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `partners`
--
ALTER TABLE `partners`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `partner_services`
--
ALTER TABLE `partner_services`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `partner_types`
--
ALTER TABLE `partner_types`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `photos`
--
ALTER TABLE `photos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `staff`
--
ALTER TABLE `staff`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `supplier_types`
--
ALTER TABLE `supplier_types`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tours`
--
ALTER TABLE `tours`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ràng buộc đối với các bảng kết xuất
--

--
-- Ràng buộc cho bảng `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ràng buộc cho bảng `hdv_nhom`
--
ALTER TABLE `hdv_nhom`
  ADD CONSTRAINT `hdv_nhom_ibfk_1` FOREIGN KEY (`hdv_id`) REFERENCES `huong_dan_vien` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `hdv_nhom_ibfk_2` FOREIGN KEY (`nhom_id`) REFERENCES `nhom_hdv` (`id`) ON DELETE CASCADE;

--
-- Ràng buộc cho bảng `partners`
--
ALTER TABLE `partners`
  ADD CONSTRAINT `partners_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `partner_types` (`id`);

--
-- Ràng buộc cho bảng `partner_services`
--
ALTER TABLE `partner_services`
  ADD CONSTRAINT `partner_services_ibfk_1` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`);

--
-- Ràng buộc cho bảng `photos`
--
ALTER TABLE `photos`
  ADD CONSTRAINT `photos_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE;

--
-- Ràng buộc cho bảng `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
