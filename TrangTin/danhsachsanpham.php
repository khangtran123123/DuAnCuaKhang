<?php
	$danhsach= $_GET['kq'];
	
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
?>