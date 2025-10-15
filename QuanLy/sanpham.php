<?php
	$sql = "select *
			from tblsanpham A, tblnhacungcap B
			where A.MaNCC = B.MaNCC ORDER by `MaSP` ASC";
	$danhsach = $connect->query($sql);
	//Nếu kết quả kết nối không được thì xuất báo lỗi và thoát
	if (!$danhsach) {
		die("Không thể thực hiện câu lệnh SQL: " . $connect->connect_error);
		exit();
	}
?>
<h3>Danh sách sản phẩm</h3>
<table class="DanhSach">
	<tr>
		<th>STT</th>
		<th>Mã sản phẩm</th>
		<th>Tên sản phẩm</th>
		<th>Nhà cung cấp</th>
		<th>Hình ảnh</th>
		<th>Số lượng</th>
		<th colspan="2">Hành động</th>
	</tr>
	<?php
		$stt = 1;
		while ($dong = $danhsach->fetch_array(MYSQLI_ASSOC)) {	
			echo "<tr>";
				echo "<tr  bgcolor='#ffffff' onmouseover='this.style.background=\"#dee3e7\"' onmouseout='this.style.background=\"#ffffff\"'>";
				echo "<td>" . $stt . "</td>";
				echo "<td>" . $dong['MaSP'] . "</td>";
				echo "<td><a href='index.php?do=sanpham_chitiet&id=" . $dong['MaSP'] . "'>" . $dong['TenSP'] . "</a></td>";
				echo "<td>" . $dong['TenNCC'] . "</td>";
				echo "<td><img src='".$dong['HinhAnh']."' width='100'/></td>";
				echo "<td>" . $dong['SoLuongSP'] . "</td>";
				
				echo "<td align='center'><a href='index.php?do=sanpham_sua&id=" . $dong['MaSP'] . "'><img src='images/edit.png' /></a></td>";
				echo "<td align='center'><a href='index.php?do=sanpham_xoa&id=" . $dong['MaSP'] . "' onclick='return confirm(\"Bạn có muốn xóa bài viết " . $dong['TenSP'] . " không?\")'><img src='images/delete.png' /></a></td>";
			echo "</tr>";
			$stt++;
		}
	?>
</table>

<a href="index.php?do=sanpham_them">Thêm sản phẩm</a>