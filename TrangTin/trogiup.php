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
						
							echo '<div > &emsp;Ý kiến của bạn về chúng tôi</div></br>'	;	
							echo '<div > &emsp;Địa chỉ: số 18, đường Ung Văn Khiêm, Long Xuyên,An Giang </div></br>'	;
							echo '<div > &emsp;SĐT: 0123456789 </div></br>'	;
							echo '<div > &emsp;Email:<a href="mailto:khang_dth225677@student.agu.edu.vn">khang_dth225677@student.agu.edu.vn</a> </div></br>'	;
							
							
							echo '<form class="form-container" method="post" action="index.php?do=guithongtin">';																
									echo '</br>&emsp;<textarea name="message" rows="6" placeholder="Nội dung" ></textarea></br>';
								echo '</br>&emsp;<button type="submit">Gửi thông tin</button>';
							echo '</form>';
							
					}
?>