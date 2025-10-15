<h3>Đổi mật khẩu</h3>
<form action="index.php?do=khachhang_doimatkhau_xuly" method="post">
	<table class="Form">
		<input type="hidden" value="<?php echo $_GET['id']; ?>" name="MaKH" />
		<tr>
			<td>Mật khẩu cũ:</td>
			<td><input type="password" name="MatKhauCu" /></td>
		</tr>
		<tr>
			<td>Mật khẩu mới:</td>
			<td><input type="password" name="MatKhauMoi" /></td>
		</tr>
		<tr>
			<td>Xác nhận mật khẩu mới:</td>
			<td><input type="password" name="XacNhanMatKhauMoi" /></td>
		</tr>
	</table>
	
	<input type="submit" value="Cập nhật mật khẩu" />
</form>