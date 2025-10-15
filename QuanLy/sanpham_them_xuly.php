<?php
	// Lấy thông tin từ FORM
	$MaSanPham = $_POST['MaSP'];
	$TenSanPham = $_POST['TenSP'];
	$LoaiSanPham = $_POST['LoaiSP'];
	$MaNhaCungCap = $_POST['MaNCC'];
	$MoTa = $_POST['MoTa'];	
	$DonGia = $_POST['DonGia'];
	$SoLuong = $_POST['SoLuong'];
	$KhuyenMai = $_POST['KhuyenMai'];
	$NgayNhap = $_POST['NgayNhap'];
	
	// Kiểm tra
	if(trim($MaSanPham) == "")
		ThongBaoLoi("Mã sản phẩm không được bỏ trống!");
	elseif(trim($MaNhaCungCap) == "")
		ThongBaoLoi("Chưa chọn nhà sản xuất!");
	elseif(trim($TenSanPham) == "")
		ThongBaoLoi("Tên sản phẩm không được bỏ trống!");
	elseif(trim($LoaiSanPham) == "")
		ThongBaoLoi("Loại sản phẩm không được bỏ trống!");
	elseif(trim($MoTa) == "")
		ThongBaoLoi("Mô tả không được bỏ trống!");
	elseif(trim($KhuyenMai) == "" || !(is_numeric($KhuyenMai)))
		ThongBaoLoi("Khuyến mãi không được bỏ trống và phải là số!");
	elseif(trim($DonGia) == "" || !(is_numeric($DonGia)))
		ThongBaoLoi("Đơn giá không được bỏ trống và phải là số!");
	elseif(trim($SoLuong) == "" || !(is_numeric($SoLuong)))
		ThongBaoLoi("Số lượng không được bỏ trống và phải là số!");
	
	else
	{
		//Lưu tập tin upload vào thư mục hinhanh
		$target_path = "images/";
		$target_path1 = "../QuanLy/images/";
		 
		$target_path = $target_path . basename($_FILES['HinhAnh']['name']);
		$target_path1 = $target_path1 . basename($_FILES['HinhAnh']['name']);
		
		
		if (move_uploaded_file($_FILES['HinhAnh']['tmp_name'], $target_path))
		{
			echo "";
			//echo "Tập tin " . basename($_FILES['HinhAnh']['name']) . " đã được upload.<br/>";			
		}
			
		else
			echo "Tập tin upload không thành công.<br/>";		
		
		copy($target_path, $target_path1);
		

		$MaAdmin = $_SESSION['MaAdmin'];
				
		
		$sql = "insert into `tbl_sanpham`(`MaSP`, `TenSP`, `LoaiSP`, `MaNCC`, `HinhAnh`, `DonGia`, `MoTa`, `SoLuong`, `KhuyenMai`, `NgayNhap`)
				VALUES ('$MaSanPham', '$TenSanPham', $LoaiSanPham, $MaNhaCungCap,'$target_path', $DonGia, '$MoTa', $SoLuong, $KhuyenMai, getdate())";
		
		$danhsach = $connect->query($sql);
		//Nếu kết quả kết nối không được thì xuất báo lỗi và thoát
		if (!$danhsach) {
			die("Không thể thực hiện câu lệnh SQL: " . $connect->connect_error);
			exit();
		}
		else
		{
			ThongBao("Thêm sản phẩm thành công!");
		}
		
		
		
	}
?>