<div>
<br>         
@if($Detalles==0)  
    <br>
    <div class="container-fluid">  
        <div class="row">  
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="col">
                    <div class="card bg-light mb-3"> 
                        <div class="text-muted" >
                            <br> 
                            <h1><center><strong>LISTA FUNCIONARIOS</strong></center></h1>
                            <hr>
                        </div>
                        <div class="card-body">
                        <div class="row">  
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"></div>
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                <input class="form-control" type="text" placeholder="Buscar..." wire:model="search" title="Buscar por titulo,Tipo documento, Observación"/>
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                <div class="row"> 
                                    <div class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
                                        <select  class="form-control" wire:model="perPage">
                                            <option value="5" selected>Mostrar 5 por página</option>
                                            <option value="10">Mostrar 10 por página</option>
                                            <option value="15">Mostrar 15 por página</option>
                                            <option value="20">Mostrar 20 por página</option>
                                            <option value="25">Mostrar 25 por página</option>
                                            <option value="30">Mostrar 30 por página</option>
                                        </select>
                                    </div>
                                    <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
                                        <center>
                                            <button wire:click="clear" type="button" class="btn btn-danger active">X</button>
                                        </center>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div> 
                    <div class="table-responsive">
                        <div class="card-body">
                            @if($Lista->count())
                                <table table class="table table-hover table-sm"> 
                                    <thead>
                                        <tr> 
                                            <th>RUT</th>
                                            <th>NOMBRE</th>
                                            <th>APELLIDO</th>
                                            <th>ADMINISTRAR</th>
                                        </tr> 
                                    </thead> 
                                    <tbody>  
                                        @foreach($Lista as $post)
                                        <tr>
                                            <td>{{ $post->Rut }}</td>
                                            <td>{{ $post->Nombres }}</td>
                                            <td>{{ $post->Apellidos }}</td>
                                            <td>
                                                <button class="btn btn-success active btn-info"  wire:click="Administrar({{ $post->ID_Funcionario_T }})">ADMINISTRAR</button>
                                            </td>
                                        </tr>
                                        @endforeach  
                                    </tbody>
                                </table>
                            @else 
                                <center><strong>No hay resultados para la búsqueda "{{ $search }}"</strong></center>
                            @endif
                        </div>  
                        <div class="card-footer table-responsive text-muted">
                            {{ $Lista->links() }}
                        </div>	
                        <div class="card-footer text-muted"> 
                            SGD
                        </div>
                    </div> 
                </div> 
            </div>
        </div> 
    </div>
@elseif($Detalles==1) 
    <br>
    <div class="container-fluid">  
        <div class="text-muted" >
            <br> 
            <h1><center><strong>Funcionario {{ $Nombres}} {{$Apellidos}}</strong></center></h1>
            <hr>
        </div>
        <div class="row"> 
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                <div class="col">
                    <div class="card bg-light mb-3"> 
                        <br>
                            <center><h5><strong>LISTA PERMISOS</strong></h5></center>
                        <div class="table-responsive">
                            <div class="card-body">
                                <table table class="table table-hover table-sm"> 
                                    <thead>
                                        <tr> 
                                            <th>PERMISOS</th>
                                            <th>AGREGAR</th>
                                        </tr> 
                                    </thead> 
                                    <tbody>  
                                        @foreach($Menu as $post)
                                            <tr>
                                                <td>{{$post->NombreMenu }}</td>
                                                <td>
                                                    <button class="btn btn-success active"  wire:click="Agregar({{$post->id_Menu}})">AGREGAR</button>
                                                </td>
                                            </tr>
                                        @endforeach  
                                    </tbody>  
                                </table>
                            </div>
                            <div class="card-footer text-muted"> 
                                {{ $Menu->links() }}
                            </div>
                            <div class="card-footer text-muted"> 
                                SGD
                            </div>
                        </div> 
                    </div>
                </div>
            </div> 
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-6">
                <div class="col">
                    <div class="card bg-light mb-3"> 
                        <br>
                            <center><h5><strong>ADMINISTRAR</strong></h5></center> 
                        <div class="table-responsive">
                            <div class="card-body">
                                @if($Roles->count())
                                    <table table class="table table-hover table-sm"> 
                                        <thead>
                                            <tr>
                                                <th>PERMISOS</th>
                                                <th>ELIMINAR</th>
                                            </tr> 
                                        </thead> 
                                        <tbody>  
                                            @foreach($Roles as $post)
                                            <tr>
                                                <td>{{ $post->NombreMenu  }}</td>
                                                <td>
                                                    <button class="btn btn-danger active"  wire:click="Eliminar({{ $post->Id_Roles   }})">ELIMINAR</button>
                                                </td>
                                            </tr>
                                            @endforeach  
                                        </tbody>
                                    </table> 
                                @endif
                            </div>  
                            <div class="card-footer text-muted">
                                {{ $Roles->links() }}
                            </div>	
                            <div class="card-footer text-muted"> 
                                SGD
                            </div>
                        </div> 
                    </div>
                </div>
            </div> 
        </div>
        <div class="btn-group" style=" width:100%;">	
            <button class="btn btn-danger active"  wire:click="Volver">VOLVER</button>
        </div>
    </div>
@endif 
</div> 
 