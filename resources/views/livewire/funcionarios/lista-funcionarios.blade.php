<div>
<br>    
@if($MostrarPagina==1)   
@if($mostrar==1)
    <div class="container-fluid">   
        <div class="row">  
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="col">
                    <div class="card bg-light mb-3"> 
                        <div class="text-muted"> 
                            <br> 
                            <h1><center><strong>LISTA FUNCIONARIOS</strong></center></h1>
                            <hr>
                        </div>
                        <div class="row"> 
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                <button class="btn btn-warning" onclick="location.reload()"><img src="{{URL::asset('Imagenes/Actualizar.png')}}" width="25" height="25"/></button>
                            </div> 
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8"></div>    
                        </div> 
                        <div class="card-body table-responsive">
                            <table table class="table table-hover table-sm"> 
                                <thead>
                                    <tr> 
                                        <th>RUN</th>
                                        <th>NOMBRE</th>
                                        <th>APELLIDO</th>
                                        <th>DESACTIVAR</th>
                                    </tr> 
                                </thead>  
                                <tbody>  
                                    @foreach($ListaFuncionariosOP as $post)
                                    <tr>
                                        <td>{{ $post->Rut }}</td>
                                        <td>{{ $post->Nombres }}</td>
                                        <td>{{ $post->Apellidos }}</td>
                                    @if($post->Activo==1)
                                        <td> 
                                            <button class="btn btn-success active btn-success"  wire:click="Desactivar({{ $post->ID_Funcionario_T }})">&nbsp;&nbsp;&nbsp;ACTIVADO&nbsp;&nbsp;&nbsp;</button>
                                        </td>
                                    @else
                                        <td> 
                                            <button class="btn btn-success active btn-danger"  wire:click="Activar({{ $post->ID_Funcionario_T }})">DESACTIVADO</button>
                                        </td>
                                    @endif
                                    </tr>
                                    @endforeach  
                                </tbody>
                            </table>
                    </div>  
                    <div class="card-footer text-muted">
                    </div>	
                    <div class="card-footer text-muted"> 
                            SGD
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
                    <div class="table-responsive">
                        <div class="card bg-light mb-3">
                            <div class="text-muted">
                                <br> 
                                <h1><center><strong>ADMINISTRAR SECRETARIA</strong></center></h1>
                                <hr>
                            </div>
                            <div class="card-body">
                                <tbody> 
                                    <td>
                                        <h5><strong>Encargado de oficina de partes no disponible.</strong></h5><br>
                                        <h7><strong>Por favor comuníquese con el departamento de informática.</strong></h7>
                                    </td> 
                                </tbody>    
                                <br>                         
                                <tbody>
                                    <td>
                                  
                                    </td>
                                </tbody>  
                            </div>  
                            <div class="card-footer text-muted"> 
                                SGD
                            </div>
                        </div>
                    </div> 
                </div> 
            </div>
        </div> 
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
                            <h1><center><strong>LISTA FUNCIONARIOS</strong></center></h1>
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
