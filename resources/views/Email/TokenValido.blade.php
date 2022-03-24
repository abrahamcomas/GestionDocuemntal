@extends('App')
@section('content') 
<div class="container-fluid">  
			<br> 
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
								<center><h5><strong>RESTAURAR CONTRASEÑA</strong></h5></center> 
							</div>
							<div class="card-body">
							<form method="POST" action="{{ route('Restaurar') }}">   
								@csrf @method('PATCH')
									<input type="hidden" id="Id_Funcionario" name="Id_Funcionario" value="{{ $Datos->ID_Funcionario_T }}">
									<div class="form-group">
										<div class="form-label-group">
											<input type="password" id="Contrasenia" name="Contrasenia" class="form-control" placeholder="Ingrese Contraseña" autocomplete="on">
										</div>
									</div>
									<div class="form-group">
										<div class="form-label-group"> 
											<input type="password" id="Confirmar_Contrasenia" name="Confirmar_Contrasenia" class="form-control" placeholder="Confirmar Contraseña" autocomplete="on">
										</div>
									</div>
									<div class="btn-group" style=" width:100%;">	
									<button type="submit" class="btn btn-success active btn-info"  style="background: #31A877;">ACEPTAR</button>
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
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-3"></div>
			</div>
		</div>

@endsection  