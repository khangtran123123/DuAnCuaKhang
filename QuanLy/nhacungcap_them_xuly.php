<?php
	// Lấy thông tin từ FORM
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
		$sql_kiemtra = "SELECT * FROM tblnhacungcap where TenNCC = '$TenNCC'";
		$danhsach = $connect->query($sql_kiemtra);

		if ($danhsach && $danhsach->num_rows == 0) 
		{

			// Tự động tạo MaNCC mới (dạng CC001, CC002, ...)
			$sql_max = "SELECT MaNCC FROM tblnhacungcap ORDER BY MaNCC DESC LIMIT 1";
			$result_max = $connect->query($sql_max);

			if ($result_max && $row = $result_max->fetch_assoc()) 
			{
				$lastMa = $row['MaNCC'];
				$number = intval(substr($lastMa, 2)) + 1;
				$MaNCC = "CC" . str_pad($number, 3, "0", STR_PAD_LEFT);
			} 
			else 
			{
				$MaNCC = "CC001"; // Nếu chưa có bản ghi nào
			}

			$sql = "INSERT INTO `tblnhacungcap`(`MaNCC`, `TenNCC`, `DiaChiNCC`, `SDTNCC`) VALUES ('$MaNCC', '$TenNCC', '$DiaChiNCC', '$SDTNCC')";
			$themncc = $connect->query($sql);
			//Nếu kết quả kết nối không được thì xuất báo lỗi và thoát
			if (!$themncc) 
			{
				die("Không thể thực hiện câu lệnh SQL: " . $connect->error);
				exit();
			}
			else
			{
				header("Location: index.php?do=nhacungcap");
			}	
		}
		else
		{
			ThongBaoLoi("Đã tồn tại nhà cung cấp !");
		}
		
	}
?>