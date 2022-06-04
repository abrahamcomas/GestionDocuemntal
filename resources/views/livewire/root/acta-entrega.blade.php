<div>
    <br>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            @include('messages')  
        </div>
    </div>
    <div class="container-fluid">  
        <div class="row">  
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="col">
                    <div class="card bg-light mb-3"> 
                        <div class="text-muted" >
                            <br> 
                            <h1><center><strong>HABILITAR O DESABILITAR ACTA DE ENTREGA</strong></center></h1>
                            <hr>
                        </div>
                        <div class="card-body"> 
                        <div class="row">  
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-2">
                            </div>
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-6">
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
                        @if($Lista->count())
                            <table table class="table table-hover table-sm"> 
                                <thead>
                                    <tr> 
                                        <th>RUN</th>
                                        <th>NOMBRE</th>
                                        <th>APELLIDO</th>
                                        <th>AGREGAR</th>
                                    </tr> 
                                </thead>  
                                <tbody>   
                                    @foreach($Lista as $post)
                                    <tr>
                                        <td>{{ $post->Rut }}</td>
                                        <td>{{ $post->Nombres }}</td>
                                        <td>{{ $post->Apellidos }}</td>
                                    @if($post->Acta==0) 
                                        <td>
                                            <button class="btn btn-success active btn-info"  wire:click="Select({{ $post->ID_Funcionario_T }})">HABILITAR</button>
                                        </td>
                                    @else
                                        <td>
                                            <button class="btn btn-danger active btn-info"  wire:click="Select({{ $post->ID_Funcionario_T }})">DESABILITAR</button>
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