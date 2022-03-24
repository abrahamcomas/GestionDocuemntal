@extends('App')
@section('content') 
<div class="container-fluid">  
	<br> 
	<div class="row"> 
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-3"></div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
			<div class="col"> 
				<div class="card bg-light mb-3">
					<div class="card-header">
						<center><h5><strong>FUNCIONARIO/A {{ $Datos->Nombres }} {{ $Datos->Apellidos }}</strong></h5></center> 
					</div>
					<div class="card-body">
						<center>
							<strong><h5 style="color: red;">ERROR, LINK NO VALIDO</h5></strong> 
						</center>
					</div> 
					<div class="card-footer text-muted">
						<div class="btn-group" style=" width:100%;">	
						<a href="{{ route('Index') }}" style="color: #31A877;"><strong>VOLVER</strong></a>
						</div>	      
					</div>
				</div>	
			</div> 
		</div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-3"></div>
	</div>
</div>
@endsection 