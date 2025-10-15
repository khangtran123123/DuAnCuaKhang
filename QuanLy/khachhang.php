<?php
	$sql = "SELECT * FROM `tblkhachhang` WHERE 1";
	$danhsach = $connect->query($sql);
	//Nếu kết quả kết nối không được thì xuất báo lỗi và thoát
	if (!$danhsach) {
		die("Không thể thực hiện câu lệnh SQL: " . $connect->connect_error);
		exit();
	}
?>
<h3>Danh sách khách hàng</h3>
<table class="DanhSach">
	<tr>
		<th>Mã khách hàng </th>
		<th>Tên khách hàng </th>
		<th>Tên đăng nhập </th>
		<th>Giới tính </th>
		<th>Cấp tài khoản </th>
		<th>SDT </th>
		<th colspan="3">Hành động</th>
	</tr>
	<?php
		while ($dong = $danhsach->fetch_array(MYSQLI_ASSOC)) {		
			echo "<tr  bgcolor='#ffffff' onmouseover='this.style.background=\"#dee3e7\"' onmouseout='this.style.background=\"#ffffff\"'>";
				echo "<td>" . $dong["MaKH"] . "</td>";
				echo "<td>" . $dong["TenKH"] . "</td>";
				echo "<td>" . $dong["TenDNKH"] . "</td>";
				echo "<td>" . $dong["GioiTinhKH"] . "</td>";
				
				if($dong['CapTK'] ==3)
					echo "<td>" . $dong['CapTK'] ." (<a href='index.php?do=khachhang_hacap&id=" . $dong['MaKH'] ."&cap=" .$dong['CapTK']. "'>Hạ cấp</a>)</td>";
				elseif($dong['CapTK'] ==0)
					echo "<td>" . $dong['CapTK'] ." (<a href='index.php?do=khachhang_tangcap&id=" . $dong['MaKH'] ."&cap=" .$dong['CapTK']. "'>Tăng cấp</a>)</td>";
				else
					echo "<td>" . $dong['CapTK'] ." (<a href='index.php?do=khachhang_tangcap&id=" . $dong['MaKH'] ."&cap=" .$dong['CapTK']. "'>Tăng cấp</a>)(<a href='index.php?do=khachhang_hacap&id=" . $dong['MaKH'] ."&cap=" .$dong['CapTK']. "'>Hạ cấp</a></td>";

				echo "<td>" . $dong["SDTKH"] . "</td>";
				
				echo "<td align='center'><a href='index.php?do=khachhang_doimatkhau&id=" . $dong["MaKH"] . "'><img src='images/key.jpg' /></a></td>";
				echo "<td align='center'><a href='index.php?do=khachhang_sua&id=" . $dong["MaKH"] . "'><img src='images/edit.png' /></a></td>";
				echo "<td align='center'><a href='index.php?do=khachhang_xoa&id=" . $dong["MaKH"] . "' onclick='return confirm(\"Bạn có muốn xóa chủ đề " . $dong['TenKH'] . " không?\")'><img src='images/delete.png' /></a></td>";
			echo "</tr>";
		}
	?>
</table>
	
<a href="index.php?do=khachhang_them">Thêm mới nhà cung cấp</a>
</form>