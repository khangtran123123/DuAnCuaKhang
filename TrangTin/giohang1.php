<?php
					if(!isset($_SESSION)) 
					{ 
						session_start(); 
					} 
	
					include_once "cauhinh.php";
	
					include_once "thuvien.php";
					
				
					
					
					if(!isset($_SESSION['MaKH']))
					{
						header( "Location: index.php?do=dangnhap");
						exit();
					}
					else
					{
					
					
					
						// Tạo giỏ hàng nếu chưa có
						if (!isset($_SESSION['cart'])) {
							$_SESSION['cart'] = array();
							
						}

								// Xử lý thêm sản phẩm
						if (isset($_POST['MaSP']) && !isset($_GET['action'])) {
							$MaSP = $_POST['MaSP'];

							if (isset($_SESSION['cart'][$MaSP])) {
								$_SESSION['cart'][$MaSP]['soluong'] += 1;
							} else {
								$sql = "SELECT * FROM tblsanpham WHERE MaSP = '$MaSP'";
								$result = $connect->query($sql);
								if ($result && $row = $result->fetch_array(MYSQLI_ASSOC)) {
									$giaban = $row['DonGia'] - ($row['KhuyenMai'] / 100) * $row['DonGia'];
									$_SESSION['cart'][$MaSP] = array(
										'TenSP' => $row['TenSP'],
										'HinhAnh' => $row['HinhAnh'],
										'DonGia' => $row['DonGia'],
										'KhuyenMai' => $row['KhuyenMai'],
										'GiaBan' => $giaban,
										'soluong' => 1,
										'SoLuongTonKho' => $row['SoLuongSP']
									);
									$_SESSION['last_product'] = array(
										'MaSP' => $row['MaSP'],
										'MaNCC' => $row['MaNCC'],
										'LoaiSP' => $row['LoaiSP']
									);
								}
								else {
									echo "<script>alert('Sản phẩm đã hết hàng');</script>";
								}
							}
						}
						

						
						if (isset($_POST['NutThem']) && isset($_SESSION['last_product'])) {
							$sp = $_SESSION['last_product'];
							header("Location: index.php?do=sanpham_chitiet&id_sp={$sp['MaSP']}&id_nsx={$sp['MaNCC']}&id_loai={$sp['LoaiSP']}");
							exit();
						}
						
						// Xử lý tăng/giảm/xóa
						if (isset($_GET['action']) && isset($_GET['MaSP'])) {
							$MaSP = $_GET['MaSP'];

							if ($_GET['action'] == 'tang') {
								$sql = "SELECT SoLuongSP FROM tblsanpham WHERE MaSP = '$MaSP'";
								$result = $connect->query($sql);
								if ($result && $row = $result->fetch_array(MYSQLI_ASSOC)) {
									$soluongton = $row['SoLuongSP'];
									if ($_SESSION['cart'][$MaSP]['soluong'] < $soluongton) {
										$_SESSION['cart'][$MaSP]['soluong']++;
									} else {
										echo "<script>alert('Không thể thêm nữa. Số lượng tồn kho chỉ còn $soluongton sản phẩm');</script>";
									}
								}
								
							}
							elseif ($_GET['action'] == 'giam') {
								if ($_SESSION['cart'][$MaSP]['soluong'] ==1) {
									unset($_SESSION['cart'][$MaSP]);
								}
								else{
									$_SESSION['cart'][$MaSP]['soluong']--;
								}
							} elseif ($_GET['action'] == 'xoa') {
								unset($_SESSION['cart'][$MaSP]);
							}
						}
						
						//Hien thi danh sach san pham trong gio hang
						echo '<h3 > Giỏ hàng của bạn </h3>';

						if (!empty($_SESSION['cart'])) {
							
							echo "<table border=1px";
							echo "<tr><th width=130px>Ảnh</th><th width=400px>Tên SP</th><th width=100px>Giá bán</th><th width=80px>Số lượng</th><th width=100px>Thành tiền</th><th width=50px>Thao tác</th></tr>";

							$tongtien = 0;

							foreach ($_SESSION['cart'] as $MaSP => $item) {
								$thanhtien = $item['GiaBan'] * $item['soluong'];
								$tongtien += $thanhtien;
								echo "<tr>";
								echo "<td><img src='{$item['HinhAnh']}' width='130' height='130'></td>";
								echo "<td>{$item['TenSP']}</td>";
								echo "<td>" . number_format($item['GiaBan']) . " $</td>";
								echo "<td>
										<a href='index.php?do=giohang1&action=giam&MaSP=" .$MaSP. "'>-</a>
										{$item['soluong']}
										<a href='index.php?do=giohang1&action=tang&MaSP=" .$MaSP. "'>+</a>
									  </td>";
								echo "<td>" . number_format($thanhtien) . " $</td>";
								echo "<td><a href='index.php?do=giohang1&action=xoa&MaSP=" .$MaSP. "'>Xóa</a></td>";
								echo "</tr>";
															
							}
								echo "<tr>";
									echo "<td colspan='4' style='text-align:right;'>Tổng cộng:</td>";
									echo "<td><span class=\"giaban\">" . number_format($tongtien) . " $</span></td>";
									echo "<td></td>";
								echo "</tr>";

							echo "</table>";
							echo "<form method='post'>";
								echo "</br> <div class=\"thanhtoan\"><input type='submit' name='thanhtoan' value='Thanh toán' /> </div>";
							echo "</form>";
						} else {
							echo "</br><p>Giỏ hàng đang trống!</p>";
						}
						
						
						
						// Xử lý khi nhấn nút Thanh toán
						if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['thanhtoan'])) 
						{
							foreach ($_SESSION['cart'] as $MaSP => $item) 
							{
								$soLuongMua = $item['soluong'];
								$sqlUpdate = "UPDATE tblsanpham 
											  SET SoLuongSP = SoLuongSP - $soLuongMua 
											  WHERE MaSP = '$MaSP' AND SoLuongSP >= $soLuongMua";
								$connect->query($sqlUpdate);
								if(!$connect)
								{
									die("Không thể thực hiện câu lệnh SQL: " . $connect->error);
									exit();
								}
							}
							
							// Tự động tạo MaHD mới (dạng HD001, HD002, ...)
							$sql_max = "SELECT MaHD FROM tblhoadon ORDER BY MaHD DESC LIMIT 1";
							$result_max = $connect->query($sql_max);	
							
							if ($result_max && $row = $result_max->fetch_assoc()) 
							{
								$lastMa = $row['MaHD'];
								$number = intval(substr($lastMa, 2)) + 1;
								$MaHD = "HD" . str_pad($number, 3, "0", STR_PAD_LEFT);
							} 
							else 
							{
								$MaHD = "HD001";
							}
							$ngayban= date("Y-m-d");
							$sql_themhd= "insert into `tblhoadon`(`MaHD`, `MaKH`, `TongTien`, `NgayBan`) values ('$MaHD', '" .$_SESSION['MaKH']. "', '$tongtien', '$ngayban')";
							$themhd= $connect->query($sql_themhd);
							if (!$themhd) 
							{
								die("Không thể thực hiện câu lệnh SQL: " . $connect->error);
								exit();
							}
							else
							{
								foreach ($_SESSION['cart'] as $MaSP => $item)
								{
									$thanhtien = $item['GiaBan'] * $item['soluong'];
									$sql_themcthd= "insert into `tblchitiethoadon`(`MaHD`, `MaSP`, `SoLuong`, `DonGia`, `ThanhTien`) values('$MaHD', '$MaSP', '$soLuongMua', '" .$item['GiaBan']. "', '$thanhtien')";
									$themcthd=$connect->query($sql_themcthd);
									if (!$themcthd) 
									{
										die("Không thể thực hiện câu lệnh SQL: " . $connect->error);
										exit();
									}
								}
							}
							$_SESSION['cart'] = array(); // Giỏ hàng trống
							echo "<script>
								alert('Thanh toán thành công!');
								window.location = 'index.php?do=giohang1';
							</script>";
							exit(); // Ngăn chạy phần HTML bên dưới
						}
					}
					
?>
