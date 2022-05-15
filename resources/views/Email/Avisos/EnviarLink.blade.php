<meta charset="utf-8">
<title>GestionDocumental</title>
<head>
	<meta name="viewport" content="width=device-width"/>
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
	<style type="text/css">
 

		.card-header { 
			color: white !important;
			background-color: #31A877 !important;
		}
	</style> 
</head>
<body>
    <div class="card-header">
        <h2><strong><center>{{ $Titulo}} RECIBIDA</center></strong></h2>
    </div>
        <center>
            <h3>Funcionario/a {{ $Nombres}}.</h3>
            <br>
            <a href="{{ $Contenido }}"><h3><strong>REVISAR</strong></h3></a>
        </center>

    <div>
        <center>
            <hr>	
                <strong>
                    © {{ date("Y") }} Dep. de informática VERSIÓN BETA 0.5.230322<br>
                    Municipalidad de Curicó<br>
                    GESTIÓN DOCUMENTAL
                </strong>
            <hr>
        </center>
    </div>
</body>