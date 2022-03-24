<div>
<br>     
@if($Ayuda==1)    
    <div class="container-fluid">  
        <div class="row">  
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="col">
                    <div class="card bg-light mb-3">  
                        <div class="card-header"> 
                        <center>
                                <h5> 
                                    <strong>
                                        INFORMACIÓN
                                    </strong>
                                </h5>
                            </center> 
                        </div>
                        <div class="card-body">
                            <center><img src="{{URL::asset('Imagenes/ROOT/AgregarJefe.JPG')}}" width="1200" height="1200" class="img-fluid" alt="Responsive image"/></center> 
                        </div>
                        <div class="card-footer text-muted"> 
                            <div class="btn-group" style=" width:100%;">	
                                <button class="btn btn-danger active" wire:click="VolverAyuda">
                                    VOLVER
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="container-fluid">   
        <div class="row">  
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="col">
                    <div class="card bg-light mb-3">  
                        <div class="card-header"> 
                            <h4><strong>AGREGAR JEFE OFICINA DE PARTES (ODP)</strong></h4>
                        </div>
                        <div class="row">  
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                                <button class="btn" wire:click="Ayuda"><img src="{{URL::asset('Imagenes/ayuda.png')}}" width="25" height="25"/></button>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                            </div>
                        </div> 
                        <br>
                        @if($CambiarBusqueda==0)
                            @if($ID_DepDir==0)
                                <h5><strong>BUSCAR DEPARTAMENTO O DIRECCIÓN</strong></h5>
                                <hr>
                                <center>
                                    <div class="btn-group" style=" width:50%;">	
                                        <button class="btn btn-success active" wire:click="CambiarBusqueda"> 
                                            CAMBIAR BUSQUEDA
                                        </button>
                                    </div>
                                </center> 
                                <hr>
                                <input class="form-control" type="text" placeholder="{{$NombreOficinaParte}}" wire:model="BuscarOficinaPartes"/>
                            @endif
                            @if($BuscarOficinaPartes!="")
                                <div class="card-body table-responsive">
                                    <table table class="table table-hover">
                                        <thead>
                                            <tr> 
                                                <th>NOMBRE</th>
                                                <th>JEFE</th> 
                                                <th>OPCIONES</th> 
                                            </tr> 
                                        </thead> 
                                        <tbody> 
                                            @foreach($OficinaPartes as $post)
                                                <tr>
                                                    <td> 
                                                        {{$post->Nombre_DepDir}}
                                                    </td> 
                                                    <td>
                                                        {{$post->Nombres}} {{$post->Apellidos}}
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-success active" wire:click="OficinaPartesSeleccionada({{ $post->ID_DepDir }})">SELECCIONAR</button>
                                                    </td>
                                                </tr> 
                                            @endforeach  
                                        </tbody> 
                                    </table>     
                                </div>
                            @endif	
                        @else
                            @if($ID_DepDir==0)
                                <h5><strong>BUSCAR POR FUNCIONARIO</strong></h5>
                                <hr>
                                <center>
                                    <div class="btn-group" style=" width:50%;">	
                                        <button class="btn btn-success active" wire:click="CambiarBusqueda">
                                            CAMBIAR BUSQUEDA
                                        </button>
                                    </div>
                                </center> 
                                <hr>
                                <input class="form-control" type="text" wire:model="BuscarNombre"/>
                            @endif
                            @if($BuscarNombre!="")
                                <div class="card-body table-responsive">
                                    <table table class="table table-hover">
                                        <thead>
                                            <tr> 
                                                <th>NOMBRE</th>
                                                <th>DEPT O DIREC</th>
                                                <th>OPCIONES</th>  
                                            </tr> 
                                        </thead>  
                                        <tbody> 
                                            @foreach($BFuncionarios as $post)
                                                <tr>
                                                    <td> 
                                                        {{$post->Nombres}} {{$post->Apellidos}}
                                                    </td> 
                                                    <td>{{$post->Nombre_DepDir}}</td>
                                                    <td>
                                                        <button class="btn btn-success active" wire:click="NombreSeleccionado({{ $post->ID_DepDir }})">SELECCIONAR</button>
                                                    </td>
                                                </tr>
                                            @endforeach   
                                        </tbody> 
                                    </table>     
                                </div>   
                            @endif	
                        @endif 
                         
                        @if($BuscarLista!=0)
                            <div class="card-body table-responsive">
                                <br>                         
                                <tbody>
                                    <td>
                                        @if($ID_DepDir!=0)
                                            <h5><strong>Encargado {{ $JefeNombre }} {{ $JefeApellido }}</strong></h5>
                                        @endif
                                    </td>
                                </tbody>
                                <table table class="table table-hover">
                                    <thead>
                                        <tr> 
                                            <th>RUN</th>
                                            <th>NOMBRE</th>
                                            <th>APELLIDO</th>
                                            <th>ADMINISTRAR</th>
                                        </tr> 
                                    </thead> 
                                    <tbody>  
                                        @foreach($ListaFuncionariosOP as $post)
                                        <tr>
                                            <td>{{ $post->Rut }}</td>
                                            <td>{{ $post->Nombres }}</td>
                                            <td>{{ $post->Apellidos }}</td>
                                            <td>
                                                <button class="btn btn-success active btn-info"  wire:click="SeleccionarJefe({{ $post->ID_Funcionario_T }})">SELECCIONAR</button>
                                            </td>
                                        </tr>
                                        @endforeach  
                                    </tbody> 
                                </table>
                            </div>
                            <div class="btn-group" style=" width:100%;">	
                                <button type="button" class="btn btn-danger" id="IngresoMulta" wire:click="Volver">
                                    Volver
                                </button> 
                            </div>
                        @endif
                        <div class="card-footer text-muted"> 
                            GESTIÓN DOCUMENTAL
                        </div>
                    </div> 
                </div>
            </div> 
        </div>
    </div> 
</div> 
@endif
 