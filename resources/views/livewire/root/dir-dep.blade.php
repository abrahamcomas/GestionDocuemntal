<div class="container-fluid">   
@if($Estado==0)
    <br>
    <div class="row">    
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col">
                <div class="card bg-light mb-3">  
                    <div class="text-muted" >
                        <br> 
                        <h1><center><strong>AGREGAR DIRECCIÓN O DEPARTAMENTO</strong></center></h1>
                        <hr>
                    </div>  
                    <div class="card-body">
                        @include('messages')  
                        @if (session()->has('message1'))
                            <div class="alert alert-success">
                                {{ session('message1') }}
                            </div>
                        @endif 
                        <div class="row">  
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-8">
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
                    <div class="card-body table-responsive">
                        @if($DepDirecciones->count())
                            <table table class="table table-hover table-sm"> 
                                <thead>
                                    <tr> 
                                        <th>NOMBRE</th>
                                        <th>EDITAR</th>
                                        <th>ESTADO</th>
                                    </tr> 
                                </thead>   
                                <tbody>
                                @foreach($DepDirecciones as $post)  
                                    <tr>
                                        <td> 
                                            <input type="text" class="form-control" placeholder="{{$post->Nombre_DepDir}}" disabled>
                                        </td>
                                        <td>
                                            <button class="btn btn-warning active"  wire:click="Editar({{ $post->ID_DepDir}})">EDITAR</button>
                                        </td>
                                        @if($post->EstadoDirDep==0)
                                            <td>
                                                <button class="btn btn-danger active"  wire:click="Habilitar({{ $post->ID_DepDir}})">DASABILITADO</button>
                                            </td>
                                        @else
                                            <td>
                                                <button class="btn btn-success active"  wire:click="Desabilitar({{ $post->ID_DepDir}})">HABILITADO</button>
                                            </td>

                                        @endif
                                        
                                    </tr>
                                @endforeach   
                                </tbody>
                            </table> 
                        @else 
                            <center><strong>No hay resultados para la búsqueda "{{ $search }}"</strong></center>
                        @endif
                    </div>   
                    <div class="card-footer table-responsive text-muted">
                        {{ $DepDirecciones ->links() }}
                    </div>	
                    <div class="form-group">   
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1"></div> 	
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10">
                                <h6>AGREGAR DIRECCIÓN O DEPARTAMENTO</h6>
                                <div class="form-label-group"> 
                                    <div class="form-label-group"> 
                                        <input type="text" class="form-control" wire:model="Nombre">
                                    </div>		
                                </div> 	
                            </div> 	                      
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1"></div> 	
                        </div>    
                    </div>
                    <div class="btn-group" style=" width:100%;">
                        <button class="btn btn-primary" wire:click="Ingresar">INGRESAR</button>
                    </div>
                    <div class="card-footer text-muted"> 
                        SGD
                    </div>
                </div> 
            </div>
        </div> 
    </div>
</div> 
@else
<br>
    <div class="row">    
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col">
                <div class="card bg-light mb-3">  
                    <div class="text-muted" >
                        <br> 
                        <h1><center><strong>AGREGAR DIRECCIÓN O DEPARTAMENTO</strong></center></h1>
                        <hr>
                    </div>
                    <div class="card-body">
                        @include('messages')  
                        @if (session()->has('message1'))
                            <div class="alert alert-success">
                                {{ session('message1') }}
                            </div>
                        @endif  
                    </div> 
                    <div class="card-body table-responsive">
                        <table table class="table table-hover table-sm"> 
                            <thead>
                                <tr>  
                                    <th>NOMBRE</th>
                                    <th>ACTUALIZAR</th>
                                    <th>EDITAR</th>
                                </tr> 
                            </thead>    
                            <tbody>
                                <tr>
                                    <td> 
                                        <input type="text" class="form-control" placeholder="{{$NombreEditado}}" disabled>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" wire:model="NombreNuevo">
                                    </td>
                                    <td>
                                        <button class="btn btn-warning active"  wire:click="ConfirmarEditar">EDITAR</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table> 
                    </div>   
                    <div class="btn-group" style=" width:100%;">
                        <button class="btn btn-danger" wire:click="Volver">VOLVER</button>
                    </div>
                    <div class="card-footer text-muted"> 
                        SGD
                    </div>
                </div> 
            </div>
        </div> 
    </div>
</div> 
@endif

                    