<?php
	if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
	
	include_once "cauhinh.php";
	
	include_once "thuvien.php";
		
	$sql_th= "select distinct TenNCC from tblnhacungcap ";
	$danhsach1= $connect->query($sql_th);
	if (!$danhsach1) {
		die("Không thể thực hiện câu lệnh SQL: " . $connect->error);
		exit();
	}
	
	$sql_sp1= "select distinct LoaiSP from tblsanpham where LoaiSP like 'Áo%' ";
	$danhsach2= $connect->query($sql_sp1);
	if (!$danhsach2) {
		die("Không thể thực hiện câu lệnh SQL: " . $connect->error);
		exit();
	}
	
	$sql_sp2= "select distinct LoaiSP from tblsanpham where LoaiSP like 'Quần%' ";
	$danhsach3= $connect->query($sql_sp2);
	if (!$danhsach3) {
		die("Không thể thực hiện câu lệnh SQL: " . $connect->error);
		exit();
	}

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Shop ban quan ao</title>
		<meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" href="css/style1.css?v=7" />
		<script type="text/javascript" src="script/banner.js"></script>
		<script type="text/javascript" src="scripts/jquery-1.4.1.js"></script>
		<script type="text/javascript" src="scripts/ckeditor/ckeditor.js"></script>
		<script type="text/javascript" src="scripts/ckfinder/ckfinder.js"></script>
		
	</head>
	<body >
		<div id="TrangWeb">
			<div id="PhanDau">
				<img name ="myimage" src="image/banner1.png" />
			</div>
			<div id="PhanMenu1">
				<?php
						//hiện menu quản lý
						if(!isset($_SESSION['MaKH']))
						{
							echo '<div class="Menu"> <a href="index.php?do=home"> Trang Chủ</a> </div>'	;		
							echo '<div class="Menu"> <a href="https://www.elle.vn/thoi-trang"> Tin tức </a> </div>';
							echo '<div class="Menu"> <a href="index.php?do=trogiup"> Trợ giúp </a> </div>';
							echo '	<div class="Menu1"> 
										<form action="index.php?do=search_xuly" method="post"> 
											Tìm kiếm: <input type="text" name="search" />
											<input type="submit" name="ok" value="Tìm" />
										</form>
									</div>';

							echo '<div class="Menu1"> <a href="index.php?do=dangnhap"> Đăng nhập </a></div>';
							echo '<div class="Menu"> <a href="index.php?do=dangky"> Đăng ký</a> </div>';
						}
						else
						{
							echo '<div class="Menu"> <a href="index.php?do=home"> Trang Chủ</a> </div>';
							echo '<div class="Menu"> <a href="https://www.elle.vn/thoi-trang"> Tin tức </a> </div>';
							echo '<div class="Menu"> <a href="index.php?do=trogiup"> Trợ giúp </a></div>';
							echo '	<div class="Menu1"> 
										<form action="index.php?do=search_xuly" method="post">
											Tìm kiếm: <input type="text" name="search" />
											<input type="submit" name="ok" value="Tìm" />
										</form>
									</div>';
									
							echo "<div class='Menu1'>" .$_SESSION['HoTen']. "&nbsp; || &nbsp; <a href='index.php?do=dangxuat'>Đăng xuất </a></div>";
							echo '<div class="Menu"> <a href="index.php?do=giohang1"> Giỏ hàng</a> </div>';
						}
				?>
			</div>

			<div id="Giua">
				<div id="BenTrai">
					<div class="filter-container">
						<form action="index.php?do=loc_sanpham" method="post">
							<?php
								echo '<div class="filter">';
									echo '<h3>Thương hiệu</h3>';
									while ($row1 = $danhsach1->fetch_array(MYSQLI_ASSOC))
									{
										echo '<label><input type="checkbox" name="ThuongHieu[]" value="' .$row1['TenNCC']. '">' .$row1['TenNCC']. '</label><br>';
									}
								echo '</div>';
								
								echo '<div class="filter">';
									echo '<h3>Áo</h3>';
									while ($row2 = $danhsach2->fetch_array(MYSQLI_ASSOC))
									{
										echo '<label><input type="checkbox" name="LoaiAo[]" value="' .$row2['LoaiSP']. '">' .$row2['LoaiSP']. '</label><br>';
									}
								echo '</div>';
								
								echo '<div class="filter">';
									echo '<h3>Quần</h3>';
									while ($row3 = $danhsach3->fetch_array(MYSQLI_ASSOC))
									{
										echo '<label><input type="checkbox" name="LoaiQuan[]" value="' .$row3['LoaiSP']. '">' .$row3['LoaiSP']. '</label><br>';
									}
								echo '</div><br>';

								echo '<input type="submit" value="Lọc" />';
							?>
						</form>
					</div>
					
				</div>	
				
				<div id="PhanGiua">
					<?php
						
						$do = isset($_GET['do']) ? $_GET['do'] : "home";
						
						include $do . ".php";
					?>
					
					
					
				</div>
			</div>
				
				
			<div id="PhanCuoi">
				<table class="TBCuoiTrang">
					<tr id="TieuDeTB">
						<td>Thông tin cửa hàng</td>
						<td>Chính sách khách hàng</td>
						<td>Công ty</td>
					</tr>
					<tr>
						<td>Địa chỉ: số 18, đường Ung Văn Khiêm, Long Xuyên,An Giang </td>
						<td>Chính sách KH thân thiết</td>
						<td>Tuyển dụng và việc làm</td>
					</tr>
					<tr>
						<td>SĐT: 0123456789</td>
						<td>Chính sách bảo hành</td>
						<td>Tin tức thời trang</td>
					</tr>
					<tr>

						<td>Email:<a href="mailto:khang_dth225677@student.agu.edu.vn">khang_dth225677@student.agu.edu.vn</a> </td>
						<td>Chính sách bảo mật</td>
						<td>Chăm sóc khách hàng</td>
					</tr>
				</table>
				
			</div>
		</div>
	</body>
</html>