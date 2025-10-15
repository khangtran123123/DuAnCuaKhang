<?php
	$QuyenAdmin= $_GET['quyen'];
	$MaAdmin = $_GET['id'];
	if(isset($_GET['quyen']))
	{
		$sql = "UPDATE `tbladmin` SET QuyenAdmin = $QuyenAdmin  WHERE MaAdmin = '$MaAdmin'";
		$danhsach = $connect->query($sql);
		//Nếu kết quả kết nối không được thì xuất báo lỗi và thoát
		if (!$danhsach) {
			die("Không thể thực hiện câu lệnh SQL: " . $connect->error);
			exit();
		}
		
		if($danhsach)
			header("Location: index.php?do=nguoidung");
		else
			ThongBaoLoi(mysql_error());
	}
	else
	{
		header("Location: index.php?do=nguoidung");
	}
?>