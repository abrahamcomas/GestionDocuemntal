@extends('App')
@section('content')
<br>
<div class="container-fluid">   
    <div class="row"> 
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3"></div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
            @include('messages')
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3"></div>
    </div> 
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-3"></div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
			<div class="col">  
          		<div class="card bg-light mb-3">
					<div class="card-header"> 
						<center><h5><strong>RESTAURACIÓN DE CONTRASEÑA</strong></h5></center> 
					</div>
					<div class="card-body">
						<form method="POST" action="{{ route('ContraseniaEnviada') }}">
							@csrf  
							<div class="form-group">
								<div class="form-label-group">
									<input type="email" id="Email" name="Email" value="{{ old('Email') }}" class="form-control" placeholder="Ingrese Email" required>
								</div>
							</div>
							<div class="btn-group" style=" width:100%;">	
								<button type="submit" class="btn btn-info active" style="background: #31A877;">ACEPTAR</button>
							</div>	
						</form>
					</div> 	
					<div class="card-footer text-muted">
						<div class="btn-group" style=" width:100%;">	
							<a href="{{ route('Index') }}" style="color: #31A877;"><strong>VOLVER</strong></a>
						</div>	      
					</div>	
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"></div>
	</div>
</div>
@endsection   