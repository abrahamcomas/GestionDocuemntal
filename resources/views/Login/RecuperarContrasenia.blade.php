@extends('App2')
@section('content')
<div class="container">   
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1"></div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-10">
            <section>
            <div class="form-login">
                <center><h2><strong>GESTIÓN DOCUMENTAL</strong></h2></center>  
                <div class="card-body">
                    <h4><strong>RESTAURACIÓN DE CONTRASEÑA</strong></h4>
                    <form method="POST" action="{{ route('ContraseniaEnviada') }}">
                        @csrf 
                        @if (count($errors) > 0)
                            @foreach ($errors->get('Rut') as $message)
                                <p style="color: white;">{{ $message }}</p>
                            @endforeach
                        @endif
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <span class="input-group-text"><img src="{{URL::asset('Imagenes/user.png')}}" height="25" alt="Curicó"/></span>
                            </div>
                            <input type="text" class="form-control" name="Rut" id="Rut" oninput="checkRut(this)" placeholder="Rut" value="{{ old('Rut') }}">
                        </div>   
                        <div class="btn-group" style=" width:100%;">	
                            <button type="submit" class="btn btn-success">ACEPTAR</button>
                        </div>	
                    </form>
                </div>
                <div class="card-footer text-muted">
                    <div class="btn-group" style=" width:100%;">
                        <a href="{{ route('Index') }}" style="color: white;"><strong>VOLVER</strong></a>
                        <hr>
                    </div>   
                </div> 
                <div class="card-footer text-muted" >
                    <center><p style="color: #FFFFFF;">Proyecto Desarrollado por el Departamento de Informática 2021-2022</p></center>
                    <center><p style="color: #FFFFFF;">ILUSTRE MUNICIPALIDAD DE CURICÓ</p></center> 
                </div>
            </div>
            <section>
            <br>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1"> </div>
    </div>
</div>
@endsection   