<?php
	$MaHD = $_GET['id'];
	
	$sql_cthd = "delete from `tblchitiethoadon` where MaHD = '$MaHD'";
	$xoa = $connect->query($sql_cthd);
	if (!$xoa) {
		die("Không thể thực hiện câu lệnh SQL: " . $connect->error);
		exit();
	}
	
	$sql_hd = "delete from `tblhoadon` where MaHD = '$MaHD'";
	$danhsach = $connect->query($sql_hd);
	
	//Nếu kết quả kết nối không được thì xuất báo lỗi và thoát
	if (!$danhsach) {
		die("Không thể thực hiện câu lệnh SQL: " . $connect->error);
		exit();
	}
	else
	{
		header("Location: index.php?do=hoadon");
	}	
	
?>