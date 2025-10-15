<!DOCTYPE html>
<html>
	<head>
		<title>Shop quan ao</title>
		<meta charset="utf-8" />
	</head>
	<body>
		
		
<?php
	if(isset($_GET["limit_home"]) == true)
		{
			$_SESSION['limit_home'] += 6;
		}
		else
		{
			$_SESSION['limit_home'] = 12;
		}
		$limit_home_ok =  $_SESSION['limit_home'];
		
		

		$sql = "select t.MaSP, t.TenSP, t.HinhAnh, t.DonGia,t.LoaiSP, t.SoLuongSP, t.MoTa, t.KhuyenMai, l.MaNCC, l.TenNCC
		from (tblnhacungcap l inner join tblsanpham t on t.MaNCC=l.MaNCC)order by KhuyenMai DESC Limit 0,".$limit_home_ok;		
		
		$danhsach = $connect->query($sql);
		//Nếu kết quả kết nối không được thì xuất báo lỗi và thoát
		if (!$danhsach) {
			die("Không thể thực hiện câu lệnh SQL: " . $connect->error);
			exit();
		}
		
		$sql1 = "select * from (tblnhacungcap l inner join tblsanpham t on t.MaNCC=l.MaNCC)";
		$danhsach2 = $connect->query($sql1);
		$count_kq = mysqli_num_rows($danhsach2);
		
		
		while ($row = $danhsach->fetch_array(MYSQLI_ASSOC)) 		
		{				
			$giaban = $row['DonGia'] - (($row['KhuyenMai'] /100) * $row['DonGia']);
			echo "<div class='khungsanpham'>";
				echo "<div class='khunganh'>";					
					echo "<a href='index.php?do=sanpham_chitiet&id_sp=" . $row['MaSP'] . "&id_nsx=" . $row['MaNCC'] . "&id_loai=" . $row['LoaiSP'] . " '>";
					//-----------------------------css
						echo "<img  src=" . $row["HinhAnh"] . "  style='width: 300px; height: 300px;'>";						
					echo "</a>";
				echo "</div>";
				echo "<div class='khungtext'>";	
					//-----------------------------css
					echo "<span class=\"khuyenmai\"> Khuyến mãi:". $row['KhuyenMai'] ." %. Từ </span><span class=\"dongia\">". number_format($row['DonGia'])." $</span>";
					//-----------------------------css--------------------
					echo "<br /></span><span class=\"giaban\">Còn:  ". number_format($giaban)." $</span>";
					echo "<p><a  href='index.php?do=sanpham_chitiet&id_sp=" . $row['MaSP'] . "&id_nsx=" . $row['MaNCC'] . "&id_loai=" . $row['LoaiSP'] . "'>" . $row['TenSP'] . "</a></p>";
				echo "</div>";
				
				
			echo "</div>";
			
		}

		if($count_kq > $_SESSION['limit_home'])
		{
			echo "<div style='clear: both;'></div>";
			//-----------------------------css--------------------
			echo "<h3 ><a href='index.php?do=home&limit_home=ok'>Xem thêm các sản phẩm khác</a></h3></td>";
		
		}
?>

		
	</body>
</html>