<div>   
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
                <div class="form-login">
                    <center><h2><strong>GESTIÓN DOCUMENTAL</strong></h2></center>  
                    @if($Estado==1)
                    <div class="card-body"> 
                        <h4><strong>REGISTRO</strong></h4>
                        <div class="input-group mb-3">
                            <div class="input-group-append">
                                <span class="input-group-text"><img src="{{URL::asset('Imagenes/user.png')}}" height="25" alt="Curicó"/></span>
                            </div>
                            <input type="text" class="form-control" wire:model="Rut" oninput="checkRut(this)" placeholder="Rut" autocomplete="off">
                        </div> 
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><img src="{{URL::asset('Imagenes/user.png')}}" height="25" alt="Curicó"/></span>
                                    </div>
                                    <input type="text" class="form-control" wire:model="Nombres"  placeholder="Nombres" autocomplete="off">
                                </div> 
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><img src="{{URL::asset('Imagenes/user.png')}}" height="25" alt="Curicó"/></span>
                                    </div>
                                    <input type="text" class="form-control" wire:model="Apellidos" placeholder="Apellidos" autocomplete="off">
                                </div> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><img src="{{URL::asset('Imagenes/password.png')}}" height="25" alt="Curicó"/></span>
                                    </div>
                                    <input type="password" class="form-control" wire:model="Contrasenia" placeholder="Contraseña" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><img src="{{URL::asset('Imagenes/password.png')}}" height="25" alt="Curicó"/></span>
                                    </div>
                                    <input type="password" class="form-control" wire:model="Confirmar_Contrasenia" placeholder="Confirmar Contraseña" autocomplete="off">
                                </div>  
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><img src="{{URL::asset('Imagenes/email.png')}}" height="25" alt="Curicó"/></span>
                                    </div>
                                    <input type="email" class="form-control" wire:model="Email" placeholder="Email" >
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><img src="{{URL::asset('Imagenes/telephone.png')}}" height="25" alt="Curicó"/></span>
                                    </div>
                                    <input type="text"  class="form-control" wire:model="Telefono" placeholder="Teléfono municipal +56912345678" min="12" maxlength="12">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><img src="{{URL::asset('Imagenes/user.png')}}" height="25" alt="Curicó"/></span>
                                    </div>
                                    <input type="text"  class="form-control" wire:model="Cargo" placeholder="Cargo">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                                <div class="input-group mb-3">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><img src="{{URL::asset('Imagenes/user.png')}}" height="25" alt="Curicó"/></span>
                                    </div>
                                    <select wire:model="Contrato" class="form-control">
                                        <option value="" selected>--Seleccionar Contrato--</option>
                                        <option value="1" style="color: #000000;">Código</option>
                                        <option value="2" style="color: #000000;">Planta</option>
                                        <option value="3" style="color: #000000;">Contrata</option>
                                        <option value="4" style="color: #000000;">Honorario</option>
                                    </select> 
                                </div> 
                            </div>
                        </div>
                        <div class="form-group"> 
                            <h6>Buscar departamento o dirección</h6>
                            <input class="form-control" type="text" placeholder="{{$NombreOficinaParte}}" wire:model="BuscarOficinaPartes"/>
                            @if($BuscarOficinaPartes!="")
                                <table table class="table table-hover">
                                    <tbody> 
                                        @foreach($OficinaPartes as $post)
                                            <tr>
                                                <td style="color: #FFFFFF;">
                                                    {{$post->Nombre_DepDir}}
                                                </td>
                                                <td>
                                                    <button class="btn btn-success" wire:click="OficinaPartesSeleccionada({{ $post->ID_DepDir }})">SELECCIONAR</button>
                                                </td>
                                            </tr>
                                        @endforeach  
                                    </tbody> 
                                </table>     
                            @endif	
                        </div>
                        <div class="btn-group" style=" width:100%;">	
                            <button type="button" class="btn btn-success" wire:click="Registro">ACEPTAR</button>
                        </div>
                    </div>	
                    <div class="card-footer text-muted">
                        <div class="btn-group" style=" width:100%;">
                            <a href="{{ route('Index') }}" style="color: #FFFFFF;"><strong>VOLVER</strong></a>
                            <hr>
                        </div>   
                    </div> 
                    <div class="card-footer text-muted" >
                        <center><p style="color: #FFFFFF;">Proyecto Desarrollado por el Departamento de Informática 2021-2022</p></center>
                        <center><p style="color: #FFFFFF;">ILUSTRE MUNICIPALIDAD DE CURICÓ</p></center> 
                    </div>
                </div> 	
            </div> 	
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1"></div>	
        </div> 	
        @else
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1"></div>
		    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10"> 
                <div class="form-login"> 
                    <div class="card-body">
                        <div class="form-group"> 
                            <center><h5 style="color: #2AADB8;"><strong>{{ $Resultado }}</strong></h5></center> 
                        </div>
                    </div>
                    <div class="card-footer text-muted">
                        <div class="btn-group" style=" width:100%;">
                            <a href="{{ route('Index') }}" style="color: #FFFFFF;"><strong>VOLVER</strong></a>
                            <hr>
                        </div>   
                    </div> 
                    <div class="card-footer text-muted" >
                        <center><p style="color: #FFFFFF;">Proyecto Desarrollado por el Departamento de Informática 2021-2022</p></center>
                        <center><p style="color: #FFFFFF;">ILUSTRE MUNICIPALIDAD DE CURICÓ</p></center> 
                    </div>
                </div> 	
            </div> 	
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1"></div>
        </div> 	
        @endif
        <br>
    </div>
</div>

