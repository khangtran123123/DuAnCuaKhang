<?php
	// Lấy thông tin từ FORM 
	$MaSanPham = $_POST['MaSanPham'];
	$MaNhaCungCap = $_POST['MaNhaCungCap'];
	$LoaiSP = $_POST['LoaiSP'];
	$TenSanPham = $_POST['TenSanPham'];
	$MoTa = $_POST['MoTa'];
	$DonGia = $_POST['DonGia'];
	$SoLuong = $_POST['SoLuong'];
	$KhuyenMai = $_POST['KhuyenMai'];	
	$NgayNhap = $_POST['NgayNhap'];
	// Kiểm tra
	if(trim($MaNhaCungCap) == "")
		ThongBaoLoi("Chưa chọn nhà sản xuất!");
	elseif(trim($TenSanPham) == "")
		ThongBaoLoi("Tên sản phẩm không được bỏ trống!");
	elseif(trim($LoaiSP) == "")
		ThongBaoLoi("Loại sản phẩm không được bỏ trống!");
	elseif(trim($MoTa) == "")
		ThongBaoLoi("Mô tả không được bỏ trống!");
	elseif(trim($DonGia) == "" || !(is_numeric($DonGia)))
		ThongBaoLoi("Đơn giá không được bỏ trống!");
	elseif(trim($SoLuong) == "" || !(is_numeric($SoLuong)))
		ThongBaoLoi("Số lượng không được bỏ trống!");
	elseif(trim($KhuyenMai) == "" || !(is_numeric($KhuyenMai)))
		ThongBaoLoi("Khuyến mãi không được bỏ trống!");
	elseif(trim($LoaiSP) == "")
		ThongBaoLoi("Ngày nhập không được bỏ trống!");
	else
	{	
		$sql = "update	tblsanpham
				SET		TenSP = '$TenSanPham',
						LoaiSP = '$LoaiSP',
						MaNCC = '$MaNhaCungCap',
						MoTa = '$MoTa',
						DonGia = $DonGia,
						SoLuongSP = $SoLuong,
						KhuyenMai = $KhuyenMai,
						NgayNhap = '$NgayNhap'
				WHERE	MaSP = '$MaSanPham'";
		
		$danhsach = $connect->query($sql);
		//Nếu kết quả kết nối không được thì xuất báo lỗi và thoát
		if (!$danhsach) {
			die("Không thể thực hiện câu lệnh SQL: " . $connect->error);
			exit();
		}
		else
		{
			ThongBao("Chỉnh sửa bài viết thành công!");
		}		
		
	}
?>