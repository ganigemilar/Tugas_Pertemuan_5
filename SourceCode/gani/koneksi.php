<?php
	//Koneksi database
	$link=mysql_connect('localhost','root','')or die('Could not connect : '.mysql_error());
	mysql_select_db('mhs_db')or die('Could not select database');
?>