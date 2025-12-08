-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost:3306
-- Thời gian đã tạo: Th12 08, 2025 lúc 02:40 PM
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
-- Cấu trúc bảng cho bảng `attendance_points`
--

CREATE TABLE `attendance_points` (
  `id` int NOT NULL,
  `tour_id` int NOT NULL,
  `point_name` varchar(255) NOT NULL,
  `checkin_time` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `attendance_records`
--

CREATE TABLE `attendance_records` (
  `id` int NOT NULL,
  `attendance_point_id` int NOT NULL,
  `booking_id` int NOT NULL,
  `status` enum('present','absent','late') DEFAULT 'present',
  `note` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `bookings`
--

CREATE TABLE `bookings` (
  `id` int NOT NULL,
  `huong_dan_vien_id` int DEFAULT NULL,
  `customer_name` varchar(150) NOT NULL,
  `customer_phone` varchar(20) NOT NULL,
  `quantity` int NOT NULL,
  `tour_name` varchar(255) NOT NULL,
  `tour_date` date NOT NULL,
  `total_price` decimal(10,2) DEFAULT NULL,
  `special_request` text,
  `type` enum('individual','group') NOT NULL,
  `status` enum('Chờ xác nhận','Đã xác nhận','Đã hủy','Hoàn thành','Đã cọc','pending') NOT NULL DEFAULT 'Chờ xác nhận',
  `booking_date` datetime NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `bookings`
--

INSERT INTO `bookings` (`id`, `huong_dan_vien_id`, `customer_name`, `customer_phone`, `quantity`, `tour_name`, `tour_date`, `total_price`, `special_request`, `type`, `status`, `booking_date`, `created_at`, `updated_at`) VALUES
(14, 6, 'Vũ Mạnh Huy Vương', '02364555224', 1, 'Đà Nẵng - Hội An 3 ngày', '2025-12-26', 3200000.00, 'không có', 'individual', 'Chờ xác nhận', '2025-12-02 08:14:39', '2025-12-02 15:14:39', '2025-12-04 00:01:21'),
(15, 1, 'Vũ Mạnh Huy Vương', '02364555224', 4, 'Đà Nẵng - Hội An 3 ngày', '2025-12-25', 12800000.00, 'không có', 'group', 'Chờ xác nhận', '2025-12-02 08:15:23', '2025-12-02 15:15:23', '2025-12-03 23:53:25'),
(16, 14, 'Hoàng Văn Kiên', '02364555467', 1, 'Hà Nội - Hạ Long 2 ngày', '2025-12-25', 2500000.00, 'không có ', 'individual', 'Chờ xác nhận', '2025-12-02 08:18:03', '2025-12-02 15:18:03', '2025-12-08 21:25:21'),
(17, 6, '122', '12341234567', 1, 'Đà Nẵng - Hội An ', '2026-01-03', 3200000.00, '', 'group', 'Đã hủy', '2025-12-03 17:03:31', '2025-12-04 00:03:31', '2025-12-08 21:25:26'),
(18, 6, 'Hoàng Văn Kiên', '02364555467', 2, 'cô tô  3 ngày 2 đêm', '2025-12-23', 37777776.00, 'không có', 'group', 'Chờ xác nhận', '2025-12-08 14:35:29', '2025-12-08 21:35:29', '2025-12-08 21:35:29');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `booking_group_members`
--

CREATE TABLE `booking_group_members` (
  `id` int NOT NULL,
  `booking_id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `booking_group_members`
--

INSERT INTO `booking_group_members` (`id`, `booking_id`, `name`, `created_at`) VALUES
(1, 18, 'Nguyễn Văn Huy', '2025-12-08 14:35:29'),
(2, 18, 'Nguyễn Văn Huy', '2025-12-08 14:35:29');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `booking_history`
--

CREATE TABLE `booking_history` (
  `id` int NOT NULL,
  `booking_id` int NOT NULL,
  `old_status` varchar(50) DEFAULT NULL,
  `new_status` varchar(50) NOT NULL,
  `changed_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `booking_history`
--

INSERT INTO `booking_history` (`id`, `booking_id`, `old_status`, `new_status`, `changed_at`) VALUES
(11, 16, 'Chờ xác nhận', 'Đã cọc', '2025-12-02 08:18:20'),
(12, 16, 'Đã cọc', 'Đã xác nhận', '2025-12-02 08:30:44'),
(13, 16, 'Đã xác nhận', 'Đã cọc', '2025-12-02 08:30:49'),
(14, 16, 'Đã cọc', 'Hoàn thành', '2025-12-02 08:30:51'),
(15, 16, 'Hoàn thành', 'Chờ xác nhận', '2025-12-02 08:30:53'),
(16, 16, 'Chờ xác nhận', 'Đã xác nhận', '2025-12-03 16:25:25'),
(17, 16, 'Đã xác nhận', 'Đã cọc', '2025-12-03 16:25:26'),
(18, 15, 'Chờ xác nhận', 'Đã xác nhận', '2025-12-03 16:25:27'),
(19, 14, 'Chờ xác nhận', 'Hoàn thành', '2025-12-03 16:25:28'),
(20, 16, 'Chờ xác nhận', 'Đã xác nhận', '2025-12-03 16:46:10'),
(21, 16, 'Đã xác nhận', 'Đã cọc', '2025-12-03 16:46:12'),
(22, 16, 'Chờ xác nhận', 'Đã cọc', '2025-12-03 16:53:10'),
(23, 17, 'Đã xác nhận', 'Đã cọc', '2025-12-03 17:43:38'),
(24, 17, 'Đã cọc', 'Đã xác nhận', '2025-12-03 17:43:40'),
(25, 17, 'Đã xác nhận', 'Chờ xác nhận', '2025-12-03 17:45:19'),
(26, 16, 'Hoàn thành', 'Chờ xác nhận', '2025-12-08 14:25:21'),
(27, 17, 'Đã cọc', 'Hoàn thành', '2025-12-08 14:25:25'),
(28, 17, 'Hoàn thành', 'Đã hủy', '2025-12-08 14:25:26');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `booking_partners`
--

CREATE TABLE `booking_partners` (
  `id` int NOT NULL,
  `booking_id` int NOT NULL,
  `partner_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `booking_partners`
--

INSERT INTO `booking_partners` (`id`, `booking_id`, `partner_id`) VALUES
(13, 14, 6),
(14, 14, 10),
(15, 14, 8),
(16, 15, 6),
(17, 15, 10),
(18, 15, 8),
(19, 16, 6),
(20, 16, 10),
(21, 16, 8),
(22, 18, 6),
(23, 18, 10),
(24, 18, 8);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `created_at`) VALUES
(3, 'Quốc tế', NULL, '2025-12-04 06:36:58'),
(4, 'Trong Nước', NULL, '2025-12-04 06:37:07'),
(5, 'Ngoài Nước', NULL, '2025-12-04 06:37:13');

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
(2, 3),
(14, 3),
(15, 3),
(5, 4),
(15, 4),
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
(15, 'Nguyen Van ưe1', '2025-11-26', '1763402357_Screenshot 2025-11-17 020102.png', '0901234567', 'a.nguyen@gmail.com', 'HDV nội địa', 'Tiếng Anh, Tiếng Hàn', 8, NULL, 1.3, 'Khỏe', '');

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
  `service_history` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `capacity` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `partners`
--

INSERT INTO `partners` (`id`, `name`, `type_id`, `address`, `phone`, `email`, `description`, `service_history`, `created_at`, `capacity`) VALUES
(1, 'Khách sạn SeaView', 1, '123 Đường Biển, Đà Nẵng', '0901234567', 'seaview@example.com', 'Khách sạn 4 sao, view biển', 'Đã phục vụ 30 tour', '2025-11-22 13:45:07', NULL),
(2, 'Công ty Vận tải Xanh', 3, '456 Đường Nội bộ, Hà Nội', '0912345678', 'vantaixanh@example.com', 'Dịch vụ xe đưa đón chất lượng cao', 'Đã phục vụ 20 tour', '2025-11-22 13:45:07', NULL),
(3, 'Nhà hàng Mai Vàng', 2, '78 Lê Lợi, Đà Nẵng', '0987654321', 'maivang@example.com', 'Nhà hàng phục vụ món Á', 'Đã phục vụ 30 tour', '2025-11-22 13:52:43', NULL),
(4, 'Công ty Visa Global', 4, '12 Trần Hưng Đạo, TP.HCM', '0909876543', 'globalvisa@example.com', 'Cung cấp dịch vụ làm visa', 'Đã phục vụ 100 khách', '2025-11-22 13:52:43', NULL),
(5, 'Khách sạn Sunrise', 1, '56 Võ Văn Kiệt, Nha Trang', '0911223344', 'sunrise@example.com', 'Khách sạn 3 sao', 'Đã phục vụ 25 tour', '2025-11-22 13:52:43', NULL),
(6, 'Công ty Bảo hiểm An Bình', 5, '34 Hai Bà Trưng, Hà Nội', '0905566778', 'anbinh@example.com', 'Bảo hiểm du lịch', 'Đã phục vụ 50 tour', '2025-11-22 13:52:43', NULL),
(7, 'Nhà hàng Ngọc Sương', 2, '23 Phan Đình Phùng, Huế', '0911445566', 'ngocsuong@example.com', 'Nhà hàng hải sản', 'Đã phục vụ 20 tour', '2025-11-22 13:52:43', NULL),
(8, 'Công ty Vận tải Minh Đức', 3, '89 Lý Thường Kiệt, TP.HCM', '0902233445', 'minhduc@example.com', 'Vận tải hành khách', 'Đã phục vụ 10 tour', '2025-11-22 13:52:43', NULL),
(9, 'Khách sạn Diamond', 1, '12 Trần Phú, Đà Lạt', '0913334455', 'diamond@example.com', 'Khách sạn 4 sao', 'Đã phục vụ 15 tour', '2025-11-22 13:52:43', NULL),
(10, 'Công ty Du lịch Happy Travel', 3, '67 Nguyễn Huệ, Nha Trang', '0907788990', 'happytravel@example.com', 'Cung cấp dịch vụ tour trọn gói', 'Đã phục vụ 60 tour', '2025-11-22 13:52:43', NULL);

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
(3, 2, '', '', '2025-11-18 14:13:31'),
(4, 1, '', '', '2025-11-18 14:13:35');

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
(2, 'GUIDE'),
(3, 'customer'),
(4, 'supplier'),
(5, 'user_manager');

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
  `category_id` int DEFAULT NULL,
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

INSERT INTO `tours` (`id`, `name`, `category_id`, `price`, `description`, `start_date`, `end_date`, `created_at`, `staff_id`, `supplier_id`, `main_image`) VALUES
(1, 'Hà Nội - Hạ Long ', 3, 2500000, 'Tham quan Hạ Long, chèo thuyền và thưởng thức hải sảnnnn', '2025-12-01', '2025-12-02', '2025-11-12 12:16:40', NULL, NULL, 'assets/uploads/tour_img_69254c42ce275.jpg'),
(2, 'Đà Nẵng - Hội An ', 4, 3200000, 'Thăm các điểm nổi tiếng: Bà Nà, Cầu Vàng, Hội An cổ.', '2025-12-05', '2025-12-06', '2025-11-12 12:16:40', 6, 5, 'assets/uploads/tour_img_69254c52cfbec.jpg'),
(8, 'phú quốc 3 ngày 2 đêm', 4, 19999999, 'đã cọc', '2025-01-15', '2025-01-17', '2025-11-15 07:20:42', 4, 4, 'assets/uploads/tour_img_69254c773046b.jpg'),
(9, 'cô tô  3 ngày 2 đêm', 5, 18888888, 'đã ck', '2025-01-23', '2025-01-24', '2025-11-15 07:58:25', 6, 9, 'assets/uploads/tour_img_69254c81cb133.jpg'),
(20, 'Hà Nội - Hạ Long 2 ngày', 4, 19999999, 'hi', '2025-11-22', '2025-11-22', '2025-11-25 08:04:56', 6, 10, 'assets/uploads/tour_img_692563282443b.jpg'),
(25, 'Hoa', NULL, 1333333333, '', '2025-12-17', '2025-12-18', '2025-12-04 06:25:35', NULL, NULL, 'assets/uploads/tour_img_6931295f5127e.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tour_itineraries`
--

CREATE TABLE `tour_itineraries` (
  `id` int NOT NULL,
  `tour_id` int NOT NULL,
  `day_number` int NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `details` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `tour_itineraries`
--

INSERT INTO `tour_itineraries` (`id`, `tour_id`, `day_number`, `title`, `details`) VALUES
(1, 1, 1, 'Hà Nội - Vịnh Hạ Long', 'Sáng: Khởi hành từ Hà Nội. Chiều: Lên du thuyền, ăn trưa và tham quan hang động. Tối: Ăn tối, câu mực đêm.'),
(2, 1, 2, 'Vịnh Hạ Long - Hà Nội', 'Sáng: Ăn sáng, chèo thuyền Kayak. Trưa: Ăn trưa, làm thủ tục trả phòng. Chiều: Xe đưa về Hà Nội.');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tour_logs`
--

CREATE TABLE `tour_logs` (
  `id` int NOT NULL,
  `tour_id` int NOT NULL,
  `guide_id` int DEFAULT NULL,
  `log_date` date NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `content` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tour_log_photos`
--

CREATE TABLE `tour_log_photos` (
  `id` int NOT NULL,
  `log_id` int NOT NULL,
  `photo_path` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(100) NOT NULL,
  `full_name` varchar(150) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `full_name`, `email`, `password`, `role_id`, `created_at`) VALUES
(1, 'admin', 'Quản trị viên', 'admin@gmail.com', '123456', 1, '2025-11-22 08:54:16'),
(2, 'guide1', 'Hướng dẫn viên', 'guide@gmail.com', '123456', 2, '2025-11-22 08:54:16'),
(4, 'supplier1', 'Nhà cung cấp 1', 'supplier1@gmail.com', '123456', 4, '2025-11-23 06:22:53'),
(5, 'user_manager1', 'Quản lý tài khoản', 'user_manager@gmail.com', '123456', 5, '2025-11-23 06:22:53'),
(6, 'customer1', 'Khách hàng 1', 'customer1@gmail.com', '123456', 3, '2025-11-23 06:22:53');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `attendance_points`
--
ALTER TABLE `attendance_points`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tour_id` (`tour_id`);

--
-- Chỉ mục cho bảng `attendance_records`
--
ALTER TABLE `attendance_records`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attendance_point_id` (`attendance_point_id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Chỉ mục cho bảng `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_huongdanvien` (`huong_dan_vien_id`);

--
-- Chỉ mục cho bảng `booking_group_members`
--
ALTER TABLE `booking_group_members`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Chỉ mục cho bảng `booking_history`
--
ALTER TABLE `booking_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Chỉ mục cho bảng `booking_partners`
--
ALTER TABLE `booking_partners`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `partner_id` (`partner_id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

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
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_tour_category` (`category_id`);

--
-- Chỉ mục cho bảng `tour_itineraries`
--
ALTER TABLE `tour_itineraries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tour_id` (`tour_id`);

--
-- Chỉ mục cho bảng `tour_logs`
--
ALTER TABLE `tour_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tour_id` (`tour_id`),
  ADD KEY `guide_id` (`guide_id`);

--
-- Chỉ mục cho bảng `tour_log_photos`
--
ALTER TABLE `tour_log_photos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `log_id` (`log_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `fk_users_role` (`role_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `attendance_points`
--
ALTER TABLE `attendance_points`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `attendance_records`
--
ALTER TABLE `attendance_records`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `booking_group_members`
--
ALTER TABLE `booking_group_members`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT cho bảng `booking_history`
--
ALTER TABLE `booking_history`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT cho bảng `booking_partners`
--
ALTER TABLE `booking_partners`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `huong_dan_vien`
--
ALTER TABLE `huong_dan_vien`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `nhom_hdv`
--
ALTER TABLE `nhom_hdv`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `partners`
--
ALTER TABLE `partners`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT cho bảng `tour_itineraries`
--
ALTER TABLE `tour_itineraries`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `tour_logs`
--
ALTER TABLE `tour_logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `tour_log_photos`
--
ALTER TABLE `tour_log_photos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `attendance_points`
--
ALTER TABLE `attendance_points`
  ADD CONSTRAINT `attendance_points_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `attendance_records`
--
ALTER TABLE `attendance_records`
  ADD CONSTRAINT `attendance_records_ibfk_1` FOREIGN KEY (`attendance_point_id`) REFERENCES `attendance_points` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `attendance_records_ibfk_2` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `fk_huongdanvien` FOREIGN KEY (`huong_dan_vien_id`) REFERENCES `huong_dan_vien` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `booking_group_members`
--
ALTER TABLE `booking_group_members`
  ADD CONSTRAINT `booking_group_members_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `booking_history`
--
ALTER TABLE `booking_history`
  ADD CONSTRAINT `booking_history_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `booking_partners`
--
ALTER TABLE `booking_partners`
  ADD CONSTRAINT `booking_partners_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_partners_ibfk_2` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `hdv_nhom`
--
ALTER TABLE `hdv_nhom`
  ADD CONSTRAINT `hdv_nhom_ibfk_1` FOREIGN KEY (`hdv_id`) REFERENCES `huong_dan_vien` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `hdv_nhom_ibfk_2` FOREIGN KEY (`nhom_id`) REFERENCES `nhom_hdv` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `partners`
--
ALTER TABLE `partners`
  ADD CONSTRAINT `partners_ibfk_1` FOREIGN KEY (`type_id`) REFERENCES `partner_types` (`id`);

--
-- Các ràng buộc cho bảng `partner_services`
--
ALTER TABLE `partner_services`
  ADD CONSTRAINT `partner_services_ibfk_1` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`);

--
-- Các ràng buộc cho bảng `photos`
--
ALTER TABLE `photos`
  ADD CONSTRAINT `photos_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `tours`
--
ALTER TABLE `tours`
  ADD CONSTRAINT `fk_tour_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `tour_itineraries`
--
ALTER TABLE `tour_itineraries`
  ADD CONSTRAINT `tour_itineraries_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `tour_logs`
--
ALTER TABLE `tour_logs`
  ADD CONSTRAINT `tour_logs_ibfk_1` FOREIGN KEY (`tour_id`) REFERENCES `tours` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tour_logs_ibfk_2` FOREIGN KEY (`guide_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `tour_log_photos`
--
ALTER TABLE `tour_log_photos`
  ADD CONSTRAINT `tour_log_photos_ibfk_1` FOREIGN KEY (`log_id`) REFERENCES `tour_logs` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_role` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`),
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
