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
                            <center><img src="{{URL::asset('Imagenes/ROOT/FirmaMasiva.JPG')}}" width="1200" height="1200" class="img-fluid" alt="Responsive image"/></center> 
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
                            <h1><center><strong>HABILITAR O DESABILITAR FIRMA MASIVA DE FUNCIONARIOS</strong></center></h1>
                            <hr>
                        </div> 
                        <div class="card-body"> 
                        <div class="row">  
                            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-2">
                                <button class="btn" wire:click="Ayuda"><img src="{{URL::asset('Imagenes/ayuda.png')}}" width="25" height="25"/></button>
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
                            <table table class="table table-hover">
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
                                    @if($post->FirmaMasiva==0)
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
                            GESTIÓN DOCUMENTAL
                    </div>
                </div> 
            </div>
        </div> 
    </div>
</div> 
@endif