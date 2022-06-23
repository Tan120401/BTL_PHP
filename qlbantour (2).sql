-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost
-- Thời gian đã tạo: Th6 16, 2022 lúc 06:29 AM
-- Phiên bản máy phục vụ: 8.0.17
-- Phiên bản PHP: 7.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `qlbantour`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `anh`
--

CREATE TABLE `anh` (
  `MaAnh` int(11) NOT NULL,
  `Link` char(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `MaDiaDiem` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `anh`
--

INSERT INTO `anh` (`MaAnh`, `Link`, `MaDiaDiem`) VALUES
(1, '../assets/img/place/Coto.jpg', 4),
(2, '../assets/img/place/hoian2.jpg', 7),
(3, '../assets/img/place/Phuquoc4.jpg', 13),
(4, '../assets/img/place/ban-cat-cat-sapa1.jpg', 14),
(5, '../assets/img/place/thac-ban-gioc-cao-bang.jpg', 17),
(6, '../assets/img/place/halong.jpg', 9),
(7, '../assets/img/place/quang-truong-lam-vien-da-lat.jpg', 5),
(8, '../assets/img/place/Dong_van_HaGiang_2.jpg', 8),
(9, '../assets/img/place/suoi_tien_HCM.jpg', 15),
(10, '../assets/img/place/daongoc.jpg', 6),
(11, '../assets/img/place/honson_kiengiang.jpg', 10),
(12, '../assets/img/place/cua-lo.jpg', 3),
(13, '../assets/img/place/ban-cat-cat_sapa.jpg', 14),
(14, '../assets/img/place/hoian.jpg', 7),
(15, '../assets/img/place/Phuquoc2.jpg', 13),
(16, 'https://busvietnam.net/wp-content/uploads/2019/05/nha-trang-1.jpg', 1),
(17, 'http://dulichvietnam.com.vn/data/du-lich-hawaii-1.jpg', 1),
(18, 'https://i.ytimg.com/vi/5Ok7-XHPGdA/maxresdefault.jpg', 1),
(19, 'https://images.fineartamerica.com/images/artworkimages/mediumlarge/1/kealani-sunset-a-colorful-sunset-in-wailea-maui-hawaii-nature-photographer.jpg', 1),
(20, 'https://danviet.mediacdn.vn/296231569849192448/2021/11/6/tamdao2-16362177639341700738538.jpg', 16),
(21, 'https://danviet.mediacdn.vn/296231569849192448/2021/11/6/tamdao10-16362177607271798884736.jpg', 16),
(22, 'https://images.unsplash.com/photo-1528127269322-539801943592?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG9', 9),
(25, '../assets/img/place/cho-noi-cai-rang.jpg', 18),
(26, '../assets/img/place/con-son-kiep-bac.jpg', 11),
(28, '../assets/img/place/cua-lo.jpg', 12),
(29, '../assets/img/place/du-lich-Ben-Tre1.jpg', 19);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ct_tour`
--

CREATE TABLE `ct_tour` (
  `MaThanhVien` int(11) NOT NULL,
  `MaTour` int(11) NOT NULL,
  `SoNguoi` int(11) DEFAULT NULL,
  `ThanhTien` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `ct_tour`
--

INSERT INTO `ct_tour` (`MaThanhVien`, `MaTour`, `SoNguoi`, `ThanhTien`) VALUES
(1, 4, 1, 2000000),
(2, 2, 3, 1800000),
(2, 19, 1, 2000000),
(3, 1, 3, 10800000),
(22, 1, 1, 2000000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `diadiem`
--

CREATE TABLE `diadiem` (
  `MaDiaDiem` int(11) NOT NULL,
  `TenDiaDiem` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `DiaChi` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `GioiThieu` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `DonGia` double NOT NULL,
  `SLTruyCap` int(11) DEFAULT NULL,
  `TenKhachSan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `DiaChiKhachSan` varchar(300) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `MaTinh` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `diadiem`
--

INSERT INTO `diadiem` (`MaDiaDiem`, `TenDiaDiem`, `DiaChi`, `GioiThieu`, `DonGia`, `SLTruyCap`, `TenKhachSan`, `DiaChiKhachSan`, `MaTinh`) VALUES
(1, 'Nha Trang', 'Khánh Hòa', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem ', 1500000, 200, 'Hải Hà', '136adress', 'KH'),
(3, 'Cửa Lò', 'Nghe An', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomi', 2000000, 100, 'Mường Thanh', '139wwww', 'NA'),
(4, 'Cô Tô', 'coto', 'If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. ', 2000000, 200, 'Mường Thanh', '136adress', 'QNinh'),
(5, 'Đà Lạt', 'dalat', 'All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet.', 2000000, 400, 'Mường Thanh', '122adress', 'LD'),
(6, 'Đảo Ngọc', 'daongoc', 'It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable', 2000000, 200, 'Mường Thanh', '126adress', 'BR'),
(7, 'Hội An', 'hoian', 'The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.', 2000000, 200, 'Mường Thanh', '111adress', 'QN'),
(8, 'Hà Giang', 'Ha Giang', 'Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur', 3000000, 60, 'HaGiang Hotel', 'Đồng Văn, Hà Giang', 'HG'),
(9, 'Hạ Long', 'halong', 'Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem ', 1500000, 300, 'Hải Hà', '125adress', 'QNinh'),
(10, 'Hòn Sơn', 'honson', 'No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encou', 1500000, 100, 'Hải Hà', '136adresss', 'TG'),
(11, 'Côn Sơn - Kiếp Bạc', 'Hai Duong', 'The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from \"de Finibus Bonorum', 4000000, 100, 'KiepBac Hotel', 'Hai Duong', 'HD'),
(12, 'Cửa Lò', 'Cua Lo, Nghe An', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 20', 5000000, 500, 'CuaLo Hotel', 'Cua Lo, Nghe An', 'NA'),
(13, 'Phú Quốc', 'Kiên Giang', 'Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur i', 3000000, 150, 'Hải Hà', '128adress', 'KG'),
(14, 'Sa Pa', 'Sa Pa - Lao Cai', 'To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to ', 1000000, 100, 'Mường Thanh', '139www', 'LC'),
(15, 'Suối Tiên', 'suoitien', 'On the other hand, we denounce with righteous indignation and dislike men who are so beguiled and demoralized by the charms of pleasure of the moment,', 1000000, 100, 'Mường Thanh', '130adress', 'SG'),
(16, 'Tam Đảo', 'Tam Dao, Tam Dao, Vinh Phuc', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomi', 200000, 200, 'TamDao Hotel', 'Tam Dao, Vinh Phuc', 'VP'),
(17, 'Trung Khánh', 'trungkhanh', 'These cases are perfectly simple and easy to distinguish. In a free hour, when our power of choice is untrammelled and when nothing prevents our being', 2000000, 100, 'Hải Hà', '109address', 'CB'),
(18, 'Chợ nổi Cái Răng', 'Cần Thơ', 'Chợ nổi Cái Răng là chợ nổi đầu mối chuyên mua bán rau củ ở trên sông Cửu Long và là điểm tham quan đặc sắc của quận Cái Răng, thành phố Cần Thơ.', 4000000, 150, 'Can Tho Hotel', 'Cần Thơ', 'CT'),
(19, 'Bến Tre', 'bentre', 'bến tre miền tây sông nước', 2000000, 100, 'mường thanh plaza', '132-bt', 'BT');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `mien`
--

CREATE TABLE `mien` (
  `MaMien` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `TenMien` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `MoTa` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `mien`
--

INSERT INTO `mien` (`MaMien`, `TenMien`, `MoTa`) VALUES
('MB', 'Miền Bắc', 'Miền Bắc Việt Nam được thiên nhiên ưu ái ban tặng vô vàn cảnh vật đẹp và hấp dẫn. Địa điểm du lịch miền Bắc 1 ngày nào hấp dẫn du khách nhất? Tất cả sẽ được bật mí ngay trong hình ảnh dưới đây!'),
('MN', 'Miền Nam', 'Du lịch miền Nam có gì hấp dẫn không? Nếu bạn chưa biết thì nên cập nhật bản đồ du lịch miền Nam cực kỳ chi tiết cùng gợi ý một số tour du lịch miền Nam ngay nhé!'),
('MT', 'Miền Trung', 'Du lịch miền Trung có gì hấp dẫn? Những điểm đến vui chơi, check-in nào nổi tiếng nhất? Tham khảo bài viết này để có kinh nghiệm và lên kế hoạch lịch trình thích hợp nhất cho bản thân.'),
('MTay', 'Miền Tây', 'Do đều bắt nguồn từ sông mẹ Mê Kông nên các tỉnh miền Tây đều có cảnh quan thiên nhiên tươi đẹp và tạo nên một bản sắc văn minh sông nước đậm nét. Những địa điểm du lịch miền Tây Nam Bộ thường gắn liền với thiên nhiên, miệt vườn, kênh rạch… và đặc biệt là bạn có thể khám phá miền Tây bằng hình thức di chuyển bằng thuyền, bè cực độc đáo.');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thanhvien`
--

CREATE TABLE `thanhvien` (
  `MaThanhVien` int(11) NOT NULL,
  `TenThanhVien` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `DiaChi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `Email` char(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `SDT` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `Avatar` char(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `username` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `pass` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `role` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `thanhvien`
--

INSERT INTO `thanhvien` (`MaThanhVien`, `TenThanhVien`, `DiaChi`, `Email`, `SDT`, `Avatar`, `username`, `pass`, `role`) VALUES
(1, 'admin', 'admin', 'admin@gmail.com', '123456789', '', 'admin', 'admin', '0'),
(2, 'Nguyễn Văn Tân', 'Vinh, Nghệ An, Việt Nam', 'nguyenvantan@gmail.com', '0123456789', '../assets/img/user-avatars/windows-11-3840x2160-microsoft-4k-23467.jpg', 'tan123', 'tan23AB@', '1'),
(3, 'Nguyễn Văn Mạnh', 'Vĩnh Phúc', 'nguyenvannam2000forreal@gmail.com', '0123456789', '../assets/img/user-avatars/6.jpg', 'manh234', 'manh4REAL@456', '1'),
(4, 'Lê Hồng Phú\r\n', 'Hải Dương', 'phuhd2k1@gmail.com', '398988688', '', 'phu111', '345678', '0'),
(5, 'Trần Văn Lanh', 'Nghệ An', 'vanlanh290@gmail.com', '346758888', '', 'lanhdan123', '123456', '1'),
(6, 'Nguyễn Văn Mạnh', 'Vĩnh Phúc', 'vandung061@gmail.com', '398988666', '', 'dungw06', '234567', '1'),
(7, 'Phan Quốc Khánh', 'Nghệ An', 'quockhanh11@gmail.com', '386329889', '', 'khanh281', '123456', '1'),
(22, 'gang', 'gang bang', 'gang@g.co', '0123456789', '../assets/img/user-avatars/Creepy Halloween Skull Decoration.jpg', 'gang4L', 'gangGANG4$', '1');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tinh`
--

CREATE TABLE `tinh` (
  `MaTinh` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `TenTinh` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `MaMien` char(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `tinh`
--

INSERT INTO `tinh` (`MaTinh`, `TenTinh`, `MaMien`) VALUES
('BR', 'Bà Rịa Vũng Tàu', 'MN'),
('BT', 'Bến Tre', 'MN'),
('CB', 'Cao Bằng', 'MB'),
('CT', 'Cần Thơ', 'MN'),
('HD', 'Hải Dương', 'MB'),
('HG', 'Hà Giang', 'MB'),
('KG', 'Kiên Giang', 'MTay'),
('KH', 'Khánh Hòa', 'MT'),
('LC', 'Lào Cai', 'MB'),
('LD', 'Lâm Đồng', 'MT'),
('NA', 'Nghệ An', 'MT'),
('QN', 'Quảng Nam', 'MT'),
('QNinh', 'Quang Ninh', 'MB'),
('SG', 'Sài Gòn', 'MN'),
('TG', 'Tiền Giang', 'MN'),
('VP', 'Vĩnh Phúc', 'MB');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tintuc`
--

CREATE TABLE `tintuc` (
  `MaTinTuc` int(11) NOT NULL,
  `MaDiaDiem` int(11) NOT NULL,
  `TieuDe` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `ChiTiet` varchar(3000) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `NgayDang` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `tintuc`
--

INSERT INTO `tintuc` (`MaTinTuc`, `MaDiaDiem`, `TieuDe`, `ChiTiet`, `NgayDang`) VALUES
(1, 9, 'It has survived not only five ', 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of \"de Finibus Bonorum et Malorum\" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.', '2022-05-18 09:00:00'),
(2, 16, 'There are many variations of p', 'If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.', '2022-05-18 06:00:00'),
(3, 4, 'The standard chunk of Lorem Ip', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).', '2022-05-05 13:00:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tour`
--

CREATE TABLE `tour` (
  `MaTour` int(11) NOT NULL,
  `MaDiaDiem` int(11) NOT NULL,
  `TenTour` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `MoTa` varchar(3000) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `SoNgay` int(11) NOT NULL,
  `NgayKhoiHanh` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `tour`
--

INSERT INTO `tour` (`MaTour`, `MaDiaDiem`, `TenTour`, `MoTa`, `SoNgay`, `NgayKhoiHanh`) VALUES
(1, 6, ' Dao Ngoc Tour', 'Day la Dao Ngoc Tour. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.', 3, '2022-06-19'),
(2, 16, 'Tam Dao Tour', 'Day la Tam Dao TOUR 2. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. ', 4, '2022-07-20'),
(3, 13, 'Phu Quoc Tour', 'I must explain to you how all this mistaken idea of denouncing pleasure and praising pain was born and I will give you a complete account of the system, and expound the actual teachings of the great explorer of the truth, the master-builder of human happiness. No one rejects, dislikes, or avoids pleasure itself, because it is pleasure, but because those who do not know how to pursue pleasure rationally encounter consequences that are extremely painful. Nor again is there anyone who loves or pursues or desires to obtain pain of itself, because it is pain, but because occasionally circumstances occur in which toil and pain can procure him some great pleasure. ', 5, '2022-06-24'),
(4, 17, 'Cao Bang Tour', 'It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.\r\n\r\nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae. Itaque earum rerum hic tenetur a sapiente delectus, ut aut reiciendis voluptatibus maiores alias consequatur aut perferendis doloribus asperiores repellat.\"', 5, '2022-08-10'),
(5, 8, 'Ha Giang Tour', 'This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, \"Lorem ipsum dolor sit amet..\", comes from a line in section 1.10.32.', 2, '2022-06-22'),
(6, 3, 'Cua Lo Tour', 'Nơi có bãi biển xanh trải dài cùng những bờ cát trắng khiến mọi người ấn tượng vô cùng.At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui officia deserunt mollitia animi, id est laborum et dolorum fuga. Et harum quidem rerum facilis est et expedita distinctio. ', 2, '2022-06-20'),
(7, 7, 'Old-Town Hoi An', 'Day la Hoi An Tour. To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?\"', 7, '2022-06-21'),
(8, 11, 'Con Son - Kiep Bac', 'To take a trivial example, which of us ever undertakes laborious physical exercise, except to obtain some advantage from it? But who has any right to find fault with a man who chooses to enjoy a pleasure that has no annoying consequences, or one who avoids a pain that produces no resultant pleasure?\"', 2, '2022-06-20'),
(19, 17, 'Trung Khánh Tour', '', 4, '2022-08-23'),
(49, 18, 'Can Tho Tour', 'Cần Thơ lại có vẻ đẹp bình dị nên thơ của làng quê sông nước, dân cư tập trung đông đúc, làng xóm trù phú núp dưới bóng dừa', 4, '2022-06-09'),
(51, 13, 'Kien Giang Tour', 'Nói đến Kiên Giang, điểm nhấn rõ nét nhất trong lòng du khách bốn phương là một vùng đất biển với cảnh quan biển đảo tươi đẹp, những cánh rừng xanh thẳm hoang sơ', 3, '2022-06-17'),
(54, 15, 'Suoi Tien Tour', 'Khu Du lịch Văn hóa Suối Tiên là một khu liên hợp vui chơi giải trí tại Quận 9, Thành phố Hồ Chí Minh', 3, '2022-06-25'),
(55, 19, 'Ben Tre Tour', 'Miền tây sông nước tuyệt vời', 3, '2022-06-18');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ythichdgia`
--

CREATE TABLE `ythichdgia` (
  `MaThanhVien` int(11) NOT NULL,
  `MaDiaDiem` int(11) NOT NULL,
  `Sao` int(11) DEFAULT NULL,
  `NhanXet` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `YeuThich` int(11) DEFAULT NULL,
  `NgayDanhGia` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Đang đổ dữ liệu cho bảng `ythichdgia`
--

INSERT INTO `ythichdgia` (`MaThanhVien`, `MaDiaDiem`, `Sao`, `NhanXet`, `YeuThich`, `NgayDanhGia`) VALUES
(2, 6, 5, 'dao ngoc dep qua troi!', 1, '2022-05-26 22:16:06'),
(2, 16, 4, 'asdf', 1, '2022-05-26 21:31:57'),
(2, 17, 5, 'Tự hào Việt Nam!', 0, '2022-06-01 12:40:36'),
(3, 1, 4, 'gang gang. wow awesome', 0, '2022-05-23 06:31:49'),
(3, 3, 4, 'Cua Lo is my hometown favorite', 0, '2022-05-23 14:06:53'),
(3, 4, 5, 'Rất tốt', 1, '2022-05-01 00:00:00'),
(3, 6, 4, '&lt;script&gt;alert(&quot;Hacked&quot;)&lt;/script&gt;', 0, '2022-06-10 16:31:26'),
(3, 7, 5, 'Hoi An is beautiful', 1, '2022-05-23 06:59:45'),
(3, 9, 5, 'It\'s a good place to go...', 1, '2022-05-11 08:00:00'),
(3, 11, 4, 'Con son Kiep Bac that binh yen ', 1, '2022-06-06 23:48:38'),
(3, 14, 4, '&lt;script&gt;alert(&quot;Hacked!&quot;)&lt;/script&gt;', 0, '2022-06-04 16:38:51'),
(3, 16, 5, 'this is beautiful', 1, '2022-05-25 22:57:51'),
(3, 17, 5, 'Thật đẹp quá đi', 1, '2022-06-05 15:36:33'),
(5, 5, 5, 'that\'s good', 1, '2022-05-10 13:15:31'),
(5, 7, 5, 'Rất tốt', 1, '2022-05-08 00:00:00'),
(5, 8, 5, 'This is pretty good', 0, '2022-05-23 06:57:05'),
(5, 9, 5, 'đẹp', 1, '2022-05-03 00:00:00'),
(5, 13, 5, 'Rất tốt', 1, '2022-05-02 00:00:00'),
(5, 14, 5, 'gang gang gang', 1, '2022-05-12 11:10:32'),
(5, 17, 5, 'Cao Bang that dep!', 1, '2022-05-26 00:23:24'),
(7, 11, 5, 'Hai Duong is best place to visit', 1, '2022-05-20 14:11:19'),
(7, 12, 4, 'Khá tốt', 0, '2022-05-04 00:00:00'),
(7, 14, 5, 'đẹp', 1, '2022-05-06 00:00:00'),
(7, 15, 5, 'Nghe An number 1', 0, '2022-01-11 05:27:09'),
(22, 6, 5, 'gang bang', 0, '2022-06-08 15:35:30'),
(22, 13, 2, 'gang bang', 1, '2022-06-08 15:34:47'),
(22, 16, 4, 'gang bang', 1, '2022-06-08 15:33:57'),
(22, 17, 5, 'gang bang', 0, '2022-06-08 15:38:23');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `anh`
--
ALTER TABLE `anh`
  ADD PRIMARY KEY (`MaAnh`),
  ADD KEY `MaDiaDiem` (`MaDiaDiem`);

--
-- Chỉ mục cho bảng `ct_tour`
--
ALTER TABLE `ct_tour`
  ADD PRIMARY KEY (`MaThanhVien`,`MaTour`),
  ADD KEY `fk_ct_tour_tour` (`MaTour`);

--
-- Chỉ mục cho bảng `diadiem`
--
ALTER TABLE `diadiem`
  ADD PRIMARY KEY (`MaDiaDiem`),
  ADD KEY `MaTinh` (`MaTinh`);

--
-- Chỉ mục cho bảng `mien`
--
ALTER TABLE `mien`
  ADD PRIMARY KEY (`MaMien`);

--
-- Chỉ mục cho bảng `thanhvien`
--
ALTER TABLE `thanhvien`
  ADD PRIMARY KEY (`MaThanhVien`);

--
-- Chỉ mục cho bảng `tinh`
--
ALTER TABLE `tinh`
  ADD PRIMARY KEY (`MaTinh`),
  ADD KEY `MaMien` (`MaMien`);

--
-- Chỉ mục cho bảng `tintuc`
--
ALTER TABLE `tintuc`
  ADD PRIMARY KEY (`MaTinTuc`),
  ADD KEY `MaDiaDiem` (`MaDiaDiem`);

--
-- Chỉ mục cho bảng `tour`
--
ALTER TABLE `tour`
  ADD PRIMARY KEY (`MaTour`),
  ADD KEY `fk_tour_diadiem` (`MaDiaDiem`);

--
-- Chỉ mục cho bảng `ythichdgia`
--
ALTER TABLE `ythichdgia`
  ADD PRIMARY KEY (`MaThanhVien`,`MaDiaDiem`),
  ADD KEY `fk_ythichdgia_diadiem` (`MaDiaDiem`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `anh`
--
ALTER TABLE `anh`
  MODIFY `MaAnh` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT cho bảng `diadiem`
--
ALTER TABLE `diadiem`
  MODIFY `MaDiaDiem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `thanhvien`
--
ALTER TABLE `thanhvien`
  MODIFY `MaThanhVien` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT cho bảng `tintuc`
--
ALTER TABLE `tintuc`
  MODIFY `MaTinTuc` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `tour`
--
ALTER TABLE `tour`
  MODIFY `MaTour` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `anh`
--
ALTER TABLE `anh`
  ADD CONSTRAINT `anh_ibfk_1` FOREIGN KEY (`MaDiaDiem`) REFERENCES `diadiem` (`MaDiaDiem`);

--
-- Các ràng buộc cho bảng `ct_tour`
--
ALTER TABLE `ct_tour`
  ADD CONSTRAINT `fk_ct_tour_thanhvien` FOREIGN KEY (`MaThanhVien`) REFERENCES `thanhvien` (`MaThanhVien`),
  ADD CONSTRAINT `fk_ct_tour_tour` FOREIGN KEY (`MaTour`) REFERENCES `tour` (`MaTour`);

--
-- Các ràng buộc cho bảng `diadiem`
--
ALTER TABLE `diadiem`
  ADD CONSTRAINT `diadiem_ibfk_1` FOREIGN KEY (`MaTinh`) REFERENCES `tinh` (`MaTinh`);

--
-- Các ràng buộc cho bảng `tinh`
--
ALTER TABLE `tinh`
  ADD CONSTRAINT `tinh_ibfk_1` FOREIGN KEY (`MaMien`) REFERENCES `mien` (`MaMien`);

--
-- Các ràng buộc cho bảng `tintuc`
--
ALTER TABLE `tintuc`
  ADD CONSTRAINT `tintuc_ibfk_1` FOREIGN KEY (`MaDiaDiem`) REFERENCES `diadiem` (`MaDiaDiem`);

--
-- Các ràng buộc cho bảng `tour`
--
ALTER TABLE `tour`
  ADD CONSTRAINT `fk_tour_diadiem` FOREIGN KEY (`MaDiaDiem`) REFERENCES `diadiem` (`MaDiaDiem`);

--
-- Các ràng buộc cho bảng `ythichdgia`
--
ALTER TABLE `ythichdgia`
  ADD CONSTRAINT `fk_ythichdgia_diadiem` FOREIGN KEY (`MaDiaDiem`) REFERENCES `diadiem` (`MaDiaDiem`),
  ADD CONSTRAINT `fk_ythichdgia_thanhvien` FOREIGN KEY (`MaThanhVien`) REFERENCES `thanhvien` (`MaThanhVien`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
