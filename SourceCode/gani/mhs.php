<?php
	ini_set('display_errors', false);
	//Header untuk format xml, jika dihilangkan maka akan terbentuk data string
	header('Content-Type: text/xml; charset=ISO-8859-1');
	include"koneksi.php";

	//Check for the path elements
	$path=$_SERVER[PATH_INFO];
	if($path!=null)
	{
		$path_params=spliti("/", $path);
	}

	//Method request untuk GET
	if($_SERVER['REQUEST_METHOD']=='GET')
	{
		if($path_params[1]!=null)
		{
			$query="SELECT nim,nama,alamat,prodi FROM mahasiswa WHERE nim=$path_params[1]";
		}
		else
		{
			$query="SELECT nim,nama,alamat,prodi FROM mahasiswa";
		}
		$result=mysql_query($query)or die('Query failed : '.mysql_error());

		echo"<data>";
		while ($line=mysql_fetch_array($result,MYSQL_ASSOC)) 
		{
			echo"<mahasiswa>";
			foreach ($line as $key => $col_value) 
			{
				echo "<$key>$col_value</$key>";
			}
			echo"</mahasiswa>";
		}
		echo"</data>";
		mysql_free_result($result);
	}
	else if ($_SERVER['REQUEST_METHOD']=='POST')
	{
		$input=file_get_contents("php://input");
		$xml=simplexml_load_string($input);
		foreach ($$xml->mahasiswa as $mahasiswa) 
		{
			$querycek="SELECT * FROM mahasiswa WHERE nim='$mahasiswa->nim'";
			$num_rows=mysql_num_rows($querycek);
			if ($num_rows==0) 
			{
				$query="INSERT INTO mahasiswa(nim,nama,alamat,prodi) VALUES('$mahasiswa->nim','$mahasiswa->nama','$mahasiswa->alamat','$mahasiswa->prodi')";
			}
			else if ($num_rows==1) 
			{
				$query="UPDATE mahasiswa SET nim='$mahasiswa->nim',nama='$mahasiswa->nama',alamat='$mahasiswa->alamat',prodi='$mahasiswa->prodi' WHERE nim='$mahasiswa->nim'";
			}
			$result=mysql_query($query)or die('Query failed : '.mysql_error());
		}
	//Method request untuk delete
	}
	mysql_close($link);
?>