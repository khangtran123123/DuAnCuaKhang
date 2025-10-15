<?php
					if(!isset($_SESSION)) 
					{ 
						session_start(); 
					} 
	
					include_once "cauhinh.php";
	
					include_once "thuvien.php";
					
					if(isset($_SESSION['MaKH']))
					{						
						$noiDung = $_POST['message'];
						$sql = "update tblkhachhang set GhiChu = '$noiDung' where MaKH = '{$_SESSION['MaKH']}'";

						$sql_update= $connect->query($sql);
							if (!$sql_update) 
							{
								die("Không thể thực hiện câu lệnh SQL: " . $connect->error);
								exit();
							}
							else
							{
								echo "<script>
									alert('Gửi thông tin thành công!');
									window.location = 'index.php?do=home';
								</script>";
								exit();
							}
							
					}
					
?>