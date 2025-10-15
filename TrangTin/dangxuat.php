<?php
	// Hủy SESSION
	unset($_SESSION['MaKH']);
	unset($_SESSION['HoTen']);
	unset($_SESSION['CapTK']);
	
	// Chuyển hướng về trang index.php
	header("Location: index.php");
?>