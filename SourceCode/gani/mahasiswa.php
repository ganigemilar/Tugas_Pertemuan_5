<?php
	//1. Koneksi Database
	$konek=mysql_connect("localhost","root","");
	$db=mysql_select_db("mhs_db");
	
	if($konek)
	{
		echo("Berhasil <br>");
	}
	else
	{
		echo("Gagal <br>");
	}

	if($db)
	{
		echo("DB Ada <br>");
	}
	else
	{
		echo("DB Null");
	}

	//2. Query Database
	$query="select * from mahasiswa";
	$hasil=mysql_query($query);
	$dataMhs=array();
	while($data=mysql_fetch_array($hasil))
	{
		$dataMhs[]=array('nim'=>$data['nim'],'nama'=>$data['nama'],'alamat'=>$data['alamat'],'prodi'=>$data['prodi']);
		//echo $data['nim'];
	}

	//3. Parsing Data XML
	$document=new DOMDocument();
	$document->formatOutput=true;
	$root=$document->createElement("data");
	$document->appendChild($root);
	foreach ($dataMhs as $mahasiswa) 
	{
		$block=$document->createElement("mahasiswa");
		//Create element nim
		$nim=$document->createElement("nim");
		//Create element untuk membuat element baru
		$nim->appendChild($document->createTextNode($mahasiswa['nim']));
		//Create Text Node untuk menampilkan isi/value
		$block->appendChild($nim);
		//appendChild untuk mempersiapkan nilai dari element diatasnya

		//Create element nama
		$nama=$document->createElement("nama");
		$nama->appendChild($document->createTextNode($mahasiswa['nama']));
		$block->appendChild($nama);

		//Create element alamat
		$alamat=$document->createElement("alamat");
		$alamat->appendChild($document->createTextNode($mahasiswa['alamat']));
		$block->appendChild($alamat);

		//Create element prodi
		$prodi=$document->createElement("prodi");
		$prodi->appendChild($document->createTextNode($mahasiswa['prodi']));
		$block->appendChild($prodi);

		$root->appendChild($block);
	}
	
	//4. Menyimpan data dalam bentuk file XML
	$generateXML=$document->save("mahasiswa.xml");
	if($generateXML)
	{
		echo("Berhasil di generate <br>");
	}
	else
	{
		echo("Gagal di generate <br>");
	}

	//5. Membaca file XML
	//Membuka file
	$url="http://localhost/gani/mahasiswa.xml";
	$client=curl_init($url);
	curl_setopt($client, CURLOPT_RETURNTRANSFER, 1);
	$response=curl_exec($client);
	curl_close($client);
		
		
	//Membaca file
	//6. Ditampilkan dalam bentuk HTML
	$dataMahasiswaXML=simplexml_load_string($response);
	//print_r($dataMahasiswaXML);
	//Perulangan
	echo 
	"<table border='1'>
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