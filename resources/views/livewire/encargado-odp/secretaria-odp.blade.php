<div>
<br>
@if($mostrar==1)
    <div class="container-fluid">   
        <div class="row">   
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="col">
                    <div class="card bg-light mb-3"> 
                        <div class="text-muted" >
                            <br> 
                            <h1><center><strong>ADMINISTRAR SECRETARIA/O</strong></center></h1>
                            <center><h2><strong>{{ $Mensaje}}</strong></h2></center>
                            <hr>
                        </div>
                        <div class="card-body table-responsive">
                            <table table class="table table-hover">
                               
                                <br>
                                <h5>SECRETARIA/O ACTUAL <strong>{{ $SecretariaNombre }} {{ $SecretariaApellido }}</strong></h5>
                                <thead>
                                    <tr> 
                                        <th>RUT</th>
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
                                SGD
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
                <div class="card bg-light mb-3">
                        <div class="text-muted">
                            <br> 
                            <h1><center><strong>SECRETARIA/O</strong></center></h1>
                            <hr>
                        </div> 
                        <div class="card-body">
                            <div class="form-group">
                                <h5>Seleccionado correctamente.</h5>
                            </div>
                        </div>
                        <br> 
                        <div class="card-footer text-muted">
                            <center>
                                <div class="btn-group" style=" width:80%;">	
                                    <button class="btn btn-danger active"  wire:click="Volver">VOLVER</button>
                                </div>
                            </center>
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