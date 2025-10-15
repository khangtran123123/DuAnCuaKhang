<?php
	$MaAdmin = $_GET['id'];
	
	$sql = "select * from `tbladmin` where MaAdmin = '$MaAdmin'";
	
	$danhsach = $connect->query($sql);
	//Nếu kết quả kết nối không được thì xuất báo lỗi và thoát
	if (!$danhsach) {
		die("Không thể thực hiện câu lệnh SQL: " . $connect->connect_error);
		exit();
	}
	
	$dong = $danhsach->fetch_array(MYSQLI_ASSOC)
?>

<h3>Sửa nhân viên</h3>
<form action="index.php?do=nguoidung_sua_xuly" method="post">
	<table class="Form">
		<input type="hidden" name="MaAdmin" value="<?php echo $dong['MaAdmin']; ?>" />
		<tr>
				<td>Tên nhân viên:</td>
				<td><input type="text" name="TenAdmin" value="<?php echo $dong['TenAdmin']; ?>" /></td>
		</tr>
		
		<tr>
				<td>Giới tính</td>
				<td><input type="text" name="GioiTinh" value="<?php echo $dong['GioiTinh']; ?>" /></td>
		</tr>
		
		<tr>
				<td>SDT</td>
				<td><input type="text" name="SDT" value="<?php echo $dong['SDT']; ?>" /></td>
		</tr>
	</table>
	
	<input type="submit" value="Cập nhật" />