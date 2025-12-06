-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3306
-- Thời gian đã tạo: Th12 01, 2024 lúc 01:22 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `k72_nhom27`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `dulieutaikhoan`
--

CREATE TABLE `dulieutaikhoan` (
  `id` int(50) NOT NULL,
  `ho_ten_nguoi_dung` varchar(250) NOT NULL,
  `taikhoan` varchar(250) NOT NULL,
  `matkhau` varchar(250) NOT NULL,
  `loaitaikhoan` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `dulieutaikhoan`
--

INSERT INTO `dulieutaikhoan` (`id`, `ho_ten_nguoi_dung`, `taikhoan`, `matkhau`, `loaitaikhoan`) VALUES
(23, 'Nguyễn Hữu ADMIN', 'admin', 'c4ca4238a0b923820dcc509a6f75849b', 'admin'),
(24, 'Phùng Đình Tuấn', 'giaovien', 'c4ca4238a0b923820dcc509a6f75849b', 'giaovien'),
(25, 'Nguyễn Hữu Trường', 'giaovien2', 'c4ca4238a0b923820dcc509a6f75849b', 'giaovien'),
(26, 'Nguyễn Văn A', 'giaovien3', 'c4ca4238a0b923820dcc509a6f75849b', 'giaovien'),
(27, 'Nguyễn Hữu Trường 1', 'hocsinh1', 'c4ca4238a0b923820dcc509a6f75849b', 'hocsinh'),
(28, 'Nguyễn Hữu Trường 2', 'hocsinh2', 'c4ca4238a0b923820dcc509a6f75849b', 'hocsinh'),
(29, 'Nguyễn Hữu Trường 3', 'hocsinh3', 'c4ca4238a0b923820dcc509a6f75849b', 'hocsinh');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ho_so_thi_sinh`
--

CREATE TABLE `ho_so_thi_sinh` (
  `id` int(50) NOT NULL,
  `tentk` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ho_ten` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `nganh_xet_tuyen` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `khoi_xet_tuyen` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `ten_nguuoi_duyet` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Chưa có ai',
  `trang_thai` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Chưa duyệt',
  `file_hoc_ba` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `diem_toan` float NOT NULL,
  `diem_ly` float NOT NULL,
  `diem_hoa` float NOT NULL,
  `diem_anh` float NOT NULL,
  `diem_sinh` float NOT NULL,
  `diem_van` float NOT NULL,
  `diem_su` float NOT NULL,
  `diem_dia` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `ho_so_thi_sinh`
--

INSERT INTO `ho_so_thi_sinh` (`id`, `tentk`, `ho_ten`, `nganh_xet_tuyen`, `khoi_xet_tuyen`, `ten_nguuoi_duyet`, `trang_thai`, `file_hoc_ba`, `diem_toan`, `diem_ly`, `diem_hoa`, `diem_anh`, `diem_sinh`, `diem_van`, `diem_su`, `diem_dia`) VALUES
(96, 'hocsinh1', 'Nguyễn Hữu Trường 1', 'Công nghệ thông tin', 'A00', 'Nguyễn Hữu Trường', '-1', 'uploadFile/casting mùa 2.png', 10, 10, 10, 0, 0, 0, 0, 0),
(97, 'hocsinh1', 'Nguyễn Hữu Trường 1', 'Sư phạm tin', 'A01', 'Chưa có ai duyệt', '0', 'uploadFile/CHU.png', 9, 7, 0, 8, 0, 0, 0, 0),
(98, 'hocsinh2', 'Nguyễn Hữu Trường 2', 'Sư phạm tin', 'A01', 'Nguyễn Hữu Trường', '1', 'uploadFile/ef35155dc1c6e79d02389298bb967939.jpg', 5, 5, 0, 5, 0, 0, 0, 0),
(99, 'hocsinh2', 'Nguyễn Hữu Trường 2', 'Ngữ Văn', 'D01', 'Chưa có ai duyệt', '0', 'uploadFile/aertyu.png', 3, 0, 0, 3, 0, 3, 0, 0),
(100, 'hocsinh3', 'Nguyễn Hữu Trường 3', 'Sư phạm tin', 'A01', 'Chưa có ai duyệt', '0', 'uploadFile/ảnh đại diện cho flames.png', 4, 5, 0, 6, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ho_so_xet_tuyen`
--

CREATE TABLE `ho_so_xet_tuyen` (
  `id` int(11) NOT NULL,
  `ten_nganh` varchar(255) NOT NULL,
  `thoi_gian_bat_dau` date NOT NULL,
  `thoi_gian_ket_thuc` date NOT NULL,
  `khoi_xet_tuyen` varchar(10) NOT NULL,
  `trang_thai` enum('hiện','ẩn') DEFAULT 'hiện',
  `giaovien_id` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `ho_so_xet_tuyen`
--

INSERT INTO `ho_so_xet_tuyen` (`id`, `ten_nganh`, `thoi_gian_bat_dau`, `thoi_gian_ket_thuc`, `khoi_xet_tuyen`, `trang_thai`, `giaovien_id`) VALUES
(51, 'Công nghệ thông tin', '2024-12-01', '2024-12-29', 'A00', 'hiện', '24,26,25'),
(52, 'Sư phạm tin', '2024-12-01', '2024-12-22', 'A01', 'hiện', '25'),
(53, 'Ngữ Văn', '2024-12-01', '2024-12-26', 'D01', 'hiện', '25');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `dulieutaikhoan`
--
ALTER TABLE `dulieutaikhoan`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `ho_so_thi_sinh`
--
ALTER TABLE `ho_so_thi_sinh`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `ho_so_xet_tuyen`
--
ALTER TABLE `ho_so_xet_tuyen`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `dulieutaikhoan`
--
ALTER TABLE `dulieutaikhoan`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT cho bảng `ho_so_thi_sinh`
--
ALTER TABLE `ho_so_thi_sinh`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT cho bảng `ho_so_xet_tuyen`
--
ALTER TABLE `ho_so_xet_tuyen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
