@extends('App2') 
@section('content')
@if(!Auth::guard('web')->check()) 
<div class="container">
    <div class="row"> 
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1"></div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10">
            @include('messages')
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1"></div>
    </div> 
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1"></div>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-10">
            <section>
            <div class="form-login">
                <center><h2><strong>SISTEMA GESTIÓN DOCUMENTAL (SGD)</strong></h2></center>  
                <div class="card-body">
                <h4><strong>INICIAR SESIÓN</strong></h4>
                    <form method="POST" action="{{ route('Login') }}">  
                        @csrf 
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <span class="input-group-text"><img src="{{URL::asset('Imagenes/user.png')}}" height="25" alt="Curicó"/></span>
                            </div>
                            <input type="text" class="form-control" name="RUN" id="RUN" oninput="checkRut(this)" placeholder="Rut" value="{{ old('RUN') }}">
                        </div>
                        <div class="input-group mb-2">
                            <div class="input-group-append">
                                <span class="input-group-text"><img src="{{URL::asset('Imagenes/password.png')}}" height="25" alt="Curicó"/></span>
                            </div>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Contraseña" autocomplete="on">
                        </div>
                        <div class="btn-group" style=" width:100%;">	
                            <button type="submit" class="btn btn-success">ACEPTAR</button>
                        </div>
                    </form> 
                </div>
                <div class="card-footer text-muted">
                    <div class="btn-group" style=" width:100%;">
                        <a href="{{ route('Recuperar') }}" style="color: white;"><strong>RECUPERAR CONTRASEÑA</strong></a>
                        <hr>
                        <a href="{{ route('Registrarse') }}" style="color: white;"><strong>REGISTRO</strong></a>
                    </div>   
                </div> 
                <div class="card-footer text-muted" >
                    <center><p style="color: #FFFFFF;">Proyecto Desarrollado por el Departamento de Informática 2021-2022</p></center>
                    <center><p style="color: #FFFFFF;">ILUSTRE MUNICIPALIDAD DE CURICÓ</p></center> 
                </div>
                <br>
                <center><strong style="color: #56FF02;">VERSIÓN 1.2</strong></center>
            </div>
            </section>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1"></div>
    </div>
</div>	
@endif
@endsection 
@section('scripts')
@endsection