<?php
	//session_set_cookie_params(30); // 1800 giây = 30 phút
	session_start();
	
	
	include_once "cauhinh.php";
	
	include_once "thuvien.php";
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Trang Tin Điện Tử</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" href="css/style.css?v=2" />
		<script src="scripts/ckeditor/ckeditor.js"></script>
	</head>
	<body>
		<div id="TrangWeb">
			<div id="PhanDau">
				<?php
					if(isset($_SESSION['MaAdmin']) && isset($_SESSION['HoTen']))
					{
						echo "<br><br><br><br><br>Xin chào ".$_SESSION['HoTen']." &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;";
					}
				?>				
			</div>
			<div id="PhanGiua">
				<div id="BenTrai">
					<?php
						//hiện menu quản lý
						if(!isset($_SESSION['MaAdmin']))
						{
							echo '<h3>Quản lý</h3>';
								echo '<ul>';
									echo '<li><a href="index.php?do=dangnhap">Đăng nhập</a></li>';
									echo '<li><a href="index.php?do=dangky">Đăng ký</a></li>';
								echo '</ul>';
						}
						else
						{
							echo '<h3>Quản lý</h3>';
							echo '<ul>';						
								echo '<li><a href="index.php?do=sanpham_them">Thêm sản phẩm</a></li>';
									
								if($_SESSION['QuyenAdmin'] == 1)
								{
									echo '<li><a href="index.php?do=nhacungcap">Danh sách nhà cung cấp </a></li>';
									echo '<li><a href="index.php?do=sanpham">Danh sách sản phẩm</a></li>';
									echo '<li><a href="index.php?do=hoadon">Danh sách hóa đơn</a></li>';
									echo '<li><a href="index.php?do=nguoidung">Danh sách nhân viên</a></li>';
									echo '<li><a href="index.php?do=khachhang">Danh sách khách hàng</a></li>';
								}
								else
								{
									echo '<li><a href="index.php?do=nhacungcap">Danh sách nhà cung cấp </a></li>';
									echo '<li><a href="index.php?do=sanpham">Danh sách sản phẩm</a></li>';
									echo '<li><a href="index.php?do=hoadon">Danh sách hóa đơn</a></li>';
									echo '<li><a href="index.php?do=khachhang">Danh sách khách hàng</a></li>';
								}
							echo '</ul>';
						}


						//hiện menu hồ sơ cá nhân					
						if(isset($_SESSION['MaAdmin']))
						{
							echo '<h3>Hồ sơ cá nhân</h3>';
							echo '<ul>';						
								echo "<li><a href='index.php?do=hosocanhan'>Hồ sơ cá nhân</a></li>";
								echo "<li><a href='index.php?do=doimatkhau&id=" . $_SESSION['MaAdmin'] . "'>Đổi mật khẩu</a></li>";
								echo "<li><a href='index.php?do=dangxuat'>Đăng xuất</a>".'&nbsp;&nbsp;';
							echo '</ul>';
						}								
					?>
				</div>
				
				<div id="BenPhai">
					<?php
						$do = isset($_GET['do']) ? $_GET['do'] : "home";
						
						include $do . ".php";
					?>
				</div>
			</div>
			<div id="PhanCuoi">
				<div class="lienhe">Liên hệ: tva@agu.edu.vn </div>
			</div>
		</div>
	</body>
</html>