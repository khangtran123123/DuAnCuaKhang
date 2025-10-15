<?php
        if (isset($_REQUEST['ok'])) {
 
            // Gán hàm addslashes để chống sql injection
            $search = addslashes($_POST['search']);
            // Dùng câu lênh like trong sql và sứ dụng toán tử % của php 
			//để tìm kiếm dữ liệu chính xác hơn.
            $sql = "select * from tblsanpham where TenSP like '%$search%'";
 
           
 
            // Thực thi câu truy vấn
            $danhsach = $connect->query($sql);
			//Nếu kết quả kết nối không được thì xuất báo lỗi và thoát
			if (!$danhsach) {
				die("Không thể thực hiện câu lệnh SQL: " . $connect->error);
				exit();
			}
            // Đếm số dòng trả về trong sql.
            $num = mysqli_num_rows($danhsach);
 
            // Nếu $search rỗng thì báo lỗi tức là người dùng chưa
			//nhập liệu mà đã nhấn submit.
            if (empty($search)) {
                echo "Hãy nhập dữ liệu vào ô tìm kiếm";
            } else {
                // Ngược lại nếu người dùng nhập liệu thì tiến hành xứ lý show dữ liệu.
                // Nếu $num > 0 hoặc $search khác rỗng tức 
				//là có dữ liệu mối show ra nhé, ngược lại thì báo lỗi.
                if ($num > 0 && $search != "") {
 
                    // Dùng $num để đếm số dòng trả về.
                    echo "<h3>$num kết quả trả về với từ khóa <b>$search</b> <br /></h3>";
                    // Vòng lặp while & mysql_fetch_assoc dùng để lấy toàn bộ 
					//dữ liệu có trong table và trả về dữ liệu ở dạng array.
					
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
		
                } else 
                    echo "Không tìm thấy kết quả!";
				}
			}
        ?>   