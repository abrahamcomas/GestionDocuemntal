<div>
<br>
    @if($Estado==1)
        <div class="container-fluid"> 
            <div class="row"> 
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3"></div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                    @include('messages')
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3"></div>
            </div>
            <br> 
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3"></div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                    <div class="col">  
                        <div class="card bg-light mb-3">
                            <div class="card-header">
                                <center><h5><strong>REGISTRO</strong></h5></center> 
                            </div> 
                            <div class="card-body"> 
                                <div class="form-group">
                                    <input type="text" class="form-control" wire:model="Rut" oninput="checkRut(this)" placeholder="Rut" autocomplete="on">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" wire:model="Nombres"  placeholder="Nombres" autocomplete="on">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" wire:model="Apellidos" placeholder="Apellidos" autocomplete="on">
                                </div> 
                                <div class="form-group">
                                    <input type="password" class="form-control" wire:model="Contrasenia" placeholder="Contraseña" autocomplete="on">
                                </div>  
                                <div class="form-group"> 
                                    <input type="password" class="form-control" wire:model="Confirmar_Contrasenia" placeholder="Confirmar Contraseña" autocomplete="on">
                                </div>  
                                <div class="form-group">
                                    <input type="email" class="form-control" wire:model="Email" placeholder="Email" >
                                </div> 
                                <div class="form-group">
                                    <input type="text"  class="form-control" wire:model="Telefono" placeholder="Teléfono municipal +56912345678" min="12" maxlength="12">
                                </div>
                                <div class="form-group">
                                    <input type="text"  class="form-control" wire:model="Cargo" placeholder="Cargo">
                                </div>
                                <div class="form-group">
                                    <h6>Buscar departamento o dirección</h6>
                                    <input class="form-control" type="text" placeholder="{{$NombreOficinaParte}}" wire:model="BuscarOficinaPartes"/>
                                    @if($BuscarOficinaPartes!="")
                                        <table table class="table table-hover">
                                            <tbody> 
                                                @foreach($OficinaPartes as $post)
                                                    <tr>
                                                        <td>
                                                            {{$post->Nombre_DepDir}}
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-success active" wire:click="OficinaPartesSeleccionada({{ $post->ID_DepDir }})">SELECCIONAR</button>
                                                        </td>
                                                    </tr>
                                                @endforeach  
                                            </tbody> 
                                        </table>     
                                    @endif	
                                </div>
                                <div class="btn-group" style=" width:100%;">	
                                    <button type="button" class="btn btn-primary active" wire:click="Registro">ACEPTAR</button>
                                </div>	
                            </div> 	
                            <div class="card-footer text-muted">
                                <div class="btn-group" style=" width:100%;">	
                                    <a href="{{ route('Index') }}" style="color: #2AADB8;"><strong>VOLVER</strong></a>
                                </div>	      
                            </div>	
                        </div>	
                    </div>	
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3"></div>
            </div>
        </div>
    @else
        <br>
        <div class="row"> 
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3"></div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                <div class="col">
                    <div class="card bg-light mb-3">
                        <div class="card-header">
                            <center><h5><strong>REGISTRO</strong></h5></center> 
                        </div> 
                        <div class="card-body">
                            <div class="form-group"> 
                            <center><h5 style="color: #2AADB8;"><strong>{{ $Resultado }}</strong></h5></center> 
                            </div>
                        </div>
                        <div class="card-footer text-muted">
                            <center><a href="{{ route('Index') }}" style="color: #2AADB8;"><strong>VOLVER</strong></a></center> 
                        </div>
                    </div> 
                </div> 
            </div>		
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3"></div>				
        </div>	
    @endif
</div>
