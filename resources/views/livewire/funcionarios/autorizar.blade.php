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
                            <center><img src="{{URL::asset('Imagenes/EncargadoODP/PortafolioDirecto.JPG')}}" width="1200" height="1200" class="img-fluid" alt="Responsive image"/></center> 
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
@if($mostrar==1)
    <div class="container-fluid">  
        <div class="row">  
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="col">
                    <div class="card bg-light mb-3">  
                        <div class="text-muted">
                            <br> 
                            <h1><center><strong>NUEVOS REGISTROS</strong></center></h1>
                            <hr>
                        </div>
                        <div class="row"> 
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                <button class="btn" wire:click="Ayuda"><img src="{{URL::asset('Imagenes/ayuda.png')}}" width="25" height="25"/></button>
                                <button class="btn btn-warning" onclick="location.reload()"><img src="{{URL::asset('Imagenes/Actualizar.png')}}" width="25" height="25"/></button>
                            </div> 
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8"></div>    
                        </div> 
                        <div class="card-body table-responsive">
                            <table table class="table table-hover">
                                <thead>
                                    <tr> 
                                        <th>RUT</th>
                                        <th>NOMBRE</th>
                                        <th>APELLIDO</th>
                                        <th>ACEPTAR</th>
                                        <th>DENEGAR</th>
                                    </tr> 
                                </thead> 
                                <tbody>  
                                    @foreach($ListaFuncionariosOP as $post)
                                    <tr>
                                        <td>{{ $post->Rut }}</td>
                                        <td>{{ $post->Nombres }}</td>
                                        <td>{{ $post->Apellidos }}</td>
                                        <td> 
                                            <button class="btn btn-success active btn-info"  wire:click="Aceptar({{ $post->ID_Funcionario_T }})">ACEPTAR</button>
                                        </td>
                                        <td>
                                            <button class="btn btn-success active btn-danger"  wire:click="Eliminar({{ $post->ID_Funcionario_T }})">DENEGAR</button>
                                        </td>
                                    </tr>
                                    @endforeach  
                                </tbody>
                            </table>
                    </div>  
                    <div class="card-footer text-muted">
                        <!--{{ $Lista->links() }}-->
                    </div>	
                    <div class="card-footer text-muted"> 
                            GESTIÓN DOCUMENTAL
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
                                GESTIÓN DOCUMENTAL
                            </div>
                        </div>
                    </div> 
                </div> 
            </div>
        </div> 
    </div> 
@endif
</div>
@endif