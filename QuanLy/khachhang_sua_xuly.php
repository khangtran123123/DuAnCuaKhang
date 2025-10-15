<?php
	// Lấy thông tin từ FORM
	$MaKH = $_POST['MaKH'];
	$TenKH = $_POST['TenKH'];
	$GioiTinhKH = $_POST['GioiTinhKH'];
	$SDTKH = $_POST['SDTKH'];
	// Kiểm tra
	if(trim($TenKH) == "")
		ThongBaoLoi("Tên khách hàng không được bỏ trống!");
	elseif(trim($GioiTinhKH) == "")
		ThongBaoLoi("Giới tính không được bỏ trống!");
	elseif(trim($SDTKH) == "" || !(is_numeric($SDTKH)))
		ThongBaoLoi("Số điện thoại không được bỏ trống!");
	else
	{
		$sql = "update `tblkhachhang` 
				SET `TenKH` = '$TenKH',
					`GioiTinhKH` = '$GioiTinhKH',
					`SDTKH` = $SDTKH
				WHERE `MaKH` = '$MaKH'";
		$danhsach = $connect->query($sql);
		//Nếu kết quả kết nối không được thì xuất báo lỗi và thoát
		if (!$danhsach) {
			die("Không thể thực hiện câu lệnh SQL: " . $connect->error);
			exit();
		}
		else
		{
			ThongBao("Chỉnh sửa thành công!");
		}	
	}
?>