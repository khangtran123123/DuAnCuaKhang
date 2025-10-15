<?php
	if(isset($_POST['ThuongHieu']))
	{
		$i=0;
		$ThuongHieu = $_POST['ThuongHieu'];
		foreach($ThuongHieu as $th)
		{
			$ThuongHieu[$i] = $th;
			$i++;
		}
	}	
	else
	{	
		$ThuongHieu=null;
	}
	if(isset($_POST['LoaiQuan']))
	{
		$i=0;
		$LoaiQuan = $_POST['LoaiQuan'];
		foreach($LoaiQuan as $lq)
		{
			$LoaiQuan[$i] = $lq;
			$i++;
		}
	}
	else
	{	
		$LoaiQuan=null;
	}
	if(isset($_POST['LoaiAo']))
	{
		$i=0;
		$LoaiAo = $_POST['LoaiAo'];
		foreach($LoaiAo as $la)
		{
			$LoaiAo[$i] = $la;
			$i++;
		}
	}
	else
	{	
		$LoaiAo=null;
	}
	
	if($ThuongHieu==null and $LoaiQuan==null and $LoaiAo==null)
	{
		$sql = "select t.MaSP, t.TenSP, t.HinhAnh, t.DonGia,t.LoaiSP, t.SoLuongSP, t.MoTa, t.KhuyenMai, l.MaNCC, l.TenNCC
				from (tblnhacungcap l inner join tblsanpham t on t.MaNCC=l.MaNCC)";	
		
		$danhsach = $connect->query($sql);
		//Nếu kết quả kết nối không được thì xuất báo lỗi và thoát
		if (!$danhsach) {
			die("Không thể thực hiện câu lệnh SQL: " . $connect->error);
			exit();
		}
		
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
					echo "<p><a  href='index.php?do=sanpham_chitiet&id_sp=" . $row['MaSP'] . "&id_nsx=" . $row['MaNCC'] . "&id_loai=" . $row['LoaiSP'] . "'>" . $row['TenSP'] . "</a></p>";
				echo "</div>";
				
				
			echo "</div>";
			
		}
	}
	elseif($ThuongHieu!=null and $LoaiQuan==null and $LoaiAo==null)
	{
		foreach ($ThuongHieu as $th) 
		{
			$sql = "select t.MaSP, t.TenSP, t.HinhAnh, t.DonGia,t.LoaiSP, t.SoLuongSP, t.MoTa, t.KhuyenMai, l.MaNCC, l.TenNCC
					from (tblnhacungcap l inner join tblsanpham t on t.MaNCC=l.MaNCC) where l.TenNCC='$th'";

			$danhsach = $connect->query($sql);
			if (!$danhsach) {
				die("Không thể thực hiện câu lệnh SQL: " . $connect->error);
				exit();
			}

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
						echo "<p><a  href='index.php?do=sanpham_chitiet&id_sp=" . $row['MaSP'] . "&id_nsx=" . $row['MaNCC'] . "&id_loai=" . $row['LoaiSP'] . "'>" . $row['TenSP'] . "</a></p>";
					echo "</div>";
					
					
				echo "</div>";
				
			}
		}	
	}
	elseif($ThuongHieu==null and $LoaiQuan!=null and $LoaiAo==null)
	{
		foreach ($LoaiQuan as $lq) 
		{
			$sql = "select t.MaSP, t.TenSP, t.HinhAnh, t.DonGia,t.LoaiSP, t.SoLuongSP, t.MoTa, t.KhuyenMai, l.MaNCC, l.TenNCC
					from (tblnhacungcap l inner join tblsanpham t on t.MaNCC=l.MaNCC) where t.LoaiSP='$lq'";

			$danhsach = $connect->query($sql);
			if (!$danhsach) {
				die("Không thể thực hiện câu lệnh SQL: " . $connect->error);
				exit();
			}

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
						echo "<p><a  href='index.php?do=sanpham_chitiet&id_sp=" . $row['MaSP'] . "&id_nsx=" . $row['MaNCC'] . "&id_loai=" . $row['LoaiSP'] . "'>" . $row['TenSP'] . "</a></p>";
					echo "</div>";
					
					
				echo "</div>";
				
			}
		}	
	}
	elseif($ThuongHieu==null and $LoaiQuan==null and $LoaiAo!=null)
	{
		foreach ($LoaiAo as $la) 
		{
			$sql = "select t.MaSP, t.TenSP, t.HinhAnh, t.DonGia,t.LoaiSP, t.SoLuongSP, t.MoTa, t.KhuyenMai, l.MaNCC, l.TenNCC
					from (tblnhacungcap l inner join tblsanpham t on t.MaNCC=l.MaNCC) where t.LoaiSP='$la'";

			$danhsach = $connect->query($sql);
			if (!$danhsach) {
				die("Không thể thực hiện câu lệnh SQL: " . $connect->error);
				exit();
			}

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
						echo "<p><a  href='index.php?do=sanpham_chitiet&id_sp=" . $row['MaSP'] . "&id_nsx=" . $row['MaNCC'] . "&id_loai=" . $row['LoaiSP'] . "'>" . $row['TenSP'] . "</a></p>";
					echo "</div>";
					
					
				echo "</div>";
				
			}
		}	
	}
	elseif($ThuongHieu!=null and $LoaiQuan!=null and $LoaiAo==null)
	{
		foreach($ThuongHieu as $th)	
			foreach ($LoaiQuan as $lq)
			{
				$sql = "select t.MaSP, t.TenSP, t.HinhAnh, t.DonGia,t.LoaiSP, t.SoLuongSP, t.MoTa, t.KhuyenMai, l.MaNCC, l.TenNCC
						from (tblnhacungcap l inner join tblsanpham t on t.MaNCC=l.MaNCC) where t.LoaiSP='$lq' and l.TenNCC='$th'";

				$danhsach = $connect->query($sql);
				if (!$danhsach) {
					die("Không thể thực hiện câu lệnh SQL: " . $connect->error);
					exit();
				}

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
							echo "<p><a  href='index.php?do=sanpham_chitiet&id_sp=" . $row['MaSP'] . "&id_nsx=" . $row['MaNCC'] . "&id_loai=" . $row['LoaiSP'] . "'>" . $row['TenSP'] . "</a></p>";
						echo "</div>";
						
						
					echo "</div>";
					
				}
			}	
	}
	elseif($ThuongHieu!=null and $LoaiQuan==null and $LoaiAo!=null)
	{
		foreach($ThuongHieu as $th)	
			foreach ($LoaiAo as $la)
			{
				$sql = "select t.MaSP, t.TenSP, t.HinhAnh, t.DonGia,t.LoaiSP, t.SoLuongSP, t.MoTa, t.KhuyenMai, l.MaNCC, l.TenNCC
						from (tblnhacungcap l inner join tblsanpham t on t.MaNCC=l.MaNCC) where t.LoaiSP='$la' and l.TenNCC='$th'";

				$danhsach = $connect->query($sql);
				if (!$danhsach) {
					die("Không thể thực hiện câu lệnh SQL: " . $connect->error);
					exit();
				}

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
							echo "<p><a  href='index.php?do=sanpham_chitiet&id_sp=" . $row['MaSP'] . "&id_nsx=" . $row['MaNCC'] . "&id_loai=" . $row['LoaiSP'] . "'>" . $row['TenSP'] . "</a></p>";
						echo "</div>";
						
						
					echo "</div>";
					
				}
			}	
	}
	elseif($ThuongHieu!=null and $LoaiQuan!=null and $LoaiAo!=null)
	{
		foreach($ThuongHieu as $th)	
			foreach ($LoaiAo as $la)
				foreach ($LoaiQuan as $lq)
				{
					$sql = "select t.MaSP, t.TenSP, t.HinhAnh, t.DonGia,t.LoaiSP, t.SoLuongSP, t.MoTa, t.KhuyenMai, l.MaNCC, l.TenNCC
							from (tblnhacungcap l inner join tblsanpham t on t.MaNCC=l.MaNCC) where (t.LoaiSP='$la' or t.LoaiSP='$lq')  and l.TenNCC='$th'";

					$danhsach = $connect->query($sql);
					if (!$danhsach) {
						die("Không thể thực hiện câu lệnh SQL: " . $connect->error);
						exit();
					}

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
								echo "<p><a  href='index.php?do=sanpham_chitiet&id_sp=" . $row['MaSP'] . "&id_nsx=" . $row['MaNCC'] . "&id_loai=" . $row['LoaiSP'] . "'>" . $row['TenSP'] . "</a></p>";
							echo "</div>";
							
							
						echo "</div>";
						
					}
				}	
	}
	
?>