<meta charset="utf-8">
<title>Control Salud</title>
<head>
	<link href="{{ asset ('css/bootstrap.min.css') }}" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</head> 
<?php

		$numeroDia = date('d', strtotime($Fecha_Ing));
        $dia = date('l', strtotime($Fecha_Ing));
        $mes = date('F', strtotime($Fecha_Ing));
        $anio = date('Y', strtotime($Fecha_Ing));

        $mesNumero = date('m', strtotime($Fecha_Ing));

        if($mes=='January'){
        $mes= 'Enero';
        }
        elseif($mes=='February'){   
        $mes= 'Febrero';
        }
        elseif($mes=='March'){  
        $mes= 'Marzo';
        }
        elseif($mes=='April'){
            $mes= 'Abril';
        }
        elseif($mes=='May'){
            $mes= 'Mayo';
        }
        elseif($mes=='June'){
            $mes= 'Junio';
        }
        elseif($mes=='July'){ 
            $mes= 'Julio';
        }
        elseif($mes=='August'){  
            $mes= 'Agosto';
        }
        elseif($mes=='September'){  
            $mes= 'Septiembre';
        }
        elseif($mes=='October'){  
            $mes= 'Octubre';
        }
        elseif($mes=='November'){  
            $mes= 'Noviembre';
        }
        else{  
            $mes= 'Diciembre';
        }

        if($dia=='Monday'){
        $dia= 'Lunes';
        }
        elseif($dia=='Tuesday'){   
        $dia= 'Martes';
        }
        elseif($dia=='Wednesday'){  
        $dia= 'Miércoles';
        }
        elseif($dia=='Thursday'){
            $dia= 'Jueves';
        }
        elseif($dia=='Friday'){
            $dia= 'Viernes';
        }
        elseif($dia=='Saturday'){
            $dia= 'Sábado';
        }
        else{ 
            $dia= 'Domingo';
        }
?>
<div class="container-fluid">  
	<div class="row"> 
		<div class="panel-heading">
			<center><h1>SISTEMA CONTROL DE SALUD</h1></center>
		</div>
		<div class="card bg-light mb-3">
			<div class="card-header">
				<center>     
						<h5><strong>{{$datos }}</strong></h5>
				</center> 
			</div>   
			<hr>
			<div class="panel-body">
				<div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
							<center>     
								<h5><strong>Lista de ingresos {{ $dia }} {{ $numeroDia }} de  {{$mes}} del {{$anio}}</strong></h5>
							</center> 
                            <table class="table table-striped table-bordered" style="width:100%">
                                <thead>
                                    <tr>  
                                        <th>Nombres</th> 
										<th>Seguimiento</th> 
                                    </tr> 
                                </thead>
                                <tbody> 
                                    @foreach($Lista as $post)
                                            <tr>
         										<td><center>{{ $post->Nombres_T }} {{ $post->Apellidos_T }}</center></td>  
												@if($post->Contacto==1)
													<td><center>NO</center></td>
												@else
													<td><center>SI</center></td>
												@endif   
                                            </tr>
                                    @endforeach 
                                </tbody>
                            </table> 
                        </div>
                    </div>
                </div>
			</div>  
		</div>
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
