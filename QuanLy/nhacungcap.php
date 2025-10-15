<?php
	$sql = "select * from`tblnhacungcap` WHERE 1";
	$danhsach = $connect->query($sql);
	//Nếu kết quả kết nối không được thì xuất báo lỗi và thoát
	if (!$danhsach) {
		die("Không thể thực hiện câu lệnh SQL: " . $connect->connect_error);
		exit();
	}
?>
<h3>Danh sách nhà cung cấp</h3>
<table class="DanhSach">
	<tr>
		<th>Mã nhà cung cấp</th>
		<th>Tên nhà cung cấp</th>
		<th>Địa chỉ</th>
		<th>SDT</th>
		<th colspan="2">Hành động</th>
	</tr>
	<?php
		while ($dong = $danhsach->fetch_array(MYSQLI_ASSOC)) {		
			echo "<tr  bgcolor='#ffffff' onmouseover='this.style.background=\"#dee3e7\"' onmouseout='this.style.background=\"#ffffff\"'>";
				echo "<td>" . $dong["MaNCC"] . "</td>";
				echo "<td>" . $dong["TenNCC"] . "</td>";
				echo "<td>" . $dong["DiaChiNCC"] . "</td>";
				echo "<td>" . $dong["SDTNCC"] . "</td>";
				echo "<td align='center'><a href='index.php?do=nhacungcap_sua&id=" . $dong["MaNCC"] . "'><img src='images/edit.png' /></a></td>";
				echo "<td align='center'><a href='index.php?do=nhacungcap_xoa&id=" . $dong["MaNCC"] . "' onclick='return confirm(\"Bạn có muốn xóa chủ đề " . $dong['TenNCC'] . " không?\")'><img src='images/delete.png' /></a></td>";
			echo "</tr>";
		}
	?>
</table>
	
<a href="index.php?do=nhacungcap_them">Thêm mới nhà cung cấp</a>
</form>