<?php
	// Lấy thông tin từ FORM
	$MaNCC = $_POST['MaNCC'];
	$TenNCC = $_POST['TenNCC'];
	$DiaChiNCC = $_POST['DiaChiNCC'];
	$SDTNCC = $_POST['SDTNCC'];
	// Kiểm tra
	if(trim($TenNCC) == "")
		ThongBaoLoi("Tên nhà cung cấp không được bỏ trống!");
	elseif(trim($DiaChiNCC) == "")
		ThongBaoLoi("Địa chỉ nhà cung cấp không được bỏ trống!");
	elseif(trim($SDTNCC) == "" || !(is_numeric($SDTNCC)))
		ThongBaoLoi("SDT nhà cung cấp không được bỏ trống!");
	else
	{
		$sql = "update `tblnhacungcap` 
				SET `TenNCC` = '$TenNCC',
					`DiaChiNCC` = '$DiaChiNCC',
					`SDTNCC` = $SDTNCC
				WHERE `MaNCC` = '$MaNCC'";
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