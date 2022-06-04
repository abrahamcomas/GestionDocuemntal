<div class="container-fluid">  
    <br>
    <div class="row">  
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col">
                <div class="card bg-light mb-3">
                    <div class="text-muted" >
                        <br> 
                        <h1><center><strong>AGREGAR PLANTILLAS</strong></center></h1>
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
                    <div class="card-body table-responsive">
                        @if($plantillas->count())
                            <table table class="table table-hover">
                                <thead>
                                    <tr> 
                                        <th>NOMBRE</th>
                                        <th>DESCARGAR</th>
                                        <th>ELIMINAR</th>
                                    </tr> 
                                </thead>  
                                <tbody>
                                @foreach($plantillas as $post)  
                                    <tr>
                                        <td> 
                                            {{$post->nombre_plantilla }}
                                        </td>
                                        <td>
                                            <form method="POST" action="{{ route('DescargarPlantillas') }}" enctype="multipart/form-data">
                                                @csrf  
                                                <input type="hidden" name="id_plantillas" value="{{ $post->id_plantillas  }}">
                                                <button type="submit" class="btn btn-info active" style="background: #31A877;">DESCARGAR</button>
                                            </form> 
                                        </td>
                                        <td>
                                            <button class="btn btn-danger active"  wire:click="EliminarPlantillas({{ $post->id_plantillas }})">ELIMINAR</button>
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
                        {{ $plantillas->links() }}
                    </div>	   
                    <div class="form-group">      
                        @include('messages')
                        <h6>AGREGAR ARCHIVO/S* <strong>WORD</strong></h6>
                        <div class="form-label-group"> 
                            <input type="file" class="form-control" wire:model="word" accept="application/word">
                        </div> 
                        <div wire:loading wire:target="word">
                            <center> 
                                <h5><strong>Subiendo documentos, espere por favor...</strong></h5>
                            </center>
                        </div> 
                    </div>
                    <div class="btn-group" style=" width:100%;">
                        <button class="btn btn-primary" wire:click="IngresarPalntilla">INGRESAR</button>
                    </div>
                    <div class="card-footer text-muted"> 
                        SGD
                    </div>
                </div> 
            </div>
        </div> 
    </div>
</div> 


                    