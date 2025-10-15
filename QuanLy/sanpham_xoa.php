<?php
	$MaSP = $_GET['id'];
	
	$sql = "delete from `tblsanpham` where MaSP = '$MaSP'";
	$danhsach = $connect->query($sql);
	
	//Nếu kết quả kết nối không được thì xuất báo lỗi và thoát
	if (!$danhsach) {
		die("Không thể thực hiện câu lệnh SQL: " . $connect->connect_error);
		exit();
	}
	else
	{
		header("Location: index.php?do=sanpham");
	}	
	
?>

