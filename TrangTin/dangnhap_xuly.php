<?php
	// Lấy thông tin từ FORM
	$TenDangNhap = $_POST['TenDangNhap'];
	$MatKhau = $_POST['MatKhau'];
	
	// Kiểm tra
	if(trim($TenDangNhap) == "")
		ThongBaoLoi("Tên đăng nhập không được bỏ trống!");
	elseif(trim($MatKhau) == "")
		ThongBaoLoi("Mật khẩu không được bỏ trống!");
	else
	{
		// Mã hóa mật khẩu
		$MatKhau = md5($MatKhau);
		
		// Kiểm tra người dùng có tồn tại không
		$sql_kiemtra = "SELECT * from tblkhachhang WHERE TenDNKH = '$TenDangNhap' AND MatKhauKH = '$MatKhau'";	
		
		
		$danhsach = $connect->query($sql_kiemtra);
		
		//Nếu kết quả kết nối không được thì xuất báo lỗi và thoát
		if (!$danhsach) {
			die("Không thể thực hiện câu lệnh SQL: " . $connect->error);
			exit();
		}
		
		$dong = $danhsach->fetch_array(MYSQLI_ASSOC);
		if($dong)
		{
			// Đăng ký SESSION
			$_SESSION['MaKH'] = $dong['MaKH'];
			$_SESSION['HoTen'] = $dong['TenKH'];
			$_SESSION['CapTK'] = $dong['CapTK'];
				
			// Chuyển hướng về trang index.php
			header("Location: index.php");
		
		}
		else
		{
			ThongBaoLoi("Tên đăng nhập hoặc mật khẩu không chính xác!");
		}
	}
	
?>