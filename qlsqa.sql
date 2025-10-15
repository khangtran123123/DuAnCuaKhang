-- phpMyAdmin SQL Dump
-- version 3.4.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Apr 25, 2025 at 05:13 AM
-- Server version: 5.5.20
-- PHP Version: 5.3.10

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `qlsqa`

CREATE DATABASE `qlsqa` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `qlsqa`;
--

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE IF NOT EXISTS `tbladmin` (
  `MaAdmin` char(5) COLLATE utf8_unicode_ci NOT NULL,
  `TenAdmin` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `TenDangNhap` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `MatKhau` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `QuyenAdmin` int(11) NOT NULL DEFAULT '0',
  `GioiTinh` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Nam',
  `SDT` char(10) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`MaAdmin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`MaAdmin`, `TenAdmin`, `TenDangNhap`, `MatKhau`, `QuyenAdmin`, `GioiTinh`, `SDT`) VALUES
('AD001', 'Trịnh Hoàng Lộc', 'hoangloc123', '202cb962ac59075b964b07152d234b70', 1, 'Nam', '0857147907'),
('AD002', 'Trần Vĩ Khang', 'vikhang123', '202cb962ac59075b964b07152d234b70', 1, 'Nam', '0957147907'),
('AD003', 'Trần Thanh Ngân', 'thanhngan123', '202cb962ac59075b964b07152d234b70', 1, 'Nữ', '0057147907'),
('AD004', 'Lê Ngọc Giao', 'ngocgiao123', '202cb962ac59075b964b07152d234b70', 0, 'Nữ', '0557147907');

-- --------------------------------------------------------


--
-- Table structure for table `tblkhachhang`
--

CREATE TABLE IF NOT EXISTS `tblkhachhang` (
  `MaKH` char(5) COLLATE utf8_unicode_ci NOT NULL,
  `TenDNKH` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `MatKhauKH` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `TenKH` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `GioiTinhKH` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Nam',
  `CapTK` int(11) NOT NULL DEFAULT '0',
  `SDTKH` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `GhiChu` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`MaKH`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tblkhachhang`
--

INSERT INTO `tblkhachhang` (`MaKH`, `TenDNKH`, `MatKhauKH`, `TenKH`, `GioiTinhKH`, `CapTK`, `SDTKH`) VALUES
('KH001', 'tva123', '202cb962ac59075b964b07152d234b70', 'Trần Văn A', 'Nam', 3, '0000111122'),
('KH002', 'tvb123', '202cb962ac59075b964b07152d234b70', 'Trần Văn B', 'Nữ', 2, '0000111123'),
('KH003', 'tvc123', '202cb962ac59075b964b07152d234b70', 'Trần Văn C', 'Nữ', 1, '0000111124'),
('KH004', 'tvd123', '202cb962ac59075b964b07152d234b70', 'Trần Văn D', 'Nam', 3, '0000111142'),
('KH005', 'tve123', '202cb962ac59075b964b07152d234b70', 'Trần Văn E', 'Nam', 1, '0000111152');

-- --------------------------------------------------------

--
-- Table structure for table `tblnhacungcap`
--

CREATE TABLE IF NOT EXISTS `tblnhacungcap` (
  `MaNCC` char(5) COLLATE utf8_unicode_ci NOT NULL,
  `TenNCC` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `DiaChiNCC` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `SDTNCC` char(10) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`MaNCC`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tblnhacungcap`
--

INSERT INTO `tblnhacungcap` (`MaNCC`, `TenNCC`, `DiaChiNCC`, `SDTNCC`) VALUES
('CC001', 'Dior', 'TP.HCM', '0213012412'),
('CC002', 'Louis VulTon', 'Hà Nội', '0313012412'),
('CC003', 'Gucci', 'An Giang', '0113012412'),
('CC004', 'LuonVuiTuoi', 'TP.HCM', '0613012412');

-- --------------------------------------------------------

--
-- Table structure for table `tblsanpham`
--

CREATE TABLE IF NOT EXISTS `tblsanpham` (
  `MaSP` char(30) COLLATE utf8_unicode_ci NOT NULL,
  `TenSP` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `LoaiSP` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `ThuongHieuSP` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `DonGia` float NOT NULL DEFAULT '0',
  `SoLuongSP` int(11) NOT NULL DEFAULT '0',
  `MaNCC` char(5) COLLATE utf8_unicode_ci NOT NULL,
  `NgayNhap` date NOT NULL,
  `KhuyenMai` float NOT NULL DEFAULT '0',
  `HinhAnh` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `MoTa` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`MaSP`),
  FOREIGN KEY (`MaNCC`) REFERENCES `tblnhacungcap`(`MaNCC`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `tblhoadon`
--

CREATE TABLE IF NOT EXISTS `tblhoadon` (
  `MaHD` char(5) COLLATE utf8_unicode_ci NOT NULL,
  `MaKH` char(5) COLLATE utf8_unicode_ci NOT NULL,
  `GiamGia` float NOT NULL DEFAULT '0',
  `TongTien` float NOT NULL DEFAULT '0',
  `NgayBan` date NOT NULL,
  PRIMARY KEY (`MaHD`),
  FOREIGN KEY (`MaKH`) REFERENCES `tblkhachhang`(`MaKH`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `tblchitiethoadon`
--

CREATE TABLE IF NOT EXISTS `tblchitiethoadon` (
  `MaHD` char(5) COLLATE utf8_unicode_ci NOT NULL,
  `MaSP` char(30) COLLATE utf8_unicode_ci NOT NULL,
  `SoLuong` int(11) NOT NULL,
  `DonGia` float NOT NULL,
  `ThanhTien` float NOT NULL,
  FOREIGN KEY (`MaHD`) REFERENCES `tblhoadon`(`MaHD`),
  FOREIGN KEY (`MaSP`) REFERENCES `tblsanpham`(`MaSP`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------




--
-- Dumping data for table `tblsanpham`
--

INSERT INTO `tblsanpham` (`MaSP`, `TenSP`, `LoaiSP`, `ThuongHieuSP`, `DonGia`, `SoLuongSP`, `MaNCC`, `NgayNhap`, `KhuyenMai`, `HinhAnh`, `MoTa`) VALUES
('Dior001', 'Dior Oblique T-Shirt', 'Áo thun', 'Dior', 50000, 100, 'CC001', '2023-09-15', 10, 'image/AT1.png', 'Áo thun nam Dior sử dụng chất liệu cotton cao cấp, mềm mại và thoáng mát.Thiết kế tối giản nhưng đầy tinh tế, phù hợp nhiều phong cách.Logo Dior tạo điểm nhấn sang trọng mà không phô trương.'),
('Dior002', 'CD Icon T-Shirt', 'Áo thun', 'Dior', 70000, 15, 'CC001', '2024-12-15', 15, 'image/AT2.png', 'Phom áo ôm vừa vặn, tôn dáng người mặc một cách tự nhiên.
Vải bền đẹp, không bai nhão sau nhiều lần giặt.
Một lựa chọn lý tưởng cho phong cách thanh lịch hằng ngày.'),
('Dior003', 'Bee Embroidery T-Shirt', 'Áo thun', 'Dior', 80000, 150, 'CC001', '2024-12-15', 15, 'image/AT3.png', 'Áo thun Dior là sự kết hợp hoàn hảo giữa thời trang và đẳng cấp.
Chất liệu vải nhập khẩu tạo cảm giác mặc nhẹ nhàng, mát mẻ.
Thiết kế đơn giản nhưng dễ nhận biết nhờ chi tiết đặc trưng thương hiệu.'),
('Dior004', 'Christian Dior Atelier T-Shirt', 'Áo thun', 'Dior', 60000, 200, 'CC001', '2024-12-15', 15, 'image/AT4.png', 'Mỗi chiếc áo thun Dior đều thể hiện sự chỉn chu đến từng đường may.
Form dáng trẻ trung, hiện đại, dễ phối đồ.
Đây là món đồ không thể thiếu cho các quý ông yêu thích sự tối giản cao cấp.'),
('Dior005', 'Dior x CACTUS JACK T-Shirt ', 'Áo thun', 'Dior', 75000, 300, 'CC001', '2024-12-15', 15, 'image/AT5.png', 'Dior mang tinh thần haute couture vào dòng áo thun thường ngày.
Mức giá cao nhưng đi kèm chất lượng vượt trội.
Một chiếc áo đơn giản, nhưng đủ để tạo ấn tượng mạnh mẽ.'),
('Dior006', 'Dior And Kenny Scharf Print T-Shirt', 'Áo thun', 'Dior', 90000, 350, 'CC001', '2024-12-15', 20, 'image/AT6.png', 'Vải cotton hữu cơ thân thiện môi trường và cực kỳ bền màu.
Logo thêu tinh xảo, tạo nên vẻ ngoài đẳng cấp.
Phù hợp để mặc đơn lẻ hoặc kết hợp cùng blazer.'),
('Dior007', 'DIOR AND KAWS Bee T-Shirt', 'Áo thun', 'Dior', 100000, 150, 'CC001', '2024-12-15', 20, 'image/AT7.png', 'Áo thun Dior có độ co giãn nhẹ, tạo cảm giác thoải mái suốt cả ngày.
Tông màu trung tính dễ phối với nhiều trang phục.
Là lựa chọn hoàn hảo cho những ai theo đuổi phong cách smart-casual'),
('Dior008', 'Dior 1947 T-Shirt', 'Áo thun', 'Dior', 80000, 0, 'CC001', '2024-12-15', 15, 'image/AT8.png', 'Chiếc áo toát lên sự sang trọng dù không cần nhiều chi tiết cầu kỳ.
Chất liệu cao cấp giữ form tốt, không dễ biến dạng.
Dior luôn biết cách khiến thời trang đơn giản trở nên khác biệt.'),
('Dior009', 'DIOR Zodiac T-Shirt', 'Áo thun', 'Dior', 50000, 570, 'CC001', '2024-12-15', 20, 'image/AT9.png', 'Áo thun Dior luôn nằm trong danh sách yêu thích của các tín đồ thời trang.
Không chỉ vì thương hiệu, mà còn bởi cảm giác mặc cực kỳ dễ chịu.
Một item vừa thoải mái vừa tôn phong cách sống hiện đại.'),
('Dior010', 'Dior Gradient Logo T-Shirt', 'Áo thun', 'Dior', 80000, 200, 'CC001', '2024-12-15', 20, 'image/AT10.png', 'Mỗi mùa, Dior đều cho ra mắt những mẫu áo thun mới mẻ và ấn tượng.
Từ phom dáng đến màu sắc đều được chăm chút kỹ lưỡng.
Phù hợp với những ai yêu cái đẹp và sự hoàn hảo.'),
('Dior011', 'CD Diamond Motif T-Shirt', 'Áo thun', 'Dior', 85000, 90, 'CC001', '2024-12-15', 20, 'image/AT11.png', 'Áo thun Dior không chỉ đẹp mắt mà còn có tính ứng dụng cao.
Dễ mặc đi làm, đi chơi hay du lịch.
Chỉ một chiếc áo cũng đủ giúp bạn nổi bật.'),
('Dior012', 'Dior Jardin d’Hiver T-Shirt', 'Áo thun', 'Dior', 79000, 100, 'CC001', '2024-12-15', 10, 'image/AT12.png', 'Sở hữu áo thun Dior là sở hữu một phần của đẳng cấp thời trang thế giới.
Từng chi tiết đều toát lên sự tinh tế và sang trọng.
Giá trị không nằm ở thương hiệu, mà ở trải nghiệm thực tế khi mặc.'),
('Dior013', 'DIOR And ERL Embroidered T-Shirt', 'Áo thun', 'Dior', 81000, 0, 'CC001', '2024-12-15', 15, 'image/AT13.png', 'Vải áo mềm mịn, nhẹ tênh như không mặc gì.
Cổ áo, tay áo đều được xử lý cẩn thận để giữ dáng lâu dài.
Chiếc áo nhỏ, nhưng thể hiện rõ gu thẩm mỹ cá nhân.'),
('Dior014', 'Dior Palm Tree Print T-Shirt', 'Áo thun', 'Dior', 69000, 70, 'CC001', '2024-12-15', 5, 'image/AT14.png', 'Dior luôn tạo ra sự khác biệt từ những điều đơn giản nhất.
Áo thun nam là minh chứng rõ ràng cho điều đó.
Một lựa chọn hoàn hảo cho những ai đề cao sự tinh tế trong thời trang.'),
('Dior015', 'Dior Lingot 50-Inspired Graphic Tee', 'Áo thun', 'Dior', 80000, 100, 'CC001', '2024-12-15', 15, 'image/AT15.png', 'Với Dior, áo thun không chỉ là món đồ cơ bản.
Đó là một phần của phong cách sống sang trọng và tự tin.
Chiếc áo có thể đơn giản, nhưng không bao giờ tầm thường.'),
('Dior016', 'Áo sơ mi Dior cổ điển', 'Áo Sơ Mi', 'Dior', 80000, 100, 'CC001', '2024-12-15', 15, 'image/ASM1.png', 'Áo sơ mi nam Dior được làm từ vải cotton Ai Cập cao cấp, mềm mại và thoáng khí.
Chất liệu cao cấp giúp áo giữ phom tốt và bền màu qua thời gian.
Từng đường may được hoàn thiện tỉ mỉ theo chuẩn haute couture.
Mức giá dao động từ 18 đến 30 triệu đồng, xứng đáng với đẳng cấp thương hiệu.'),
('Dior017', 'Áo sơ mi Dior Oblique', 'Áo Sơ Mi', 'Dior', 85000, 150, 'CC001', '2024-12-15', 10, 'image/ASM2.png', 'Sản phẩm sử dụng vải poplin 100% cotton, mỏng nhẹ nhưng bền chắc.
Cảm giác mặc rất mát và dễ chịu, thích hợp cho cả ngày dài.
Chiếc áo toát lên sự thanh lịch ngay từ chất liệu vải.
Giá thành từ 20 triệu đồng, phản ánh đúng chất lượng và thiết kế Dior.'),
('Dior018', 'Áo sơ mi Dior Classic Fit', 'Áo Sơ Mi', 'Dior', 90000, 200, 'CC001', '2024-12-15', 15, 'image/ASM3.png', 'Dior chọn loại cotton hữu cơ cao cấp, thân thiện với môi trường và lành tính với làn da.
Bề mặt vải mịn, mượt, không nhăn dễ dàng sau nhiều lần sử dụng.
Áo sơ mi được thiết kế tinh giản nhưng sang trọng và chỉn chu.
Giá từ 22 triệu trở lên, hướng đến những quý ông yêu cái đẹp bền vững.'),
('Dior019', 'Áo sơ mi Dior Slim Fit', 'Áo Sơ Mi', 'Dior', 100000, 130, 'CC001', '2024-12-15', 10, 'image/ASM4.png', 'Chất liệu vải jacquard dệt họa tiết nhẹ giúp áo có chiều sâu và cảm giác cao cấp.
Thiết kế vừa vặn, tôn lên vóc dáng nam tính.
Từng nút áo đều được chọn lựa thủ công, khẳng định sự khác biệt.
Giá bán khoảng 25–35 triệu đồng tùy phiên bản và bộ sưu tập.'),
('Dior020', 'Áo sơ mi Dior Oversize', 'Áo Sơ Mi', 'Dior', 90000, 300, 'CC001', '2024-12-15', 20, 'image/ASM5.png', 'Áo sơ mi Dior sử dụng chất liệu cotton pha lụa, tạo nên độ bóng tự nhiên và mềm mại.
Vải có độ rũ đẹp, giúp áo luôn giữ được vẻ thanh lịch.
Mỗi thiết kế là sự kết hợp hoàn hảo giữa truyền thống và hiện đại.
Giá sản phẩm khoảng 28 triệu đồng – một khoản đầu tư cho phong cách.'),
('Dior021', 'Áo sơ mi Dior lụa', 'Áo Sơ Mi', 'Dior', 75000, 250, 'CC001', '2024-12-15', 15, 'image/ASM6.png', 'Vải denim mỏng cao cấp được Dior ứng dụng vào dòng sơ mi nam đầy sáng tạo.
Chất vải bền nhưng vẫn đảm bảo độ thoải mái khi mặc.
Phù hợp với phong cách casual-chic, trẻ trung và đậm chất Pháp.
Giá áo từ 19 triệu đồng – đáng giá cho một diện mạo mới mẻ.'),
('Dior022', 'Áo sơ mi Dior cotton', 'Áo Sơ Mi', 'Dior', 110000, 200, 'CC001', '2024-12-15', 10, 'image/ASM7.png', 'Dior sử dụng vải twill dày dặn, ít nhăn và giữ phom tốt cho áo sơ mi nam.
Chất liệu giúp áo đứng form nhưng vẫn co giãn nhẹ cho sự thoải mái.
Các chi tiết như cổ áo, tay áo được may cứng cáp, sắc nét.
Giá áo khoảng 24–30 triệu đồng, phù hợp cho môi trường công sở sang trọng.'),
('Dior023', 'Áo sơ mi Dior denim', 'Áo Sơ Mi', 'Dior', 98000, 260, 'CC001', '2024-12-15', 10, 'image/ASM8.png', 'Áo sơ mi được làm từ vải viscose pha cotton, tạo cảm giác mát và nhẹ trên da.
Vải không nhăn, dễ ủi và luôn giữ được vẻ mới mẻ.
Thiết kế tối giản nhưng có chiều sâu nhờ đường may sắc sảo.
Giá dao động từ 18 đến 26 triệu đồng, tuỳ theo chất liệu và bộ sưu tập.'),
('Dior024', 'Áo sơ mi Dior Tailoring', 'Áo Sơ Mi', 'Dior', 88000, 190, 'CC001', '2024-12-15', 20, 'image/ASM9.png', 'Sản phẩm sử dụng vải linen thượng hạng, mang lại sự thoáng mát tuyệt đối cho mùa hè.
Dior xử lý vải linen đặc biệt để tránh nhăn và giữ phom lâu hơn.
Phong cách lịch sự, nhã nhặn nhưng vẫn thời thượng.
Mức giá khoảng 21–27 triệu đồng, phù hợp với phân khúc cao cấp.'),
('Dior025', 'Áo sơ mi Dior Essential', 'Áo Sơ Mi', 'Dior', 60000, 230, 'CC001', '2024-12-15', 15, 'image/ASM10.png', 'Vải Oxford được chọn lọc kỹ lưỡng cho mẫu áo sơ mi nam Dior, bề mặt vải chắc và đều màu.
Thiết kế cổ điển dễ phối với suit hoặc mặc riêng.
Logo Dior được thêu nhẹ nhàng nhưng đầy khí chất.
Giá sản phẩm từ 20 đến 29 triệu đồng.'),
('Dior026', 'Áo sơ mi Dior form rộng', 'Áo Sơ Mi', 'Dior', 59000, 190, 'CC001', '2024-12-15', 10, 'image/ASM11.png', 'Áo sơ mi Dior sử dụng vải seersucker tạo hiệu ứng gợn nhẹ độc đáo, vừa thoáng mát vừa nổi bật.
Chất liệu phù hợp với thời tiết nóng, giữ áo luôn khô thoáng.
Form dáng relaxed nhưng vẫn giữ được sự lịch lãm.
Giá bán khoảng 23–32 triệu đồng.'),
('Dior027', 'Áo sơ mi Dior chất liệu cao cấp', 'Áo Sơ Mi', 'Dior', 80000, 100, 'CC001', '2024-12-15', 15, 'image/ASM12.png', 'Vải cotton satin giúp áo sơ mi có độ bóng nhẹ, rất phù hợp với các dịp trang trọng.
Chất vải mát tay, có độ co giãn nhẹ, tạo sự linh hoạt khi di chuyển.
Dior luôn chú trọng sự tinh tế trong từng đường cắt may.
Giá áo dao động từ 25 triệu đồng trở lên.'),
('Dior028', 'Áo sơ mi Dior cổ tàu', 'Áo Sơ Mi', 'Dior', 120000, 200, 'CC001', '2024-12-15', 15, 'image/ASM13.png', 'Áo sơ mi Dior được may từ vải pique cao cấp, thường thấy ở các dòng thể thao sang trọng.
Chất liệu này giúp thoáng khí nhưng vẫn giữ dáng áo suốt cả ngày dài.
Thiết kế đơn giản, thanh lịch nhưng rất “Dior” trong từng chi tiết.
Giá thành khoảng 20–28 triệu đồng.'),
('Dior029', 'Áo sơ mi Dior dạng layering', 'Áo Sơ Mi', 'Dior', 80000, 100, 'CC001', '2024-12-15', 15, 'image/ASM14.png', 'Chất liệu tencel kết hợp với cotton cho cảm giác mặc cực kỳ mịn, mát và ít nhăn.
Áo sơ mi nhẹ tênh, lý tưởng cho những ngày dài năng động.
Đây là lựa chọn lý tưởng cho những ai yêu thích sự thoải mái nhưng vẫn sang trọng.
Giá dao động từ 18 đến 25 triệu đồng.'),
('Dior030', 'Áo sơ mi Dior Limited Edition', 'Áo Sơ Mi', 'Dior', 70000, 210, 'CC001', '2024-12-15', 10, 'image/ASM15.png', 'Dior ưu tiên chất liệu cotton Nhật Bản dệt sợi siêu mảnh, cho độ mịn và độ rơi vải tự nhiên.
Sản phẩm có độ bền cao và cảm giác sang trọng ngay từ lần chạm đầu tiên.
Từng chi tiết nhỏ như cúc áo, cổ áo đều đạt chuẩn tinh tế.
Giá sản phẩm khoảng 26–35 triệu đồng, tùy phiên bản giới hạn.'),
('Dior031', 'Quần tây Dior Tailored Straight', 'Quần Tây', 'Dior', 70000, 210, 'CC001', '2024-12-15', 10, 'image/QT1.png', 'Quần tây nam Dior được may từ vải wool Ý cao cấp, mềm nhẹ và có độ rủ đẹp. Chất liệu giữ form hoàn hảo, không nhăn và thoáng khí. Thiết kế tinh tế, tôn dáng và phù hợp cho cả công sở lẫn sự kiện trang trọng.'),
('Dior032', 'Quần tây Dior Tailored Track với tag Christian Dior Couture', 'Quần Tây', 'Dior', 76000, 230, 'CC001', '2024-12-15', 15, 'image/QT2.png', 'Chất liệu vải gabardine giúp quần tây Dior có độ bền vượt trội và bề mặt mịn màng. Đường may sắc sảo, cạp quần và ống quần được xử lý cực kỳ chuẩn form.
Phong cách tối giản nhưng tinh tế, dễ phối với áo sơ mi hoặc blazer.'),
('Dior033', 'Quần tây Dior Track Pants', 'Quần Tây', 'Dior', 80000, 290, 'CC001', '2024-12-15', 10, 'image/QT3.png', 'Dior sử dụng vải cashmere pha wool trong một số mẫu quần tây, cho cảm giác mặc êm ái và ấm áp. Chất vải co giãn nhẹ, giữ nếp tốt và không bai dão theo thời gian. Quần được thiết kế cạp cao vừa vặn, tạo vẻ nam tính và thanh lịch.'),
('Dior034', 'Quần tây Dior Cargo Pants', 'Quần Tây', 'Dior', 90000, 200, 'CC001', '2024-12-15', 20, 'image/QT4.png', 'Vải cotton pha elastane giúp quần tây Dior vừa giữ dáng vừa thoải mái khi vận động.
Chất liệu có độ đàn hồi nhẹ, phù hợp mặc cả ngày dài không gò bó.
Thiết kế ống suông hoặc slim-fit đều hiện đại và thời trang.'),
('Dior035', 'Quần tây Dior Chinos', 'Quần Tây', 'Dior', 100000, 110, 'CC001', '2024-12-15', 15, 'image/QT5.png', 'Quần tây Dior với chất vải linen dệt chéo mang lại cảm giác mát mẻ và sang trọng vào mùa hè.
Form dáng relaxed fit nhưng vẫn giữ sự thanh lịch đặc trưng.
Đường ly được ép chỉn chu tạo điểm nhấn tinh tế.'),
('Dior036', 'Quần tây Dior Flared Pants', 'Quần Tây', 'Dior', 70000, 210, 'CC001', '2024-12-15', 10, 'image/QT6.png', 'Sản phẩm sử dụng vải twill cotton dày dặn, không nhăn và có độ bóng nhẹ sang trọng.
Phom quần được cắt may chuẩn xác, giúp tôn dáng người mặc.
Kiểu dáng cổ điển dễ phối đồ, phù hợp mọi hoàn cảnh.'),
('Dior037', 'Quần tây Dior Loose Pants', 'Quần Tây', 'Dior', 79000, 250, 'CC001', '2024-12-15', 15, 'image/QT7.png', 'Dior ứng dụng vải flannel cao cấp vào dòng quần tây mùa lạnh, giữ ấm nhưng vẫn nhẹ và thoáng khí.
Chất vải mịn, không xù, kết hợp với chi tiết may thủ công tinh xảo.
Màu sắc trung tính dễ phối với áo sơ mi, sweater hay áo khoác.'),
('Dior038', 'Quần tây Dior Tailored and Cuffed Chino Pants', 'Quần Tây', 'Dior', 110000, 310, 'CC001', '2024-12-15', 15, 'image/QT8.png', 'Vải canvas pha len giúp quần tây Dior có kết cấu chắc chắn và dáng đứng sang trọng.
Thiết kế nhấn vào sự đơn giản và tôn dáng, phù hợp với phong cách menswear cổ điển.
Chất liệu mang đến sự thoải mái suốt ngày dài mà không làm mất form.'),
('Dior039', 'Quần tây Dior Tailored Chinos', 'Quần Tây', 'Dior', 70000, 130, 'CC001', '2024-12-15', 10, 'image/QT9.png', 'Quần tây Dior làm từ chất vải barathea – loại len cao cấp thường dùng trong tuxedo.
Bề mặt vải mịn, có độ bóng nhẹ và rơi dáng tuyệt đẹp.
Kiểu dáng formal đỉnh cao, lý tưởng cho sự kiện hoặc business wear.'),
('Dior040', 'Quần tây Dior Tailored Straight Pants​', 'Quần Tây', 'Dior', 98000, 240, 'CC001', '2024-12-15', 20, 'image/QT10.png', 'Dior sử dụng chất liệu viscose pha wool để tạo nên quần tây nhẹ, mát và cực kỳ bền màu.
Vải không nhăn, dễ bảo quản và giữ phom suốt cả ngày.
Thiết kế hiện đại, thanh thoát và phù hợp với mọi dáng người.'),
('Dior041', 'Quần thun Dior Oblique', 'Quần Thun', 'Dior', 98000, 240, 'CC001', '2024-12-15', 20, 'image/QThun1.png', 'Quần thun Dior được làm từ cotton pha elastane cao cấp, tạo cảm giác co giãn linh hoạt.
Chất vải dày dặn, mịn và thấm hút tốt, phù hợp cho cả ngày dài vận động.
Thiết kế ôm vừa, tôn dáng mà vẫn thoải mái.
Đây là lựa chọn lý tưởng cho phong cách năng động và tinh tế.'),
('Dior042', 'Quần thun Dior CD Icon', 'Quần Thun', 'Dior', 90000, 140, 'CC001', '2024-12-15', 10, 'image/QThun2.png', 'Sản phẩm sử dụng vải jersey Ý cao cấp, mềm mượt và ít nhăn.
Vải giữ màu tốt, không xù lông dù giặt nhiều lần.
Phom dáng trẻ trung, kết hợp dễ dàng với áo thun hay hoodie.
Quần thun Dior luôn giữ được sự chỉn chu và sang trọng.'),
('Dior043', 'Quần thun Dior Tailored Track​', 'Quần Thun', 'Dior', 100000, 290, 'CC001', '2024-12-15', 15, 'image/QThun3.png', 'Chất liệu vải dệt kim cao cấp giúp quần thun Dior co giãn 4 chiều.
Mặt vải mịn, không gây kích ứng da khi vận động nhiều.
Thiết kế đơn giản nhưng tôn lên phong cách hiện đại.
Phù hợp để mặc ở nhà, đi chơi hay tập nhẹ.'),
('Dior044', 'Quần thun Dior dáng suông​', 'Quần Thun', 'Dior', 68000, 220, 'CC001', '2024-12-15', 10, 'image/QThun4.png', 'Quần thun Dior có lớp vải double-knit giúp giữ phom và tạo cảm giác đứng dáng hơn.
Phù hợp với những ai thích sự khỏe khoắn nhưng vẫn thanh lịch.
Logo Dior được in hoặc thêu tinh tế bên hông hoặc gấu quần.
Chất vải cao cấp mang đến sự khác biệt rõ rệt khi mặc.'),
('Dior045', 'Quần thun Dior dáng ôm​', 'Quần Thun', 'Dior', 98000, 240, 'CC001', '2024-12-15', 20, 'image/QThun5.png', 'Dior sử dụng vải modal pha cotton để tạo nên độ mềm mịn tối đa cho sản phẩm.
Vải nhẹ, thoáng khí và không bị xù sau thời gian dài sử dụng.
Phom quần suông nhẹ, linh hoạt khi di chuyển.
Một chiếc quần thun cao cấp đúng chuẩn Dior: tiện dụng nhưng vẫn đẳng cấp.'),
('Dior046', 'Quần thun Dior ống rộng', 'Quần Thun', 'Dior', 88000, 190, 'CC001', '2024-12-15', 10, 'image/QThun6.png', 'Vải cotton organic kết hợp với sợi tái chế giúp quần thun Dior thân thiện với môi trường.
Chất liệu không chỉ bền đẹp mà còn thể hiện giá trị bền vững của thương hiệu.
Thiết kế hướng đến sự tối giản, dễ phối đồ.
Dù là ở phòng tập hay đi cà phê, vẫn giữ nguyên phong cách tinh tế.'),
('Dior047', 'Quần thun Dior ống côn', 'Quần Thun', 'Dior', 130000, 250, 'CC001', '2024-12-15', 15, 'image/QThun7.png', 'Quần thun Dior thường có đường cắt sắc nét, tạo form dáng chuẩn ngay cả với chất liệu mềm.
Vải cao cấp giúp áo không bị mất dáng khi giặt hoặc ngồi nhiều.
Các chi tiết như dây rút, túi khóa kéo đều được hoàn thiện cao cấp.
Phong cách thể thao nhưng mang tinh thần thời trang cao cấp.'),
('Dior048', 'Quần thun Dior phối viền', 'Quần Thun', 'Dior', 70000, 120, 'CC001', '2024-12-15', 10, 'image/QThun8.png', 'Chất liệu terry cotton giúp quần thun Dior giữ ấm nhẹ vào mùa thu đông.
Lớp vải trong mềm, không gây kích ứng cho da.
Thiết kế đơn giản, màu sắc trung tính dễ phối với nhiều kiểu áo.
Sự lựa chọn hoàn hảo cho các quý ông yêu thời trang thoải mái.'),
('Dior049', 'Quần thun Dior phong cách streetwear', 'Quần Thun', 'Dior', 80000, 240, 'CC001', '2024-12-15', 15, 'image/QThun9.png', 'Quần thun Dior sử dụng vải cotton-heavy cao cấp, bề mặt dày nhưng vẫn thoáng khí.
Rất phù hợp cho các buổi đi chơi cuối tuần hoặc dạo phố.
Logo được in nổi hoặc thêu nhẹ, tạo điểm nhấn tinh tế.
Mẫu quần lý tưởng để vừa thoải mái vừa thời thượng.'),
('Dior050', 'Quần thun Dior Essentials​', 'Quần Thun', 'Dior', 99000, 240, 'CC001', '2024-12-15', 10, 'image/QThun10.png', 'Sản phẩm sử dụng vải cotton lụa hiếm, có độ rũ nhẹ và bóng tự nhiên.
Vải thoát khí tốt, chống ẩm và nhanh khô.
Phom dáng slim-fit nhưng vẫn dễ vận động.
Một lựa chọn cao cấp cho phong cách thể thao thanh lịch.'),
('Dior051', 'Quần thun Dior Oblique jacquard​', 'Quần Thun', 'Dior', 120000, 290, 'CC001', '2024-12-15', 15, 'image/QThun11.png', 'Quần thun Dior có lớp vải dệt hai lớp, bên ngoài mịn – bên trong êm ái.
Giữ nhiệt nhẹ, rất lý tưởng cho những ngày se lạnh.
Thiết kế bo gấu giúp giữ form và tạo vẻ gọn gàng.
Món đồ không thể thiếu trong tủ đồ nam giới theo phong cách thời trang cao cấp.'),
('Dior052', 'Quần thun Dior không ly​', 'Quần Thun', 'Dior', 97000, 240, 'CC001', '2024-12-15', 10, 'image/QThun12.png', 'Vải cotton pha nylon giúp sản phẩm có độ co giãn tốt và khó bị bai dão.
Khả năng chống nhăn cao, phù hợp cho các hoạt động thường nhật.
Form dáng trẻ trung, tôn chân và không bị thô.
Một chiếc quần thun đơn giản nhưng cực kỳ "có gu".'),
('Dior053', 'Quần thun Dior chất liệu len pha​', 'Quần Thun', 'Dior', 79000, 180, 'CC001', '2024-12-15', 15, 'image/QThun13.png', 'Dior ứng dụng vải knit kỹ thuật cao cho dòng quần thun mới.
Vải mềm như len nhưng không bị xù, giữ dáng lâu dài.
Phù hợp để mặc hàng ngày hoặc kết hợp theo phong cách athleisure.
Sự kết hợp giữa tiện dụng và đẳng cấp đúng chuẩn Dior.'),
('Dior054', 'Quần thun Dior cao cấp form tailored​', 'Quần Thun', 'Dior', 91000, 240, 'CC001', '2024-12-15', 10, 'image/QThun14.png', 'Quần thun Dior làm từ vải scuba nhẹ – loại vải thường dùng cho đồ thể thao cao cấp.
Bề mặt vải mịn, chống thấm nhẹ và khó bị biến dạng.
Thiết kế hiện đại, phối màu tối giản.
Là mẫu quần vừa thời trang vừa thực tế cho người hiện đại.'),
('Dior055', 'Quần thun Dior hợp tác nghệ sĩ​', 'Quần Thun', 'Dior', 96000, 260, 'CC001', '2024-12-15', 15, 'image/QThun15.png', 'Với chất liệu cotton cashmere pha nhẹ, quần thun Dior mang lại cảm giác mềm mịn đặc biệt.
Vải cực kỳ nhẹ và thoáng, phù hợp cho mùa xuân – thu.
Thiết kế không rườm rà, nhưng tôn dáng nam giới rõ rệt.
Một món đồ đắt giá cho những ai yêu thời trang tối giản mà đẳng cấp.'),
('Gucci001', 'Áo thun Gucci logo cổ điển', 'Áo thun', 'Gucci', 80000, 200, 'CC003', '2023-12-15', 10, 'image/AT16.png', 'Áo thun Gucci được làm từ 100% cotton cao cấp nhập khẩu từ Ý.
Chất vải mềm mại, mịn tay và thoáng khí vượt trội.
Khi mặc, mang lại cảm giác nhẹ tênh và cực kỳ dễ chịu.
Sự thoải mái ấy đến từ chính sự tỉ mỉ trong từng chi tiết.'),
('Gucci002', 'Áo thun Gucci cotton jersey', 'Áo thun', 'Gucci', 90000, 120, 'CC003', '2023-12-15', 20, 'image/AT17.png', 'Gucci lựa chọn vải cotton hữu cơ dày dặn nhưng vẫn thoáng mát.
Chiếc áo giữ phom chuẩn dù mặc lâu hay giặt nhiều lần.
Trải nghiệm mặc cực kỳ "êm" và dễ chịu cho cả ngày dài.
Đây là sự kết hợp giữa chất lượng và đẳng cấp thời trang Ý.'),
('Gucci003', 'Áo thun Gucci dáng suông', 'Áo thun', 'Gucci', 98000, 230, 'CC003', '2023-12-15', 15, 'image/AT18.png', 'Áo thun Gucci sử dụng cotton jersey cao cấp, mịn màng và có độ rũ tự nhiên.
Vải co giãn nhẹ, ôm dáng mà không gò bó.
Người mặc cảm nhận được sự nhẹ nhàng, thanh thoát trên da.
Gucci không chỉ bán áo – họ bán cảm giác sang trọng ngay từ lớp vải.'),
('Gucci004', 'Áo thun Gucci dáng ôm', 'Áo thun', 'Gucci', 100000, 240, 'CC003', '2023-12-15', 10, 'image/AT19.png', 'Sản phẩm được làm từ cotton pha modal, mềm mại và thoát khí cực tốt.
Mỗi lần mặc như được "ôm nhẹ" bởi làn gió mát.
Cảm giác thoải mái kéo dài suốt cả ngày, kể cả trong thời tiết nóng bức.
Chiếc áo là minh chứng cho sự tinh tế trong từng lựa chọn chất liệu của Gucci.'),
('Gucci005', 'Áo thun Gucci cổ tròn', 'Áo thun', 'Gucci', 110000, 120, 'CC003', '2023-12-15', 20, 'image/AT20.png', 'Chất liệu cotton cashmere pha tạo nên độ mềm mịn vượt trội cho áo thun Gucci.
Vải cực kỳ nhẹ, mát và mang đến cảm giác mặc như không.
Mỗi bước di chuyển đều thoải mái, linh hoạt.
Gucci mang đến sự sang trọng không chỉ bằng thiết kế mà còn bằng cảm giác chạm vào.'),
('Gucci006', 'Áo thun Gucci cổ polo', 'Áo thun', 'Gucci', 99000, 220, 'CC003', '2023-12-15', 10, 'image/AT21.png', 'Gucci sử dụng vải interlock cotton dệt hai lớp giúp áo dày dặn nhưng không bí.
Cảm giác khi mặc luôn mát và êm ái, ngay cả trong mùa hè.
Độ bền cao giúp áo giữ nguyên dáng và màu sắc qua thời gian.
Chiếc áo là hiện thân của sự chỉn chu trong từng chi tiết.'),
('Gucci007', 'Áo thun Gucci in hình nghệ thuật', 'Áo thun', 'Gucci', 100000, 290, 'CC003', '2023-12-15', 15, 'image/AT22.png', 'Áo thun Gucci thường được làm từ cotton compact giúp bề mặt vải láng mịn, ít xù lông.
Khi mặc, người dùng sẽ cảm nhận sự “ôm vừa” dễ chịu.
Form áo được cắt may chuẩn, giúp tôn dáng tự nhiên.
Mỗi lần mặc là một lần trải nghiệm chất lượng đúng nghĩa.'),
('Gucci008', 'Áo thun Gucci họa tiết vintage', 'Áo thun', 'Gucci', 69000, 90, 'CC003', '2023-12-15', 10, 'image/AT23.png', 'Chất liệu cotton pique được Gucci xử lý đặc biệt để đạt độ thoáng khí tối ưu.
Áo thun mang đến cảm giác dễ chịu trong mọi hoạt động thường ngày.
Sự mềm mại và co giãn vừa đủ tạo cảm giác tự nhiên như làn da thứ hai.
Thiết kế đơn giản nhưng tinh tế, đúng chất Gucci.'),
('Gucci009', 'Áo thun Gucci phong cách retro', 'Áo thun', 'Gucci', 81000, 210, 'CC003', '2023-12-15', 15, 'image/AT24.png', 'Gucci ứng dụng chất liệu cotton sinh học cho các mẫu áo thun mới.
Không chỉ thân thiện với làn da mà còn tốt cho môi trường.
Trải nghiệm mặc nhẹ tênh, dễ chịu và không hề bức bí.
Đó là cảm giác sang trọng đi cùng trách nhiệm bền vững.'),
('Gucci0010', 'Áo thun Gucci limited edition', 'Áo thun', 'Gucci', 85000, 80, 'CC003', '2023-12-15', 15, 'image/AT25.png', 'Vải cotton đặc biệt của Gucci có độ bóng nhẹ, mềm mại và giữ màu lâu.
Người mặc sẽ cảm nhận sự mượt mà trong từng chuyển động.
Thiết kế áo ôm vừa, dễ phối đồ nhưng vẫn rất khác biệt.
Chất lượng vải là điều làm nên trải nghiệm đáng giá.'),
('Gucci0011', 'Áo thun Gucci collab nghệ sĩ', 'Áo thun', 'Gucci', 73000, 120, 'CC003', '2023-12-15', 10, 'image/AT26.png', 'Áo thun Gucci được làm từ vải cotton sufu (super fine), mang lại độ mềm mịn cao cấp.
Chạm vào đã thích, mặc lên lại càng yêu thích hơn.
Cảm giác như đang khoác lên mình sự tinh tế của nước Ý.
Gucci khiến những chiếc áo thun trở nên đặc biệt hơn bao giờ hết.'),
('Gucci0012', 'Áo thun Gucci phong cách thể thao', 'Áo thun', 'Gucci', 67000, 200, 'CC003', '2023-12-15', 20, 'image/AT27.png', 'Chất liệu cotton Nhật Bản nhập khẩu được Gucci sử dụng trong nhiều dòng áo thun.
Khả năng thấm hút mồ hôi tốt, thoáng khí và nhẹ nhàng.
Người mặc cảm nhận sự mát lạnh ngay khi chạm vào.
Mỗi sản phẩm là một trải nghiệm cao cấp từ chất liệu đến thiết kế.'),
('Gucci0013', 'Áo thun Gucci phong cách streetwear', 'Áo thun', 'Gucci', 93000, 300, 'CC003', '2023-12-15', 10, 'image/AT28.png', 'Gucci kết hợp cotton với sợi tái chế cao cấp để tạo nên chất vải thân thiện, nhẹ và bền.
Áo thun có độ co giãn nhẹ, thích hợp cho vận động thường ngày.
Trải nghiệm mặc mượt mà, thoải mái và thời thượng.
Một lựa chọn thời trang hiện đại, ý nghĩa và tinh tế.'),
('Gucci0014', 'Áo thun Gucci họa tiết biểu tượng', 'Áo thun', 'Gucci', 80000, 230, 'CC003', '2023-12-15', 15, 'image/AT29.png', 'Vải cotton cao cấp được xử lý chống nhăn giúp áo thun Gucci luôn giữ vẻ ngoài hoàn hảo.
Cảm giác mặc gọn gàng, không bị nhàu kể cả sau một ngày dài.
Đường may tỉ mỉ tạo sự thoải mái và độ fit hoàn hảo.
Sự chăm chút trong từng chi tiết chính là “trải nghiệm Gucci” đích thực.'),
('Gucci0015', 'Áo thun Gucci họa tiết GG', 'Áo thun', 'Gucci', 120000, 290, 'CC003', '2023-12-15', 10, 'image/AT30.png', 'Gucci sử dụng cotton pha lụa tự nhiên trong một số dòng áo thun cao cấp.
Lớp vải mềm, mát và có độ bóng nhẹ khiến người mặc nổi bật.
Trải nghiệm như khoác lên làn gió, nhẹ tênh và sành điệu.
Không chỉ là áo thun – đó là cảm giác tận hưởng đỉnh cao thời trang.'),
('Gucci016', 'Áo sơ mi Gucci cotton cổ điển', 'Áo sơ mi', 'Gucci', 80000, 200, 'CC003', '2023-12-15', 10, 'image/ASM16.png', 'Áo sơ mi nam Gucci được làm từ 100% cotton Ý cao cấp, mềm mại và thoáng khí.
Form dáng slim-fit giúp tôn lên vẻ lịch lãm, hiện đại.
Từng đường chỉ may sắc nét thể hiện sự đầu tư chỉn chu.
Một lựa chọn hoàn hảo cho phong cách quý ông sang trọng.'),
('Gucci017', 'Áo sơ mi Gucci lụa sang trọng', 'Áo sơ mi', 'Gucci', 89000, 180, 'CC003', '2023-12-15', 15, 'image/ASM17.png', 'Gucci sử dụng chất liệu lụa tự nhiên để tạo nên những chiếc sơ mi đẳng cấp.
Bề mặt vải có độ bóng nhẹ, mang lại cảm giác mượt mà khi mặc.
Thiết kế tối giản nhưng đầy tinh tế, phù hợp với mọi dịp.
Chiếc áo là biểu tượng của sự sang trọng pha chút phóng khoáng Ý.'),
('Gucci018', 'Áo sơ mi Gucci Oxford', 'Áo sơ mi', 'Gucci', 90000, 190, 'CC003', '2023-12-15', 20, 'image/ASM18.png', 'Sản phẩm được làm từ cotton hữu cơ dệt mịn, thân thiện với môi trường.
Áo mang đến cảm giác nhẹ nhàng và thoải mái trong từng chuyển động.
Logo hoặc họa tiết Gucci được thể hiện đầy tinh tế trên cổ hoặc tay áo.
Một chiếc sơ mi kết hợp giữa thời trang cao cấp và ý thức xanh.'),
('Gucci019', 'Áo sơ mi Gucci họa tiết GG', 'Áo sơ mi', 'Gucci', 100000, 150, 'CC003', '2023-12-15', 10, 'image/ASM19.png', 'Sản phẩm được làm từ cotton hữu cơ dệt mịn, thân thiện với môi trường.
Áo mang đến cảm giác nhẹ nhàng và thoải mái trong từng chuyển động.
Logo hoặc họa tiết Gucci được thể hiện đầy tinh tế trên cổ hoặc tay áo.
Một chiếc sơ mi kết hợp giữa thời trang cao cấp và ý thức xanh.'),
('Gucci020', 'Áo sơ mi Gucci có cổ button-down', 'Áo sơ mi', 'Gucci', 88000, 220, 'CC003', '2023-12-15', 10, 'image/ASM20.png', 'Áo sơ mi Gucci nổi bật với vải poplin mỏng nhẹ, mát và bền.
Thiết kế cổ áo đứng chuẩn, dễ kết hợp với vest hoặc mặc riêng.
Form áo ôm gọn giúp tôn dáng nhưng vẫn thoải mái.
Gucci mang đến sự thanh lịch vượt thời gian cho nam giới hiện đại.'),
('Gucci021', 'Áo sơ mi Gucci oversize', 'Áo sơ mi', 'Gucci', 120000, 310, 'CC003', '2023-12-15', 20, 'image/ASM21.png', 'Sản phẩm sử dụng cotton dệt sợi siêu mảnh tạo độ mịn gần như lụa.
Mặc lên cảm giác nhẹ nhàng, thoáng mát suốt cả ngày.
Thiết kế cổ điển nhưng có điểm nhấn riêng biệt của Gucci.
Chiếc áo tôn vinh vẻ đẹp đơn giản nhưng đắt giá.'),
('Gucci022', 'Áo sơ mi Gucci regular fit', 'Áo sơ mi', 'Gucci', 98000, 170, 'CC003', '2023-12-15', 15, 'image/ASM22.png', 'Gucci giới thiệu áo sơ mi nam bằng linen cao cấp – nhẹ, mát và bền.
Phù hợp với khí hậu nóng hoặc những chuyến đi nghỉ dưỡng sang trọng.
Thiết kế relaxed-fit giúp người mặc luôn cảm thấy thoải mái.
Sự kết hợp giữa tự nhiên và tinh tế đúng chất Gucci.'),
('Gucci023', 'Áo sơ mi Gucci slim fit', 'Áo sơ mi', 'Gucci', 87000, 150, 'CC003', '2023-12-15', 15, 'image/ASM23.png', 'Áo sơ mi được may từ vải Oxford dày dặn, giữ form tốt và không nhăn nhiều.
Thiết kế hướng đến sự chỉn chu cho môi trường công sở cao cấp.
Chi tiết khuy áo và cổ áo được xử lý tỉ mỉ.
Một mẫu áo phù hợp cho người đàn ông hiện đại và thành đạt.'),
('Gucci024', 'Áo sơ mi Gucci họa tiết in toàn thân', 'Áo sơ mi', 'Gucci', 99000, 180, 'CC003', '2023-12-15', 10, 'image/ASM24.png', 'Gucci tạo dấu ấn với sơ mi họa tiết đặc trưng, in sắc nét trên nền vải lụa.
Mỗi chiếc áo là một tác phẩm nghệ thuật thời trang cao cấp.
Vải mềm mịn, rũ nhẹ, tạo sự thoải mái tối đa.
Phù hợp với những ai yêu thích sự khác biệt và nổi bật.'),
('Gucci025', 'Áo sơ mi Gucci phong cách retro', 'Áo sơ mi', 'Gucci', 70000, 210, 'CC003', '2023-12-15', 10, 'image/ASM25.png', 'Áo sơ mi Gucci dáng suông nhẹ, làm từ cotton Nhật nhập khẩu.
Vải giữ màu tốt, không bị co rút sau khi giặt.
Phong cách trẻ trung, dễ phối cùng jeans hoặc quần tây.
Gucci mang lại sự linh hoạt nhưng vẫn giữ vẻ sang trọng cần có.'),
('Gucci026', 'Áo sơ mi Gucci hợp tác nghệ sĩ', 'Áo sơ mi', 'Gucci', 79000, 145, 'CC003', '2023-12-15', 20, 'image/ASM26.png', 'Chất liệu vải viscose pha cotton cho cảm giác mịn mát và dễ chịu.
Form áo gọn gàng, chuẩn phom châu Âu.
Gucci chú trọng đến trải nghiệm người mặc trong từng chi tiết nhỏ.
Chiếc áo phù hợp cho cả ngày làm việc lẫn buổi tiệc tối.'),
('Gucci027', 'Áo sơ mi Gucci in logo vintage', 'Áo sơ mi', 'Gucci', 63000, 200, 'CC003', '2023-12-15', 20, 'image/ASM27.png', 'Gucci kết hợp thiết kế cổ điển với họa tiết monogram độc quyền.
Chất liệu vải cao cấp giúp áo luôn giữ phom và ít nhăn.
Cảm giác mặc thoải mái nhưng vẫn giữ được phong cách sang trọng.
Một lựa chọn lý tưởng cho những ai yêu Gucci và sự khác biệt.'),
('Gucci028', 'Áo sơ mi Gucci formal', 'Áo sơ mi', 'Gucci', 92000, 170, 'CC003', '2023-12-15', 10, 'image/ASM28.png', 'Áo sơ mi nam Gucci thường được cắt may theo dáng tailored-fit.
Giúp người mặc trở nên gọn gàng và nam tính hơn.
Chất liệu cao cấp giúp áo không xù, không bai dão theo thời gian.
Gucci tôn vinh phong cách phái mạnh qua từng đường kim mũi chỉ.'),
('Gucci029', 'Áo sơ mi Gucci casual', 'Áo sơ mi', 'Gucci', 93000, 190, 'CC003', '2023-12-15', 15, 'image/ASM29.png', 'Gucci sử dụng vải jacquard dệt họa tiết nổi tinh tế cho dòng sơ mi cao cấp.
Áo có chiều sâu thị giác nhưng vẫn giữ sự lịch lãm cần thiết.
Phối hợp dễ dàng với các phụ kiện như cà vạt, blazer.
Chiếc áo là tuyên ngôn thời trang dành cho nam giới yêu phong cách độc bản.'),
('Gucci030', 'Áo sơ mi Gucci ', 'Áo sơ mi', 'Gucci', 81000, 220, 'CC003', '2023-12-15', 10, 'image/ASM30.png', 'Sản phẩm được hoàn thiện bằng vải twill nhẹ, giúp áo rũ đẹp và khó nhăn.
Tay áo và cổ áo được may cứng form, tạo sự chỉn chu.
Cảm giác mặc rất “đã” – nhẹ, mát và ôm cơ thể vừa vặn.
Gucci đem đến sự tinh tế không phô trương, nhưng đầy sức hút.'),
('Gucci031', 'Quần tây Gucci dáng suông cổ điển', 'Quần tây', 'Gucci', 80000, 220, 'CC003', '2023-12-15', 10, 'image/QT11.png', 'Quần tây Gucci được may từ chất liệu wool Ý cao cấp, mềm mịn và đứng dáng.
Form slim-fit ôm nhẹ, tôn lên vóc dáng thanh lịch của người mặc.
Đường may chuẩn xác, tinh tế đến từng chi tiết nhỏ.
Một lựa chọn hoàn hảo cho những quý ông yêu phong cách cổ điển pha hiện đại.'),
('Gucci032', 'Quần tây Gucci slim fit', 'Quần tây', 'Gucci', 89000, 270, 'CC003', '2023-12-15', 10, 'image/QT12.png', 'Gucci sử dụng vải cotton pha elastane giúp quần có độ co giãn nhẹ.
Cảm giác khi mặc cực kỳ thoải mái, dễ vận động mà vẫn sang trọng.
Thiết kế trẻ trung, phù hợp cả đi làm lẫn dạo phố.
Quần tây Gucci luôn tạo nên sự khác biệt qua chất vải và phom dáng.'),
('Gucci033', 'Quần tây Gucci regular fit', 'Quần tây', 'Gucci', 88000, 290, 'CC003', '2023-12-15', 20, 'image/QT13.png', 'Chất liệu vải gabardine được Gucci xử lý kỹ lưỡng, mang lại độ mượt và bền đẹp.
Quần có độ rũ nhẹ, giữ nếp thẳng ngay cả sau nhiều lần giặt.
Cảm giác khi mặc vừa mát mẻ, vừa sang trọng.
Gucci kết hợp thời trang cao cấp với sự tiện dụng thực tế.'),
('Gucci034', 'Quần tây Gucci regular fit', 'Quần tây', 'Gucci', 90000, 230, 'CC003', '2023-12-15', 20, 'image/QT14.png', 'Quần tây Gucci dáng straight-fit phù hợp với nhiều dáng người.
Chất liệu vải wool blend cao cấp mang đến vẻ ngoài thanh lịch và chỉn chu.
Khuy, khóa và đường viền đều được hoàn thiện với độ chính xác cao.
Một thiết kế tinh gọn nhưng vẫn toát lên phong cách Ý đặc trưng.'),
('Gucci035', 'Quần tây Gucci ống đứng', 'Quần tây', 'Gucci', 100000, 190, 'CC003', '2023-12-15', 15, 'image/QT15.png', 'Sản phẩm nổi bật với vải linen cao cấp, thoáng mát và nhẹ nhàng.
Phù hợp với thời tiết mùa hè và những buổi gặp gỡ thư giãn.
Thiết kế tinh giản, mang tinh thần thời trang cao cấp không gò bó.
Gucci đem lại sự lịch lãm tự nhiên mà không cần cầu kỳ.'),
('Gucci036', 'Quần tây Gucci xếp ly', 'Quần tây', 'Gucci', 84000, 200, 'CC003', '2023-12-15', 15, 'image/QT16.png', 'Gucci cho ra mắt dòng quần tây sử dụng vải cotton hữu cơ, thân thiện môi trường.
Vải mềm, ít nhăn và tạo cảm giác dễ chịu khi mặc cả ngày dài.
Dáng quần gọn, dễ phối cùng áo sơ mi hay blazer.
Một lựa chọn sang trọng đi kèm giá trị bền vững.'),
('Gucci037', 'Quần tây Gucci chất liệu len', 'Quần tây', 'Gucci', 92000, 200, 'CC003', '2023-12-15', 10, 'image/QT17.png', 'Quần tây Gucci mang dấu ấn riêng qua các chi tiết monogram thêu tinh tế.
Vải được dệt chặt, giúp giữ phom dáng chuẩn suốt thời gian sử dụng.
Thiết kế hiện đại, thích hợp cho môi trường làm việc chuyên nghiệp.
Đây không chỉ là quần tây, mà là một phần của phong cách sống Gucci.'),
('Gucci038', 'Quần tây Gucci cotton cao cấp', 'Quần tây', 'Gucci', 78000, 290, 'CC003', '2023-12-15', 10, 'image/QT18.png', 'Sản phẩm được cắt may theo kỹ thuật tailoring cao cấp từ Ý.
Chất liệu wool cashmere giúp vải mịn, nhẹ và cực kỳ thoải mái.
Phom quần ôm nhẹ, tôn lên vẻ sang trọng mà không bị gò bó.
Gucci tôn vinh vẻ đẹp nam tính qua từng chi tiết chuẩn mực.'),
('Gucci039', 'Quần tây Gucci phong cách vintage', 'Quần tây', 'Gucci', 98000, 130, 'CC003', '2023-12-15', 15, 'image/QT19.png', 'Gucci thiết kế quần tây dáng relaxed-fit mang đến sự thoải mái tối đa.
Chất vải nhẹ, thoáng, phù hợp với phong cách phóng khoáng nhưng vẫn thanh lịch.
Đường ly sắc nét giúp giữ dáng cho cả ngày dài.
Là sự kết hợp giữa cổ điển và hiện đại đầy tinh tế.'),
('Gucci040', 'Quần tây Gucci formal', 'Quần tây', 'Gucci', 99000, 180, 'CC003', '2023-12-15', 15, 'image/QT20.png', 'Quần tây Gucci không chỉ đẹp ở bề ngoài mà còn ở cảm giác khi mặc.
Chất liệu vải được chọn lọc kỹ càng, mang đến sự mềm mại và thoáng khí.
Thiết kế tối giản nhưng vẫn đầy cuốn hút với từng chi tiết nhỏ.
Một biểu tượng thời trang cho những người đàn ông yêu sự khác biệt.'),
('Gucci041', 'Quần thun Gucci dáng ôm', 'Quần thun', 'Gucci', 99000, 180, 'CC003', '2023-12-15', 15, 'image/QThun16.png', 'Quần thun nam Gucci được làm từ chất liệu cotton pha elastane, mang lại sự thoải mái và độ co giãn tuyệt vời.
Dáng quần ôm nhẹ, tạo sự linh hoạt trong mọi chuyển động.
Chất vải mềm mại, mịn màng và dễ chịu trên da, không gây bí bách.
Sự kết hợp giữa thiết kế thời thượng và tiện dụng làm cho chiếc quần trở thành lựa chọn lý tưởng.'),
('Gucci042', 'Quần thun Gucci dáng suông', 'Quần thun', 'Gucci', 98000, 280, 'CC003', '2023-12-15', 15, 'image/QThun17.png', 'Gucci sử dụng vải jersey cao cấp cho quần thun, nhẹ nhàng và thoáng khí.
Form quần phù hợp với mọi dáng người, ôm vừa vặn mà không quá chật.
Chất liệu thấm hút mồ hôi tốt, giữ người mặc luôn khô ráo và dễ chịu.
Quần thun Gucci là sự hòa quyện hoàn hảo giữa phong cách và sự thoải mái.'),
('Gucci043', 'Quần thun Gucci ống côn', 'Quần thun', 'Gucci', 88000, 170, 'CC003', '2023-12-15', 20, 'image/QThun18.png', 'Quần thun Gucci mang đến cảm giác dễ chịu suốt cả ngày dài nhờ chất liệu cotton mịn.
Dáng quần thẳng, dễ phối với nhiều loại áo khác nhau từ áo thun đến sơ mi.
Chất vải dẻo dai, không nhăn và rất dễ chăm sóc.
Gucci mang đến cho người mặc một sản phẩm không chỉ đẹp mà còn thực sự tiện dụng.'),
('Gucci044', 'Quần thun Gucci ống rộng', 'Quần thun', 'Gucci', 90000, 190, 'CC003', '2023-12-15', 20, 'image/QThun19.png', 'Với chất liệu cotton pha polyester, quần thun Gucci bền bỉ và ít bị co rút khi giặt.
Thiết kế đơn giản nhưng vẫn thể hiện được sự tinh tế trong từng chi tiết.
Chất vải mềm mại, giúp người mặc cảm thấy thoải mái và tự tin.
Quần thun Gucci là một phần không thể thiếu trong tủ đồ của những người yêu thích sự sang trọng.'),
('Gucci045', 'Quần thun Gucci cotton cao cấp', 'Quần thun', 'Gucci', 100000, 200, 'CC003', '2023-12-15', 10, 'image/QThun20.png', 'Quần thun Gucci sử dụng vải thun có khả năng co giãn tốt, mang lại sự thoải mái tối đa.
Dáng quần slim-fit ôm nhẹ, tạo sự gọn gàng và thời thượng.
Chất liệu mềm mịn, không gây khó chịu cho làn da ngay cả khi mặc lâu.
Sản phẩm là sự kết hợp hoàn hảo giữa phong cách và chất lượng vượt trội.'),
('Gucci046', 'Quần thun Gucci thể thao', 'Quần thun', 'Gucci', 99000, 220, 'CC003', '2023-12-15', 10, 'image/QThun21.png', 'Gucci sử dụng chất liệu cotton pha sợi polyamide, mang đến sự bền bỉ và thoải mái cho người mặc.
Quần thun có đường may sắc nét, vừa vặn nhưng không gò bó.
Chất liệu mát mẻ, lý tưởng cho các hoạt động thể thao hoặc dạo phố.
Gucci luôn chú trọng đến cả chất lượng và cảm giác của người mặc.'),
('Gucci047', 'Quần thun Gucci casual', 'Quần thun', 'Gucci', 90000, 230, 'CC003', '2023-12-15', 15, 'image/QThun22.png', 'Quần thun Gucci được làm từ chất liệu vải cotton cao cấp, mềm mại và không gây kích ứng da.
Dáng quần ôm vừa, không quá bó nhưng vẫn tôn dáng người mặc.
Chất liệu vải giữ form tốt, không bị nhăn hoặc xù lông sau nhiều lần giặt.
Sản phẩm này là sự lựa chọn lý tưởng cho những ai yêu thích sự kết hợp giữa thời trang và tiện lợi.'),
('Gucci048', 'Quần thun Gucci có viền sọc', 'Quần thun', 'Gucci', 87000, 190, 'CC003', '2023-12-15', 15, 'image/QThun23.png', 'Gucci mang đến sự thoải mái tối đa với quần thun làm từ vải cotton pha elastane.
Quần có thiết kế đơn giản nhưng tinh tế, dễ dàng phối đồ với các trang phục khác.
Chất liệu vải nhẹ nhàng và thoáng khí, tạo cảm giác dễ chịu khi mặc.
Quần thun Gucci là sự lựa chọn không thể thiếu trong tủ đồ của những người yêu thích sự thời thượng.'),
('Gucci049', 'Quần thun Gucci họa tiết in', 'Quần thun', 'Gucci', 89000, 280, 'CC003', '2023-12-15', 20, 'image/QThun24.png', 'Với chất liệu thun mịn và nhẹ, quần thun Gucci đem lại cảm giác thoải mái suốt cả ngày dài.
Chất vải dẻo dai, giúp quần giữ được hình dáng chuẩn mà không bị biến dạng.
Sản phẩm được thiết kế vừa vặn, dễ dàng phối hợp với nhiều loại áo khác nhau.
Gucci luôn mang đến những sản phẩm hoàn hảo về cả chất lượng và thẩm mỹ.'),
('Gucci050', 'Quần thun Gucci phong cách retro', 'Quần thun', 'Gucci', 91000, 190, 'CC003', '2023-12-15', 20, 'image/QThun25.png', 'Quần thun nam Gucci được làm từ chất liệu cotton pha polyamide, vừa mềm mại vừa bền chắc.
Dáng quần đơn giản, phù hợp với nhiều phong cách từ công sở đến dạo phố.
Chất liệu thoáng khí giúp người mặc cảm thấy thoải mái, không bị nóng bức.
Gucci không chỉ chú trọng vào thiết kế mà còn rất tinh tế trong việc lựa chọn chất liệu.'),
('Gucci051', 'Quần thun Gucci cổ điển', 'Quần thun', 'Gucci', 99000, 180, 'CC003', '2023-12-15', 15, 'image/QThun26.png', 'Gucci sử dụng vải thun cao cấp, co giãn nhẹ, tạo cảm giác dễ chịu khi vận động.
Form quần vừa vặn, không quá rộng cũng không quá chật, giúp người mặc tự do di chuyển.
Chất liệu mềm mại, dễ dàng bảo quản và giữ phom dáng lâu dài.
Quần thun Gucci là một sự lựa chọn lý tưởng cho phong cách thể thao năng động.'),
('Gucci052', 'Quần thun Gucci phong cách streetwear', 'Quần thun', 'Gucci', 99000, 180, 'CC003', '2023-12-15', 15, 'image/QThun27.png', 'Chất liệu cotton pha spandex giúp quần thun Gucci có độ co giãn tuyệt vời.
Dáng quần ôm nhẹ vừa vặn, tạo sự thoải mái khi di chuyển mà không gây khó chịu.
Vải thun mềm mại, không bám mồ hôi, luôn giữ người mặc khô ráo và mát mẻ.
Gucci mang đến sự kết hợp hoàn hảo giữa tiện nghi và phong cách thời trang cao cấp.'),
('Gucci053', 'Quần thun Gucci phối viền', 'Quần thun', 'Gucci', 110000, 170, 'CC003', '2023-12-15', 10, 'image/QThun28.png', 'Gucci mang đến cho bạn sự thoải mái tối đa với quần thun làm từ chất liệu cotton pha polyester.
Quần có thiết kế thể thao năng động, dễ dàng kết hợp với áo thun hay hoodie.
Chất vải nhẹ nhàng, không nhăn, luôn giữ dáng quần đẹp và gọn gàng.
Một sản phẩm lý tưởng cho những ai yêu thích sự thoải mái và phong cách đương đại.'),
('Gucci054', 'Quần thun Gucci có túi hộp', 'Quần thun', 'Gucci', 10000, 170, 'CC003', '2023-12-15', 10, 'image/QThun29.png', 'Quần thun Gucci có chất liệu vải cotton nhẹ, giúp người mặc luôn cảm thấy thoải mái, dễ chịu.
Dáng quần hiện đại, kết hợp với thiết kế tối giản, dễ dàng phối hợp với các trang phục khác.
Chất liệu vải thoáng khí, phù hợp với nhiều hoạt động hàng ngày.
Gucci luôn mang đến những sản phẩm hoàn hảo, nâng tầm phong cách sống thời thượng.'),
('Gucci055', 'Quần thun Gucci hợp tác nghệ sĩ', 'Quần thun', 'Gucci', 99000, 180, 'CC003', '2023-12-15', 10, 'image/QThun30.png', 'Quần thun Gucci được làm từ vải cotton pha polyamide, giúp quần bền bỉ và dễ bảo quản.
Form quần ôm nhẹ, tạo sự thoải mái mà không gò bó.
Chất vải mềm mại và thoáng khí, giữ cho người mặc luôn mát mẻ trong suốt cả ngày.
Quần thun Gucci không chỉ là một món đồ thời trang, mà còn là sự kết hợp giữa tiện ích và phong cách sang trọng.');






-- --------------------------------------------------------

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
