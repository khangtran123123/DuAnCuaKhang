<?php
	$MaKH = $_GET['id'];
	
	$sql = "select * from `tblkhachhang` where MaKH = '$MaKH'";
	
	$danhsach = $connect->query($sql);
	//Nếu kết quả kết nối không được thì xuất báo lỗi và thoát
	if (!$danhsach) {
		die("Không thể thực hiện câu lệnh SQL: " . $connect->connect_error);
		exit();
	}
	
	$dong = $danhsach->fetch_array(MYSQLI_ASSOC)
?>

<h3>Sửa nhân viên</h3>
<form action="index.php?do=khachhang_sua_xuly" method="post">
	<table class="Form">
		<input type="hidden" name="MaKH" value="<?php echo $dong['MaKH']; ?>" />
		<tr>
				<td>Tên khách hàng:</td>
				<td><input type="text" name="TenKH" value="<?php echo $dong['TenKH']; ?>" /></td>
		</tr>
		
		<tr>
				<td>Giới tính</td>
				<td><input type="text" name="GioiTinhKH" value="<?php echo $dong['GioiTinhKH']; ?>" /></td>
		</tr>
		
		<tr>
				<td>SDT</td>
				<td><input type="text" name="SDTKH" value="<?php echo $dong['SDTKH']; ?>" /></td>
		</tr>
	</table>
	
	<input type="submit" value="Cập nhật" />