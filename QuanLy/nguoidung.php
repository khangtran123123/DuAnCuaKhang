<?php
	$sql = "SELECT * FROM `tbladmin` WHERE 1";
	$danhsach = $connect->query($sql);
	//Nếu kết quả kết nối không được thì xuất báo lỗi và thoát
	if (!$danhsach) {
		die("Không thể thực hiện câu lệnh SQL: " . $connect->error);
		exit();
	}

?>
<h3>Danh sách người dùng</h3>
<table class="DanhSach">
	<tr>
		<th>Mã Admin</th>
		<th>Họ và tên</th>
		<th>Tên đăng nhập</th>
		<th>Quyền</th>
		<th>Giới tính</th>
		<th>SDT</th>
		<th colspan="3">Hành động</th>
	</tr>
	<?php
		$stt = 1;
		//Dùng vòng lặp while truy xuất các phần tử trong table
		while ($dong = $danhsach->fetch_array(MYSQLI_ASSOC)) 
		{			
			echo "<tr  bgcolor='#ffffff' onmouseover='this.style.background=\"#dee3e7\"' onmouseout='this.style.background=\"#ffffff\"'>";
				echo "<td>" . $dong["MaAdmin"] . "</td>";
				echo "<td>" . $dong["TenAdmin"] . "</td>";
				echo "<td>" . $dong["TenDangNhap"] . "</td>";
				
				echo "<td>";
					if($dong["QuyenAdmin"] == 1)
					{
						if($_SESSION['MaAdmin'] != $dong["MaAdmin"])
							echo "Quản trị (<a href='index.php?do=nguoidung_kichhoat&id=" . $dong["MaAdmin"] . "&quyen=2'>Hạ quyền</a>)";
						else
							echo "Quản trị ";
					}
					else
						echo "Thành viên (<a href='index.php?do=nguoidung_kichhoat&id=" . $dong["MaAdmin"] . "&quyen=1'>Nâng quyền</a>)";
				echo "</td>";
				
				echo "<td>" . $dong["GioiTinh"] . "</td>";
				echo "<td>" . $dong["SDT"] . "</td>";
				
				echo "<td align='center'><a href='index.php?do=doimatkhau&id=" . $dong["MaAdmin"] . "'><img src='images/key.jpg' /></a></td>";
				echo "<td align='center'><a href='index.php?do=nguoidung_sua&id=" . $dong["MaAdmin"] . "'><img src='images/edit.png' /></a></td>";
				echo "<td align='center'><a href='index.php?do=nguoidung_xoa&id=" . $dong["MaAdmin"] . "' onclick='return confirm(\"Bạn có muốn xóa người dùng " . $dong['TenAdmin'] . " không?\")'><img src='images/delete.png' /></a></td>";
			echo "</tr>";
		}
	?>
</table>
	
<a href="index.php?do=dangky">Thêm mới người dùng</a>
</form>