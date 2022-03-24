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
                            <center><img src="{{URL::asset('Imagenes/EncargadoODP/Secretaria.JPG')}}" width="1200" height="1200" class="img-fluid" alt="Responsive image"/></center> 
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
                        <div class="card-header">
                            <h4><strong>ADMINISTRAR SECRETARIA/O</strong></h4>
                            <center><h2><strong>{{ $Mensaje}}</strong></h2></center> 
                        </div> 
                        <br>
                        <div class="row"> 
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                                <button class="btn" wire:click="Ayuda"><img src="{{URL::asset('Imagenes/ayuda.png')}}" width="25" height="25"/></button>
                            </div> 
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8"> 
                                <h5><strong>{{ $NombreDireccion}}</strong></h5>
                            </div>    
                        </div> 
                        <div class="card-body table-responsive">
                            <table table class="table table-hover">
                               
                                <br>
                                <h5><strong>SECRETARIA/O {{ $SecretariaNombre }} {{ $SecretariaApellido }}</strong></h5>
                                <thead>
                                    <tr> 
                                        <th>RUN</th>
                                        <th>NOMBRE</th>
                                        <th>APELLIDO</th>
                                        <th>ADMINISTRAR</th>
                                    </tr> 
                                </thead> 
                                <tbody>   
                                    @foreach($ListaFuncionariosOP as $post)
                                    <tr>
                                        <td>{{ $post->Rut }}</td>
                                        <td>{{ $post->Nombres }}</td>
                                        <td>{{ $post->Apellidos }}</td>
                                        <td>
                                            <button class="btn btn-success active btn-info"  wire:click="SeleccionarSecretaria({{ $post->ID_Funcionario_T }})">SELECCIONAR</button>
                                        </td>
                                    </tr>
                                    @endforeach  
                                </tbody> 
                            </table> 
                        </div> 	
                        <div class="card-footer text-muted"> 
                                GESTIÓN DOCUMENTAL
                        </div>
                    </div> 
                </div> 
            </div>
        </div>  
    </div>
@else 
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col">
                <div class="card bg-light mb-3" > 
                    <div class="card-header"><h4><strong>SECRETARIA/O</strong></strong></h4></div>  
                        <div class="card-body">
                            <div class="form-group">
                                <h5>SELECCIONADO CORRECTAMENTE</h5>
                            </div>
                        </div>
                        <br> 
                        <div class="card-footer text-muted">
                            <center>
                                <div class="btn-group" style=" width:50%;">	
                                    <button class="btn btn-danger active"  wire:click="Volver">VOLVER</button>
                                </div>
                            </center>
                        </div>
                        <div class="card-footer text-muted">
                            GESTIÓN DOCUMENTAL <br>
                        </div>
                    </div>
                </div>	
            </div>
        </div>			
    </div>
@endif
</div>
@endif