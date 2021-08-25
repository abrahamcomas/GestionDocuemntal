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
						<center><h5><strong>REGISTRO</strong></h5></center> 
					</div> 
					<div class="card-body">
						<form method="POST" action="{{ route('Registro') }}">
							@csrf @method('PATCH')
							<div class="form-group">
								<input type="text" class="form-control" name="Rut" id="Rut" 
								value="{{ old('Rut') }}" oninput="checkRut(this)" placeholder="Rut" autocomplete="on">
							</div>
							<div class="form-group">
								<input type="text" class="form-control" name="Nombres" id="Nombres" 
								value="{{ old('Nombres') }}"  placeholder="Nombres" autocomplete="off">
							</div>
							<div class="form-group">
								<input type="text" class="form-control" name="Apellidos" id="Apellidos" 
								value="{{ old('Apellidos') }}" placeholder="Apellidos" autocomplete="off">
							</div> 
							<div class="form-group">
								<input type="password" class="form-control" name="Contrasenia" id="Contrasenia" 
								value="{{ old('Contrasenia') }}" placeholder="Contraseña" autocomplete="off">
							</div>  
							<div class="form-group">
								<input type="password" class="form-control" name="Confirmar_Contrasenia" id="Confirmar_Contrasenia" value="{{ old('Confirmar_Contrasenia') }}" placeholder="Confirmar Contraseña" autocomplete="off">
							</div>
							<div class="form-group">
								<input type="email" name="Email" id="Email" value="{{ old('EmailCO') }}" class="form-control" placeholder="Email" >
							</div> 
							<div class="form-group">
								<input type="text" name="Telefono" id="Telefono" value="{{ old('Telefono') }}" class="form-control" placeholder="Teléfono municipal +56912345678" min="12" maxlength="12">
							</div> 
							<div class="btn-group" style=" width:100%;">	
								<button type="submit" class="btn btn-info active" style="background: #31A877;">Aceptar</button>
							</div>	
						</form>
					</div> 	
					<div class="card-footer text-muted">
						<div class="btn-group" style=" width:100%;">	
							<a href="{{ route('Index') }}" style="color: #31A877;"><strong>Volver</strong></a>
						</div>	      
					</div>	
				</div>	
			</div>	
		</div>
		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"></div>
	</div>
</div>
@endsection

