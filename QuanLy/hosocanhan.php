<?php
	$sql = "SELECT * FROM `tbladmin` WHERE MaAdmin = '" .$_SESSION['MaAdmin']. "'";
	
	$danhsach = $connect->query($sql);
	//Nếu kết quả kết nối không được thì xuất báo lỗi và thoát
	if (!$danhsach) {
		die("Không thể thực hiện câu lệnh SQL: " . $connect->error);
		exit();
	}
	
	$dong = $danhsach->fetch_array(MYSQLI_ASSOC);
?>
<h3>Hồ sơ cá nhân</h3>
<form action="index.php?do=hosocanhan_xuly" method="post">
	<table class="Form">
		<input type="hidden" value="<?php echo $dong['MaAdmin']; ?>" name="MaAdmin" />
		<tr>
			<td>Họ và tên:</td>
			<td><input type="text" value="<?php echo $dong['TenAdmin']; ?>" name="TenAdmin" /></td>
		</tr>
		
		<tr>
			<td>Giới tính:</td>
			<td><input type="text" value="<?php echo $dong['GioiTinh']; ?>" name="GioiTinh" /></td>
		</tr>
		
		<tr>
			<td>SDT:</td>
			<td><input type="text" value="<?php echo $dong['SDT']; ?>" name="SDT" /></td>
		</tr>
		
		<tr>
			<td>Tên đăng nhập:</td>
			<td><input type="text" value="<?php echo $dong['TenDangNhap']; ?>" name="TenDangNhap" disabled="disabled" /></td>
		</tr>
	</table>
	
	<input type="submit" value="Cập nhật hồ sơ" />
</form>