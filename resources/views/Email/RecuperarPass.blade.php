<meta charset="utf-8">
<title>Liquidaciones</title>
<head>
	<link href="{{ asset ('css/bootstrap.min.css') }}" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</head> 

<div class="container-fluid"> 
	<div class="row"> 
		<div class="col-lg-4"></div>
		<div class="col-lg-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					<center><h1>SISTEMA GESTIÓN DOCUMENTAL</h1></center>
				</div>
				<hr style="width:100%; border-color: green;">
				<div class="panel-body">
					<center>
						<h4>
							Funcionario/a {{ $datos->Nombres}} {{ $datos->Apellidos}} Se ha solicitado una restauración de contraseña.
						</h4>
						<center>
							<a href="{{ $token }}" style="color: black;">
		      				RECUPERAR CONTRASEÑA
		      			</center>
					</center>
					</center> 
				</div>  
			</div> 
		</div>
		<div class="col-lg-4"></div>
	</div>
	<br>
	<hr style="width:100%; border-color: green;">
	<footer>
		<br>
  		<center>
  			<p><a style="color: green">© {{ date("Y") }} Departamento de informática<br>
              SGD</a></p>
		</center>
	</footer>
</div>
