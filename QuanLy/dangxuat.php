<?php
	// Hủy SESSION
	unset($_SESSION['MaAdmin']);
	unset($_SESSION['HoTen']);
	unset($_SESSION['QuyenAdmin']);
	
	// Chuyển hướng về trang index.php
	header("Location: index.php");
?>