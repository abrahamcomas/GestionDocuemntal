<div>
<br>
    <div class="row">  
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
                <div class="col">
                    <div class="card bg-light mb-3"> 
                        <div class="card-header"> 
                            <h4><strong>LISTA PLANTILLAS</strong></h4> 
                        </div>
                        <div class="card-body"> 
                            <div class="row">   
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <select  class="form-control" wire:model="Listado">
                                        <option value="5" selected>Creados</option>
                                        <option value="10">Publicos</option>
                                    </select>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                    <input class="form-control" type="text" placeholder="Buscar..." wire:model="search" title="Buscar por titulo,Tipo documento, Observación"/>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
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
                    @if($plantillas->count())
                        <div class="card-body table-responsive">
                            <table table class="table table-hover"> 
                                <thead>  
                                    <tr>
                                        <th>NOMBRE</th>
                                        <th>UTILIZAR</th>
                                        <th>ACTUALIZAR</th>
                                        <th>ELIMINAR</th>
                                    </tr>
                                </thead>    
                                <tbody> 
                                    @foreach($plantillas as $post) 
                                            <tr>
                     
                                                <td> 
                                                    <strong>{{$post->nombre_plantilla}}</strong>
                                                </td>
                                                <td> 
                                                <form method="POST" action="{{ route('MostrarPlantillas') }}">  
                                                    @csrf 
                                                    <input type="hidden" id="id_plantillas" name="id_plantillas" value="{{ $post->id_plantillas  }}">
                                                    <button type="submit" class="btn btn-success">UTILIZAR</button>
                                                </form>
                                                </td>
                                                <td> 
                                          
                                          <button type="submit" class="btn btn-warning">ACTUALIZAR</button>
                                  
                                      </td>
                                                <td> 
                                          
                                                    <button type="submit" class="btn btn-danger">ELIMINAR</button>
                                            
                                                </td>
                                            </tr>
                                    @endforeach   
                                </tbody> 
                            </table>
                            <div class="btn-group" style=" width:100%;">
                                            <button class="btn btn-primary" wire:click="Ingresar">CREAR PLANTILLA</button>
                                        </div>
                        </div>
                    @else 
                        <div class="card-body">
                            <center><strong>No hay resultados para la búsqueda "{{ $search }}"</strong></center>
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
