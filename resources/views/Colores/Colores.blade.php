@extends('App') 
@section('content')
<br>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3"></div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
        <div class="col">
            <div class="card bg-light mb-3">
            <div class="text-muted">
                <br> 
                <h1><center><strong>PERSONALIZAR COLORES</strong></center></h1>
                <hr>
            </div>
            <form id="F_prestamo" name="F_prestamo" method="POST" action="{{ route('IngresarColores') }}">
                @csrf
                    <br>
                    <center><h5><strong>COLOR CABEZERA Y MENÚ LATERAL</strong></h5></center>
                    <br>
                    <div class="row"> 
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                            <strong>Principal</strong>   
                            <input type="color" class="form-control" value="{{ $ColorPrincipal }}" name="ColorPrincipal">
                        </div> 
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                            <strong>Secundario</strong>
                            <input type="color"  class="form-control" value="{{ $ColorSecundario }}" name="ColorSecundario">  
                        </div>
                    </div>
                    <hr>
                    <center><h5><strong>COLOR DE FONDO</strong></h5></center>
                    <br>
                    <div class="row"> 
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                            <strong>Principal</strong>
                            <input type="color" class="form-control" value="{{ $BodyPrincipal }}" name="BodyPrincipal">
                        </div> 
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                            <strong>Secundario</strong>
                            <input type="color"  class="form-control" value="{{ $BodySecundario }}" name="BodySecundario">  
                        </div>
                    </div>
                    <hr>
                    <center><h5><strong>LETRAS (POR ENCIMA)</strong></h5></center>
                    <br>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                            <strong>Letra seleccionada</strong>
                            <input type="color" class="form-control" value="{{ $FocoNoSelecLetra }}" name="FocoNoSelecLetra">
                        </div> 
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                            <strong>Foco sin seleccionar</strong>
                            <input type="color" class="form-control" value="{{ $FocoNoSelecFondo }}" name="FocoNoSelecFondo">
                        </div>
                    </div>
                    <hr>
                    <center><h5><strong>LETRAS</strong></h5></center>
                    <br>
                    <div class="row"> 
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                            <strong>Letra (menú desplegable)</strong>
                            <input type="color" class="form-control" value="{{ $LetraLista }}" name="LetraLista">
                        </div> 
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                            <strong>Letra principal</strong>
                            <input type="color" class="form-control" value="{{ $LetraPrincipal }}" name="LetraPrincipal">
                        </div>
                    </div>
                    <hr>
                    <center><h5><strong>LETRAS (SELECCIONADO)</strong></h5></center>
                    <br>
                    <div class="row"> 
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                            <strong>Letra lista</strong>
                            <input type="color" class="form-control" value="{{ $FocoSelecLetra }}" name="FocoSelecLetra">
                        </div> 
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                            <strong>Principal lista</strong>
                            <input type="color" class="form-control" value="{{ $FocoSelecFondo }}" name="FocoSelecFondo">
                        </div> 
                    </div>
                    <div class="card-footer text-muted">
                        <div class="btn-group" style=" width:100%;">
                            <button type="submit" id="btnEnviar1" class="btn btn-success  btn-submit active">INGRESAR</button>
                        </div>
                    </div>
                </form>
                <form id="F_prestamo" name="F_prestamo" method="POST" action="{{ route('BorrarColores') }}">
                        @csrf
                        <div class="card-footer text-muted">
                        <div class="btn-group" style=" width:100%;">
                            <button type="submit" id="btnEnviar1" class="btn btn-danger  btn-submit active">RESTABLECER</button>
                        </div>
                    </div>
                </form>
                <div class="card-footer text-muted">
                    GESTION DOCUMENTAL
                </div>
            </div>
        </div>	
    </div>	
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3"></div>				
</div>
@endsection    