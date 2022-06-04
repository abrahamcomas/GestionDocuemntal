@extends('App')

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

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
                <div class="text-muted" >
                    <br> 
                    <h1><center><strong>CAMBIAR LUGAR DE TRABAJO</strong></center></h1>
                    <hr>
                </div>
				<div class="card-body">
                <div class="card-footer text-muted" >
                    <center><p><strong>INPORTANTE:</strong> Al cambiarse de lugar de trabajo su sesión se cerrara automáticamente y quedara a espera de aprobación de ingreso por parte de la ODP seleccionada.</p></center>
                </div>
					<form method="POST" action="{{ route('FormLugarTrabajo') }}">    
						@csrf    
						<div class="form-group">
							<div class="form-label-group">
								<input type="password" id="passwordActual" name="passwordActual" class="form-control" placeholder="Ingrese Contraseña Actual" >
							</div>
						</div>	
                        <div class="form-group">
                        <h6>LUGAR DE TRABAJO*</h6>				                    
                            <div class="form-label-group">   
                               <center> 
                                <select class='mi-selector' name='Lugar'>
                                    <option value="" selected>---SELECCIONAR---</option>        
                                    @foreach($Lugares as $post)
                                        <option value="{{ $post->ID_DepDir}}">{{ $post->Nombre_DepDir}}</option>
                                @endforeach         
                                </select> 
                                </center>
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
@section('scripts')
    <script type="text/javascript">
        jQuery(document).ready(function($){
            $(document).ready(function() {
                $('.mi-selector').select2();
            });
        });
    </script>	
