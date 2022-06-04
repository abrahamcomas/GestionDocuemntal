<div>
<br>
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
                        SGD
                    </div>
                </div> 
            </div>
        </div> 
    </div>
</div>