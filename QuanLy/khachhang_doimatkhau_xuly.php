<?php
	$MaKH = $_POST['MaKH'];
	$MatKhauCu = $_POST['MatKhauCu'];
	$MatKhauMoi = $_POST['MatKhauMoi'];
	$XacNhanMatKhauMoi = $_POST['XacNhanMatKhauMoi'];
	if(trim($MatKhauCu) == "")
		ThongBaoLoi("Mật khẩu cũ không được bỏ trống!");
	elseif(trim($MatKhauMoi) == "")
		ThongBaoLoi("Mật khẩu mới không được bỏ trống!");	
	elseif($MatKhauMoi == $MatKhauCu)
		ThongBaoLoi("Mật khẩu mới phải khác mật khẩu cũ!");
	elseif($MatKhauMoi != $XacNhanMatKhauMoi)
		ThongBaoLoi("Xác nhận mật khẩu không đúng!");
	else	
	{
		$MatKhauCu= md5($MatKhauCu);
		$MatKhauMoi= md5($MatKhauMoi);
		$sql_kiemtra = "SELECT MatKhauKH FROM tblkhachhang WHERE MaKH = '$MaKH' and MatKhauKH = '$MatKhauCu'";
		$danhsach = $connect->query($sql_kiemtra);
		
		if($danhsach)
		{
			$sql= "update `tblkhachhang`
					SET `MatKhauKH` = '$MatKhauMoi'
					Where `MaKH` = '$MaKH'";
			$doimatkhau = $connect->query($sql);
			//Nếu kết quả kết nối không được thì xuất báo lỗi và thoát
			if (!$doimatkhau) 
			{
				die("Không thể thực hiện câu lệnh SQL: " . $connect->error);
				exit();
			}
			else
			{
				ThongBao("Chỉnh sửa thành công!");
			}
			
		}
		else
		{
			ThongBao("Mật khẩu cũ không đúng!");
		}
			
	}	
?>