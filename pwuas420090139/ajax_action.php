<!-- Validasi data -->
<?php 
	include "config.php";
	$uid=$_POST["uid"];
	$Merk=mysqli_real_escape_string($con,$_POST["Merk"]);
	$SERI=mysqli_real_escape_string($con,$_POST["SERI"]);
	$TAHUN=mysqli_real_escape_string($con,$_POST["TAHUN"]);
	if($uid=="0"){

		//fungsi tambah data
		$sql="insert into user (Merk,SERI,TAHUN) values ('{$Merk}','{$SERI}','{$TAHUN}')";
		if($con->query($sql)){
			$uid=$con->insert_id;
			echo"<tr class='{$uid}'>
				<td>{$Merk}</td>
				<td>{$SERI}</td>
				<td>{$TAHUN}</td>
				<td><a href='#' class='btn btn-primary edit' uid='{$uid}'>Edit</a></td>
				<td><a href='#' class='btn btn-danger del' uid='{$uid}'>Hapus</a></td>					
			</tr>";
			
		}
	}else{

		//fungsi update data
		$sql="update user set Merk='{$Merk}',SERI='{$SERI}',TAHUN='{$TAHUN}' where UID='{$uid}'";
		if($con->query($sql)){
			echo"
				<td>{$Merk}</td>
				<td>{$SERI}</td>
				<td>{$TAHUN}</td>
				<td><a href='#' class='btn btn-primary edit' uid='{$uid}'>Edit</a></td>
				<td><a href='#' class='btn btn-danger del' uid='{$uid}'>Hapus</a></td>					
			";
		}
	}
?>