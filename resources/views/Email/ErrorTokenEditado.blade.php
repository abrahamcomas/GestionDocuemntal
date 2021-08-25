@extends('App')
@section('content') 
<div class="container-fluid"> 
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4"></div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
			<div class="panel panel-default">
				<br>
				<div class="panel-body">
					<center>
						<h3><strong>SISTEMA CONTROL DE SALUD</strong></h3>
					</center> 
					<br>
					<hr style="width:100%; border-color: blue;">
					<center>
						<strong><h5 style="color: red;">ERROR, LINK NO VALIDO</h5></strong> 
					</center> 
					<hr style="width:100%; border-color: blue;">
					<br>
					<center>
						<a href="{{ route('Index') }}" style="color: black;"><strong>Volver</strong></a>
					</center> 
				</div>
			</div> 
		</div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4"></div>
	</div>
</div>
@endsection 