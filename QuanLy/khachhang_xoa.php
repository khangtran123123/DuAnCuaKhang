<?php
	$MaKH = $_GET['id'];
	
	$sql = "delete from `tblkhachhang` where MaKH = '$MaKH'";
	$danhsach = $connect->query($sql);
	
	//Nếu kết quả kết nối không được thì xuất báo lỗi và thoát
	if (!$danhsach) {
		die("Không thể thực hiện câu lệnh SQL: " . $connect->error);
		exit();
	}
	else
	{
		header("Location: index.php?do=khachhang");
	}	
	
?>
