
	

<?php
	if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
	
	include_once "cauhinh.php";
	
	include_once "thuvien.php";
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Shop ban quan ao</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" href="css/style1.css?v=2" />
		<script type="text/javascript" src="script/banner.js"></script>
		
		
	</head>
	<body >
		<div id="TrangWeb">
			<div id="PhanDau">
				<img name ="myimage" src="image/banner1.png" />
			</div>
			<div id="PhanMenu1">
				<div class="Menu"> <a href="index.php?do=home"> Trang Chủ</a> </div>			
				<div class="Menu"> Tin tức </div>
				<div class="Menu"> Trợ giúp </div>
				<div class="Menu1"> 
				<form action="index.php?do=search_xuly" method="post">
					Tìm kiếm: <input type="text" name="search" />
					<input type="submit" name="ok" value="search" />
				</form>

				</div>	
				<div class="Menu"> Đăng nhập </div>
				<div class="Menu"> <a href="giohang1.php"> Giỏ hàng</a> </div>
		
			</div>

			<div id="Giua">
				<div id="BenTrai">					
					<h3>Kết quả khi đã lọc</h3>
				</div>	
				
				<div id="PhanGiua">
					<?php
												
						if (!isset($connect)) {
						include_once "cauhinh.php"; // Đảm bảo kết nối cơ sở dữ liệu
						}

						$dieuKienWhere = array();
						$cacDieuKien = array();

						// Xử lý bộ lọc Thương hiệu
						if (isset($_GET['ThuongHieu']) && is_array($_GET['ThuongHieu']) && !empty($_GET['ThuongHieu'])) {
							$dieuKienThuongHieu = array();
							foreach ($_GET['ThuongHieu'] as $th) {
								$dieuKienThuongHieu[] = "l.TenNCC = '" . $connect->real_escape_string($th) . "'"; // Thoát dữ liệu cơ bản
							}
							$dieuKienWhere[] = "(" . implode(" OR ", $dieuKienThuongHieu) . ")";
						}

						// Xử lý bộ lọc Áo
						if (isset($_GET['LoaiAo']) && is_array($_GET['LoaiAo']) && !empty($_GET['LoaiAo'])) {
							$dieuKienAo = array();
							foreach ($_GET['LoaiAo'] as $la) {
								$dieuKienAo[] = "t.LoaiSP = '" . $connect->real_escape_string($la) . "'"; // Thoát dữ liệu cơ bản
							}
							$dieuKienWhere[] = "(" . implode(" OR ", $dieuKienAo) . ")";
						}

						// Xử lý bộ lọc Quần
						if (isset($_GET['LoaiQuan']) && is_array($_GET['LoaiQuan']) && !empty($_GET['LoaiQuan'])) {
							$dieuKienQuan = array();
							foreach ($_GET['LoaiQuan'] as $lq) {
								$dieuKienQuan[] = "t.LoaiSP = '" . $connect->real_escape_string($lq) . "'"; // Thoát dữ liệu cơ bản
							}
							$dieuKienWhere[] = "(" . implode(" OR ", $dieuKienQuan) . ")";
						}

						$where = "WHERE t.MaNCC = l.MaNCC";
						if (!empty($dieuKienWhere)) {
							$where .= " AND " . implode(" AND ", $dieuKienWhere);
						}

						// Tạo và thực thi truy vấn SQL
						$sql = "SELECT t.MaSP, t.TenSP,  t.HinhAnh, t.DonGia, t.LoaiSP, t.SoLuongSP, t.MoTa, t.KhuyenMai, l.MaNCC, l.TenNCC
								FROM tblsanpham t
								INNER JOIN tblnhacungcap l ON t.MaNCC = l.MaNCC
								$where";

						$danhsach = $connect->query($sql);

						if (!$danhsach) {
							echo "Lỗi SQL: " . $connect->error;
							return;
						}
						while ($row = $danhsach->fetch_array(MYSQLI_ASSOC)) 		
						{				
							$giaban = $row['DonGia'] - (($row['KhuyenMai'] /100) * $row['DonGia']);
							echo "<div class='khungsanpham'>";
								echo "<div class='khunganh'>";					
									echo "<a href='index.php?do=sanpham_chitiet&id_sp=" . $row['MaSP'] . "&id_nsx=" . $row['MaNCC'] . "&id_loai=" . $row['LoaiSP'] . " '>";
									//-----------------------------css
										echo "<img class='hinhanhphim' src=" . $row["HinhAnh"] . "  style='width: 300px; height: 300px;'>";						
									echo "</a>";
								echo "</div>";
								echo "<div class='khungtext'>";	
									//-----------------------------css
									echo "<span class=\"khuyenmai\"> Khuyến mãi:". $row['KhuyenMai'] ." %. Từ </span><span class=\"dongia\">". number_format($row['DonGia'])." $</span>";
									//-----------------------------css--------------------
									echo "<br /></span><span class=\"giaban\">Còn:  ". number_format($giaban)." $</span>";
									echo "<p><a  href='index.php?do=sanpham_chitiet&id_sp=" . $row['MaSP'] . " &id_nsx=" . $row['MaNCC'] . " &id_loai=" . $row['LoaiSP'] . " '>" . $row['TenSP'] . "</a></p>";
								echo "</div>";
								
								
							echo "</div>";
							
						}
		
?>
					
				</div>
				
				
				
			<div id="PhanCuoi">
				<table class="TBCuoiTrang">
					<tr id="TieuDeTB">
						<td>Thông tin cửa hàng</td>
						<td>Chính sách khách hàng</td>
						<td>Công ty</td>
					</tr>
					<tr>
						<td>Địa chỉ: số 18, đường Ung Văn Khiêm, Long Xuyên,An Giang </td>
						<td>Chính sách KH thân thiết</td>
						<td>Tuyển dụng và việc làm</td>
					</tr>
					<tr>
						<td>SĐT: 0123456789</td>
						<td>Chính sách bảo hành</td>
						<td>Tin tức thời trang</td>
					</tr>
					<tr>

						<td>Email:<a href="mailto:khang_dth225677@student.agu.edu.vn">khang_dth225677@student.agu.edu.vn</a> </td>
						<td>Chính sách bảo mật</td>
						<td>Chăm sóc khách hàng</td>
					</tr>
				</table>
				
			</div>
		</div>
	</body>
</html>
	


		
	</body>
</html>