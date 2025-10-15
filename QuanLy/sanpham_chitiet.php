<?php
	$MaSP = $_GET['id'];
	
	$sql = "SELECT *
			FROM tblsanpham A, tblnhacungcap B
			WHERE A.MaNCC = B.MaNCC AND A.MaSP = '$MaSP'";

	$danhsach = $connect->query($sql);
	//Nếu kết quả kết nối không được thì xuất báo lỗi và thoát
	if (!$danhsach) {
		die("Không thể thực hiện câu lệnh SQL: " . $connect->connect_error);
		exit();
	}
	
	$dong = $danhsach->fetch_array(MYSQLI_ASSOC);
	
?>
<h3><?php echo $dong['TenSP']; ?></h3>

<p class="TomTat">Loại sản phẩm: <?php echo $dong['LoaiSP']; ?></p>
<p class="TomTat">Nhà cung cấp: <?php echo $dong['TenNCC']; ?></p>
<p class="TomTat">Đơn giá: <?php echo $dong['DonGia']; ?></p>
<p class="TomTat">Số lượng: <?php echo $dong['SoLuongSP']; ?></p>
<p class="TomTat">Khuyến mãi: <?php echo $dong['KhuyenMai']; ?></p>
<p class="TomTat">Ngày nhập: <?php echo $dong['NgayNhap']; ?></p>
<p><?php echo    "<td colspan=\"2\"><img width=\"200\" src=" . $dong["HinhAnh"] . "></td>"; ?></p>
<h4 >Mô tả:</h4>
<p class="NoiDung"><?php echo $dong['MoTa']; ?></p>




