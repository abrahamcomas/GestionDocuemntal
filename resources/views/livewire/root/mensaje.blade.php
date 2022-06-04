<div class="container-fluid">  
    <br>
    <div class="row">   
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col">
                <div class="card bg-light mb-3">  
                    <div class="text-muted" >
                        <br> 
                        <h1><center><strong>AGREGAR MENSAJE PUBLICO</strong></center></h1>
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
                        @if($Mensaje->count())
                            <table table class="table table-hover table-sm"> 
                                <thead>
                                    <tr> 
                                        <th>MENSAJE</th>
                                        <th>FECHA INGRESADO</th>
                                        <th>ESTADO</th>
                                        <th>ELIMINAR</th>
                                    </tr> 
                                </thead>    
                                <tbody>
                                @foreach($Mensaje as $post)  
                                    <tr>
                                        <td>
                                            <textarea class="form-control" disabled>{{$post->Mensaje}}</textarea>
                                        </td>
                                        <td>
                                            {{date("d/m/Y", strtotime($post->FechaInicio)) }}
                                        </td>
                                        @if($post->Estado==0)
                                            <td>
                                                <button class="btn btn-warning active">DASABILITADO</button>
                                            </td>
                                        @else 
                                            <td>
                                            <button class="btn btn-success active">HABILITADO</button>
                                            </td>
                                        @endif 
                                        <td>
                                                <button class="btn btn-danger active"  wire:click="Eliminar({{ $post->id_Mensaje  }})">ELIMINAR</button>
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
                        {{ $Mensaje ->links() }}
                    </div> 
                    <div class="card-body table-responsive">
                        <table table class="table table-hover table-sm">   
                            <tbody>
                                <tr>
                                    <td> 
                                        <input type="text" class="form-control"wire:model="MensajeIngresado" placeholder="MENSAJE">
                                    </td>
                                    <td>
                                        <button class="btn btn-success active"  wire:click="IngresarMensaje">INGRESAR</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>  
                    </div>
                    <div class="card-footer text-muted"> 
                        SGD
                    </div>
                </div> 
            </div>
        </div> 
    </div>
</div>
                    