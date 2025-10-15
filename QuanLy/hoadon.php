<?php
	$sql = "select * from `tblhoadon` , `tblkhachhang`  WHERE `tblhoadon`.MaKH=`tblkhachhang`.MaKH";
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
		<th>Tên khách hàng</th>
		<th>Tổng tiền</th>
		<th>Ngày bán</th>
		<th>Hành động</th>
	</tr>
	<?php
		while ($dong = $danhsach->fetch_array(MYSQLI_ASSOC)) {		
			echo "<tr  bgcolor='#ffffff' onmouseover='this.style.background=\"#dee3e7\"' onmouseout='this.style.background=\"#ffffff\"'>";
				echo "<td><a href='index.php?do=chitiethoadon&id=" . $dong['MaHD'] . "'>" . $dong['MaHD'] . "</a></td>";
				echo "<td>" . $dong["TenKH"] . "</td>";
				echo "<td>" . $dong["TongTien"] . "</td>";
				echo "<td>" . $dong["NgayBan"] . "</td>";
				echo "<td align='center'><a href='index.php?do=hoadon_xoa&id=" . $dong["MaHD"] . "' onclick='return confirm(\"Bạn có muốn xóa hóa đơn " . $dong['MaHD'] . " không?\")'><img src='images/delete.png' /></a></td>";
			echo "</tr>";
		}
	?>
</table>
</form>