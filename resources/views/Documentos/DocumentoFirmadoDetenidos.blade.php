@extends('App') 
@section('content')
<br>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3"></div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
        <div class="col">
            <div class="card bg-light mb-3" > 
            <div class="card-header">ARCHIVO</div>  
                @if($status=='OK')
                    <div class="card-body">
                        <h5><strong><center>Archivo/s firmado/s correctamente.</center></strong></h5>
                    </div>
                    <div class="card-footer text-muted"> 
                        <form method="POST" action="{{ route('EnvioOficinaPartes') }}">
                            @csrf
                            <div class="btn-group" style=" width:100%;">
                                <button type="submit" class="btn btn-primary active">
                                    CONTINUAR
                                </button> 
                            </div>
                        </form>
                    </div>
                @else  
                    <div class="card-body">
                        <h3><strong><center>ERROR EN FIRMA DIGITAL.<br></center></strong></h3>
                        <br>
                        <h5>
                        Por favor complete el siguiente formulario. <br>
                        
                        <a href="https://forms.gle/d4ke6fWhvaPnSr217" target="_blank"> Completar formulario </a><br>
                        <hr>
                        <strong>O contacte con Nelson Arturo Sepúlveda Manzo<br> Encargado Firma Digital Avanzada.</strong>
                        <hr>
                            nelson.sepulveda@curico.cl<br>
                            Anexo 755<br>
                            Teléfono +569-76212407
                        </h5>
                    </div> 
                    <div class="card-footer text-muted"> 
                        <form method="POST" action="{{ route('EnvioOficinaPartes') }}">
                            @csrf
                            <div class="btn-group" style=" width:100%;">
                                <button type="submit" class="btn btn-danger active">
                                    VOLVER
                                </button> 
                            </div>
                        </form>
                    </div>
                @endif
                <div class="card-footer text-muted">
                    GESTION DOCUMENTAL
                </div>
            </div>
        </div>	
    </div>	
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3"></div>				
</div>
@endsection    