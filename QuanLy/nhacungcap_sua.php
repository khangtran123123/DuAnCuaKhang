<?php
	$MaNCC = $_GET['id'];
	$sql = "select * from `tblnhacungcap` where MaNCC = '$MaNCC'";
	$danhsach = $connect->query($sql);
	//Nếu kết quả kết nối không được thì xuất báo lỗi và thoát
	if (!$danhsach) {
		die("Không thể thực hiện câu lệnh SQL: " . $connect->error);
		exit();
	}

	$dong = $danhsach->fetch_array(MYSQLI_ASSOC);
?>
<h3>Sửa nhà cung cấp </h3>
<form action="index.php?do=nhacungcap_sua_xuly" method="post">
	<table class="Form">
		<input type="hidden" name="MaNCC" value="<?php echo $dong['MaNCC']; ?>" />
		<tr>
			<td>Tên nhà cung cấp:</td>
			<td><input type="text" name="TenNCC" value="<?php echo $dong['TenNCC']; ?>" /></td>
		</tr>
		
		<tr>
			<td>Địa chỉ:</td>
			<td><input type="text" name="DiaChiNCC" value="<?php echo $dong['DiaChiNCC']; ?>" /></td>
		</tr>
		
		<tr>
			<td>SDT:</td>
			<td><input type="text" name="SDTNCC" value="<?php echo $dong['SDTNCC']; ?>" /></td>
		</tr>
	</table>
	
	<input type="submit" value="Cập nhật" />
</form>