<?php
	$MaHD = $_GET['id'];
	$sql = "select * from `tblchitiethoadon` , `tblsanpham`  WHERE `tblchitiethoadon`.MaSP=`tblsanpham`.MaSP and `tblchitiethoadon`.MaHD='$MaHD'";
	$danhsach = $connect->query($sql);
	//Nếu kết quả kết nối không được thì xuất báo lỗi và thoát
	if (!$danhsach) {
		die("Không thể thực hiện câu lệnh SQL: " . $connect->error);
		exit();
	}
?>
<h3>Danh sách hóa đơn</h3>
<table class="DanhSach">
	<tr>
		<th>Mã hóa đơn</th>
		<th>Mã sản phẩm</th>
		<th>Tên sản phẩm</th>
		<th>Số lượng</th>
		<th>Đơn giá</th>
		<th>Thành tiền</th>
	</tr>
	<?php
		while ($dong = $danhsach->fetch_array(MYSQLI_ASSOC)) {		
			echo "<tr  bgcolor='#ffffff' onmouseover='this.style.background=\"#dee3e7\"' onmouseout='this.style.background=\"#ffffff\"'>";
				echo "<td>" . $dong['MaHD'] . "</td>";
				echo "<td>" . $dong["MaSP"] . "</td>";
				echo "<td>" . $dong["TenSP"] . "</td>";
				echo "<td>" . $dong["SoLuong"] . "</td>";
				echo "<td>" . $dong["DonGia"] . "</td>";
				echo "<td>" . $dong["ThanhTien"] . "</td>";
			echo "</tr>";
		}
	?>
</table>
</form>