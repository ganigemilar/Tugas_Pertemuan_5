<html>
<head>
	<title>View Data Bukti</title>
</head>
<body>
<?php
	//include "koneksi.php";
	//Resource
	$url='http://localhost/gani/mhs.php';
	//Mengambil data string dari resurce
	$client=curl_init($url);
	curl_setopt($client, CURLOPT_RETURNTRANSFER, 1);
	$response=curl_exec($client);
	curl_close($client);

	$dataMahasiswaXML=simplexml_load_string($response);

	echo "<table border='1'>
			<tr>
				<td>NIM</td>
				<td>Nama</td>
				<td>Alamat</td>
				<td>Prodi</td>
			</tr>";
	foreach ($dataMahasiswaXML->mahasiswa as $mahasiswa) 
	{
		echo 
		"<tr>
			<td>".$mahasiswa->nim."</td>
			<td>".$mahasiswa->nama."</td>
			<td>".$mahasiswa->alamat."</td>
			<td>".$mahasiswa->prodi."</td>
		</tr>";
	}
	echo "</table>";
?>
</body>
</html>