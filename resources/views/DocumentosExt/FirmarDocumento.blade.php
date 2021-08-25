@extends('App')
@section('content')
<div class="container-fluid">  
    <div  id="MostrarFor" style="display:none">
        <div class="col">  
            <div class="card bg-light mb-3" >
                <div class="card-body">
                    <center> 
                        <img src="{{URL::asset('Imagenes/12.gif')}}" width="220" height="220"/>
                        <h5><strong>Firmando documento, espere por favor...</strong></h5>
                    </center>
                </div>
                <div class="card-footer text-muted">
                    GESTIÓN DOCUMENTAL
                </div>
            </div>
        </div> 
    </div>
    <div class="row" id="IngresoFirma">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4"></div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
			<br>
			@include('messages')
            <div class="col"> 
                <div class="card bg-light mb-3">
                    <div class="card-header"> <h5><strong>Firmar documento externo</strong></h5></div>
                        <div class="card-body"> 
                            <form method="POST" action="{{ route('FirmarExterno') }}" accept-charset="UTF-8" enctype="multipart/form-data">
                                @csrf    
                                <br>       
                                <div class="form-group"> 
                                    <h6>Elegir PDF*</h6> 
                                    <div class="form-label-group">  
                                        <input type="file" class="form-control" name="PDF" accept="application/pdf" />
                                    </div> 
                                </div>
                                <br>
                                <div class="form-label-group">
                                    <input type="password" class="form-control" name="Contrasenia"  placeholder="Confirme Contraseña Usuario" autocomplete="off">
                                </div>
                                <br>
                                <div class="card-footer text-muted">
                                    <div class="btn-group" style=" width:100%;">
                                    <button type="submit" id="btnEnviar1" class="btn btn-success active">ACEPTAR</button>
                                    </div>
                                </div>
                            </form> 
                        </div>
                        <div class="card-footer text-muted">
                            GESTIÓN DOCUMENTAL
                        </div>   
                    </div>     
                </div>
            </div> 
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4"></div>
    </div>




<script type="text/javascript">
	$(document).ready(function(){               
		$(document).on('click', '#btnEnviar1', function(){ 
			$("#MostrarFor").show(); 
			$("#IngresoFirma").hide();      
		}); 
	}); 
</script>  
@endsection 