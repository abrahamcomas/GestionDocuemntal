@extends('App') 
@section('content')
@if(!Auth::guard('web')->check())
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
								<center><h5><strong>INICIAR SESIÓN</strong></h5></center> 
							</div>
							<div class="card-body">
								<form method="POST" action="{{ route('Login') }}">  
									@csrf    
									<div class="form-group">
										<div class="form-label-group">
											<input type="text" class="form-control" name="RUN" id="RUN" oninput="checkRut(this)" placeholder="Rut" value="{{ old('RUN') }}">
										</div>
									</div>
									<div class="form-group">
										<div class="form-label-group">
											<input type="password" id="password" name="password" class="form-control" placeholder="Contraseña" autocomplete="on">
										</div>
									</div>
									<div class="btn-group" style=" width:100%;">	
										<button type="submit" class="btn btn-success active btn-info"  style="background: #31A877;">Aceptar</button>
									</div>
								</form>
							</div> 
							<div class="card-footer text-muted">
								<div class="btn-group" style=" width:100%;">	
									<a href="{{ route('Recuperar') }}" style="color: #31A877;"><center><strong>Recuperar Contraseña</strong></center></a>
								</div>	      
							</div>
						</div>	
					</div> 
				</div>
				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-3"></div>
			</div>
		</div>
		@endif
@endsection 
@section('scripts')
<script type="text/javascript">
	$(document).ready(function(){
	        window.addEventListener( "pageshow", function ( event ) {
			  	var historyTraversal = event.persisted || 
			                         ( typeof window.performance != "undefined" && 
			                              window.performance.navigation.type === 2 );
			  	if ( historyTraversal ) {
			   	 	// Handle page restore.
			    	window.location.reload();
			  	}
			});
	});	
</script>
@endsection