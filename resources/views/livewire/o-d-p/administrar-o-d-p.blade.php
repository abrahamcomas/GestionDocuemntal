<div>
<br>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            @include('messages')  
        </div>
    </div>  
@if($MostrarPagina==1)   
@if($Detalles==0)
    <div class="container-fluid">  
        <div class="row">  
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="col">
                    <div class="card bg-light mb-3"> 
                        <div class="text-muted" >
                            <br> 
                            <h1><center><strong>AGREGAR FUNCIONARIO ODP</strong></center></h1>
                            <hr>
                        </div>
                        <div class="row">  
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1"></div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10">
                                <div class="text-muted" >
                                    <h4><strong>FUNCIONARIOS HABILITADOS</strong></h4>
                                </div>
                                <table table class="table table-hover table-sm table-bordered">
                                    <thead>
                                        <tr> 
                                            <th><center>FUNCIONARIOS</center></th> 
                                            <th><center>ODP</center></th> 
                                        </tr> 
                                    </thead>  
                                    <tbody>  
                                        @foreach($FuncionariosApoyo as $post)
                                        <tr>
                                            <td><center>{{$post->Nombres}} {{$post->Apellidos}}</center></td>
                                            <td><center>{{$post->Nombre_DepDir}}</center></td>
                                        </tr>
                                        @endforeach  
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1"></div>
                        </div>      
                        <div class="text-muted" >
                            <h4><strong><center>LISTA DE FUNCIONARIOS</center></strong></h4>
                        </div>
                        <div class="card-body">
                            <div class="row">   
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-2"></div>
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
                                <table table class="table table-hover table-bordered">
                                    <thead>
                                        <tr> 
                                            <th>RUN</th>
                                            <th>FUNCIONARIO</th>
                                            <th>AREA LABORAL</th>
                                            <th>ADMINISTRAR</th>
                                        </tr> 
                                    </thead>  
                                    <tbody>  
                                        @foreach($Lista as $post)
                                        <tr>
                                            <td>{{ $post->Rut }}</td>
                                            <td>{{ $post->Nombres }} {{ $post->Apellidos }}</td>
                                            <td>{{ $post->Nombre_DepDir }}</td>
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
        <div class="row"> 
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="col">
                    <div class="card bg-light mb-3"> 
                        <div class="text-muted" >
                            <br> 
                            <h1><center><strong>FUNCIONARIO APOYO ODP</strong></center></h1>
                            <hr>
                        </div>
                        @if($MismaOPD==1)
                            <center>
                                <p>Desea desabilitar al funcionario <strong>{{ $Funcionario_R}}</strong> de <strong>{{ $OPD_R}}</strong><br>
                                    como ODP de apoyo.
                                </p>
                            </center>
                            <br>
                            <center>
                                <div class="btn-group" style=" width:80%;">	
                                    <button type="button" class="btn btn-danger active" wire:click="Volver">
                                        Volver
                                    </button> 
                                    <button type="button" class="btn btn-warning active" wire:click="Desabilitar">
                                        DESABILITAR
                                    </button> 
                                </div>
                            </center>
                        @else
                                @if($ResultadoJefe==1)
                                    <center>
                                        <p>El funcionario <strong>{{ $Funcionario_R}}</strong> de  <strong>{{ $OPD_R}}</strong><br>
                                            Figura como encargado, no disponible como funcionario de apoyo.
                                        </p>
                                    </center>
                                    <br>
                                    <center>
                                        <div class="btn-group" style=" width:80%;">	
                                            <button type="button" class="btn btn-danger IngresoMulta active" id="IngresoMulta" wire:click="Volver">
                                                Volver
                                            </button> 
                                        </div>
                                    </center>
                                @else
                                    @if($ResultadoSecretaria==1)
                                        <center>
                                            <p>El funcionario <strong>{{ $Funcionario_R}}</strong> de <strong>{{ $OPD_R}}</strong><br>
                                                figura como ODP, dicho funcionario/a quedara a cargo de las siguientes ODP.
                                            </p>
                                        </center>
                                        @if(!empty($ListaODP))
                                            <div class="row">  
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1"></div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10">
                                                    <table table class="table table-sm table-bordered">
                                                        <thead>
                                                            <tr> 
                                                            <th><center>ODP</center></th> 
                                                            </tr> 
                                                        </thead>  
                                                        <tbody>  
                                                            @foreach($ListaODP as $post)
                                                            <tr>
                                                            <td><center>{{$post->Nombre_DepDir}}</center></td>
                                                            </tr>
                                                            @endforeach  
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1"></div>
                                            </div>
                                        @endif
                                        <br>
                                        <center>
                                            <div class="btn-group" style=" width:80%;">	
                                                <button type="button" class="btn btn-danger active" wire:click="Volver">
                                                    Volver
                                                </button> 
                                                <button type="button" class="btn btn-success active" wire:click="Agregar">
                                                    CONFIRMAR
                                                </button> 
                                            </div>
                                        </center>
                                        @else
                                        <center>
                                            <p>El funcionario <strong>{{ $Funcionario_R}}</strong> de  <strong>{{ $OPD_R}}</strong><br>
                                                quedará como <strong>ODP</strong> de apoyo.
                                            </p>
                                        </center>
                                        <br>
                                        <center>
                                            <div class="btn-group" style=" width:80%;">	
                                                <button type="button" class="btn btn-danger active" wire:click="Volver">
                                                    Volver
                                                </button> 
                                                <button type="button" class="btn btn-success active" wire:click="Agregar">
                                                    CONFIRMAR
                                                </button> 
                                            </div>
                                        </center>
                                    @endif
                                @endif
                        @endif
                        <div class="card-footer text-muted">  
                            SGD
                        </div>
                    </div>
                </div> 
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3"></div>
    </div>
@endif  
@else

<div class="container-fluid">  
        <div class="row">  
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="col">
                    <div class="card bg-light mb-3"> 
                        <div class="text-muted" >
                            <br> 
                            <h1><center><strong>AGREGAR FUNCIONARIO ODP</strong></center></h1>
                            <hr>
                        </div>
                        <div class="row">  
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1"></div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-10">
                                <div class="text-muted" >
                                    <h4><center><strong>Opción no disponible para el funcionario/a actual.</strong></center></h4>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-1"></div>
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
</div> 
 