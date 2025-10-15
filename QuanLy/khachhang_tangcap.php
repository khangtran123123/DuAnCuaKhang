<?php
	$CapTK= $_GET['cap']+1;
	$MaKH = $_GET['id'];
	
	$sql = "UPDATE `tblkhachhang` SET CapTK = $CapTK  WHERE MaKH = '$MaKH'";
	$danhsach = $connect->query($sql);
	//Nếu kết quả kết nối không được thì xuất báo lỗi và thoát
	if (!$danhsach) {
		die("Không thể thực hiện câu lệnh SQL: " . $connect->error);
		exit();
	}
	
	if($danhsach)
		header("Location: index.php?do=khachhang");
	else
		ThongBaoLoi(mysql_error());
?>