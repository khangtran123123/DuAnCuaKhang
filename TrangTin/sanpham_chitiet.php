<?php
	
	$MaSP = $_GET['id_sp'];
	
	$sql = "SELECT * 
        FROM tblsanpham A 
        INNER JOIN tblnhacungcap B ON A.MaNCC = B.MaNCC 
        WHERE A.MaSP = '$MaSP'";
	
	$danhsach = $connect->query($sql);
	//Nếu kết quả kết nối không được thì xuất báo lỗi và thoát
	if (!$danhsach) {
		die("Không thể thực hiện câu lệnh SQL: " . $connect->connect_error);
		exit();
	}
	
	$dong = $danhsach->fetch_array(MYSQLI_ASSOC);

	$giaban = $dong['DonGia'] - (($dong['KhuyenMai'] /100) * $dong['DonGia']);
?>

<table>
	<tr> 
		<td>
			<div class="anhchitiet"><?php echo    "<img src=" . $dong["HinhAnh"] . " style='width: 300px; height: 400px;' >"; ?></divv>				
		</td>
		<td width=400px>
			<h3><?php echo $dong['TenSP']; ?></h3>			
			<p class="TomTat">Nhà cung cấp: <?php echo $dong['TenNCC']; ?></p>
			<p class="TomTat">Mã sản phẩm: <?php echo $dong['MaSP']; ?></p>
			<p class="TomTat">Tỉ lệ giảm giá: <?php echo $dong['KhuyenMai']; ?> %</p>
			<p class="TomTat">Giá gốc:<span class="dongia"><?php echo number_format($dong['DonGia']); ?> $</span></p>
			<p class="TomTat">Giá bán: <span class="giaban"><?php echo number_format($giaban); ?> $</p>
			<p class="TomTat">Số lượng: <?php echo $dong['SoLuongSP']; ?></p>
			<h3 > Thông tin sản phẩm:</h2>
			<p class="TomTat"> <?php echo $dong['MoTa']; ?></p>
			
		</td>	
		<td>
			<form method="POST" action="index.php?do=giohang1">		
				<input type="hidden" name="MaSP" value="<?php echo $MaSP; ?>">
				<input type="submit" name="NutThem" value ='Thêm vào giỏ hàng'/>
			</form><br/>
			<form method="POST" action="index.php?do=giohang1">							
				<input type="hidden" name="MaSP" value="<?php echo $MaSP; ?>">
				<input type="submit" name="NutMua" value ='Mua'/>
			</form>
		</td>
	</tr>
	
</table>
<div> 
		<h2> Một số sản phẩm tương tự:</h3>
		
</div>

<?php
	if(isset($_GET["limit"]) == true)
		{
			$_SESSION['limit'] += 3;
		}
		else
		{
			$_SESSION['limit'] = 6;
		}
		$limit_ok =  $_SESSION['limit'];
		
		$MaSP = $_GET['id_sp'];		
		$LoaiSP = $_GET['id_loai'];
		$IdNhaSanXuat = $_GET["id_nsx"];

		$sql1 =  "select * from tblnhacungcap where LoaiSP = '" . $LoaiSP . "' and MaNCC='" . $IdNhaSanXuat . "'"; 
		$danhsach1 = $connect->query($sql1);
		
    
        $sql2 =  "select * from tblsanpham where LoaiSP = '" . $LoaiSP . "' and MaNCC='" . $IdNhaSanXuat . "' ORDER by MaSP DESC  LIMIT 0, ".$limit_ok; 
		
		$danhsach = $connect->query($sql2);
		
		//Nếu kết quả kết nối không được thì xuất báo lỗi và thoát
		if (!$danhsach) {
			die("Không thể thực hiện câu lệnh SQL: " . $connect->connect_error);
			exit();
		}
		$sql3 =  "select * from tblsanpham where LoaiSP = '" . $LoaiSP . "' and  MaNCC='" . $IdNhaSanXuat . "'"; 
		$danhsach2 = $connect->query($sql3);
		$count_sp = mysqli_num_rows($danhsach2);

		
		while ($row = $danhsach->fetch_array(MYSQLI_ASSOC)) 		
		{				
			$giaban = $row['DonGia'] - (($row['KhuyenMai'] /100) * $row['DonGia']);
			echo "<div class='khungsanpham'>";
				echo "<div class='khunganh'>";					
					echo "<a href='index.php?do=sanpham_chitiet&id_sp=" . $row['MaSP'] . "&id_nsx=" . $row['MaNCC'] . "&id_loai=" . $row['LoaiSP'] . " '>";
					//-----------------------------css
						echo "<img class='hinhanhphim' src=" . $row["HinhAnh"] . "  style='width: 300px; height: 300px;'>";						
					echo "</a>";
				echo "</div>";
				echo "<div class='khungtext'>";	
					//-----------------------------css
					echo "<span class=\"khuyenmai\"> Khuyến mãi:". $row['KhuyenMai'] ." %. Từ </span><span class=\"dongia\">". number_format($row['DonGia'])." $</span>";
					//-----------------------------css--------------------
					echo "<br /></span><span class=\"giaban\">Còn:  ". number_format($giaban)." $</span>";
					echo "<p><a  href='index.php?do=sanpham_chitiet&id_sp=" . $row['MaSP'] . " &id_nsx=" . $row['MaNCC'] . " &id_loai=" . $row['LoaiSP'] . " '>" . $row['TenSP'] . "</a></p>";
				echo "</div>";
				
				
			echo "</div>";
			
		}

		if($count_sp > $_SESSION['limit'])
		{
			//-----------------------------css--------------------
			//echo "<h3 class=\"xemthem\"><a href='index.php?do=sanpham_chitiet&id_sp="'$MaSP'"&id_nsx="'$IdNhaSanXuat'"&id_loai="'$LoaiSP'"&limit=ok'>Xem thêm các sản phẩm khác</a></h3></td>";
			echo "<h3 class=\"xemthem\"><a href='index.php?do=sanpham_chitiet&id_sp=" . $MaSP . "&id_nsx=" . $IdNhaSanXuat . "&id_loai=" . $LoaiSP . "&limit=ok'>Xem thêm các sản phẩm khác</a></h3>";

		}
?>
