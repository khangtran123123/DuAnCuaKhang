<?php
	// Lấy thông tin từ FORM
	$MaAdmin = $_POST['MaAdmin'];
	$TenAdmin = $_POST['TenAdmin'];
	$GioiTinh = $_POST['GioiTinh'];
	$SDT = $_POST['SDT'];
	// Kiểm tra
	if(trim($TenAdmin) == "")
		ThongBaoLoi("Tên nhân viên không được bỏ trống!");
	elseif(trim($GioiTinh) == "")
		ThongBaoLoi("Giới tính không được bỏ trống!");
	elseif(trim($SDT) == "" || !(is_numeric($SDT)))
		ThongBaoLoi("Số điện thoại không được bỏ trống!");
	else
	{
		$sql = "update `tbladmin` 
				SET `TenAdmin` = '$TenAdmin',
					`GioiTinh` = '$GioiTinh',
					`SDT` = $SDT
				WHERE `MaAdmin` = '$MaAdmin'";
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