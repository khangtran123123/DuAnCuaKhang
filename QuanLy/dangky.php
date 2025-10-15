<h3>Đăng ký</h3>
<form action="index.php?do=dangky_xuly" method="post">
	<table class="Form">
		<tr>
			<td>Họ và tên:</td>
			<td><input type="text" name="HoVaTen" /></td>
		</tr>
		<tr>
			<td>Tên đăng nhập:</td>
			<td><input type="text" name="TenDangNhap" /></td>
		</tr>
		<tr>
			<td>Mật khẩu:</td>
			<td><input type="password" name="MatKhau" /></td>
		</tr>
		<tr>
			<td>Xác nhận mật khẩu:</td>
			<td><input type="password" name="XacNhanMatKhau" /></td>
		</tr>
		<tr>
			<td>Giới tính:</td>
			<td>
				<select name="GioiTinh">
					<option value="nam">Nam</option>
					<option value="nu">Nữ</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>Số điện thoại:</td>
			<td><input type="text" name="SDT" /></td>
		</tr>
	</table>
	
	<input type="submit" value="Đăng ký" />
</form>