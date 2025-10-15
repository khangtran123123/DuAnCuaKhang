<?php
	$MaSP = $_GET['id'];
	
	$sql = "select * from `tblsanpham` where MaSP = '$MaSP'";
	
	$danhsach = $connect->query($sql);
	//Nếu kết quả kết nối không được thì xuất báo lỗi và thoát
	if (!$danhsach) {
		die("Không thể thực hiện câu lệnh SQL: " . $connect->connect_error);
		exit();
	}
	
	$dong = $danhsach->fetch_array(MYSQLI_ASSOC)
?>

<h3>Sửa sản phẩm</h3>
<form action="index.php?do=sanpham_sua_xuly" method="post">
	<table class="Form">
		
		<input type="hidden" name="MaSanPham" value="<?php echo $dong['MaSP']; ?>" />
		<tr>
			<td>
				<span class="MyFormLabel">Tên sản phẩm:</span>
				<input type="text" name="TenSanPham" value="<?php echo $dong['TenSP']; ?>" />
			</td>
		</tr>
		<tr>
			<td>
				<span class="MyFormLabel">Nhà cung cấp:</span>
				<select name="MaNhaCungCap">
					<option value="">-- Chọn --</option>
					<?php
						$sql = "select * from `tblnhacungcap` where 1 ORDER BY TenNCC";
						$danhsach = $connect->query($sql);
						//Nếu kết quả kết nối không được thì xuất báo lỗi và thoát
						if (!$danhsach) {
							die("Không thể thực hiện câu lệnh SQL: " . $connect->connect_error);
							exit();
						}
						
						while($dong_ncc = $danhsach->fetch_array(MYSQLI_ASSOC))
						{
							if($dong['MaNCC'] == $dong_ncc['MaNCC'])
								echo "<option value='" . $dong_ncc['MaNCC'] . "' selected='selected'>" . $dong_ncc['TenNCC'] . "</option>";
							else
								echo "<option value='" . $dong_ncc['MaNCC'] . "'>" . $dong_ncc['TenNCC'] . "</option>";
						}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td>
				<span class="MyFormLabel">Loại sản phẩm</span>
				<input type="text" name="LoaiSP" value="<?php echo $dong['LoaiSP']; ?>" />
			</td>
		</tr>
		
		<tr>
			<td>
				<span class="MyFormLabel">Đơn giá</span>
				<input type="text" name="DonGia" value="<?php echo $dong['DonGia']; ?>" />
			</td>
		</tr>
		
		<tr>
			<td>
				<span class="MyFormLabel">Số lượng</span>
				<input type="text" name="SoLuong" value="<?php echo $dong['SoLuongSP']; ?>" />
			</td>
		</tr>
		
		<tr>
			<td>
				<span class="MyFormLabel">Khuyến mãi</span>
				<input type="text" name="KhuyenMai" value="<?php echo $dong['KhuyenMai']; ?>" />
			</td>
		</tr>
		
		<tr>
			<td>
				<span class="MyFormLabel">Ngày nhập</span>
				<input type="date" name="NgayNhap" value="<?php echo $dong['NgayNhap']; ?>" />
			</td>
		</tr>
		
		<tr>
			<td>
				<span class="MyFormLabel">Mô tả:</span>
				<textarea name="MoTa" id="MoTa"><?php echo $dong['MoTa']; ?></textarea>
				<script type="text/javascript">
					var editor = CKEDITOR.replace('MoTa');
					
					CKFinder.setupCKEditor(editor, '/trangtin_v0.6/scripts/ckfinder/');
				</script>
			</td>
		</tr>
		
	</table>
	
	<input type="submit" value="Cập nhật" />
</form>