<?php
	// Lấy thông tin từ FORM
	$TenKH = $_POST['TenKH'];
	$TenDNKH = $_POST['TenDNKH'];
	$MatKhauKH = $_POST['MatKhauKH'];
	$XacNhanMatKhau = $_POST['XacNhanMatKhau'];
	$GioiTinhKH = $_POST['GioiTinhKH'];
	$SDTKH = $_POST['SDTKH'];
	// Kiểm tra
	if(trim($TenKH) == "")
		ThongBaoLoi("Họ và tên không được bỏ trống!");
	elseif(trim($TenDNKH) == "")
		ThongBaoLoi("Tên đăng nhập không được bỏ trống!");
	elseif(trim($MatKhauKH) == "")
		ThongBaoLoi("Mật khẩu không được bỏ trống!");
	elseif($MatKhauKH != $XacNhanMatKhau)
		ThongBaoLoi("Xác nhận mật khẩu không đúng!");
		elseif(trim($GioiTinhKH) == "")
		ThongBaoLoi("Giới tính không được bỏ trống!");
	elseif(trim($SDTKH) == "" || !(is_numeric($SDTKH)))
		ThongBaoLoi("Số điện thoại không được bỏ trống và phải là số!");
	else
	{	
		$sql_kiemtra = "SELECT * FROM tblkhachhang where TenDNKH = '$TenDNKH'";
		$danhsach = $connect->query($sql_kiemtra);

		if ($danhsach && $danhsach->num_rows == 0) 
		{

			// Tự động tạo MaNCC mới (dạng KH001, KH002, ...)
			$sql_max = "SELECT MaKH FROM tblkhachhang ORDER BY MaKH DESC LIMIT 1";
			$result_max = $connect->query($sql_max);

			if ($result_max && $row = $result_max->fetch_assoc()) 
			{
				$lastMa = $row['MaKH'];
				$number = intval(substr($lastMa, 2)) + 1;
				$MaKH = "KH" . str_pad($number, 3, "0", STR_PAD_LEFT);
			} 
			else 
			{
				$MaKH = "KH001"; // Nếu chưa có bản ghi nào
			}
			
			$MatKhauKH = md5($MatKhauKH);
			$sql_them = "INSERT INTO `tblkhachhang`(`MaKH`, `TenKH`, `TenDNKH`, `MatKhauKH`, `GioiTinhKH`, `CapTK`, `SDTKH`) 
			VALUES ('$MaKH', '$TenKH', '$TenDNKH', '$MatKhauKH', '$GioiTinhKH', 0, '$SDTKH')";
			$themadmin = $connect->query($sql_them);
			
			if($themadmin)
				ThongBao("Đăng ký thành công!");
			else
				ThongBaoLoi(mysql_error());
		}
		else
		{
			ThongBaoLoi("Khách hàng với tên đăng nhập đã được sử dụng!");
		}
		
	}
?>