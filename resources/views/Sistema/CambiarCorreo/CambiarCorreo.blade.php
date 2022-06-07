@extends('App')
@section('content') 
<div class="row"> 
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3"></div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
        <div class="card bg-light mb-3">
            <div class="card-body">
               @include('messages') 
            </div>
        </div>  
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3"></div>
</div>
<div class="container-fluid">   
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-3"></div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
			<div class="card bg-light mb-3">
                <div class="text-muted">
                    <h1><center><strong>CAMBIAR EMAIL</strong></center></h1>
                    <hr>
                </div>
				<div class="card-body">
                <center><strong><h5>{{ $Email }} </h5></strong></center> 
					<form method="POST" action="{{ route('FormCorreo') }}">   
						@csrf    
							<div class="form-group">
							<div class="form-label-group">
								<input type="password" id="passwordActual" name="passwordActual" class="form-control" placeholder="Ingrese Contraseña Actual" >
							</div>
						</div>					                    
						<div class="form-group">
							<div class="form-label-group">
								<input type="email" id="Correo" name="Correo" class="form-control" placeholder="Ingrese Nuevo Email" >
							</div>
						</div>
						<div class="btn-group" style=" width:100%;">	
							<button type="submit" class="btn btn-info active" >Aceptar</button>
						</div>
					</form>
				</div>
                <div class="card-footer text-muted"> 
                    SGD
                </div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-3"></div>
	</div>
</div>
@endsection   

