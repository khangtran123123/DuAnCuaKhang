<?php
	// Lấy thông tin từ FORM
	$HoVaTen = $_POST['HoVaTen'];
	$TenDangNhap = $_POST['TenDangNhap'];
	$MatKhau = $_POST['MatKhau'];
	$XacNhanMatKhau = $_POST['XacNhanMatKhau'];
	$GioiTinh = $_POST['GioiTinh'];
	$SDT = $_POST['SDT'];
	
	// Kiểm tra
	if(trim($HoVaTen) == "")
		ThongBaoLoi("Họ và tên không được bỏ trống!");
	elseif(trim($TenDangNhap) == "")
		ThongBaoLoi("Tên đăng nhập không được bỏ trống!");
	elseif(trim($MatKhau) == "")
		ThongBaoLoi("Mật khẩu không được bỏ trống!");
	elseif($MatKhau != $XacNhanMatKhau)
		ThongBaoLoi("Xác nhận mật khẩu không đúng!");
	elseif(trim($SDT) == "" || !(is_numeric($SDT)))
		ThongBaoLoi("Số điện thoại không được bỏ trống và phải là số!");
	else
	{	
		// Kiểm tra người dùng đã tồn tại chưa
		$sql_kiemtra = "SELECT * FROM tbladmin WHERE TenDangNhap = '$TenDangNhap'";
		
		$danhsach = $connect->query($sql_kiemtra);
		
		if ($danhsach && $danhsach->num_rows == 0) 
		{

			// Tự động tạo MaAdmin mới (dạng AD001, AD002, ...)
			$sql_max = "SELECT MaAdmin FROM tbladmin ORDER BY MaAdmin DESC LIMIT 1";
			$result_max = $connect->query($sql_max);	
			
			if ($result_max && $row = $result_max->fetch_assoc()) 
			{
				$lastMa = $row['MaAdmin'];
				$number = intval(substr($lastMa, 2)) + 1;
				$MaAdmin = "AD" . str_pad($number, 3, "0", STR_PAD_LEFT);
			} 
			else 
			{
				$MaAdmin = "AD001";
			}

			// Mã hóa mật khẩu
			$MatKhau = md5($MatKhau);
			$sql_them = "INSERT INTO `tbladmin`(`MaAdmin`, `TenAdmin`, `TenDangNhap`, `MatKhau`, `QuyenAdmin`, `GioiTinh`, `SDT`)
					VALUES ('$MaAdmin', '$HoVaTen', '$TenDangNhap', '$MatKhau', 0, '$GioiTinh', '$SDT')";
			$themadmin = $connect->query($sql_them);
			
			if($themadmin)
				ThongBao("Đăng ký thành công!");
			else
				ThongBaoLoi(mysql_error());
		}
		else
		{
			ThongBaoLoi("Người dùng với tên đăng nhập đã được sử dụng!");
		}
	}
?>