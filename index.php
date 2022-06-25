<?php
	include "config.php";
?>
<html>
	<head>
		<title>CRUD Application Perekaman Data Laptop</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css"> 
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	</head>
	<body>
		
		<!-- JUDUL APLIKASI -->
	<div class="container">
		<h3 class='text-center'>CRUD Application Perekaman Data Laptop</h3><hr>

		<!-- MEMBUAT FORM TABEL INPUT DATA -->
		<div class='row'>
			<div class="col-md-5">
				<form id='frm'>
				  <div class="form-group">
					<label>Merk Laptop</label>
					<input type="Merk" class="form-control" name="Merk" id='Merk' required placeholder="Merk Laptop">
				  </div>
				  <div class="form-group">
					<label>Seri Laptop</label>
					<input type="SERI" class="form-control" name="SERI" id='SERI' required placeholder="Seri Laptop">
				  </div>
				  <div class="form-group">
					<label>Tahun Produksi</label>
					<input type="TAHUN" class="form-control"  name="TAHUN" id='TAHUN' required placeholder="Tahun Produksi">
				  </div>
				  
				  <input type="hidden" class="form-control" name="uid" id='uid' required value='0' placeholder="">
				  
				  <button type="submit" name="submit" id="but" class="btn btn-success">Simpan</button>
				  <button type="button" id="clear" class="btn btn-warning">Hapus</button>
				</form> 
			</div>

			<!-- MEMBUAT TABEL DATA -->
			<div class="col-md-7">
				<table class="table table-bordered" id='table'>
					<thead>
						<tr>
							<th>Merk Laptop</th>
							<th>Seri Laptop</th>
							<th>Tahun Produksi</th>
							<th>Edit</th>
							<th>Hapus</th>
						</tr>
					</thead>

					<!-- VALIDASI DATA TABEL DENGAN TABEL DI DB  -->
					<tbody>
						<?php
							$sql="select * from user";
							$res=$con->query($sql);
							if($res->num_rows>0)
							{
								while($row=$res->fetch_assoc())
								{	
									echo"<tr class='{$row["UID"]}'>
										<td>{$row["Merk"]}</td>
										<td>{$row["SERI"]}</td>
										<td>{$row["TAHUN"]}</td>
										<td><a href='#' class='btn btn-primary edit' uid='{$row["UID"]}'>Edit</a></td>
										<td><a href='#' class='btn btn-danger del' uid='{$row["UID"]}'>Hapus</a></td>					
									</tr>";
								}
							}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>	
	<script>
		$(document).ready(function(){
			
			//RESET INPUTAN DATA PADA MENU EDIT
			$("#clear").click(function(){
				$("#Merk").val("");
				$("#SERI").val("");
				$("#TAHUN").val("");
				$("#uid").val("0");
				$("#but").text("Simpan");
			});
			
			//MENGUPDATE DATA 
			$("#but").click(function(e){
				e.preventDefault();
				var btn=$(this);
				var uid=$("#uid").val();
				
				
				var required=true;
				$("#frm").find("[required]").each(function(){
					if($(this).val()==""){
						alert($(this).attr("placeholder"));
						$(this).focus();
						required=false;
						return false;
					}
				});
				if(required){
					$.ajax({
						type:'POST',
						url:'ajax_action.php',
						data:$("#frm").serialize(),
						beforeSend:function(){
							$(btn).text("Wait...");
						},
						success:function(res){
							
							var uid=$("#uid").val();
							if(uid=="0"){
								$("#table").find("tbody").append(res);
							}else{
								$("#table").find("."+uid).html(res);
							}
							
							$("#clear").click();
							$("#but").text("Simpan");
						}
					});
				}
			});
			
			//MENGHAPUS DATA
			$("body").on("click",".del",function(e){
				e.preventDefault();
				var uid=$(this).attr("uid");
				var btn=$(this);
				if(confirm("Are You Sure ? ")){
					$.ajax({
						type:'POST',
						url:'ajax_delete.php',
						data:{id:uid},
						beforeSend:function(){
							$(btn).text("Deleting...");
						},
						success:function(res){
							if(res){
								btn.closest("tr").remove();
							}
						}
					});
				}
			});
			
			//mengisi form input data ssesuai tabel db
			$("body").on("click",".edit",function(e){
				e.preventDefault();
				var uid=$(this).attr("uid");
				$("#uid").val(uid);
				var row=$(this);
				var nomor=row.closest("tr").find("td:eq(0)").text();
				$("#Merk").val(nomor);
				var SERI=row.closest("tr").find("td:eq(1)").text();
				$("#SERI").val(SERI);
				var TAHUN=row.closest("tr").find("td:eq(2)").text();
				$("#TAHUN").val(TAHUN);
				$("#but").text("Simpan");
			});
		});
	</script>
	</body>
</html>